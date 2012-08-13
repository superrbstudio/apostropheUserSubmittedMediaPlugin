<?php

class apostropheUserSubmittedMediaPluginConfiguration extends sfPluginConfiguration
{
  static $registered = false;
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    // Yes, this can get called twice. This is Fabien's workaround:
    // http://trac.symfony-project.org/ticket/8026
    
    if (!self::$registered)
    {
      $this->dispatcher->connect('a.migrateSchemaAdditions', array($this, 'migrate'));
      $this->dispatcher->connect('a.mediaGetBrowseQuery', array($this, 'mediaGetBrowseQuery'));
      $this->dispatcher->connect('a.mediaItemFormAfterSetup', array($this, 'mediaItemFormAfterSetup'));
      
      self::$registered = true;
    }
  }
  
  public function migrate($event)
  {
    $migrate = $event->getSubject();
    if (!$migrate->columnExists('a_media_item', 'approved'))
    {
      $migrate->sql(array(
        'ALTER TABLE a_media_item ADD COLUMN approved TINYINT(1) DEFAULT 1'
      ));
    }
  }

  /**
   * Make sure unapproved media are not visible under normal circumstances
   */
  public function mediaGetBrowseQuery($event)
  {
    $query = $event->getSubject();
    // This is a nice idea although currently the unapproved action uses its own query anyway
    $approved = isset($event['params']['approved']) ? $event['params']['approved'] : true;
    $query->andWhere('aMediaItem.approved = ?', $approved);
  }

  /**
   * Remove the approved field from the media item form, except in
   * our approval form. Otherwise things get unapproved when you
   * edit them
   */
  public function mediaItemFormAfterSetup($event)
  {
    $form = $event->getSubject();
    if (!($form instanceof aUserSubmittedMediaApprovalForm))
    {
      unset($form['approved']);
    }
  }
}

<?php

class PluginaUserSubmittedMediaForm extends aMediaEditForm
{
  public function configure()
  {
    parent::configure();
    $this->useFields($this->getUseFields());
    $this->widgetSchema->setFormFormatterName('aAdmin');
    $this->widgetSchema->setLabel('file', 'File');
  } 

  public function getUseFields()
  {
    return array('title', 'description', 'file');
  }

  /**
   * Currently user submitted media must be of the image type
   */
  public function getType()
  {
    return 'image';
  }

  /**
   * By default the media item form class isn't really set up to deal with anonymous users 
   * when it comes to categories. Force a query with no results. It'll get unset once
   * we get into configure() anyway, but setup() fires first
   */
  protected function getCategoriesQuery()
  {
    $user = sfContext::getInstance()->getUser();
    $admin = $user->hasCredential(aMediaTools::getOption('admin_credential'));
    return Doctrine::getTable('aCategory')->createQuery('c')->where('0 <> 0');
  }

  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    $object->setApproved(false);
    $object->setType($this->getType());
    $categoryName = sfConfig::get('app_aUserSubmittedMedia_category', 'User-Submitted');
    $category = Doctrine::getTable('aCategory')->findOneByName($categoryName);
    if (!$category)
    {
      $category = new aCategory();
      $category->setName($categoryName);
    }
    // In case we decide to let people edit their submissions:
    // don't add the category twice
    $found = false;
    foreach ($object->Categories as $category)
    {
      if ($category->getName() === $category->getName())
      {
        $found = true;
        break;
      }
    }
    if (!$found)
    {
      $object->Categories[] = $category;
    }
    return $object;
  }
}
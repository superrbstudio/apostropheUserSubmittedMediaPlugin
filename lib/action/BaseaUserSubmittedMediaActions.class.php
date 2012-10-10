<?php

class BaseaUserSubmittedMediaActions extends sfActions
{
  public function executeSubmit(sfWebRequest $request)
  {
    $mediaItem = new aMediaItem();
    $mediaItem->setType('image');
    $this->form = new aUserSubmittedMediaForm($mediaItem);
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('a_media_item'), $request->getFiles('a_media_item'));
      if ($this->form->isValid())
      {
        $file = $this->form->getValue('file');
        unset($this->form['file']);
        $object = $this->form->getObject();
        if ($file)
        {
          $object->preSaveFile($file->getTempName());
        }
        $this->form->save();
        if ($file)
        {
          $object->saveFile($file->getTempName());
        }
        return $this->redirect(sfConfig::get('app_aUserSubmittedMedia_afterSubmission', '@homepage'));
      }
    }
  }

  public function executeUnapproved(sfWebRequest $request)
  {
    // Long-patient submissions go first
    // Pagination probably a good idea
    $this->mediaItems = Doctrine::getTable('aMediaItem')->createQuery('m')->where('m.approved IS FALSE')->orderBy('m.created_at asc')->execute();
  }

  public function executeApprove(sfWebRequest $request)
  {
    $this->mediaItem = Doctrine::getTable('aMediaItem')->find($request->getParameter('id'));
    $this->forward404Unless($this->mediaItem);
    $this->form = new aUserSubmittedMediaApprovalForm($this->mediaItem);
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('a_media_item'), $request->getFiles('a_media_item'));
      if ($this->form->isValid())
      {
        $file = $this->form->getValue('file');
        if ($file)
        {
          // Handle replacement file
          unset($this->form['file']);
          $object = $this->form->getObject();
          if ($file)
          {
            $object->preSaveFile($file->getTempName());
          }
          $this->form->save();
          if ($file)
          {
            $object->saveFile($file->getTempName());
          }
        }
        else
        {
          // No replacement was made
          unset($this->form['file']);
          $this->form->save();
        }
        return $this->redirect('@aUserSubmittedMedia_unapproved');
      }
    }
  }
}
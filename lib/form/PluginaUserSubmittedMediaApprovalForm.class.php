<?php

class PluginaUserSubmittedMediaApprovalForm extends aMediaEditForm
{
  public function configure()
  {
    parent::configure();
    $this->useFields($this->getUseFields());
    $this->widgetSchema->setFormFormatterName('aAdmin');
    $this->widgetSchema->setLabel('file', 'Replace File');
    $this->widgetSchema->setHelp('file', 'If the submitted image is OK, do not select a replacement.');
    $this->getValidator('file')->setOption('required', false);
  } 

  public function getUseFields()
  {
    return array('title', 'description', 'file', 'tags', 'categories_list', 'approved');
  }
}
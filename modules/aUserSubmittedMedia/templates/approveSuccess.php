<?php
  use_helper('a');

  // Compatible with sf_escaping_strategy: true
  $form = isset($form) ? $sf_data->getRaw('form') : null;
  $popularTags = isset($popularTags) ? $sf_data->getRaw('popularTags') : array();
  $allTags = isset($allTags) ? $sf_data->getRaw('allTags') : array();
  
  $options = array('choose-one' => 'Select One', 'add' => '+ New Category');
  a_js_call('aMultipleSelect(?, ?)', '.a_media_item_categories_list', $options);
?>

<p>
    <img src="<?php echo $mediaItem->getImgSrcUrl(sfConfig::get('aUserSubmittedMedia_approvalWidth', 500), sfConfig::get('aUserSubmittedMedia_approvalHeight', false), 's') ?>" />
</p>

<form enctype="multipart/form-data" method="POST" action="<?php url_for('@aUserSubmittedMedia_submit') ?>">
    <?php echo $form ?>
    <div class="a-form-row">
        <input type="submit" value="Save" /> 
        <?php echo link_to('<span class="icon"></span>'.__("Delete", null, 'apostrophe'), "@aUserSubmittedMedia_delete?id=" . $mediaItem->getId(), array("confirm" => __('Are you sure? This operation can not be undone.', null, 'apostrophe'), 'class' => 'a-btn icon a-delete alt lite', 'title' => __('Delete', null, 'apostrophe'))) ?>
        <a href="<?php echo url_for(sfConfig::get('aUserSubmittedMedia_cancel', '@homepage')) ?>">Cancel</a>
    </div>
</form>

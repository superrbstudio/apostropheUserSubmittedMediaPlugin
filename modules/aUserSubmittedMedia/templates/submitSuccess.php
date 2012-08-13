<?php
  // Compatible with sf_escaping_strategy: true
  $form = isset($form) ? $sf_data->getRaw('form') : null;
  $popularTags = isset($popularTags) ? $sf_data->getRaw('popularTags') : array();
  $allTags = isset($allTags) ? $sf_data->getRaw('allTags') : array();
?>

<form enctype="multipart/form-data" method="POST" action="<?php url_for('@aUserSubmittedMedia_submit') ?>">
	<?php echo $form ?>
	<div class="a-form-row">
		<input type="submit" value="Save" /> <a href="<?php echo url_for(sfConfig::get('aUserSubmittedMedia_cancel', '@homepage')) ?>">Cancel</a>
	</div>
</form>

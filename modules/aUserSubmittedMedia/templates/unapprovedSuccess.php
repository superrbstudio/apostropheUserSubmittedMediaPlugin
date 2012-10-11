<?php use_helper('a'); ?>
<?php $mediaItems = $sf_data->getRaw('mediaItems') ?>
<ul class="unapproved">
<?php foreach ($mediaItems as $mediaItem): ?>
    <li class="unapproved">
        <p class="title"><?php echo aHtml::entities($mediaItem->getTitle()) ?></p>
        <img src="<?php echo $mediaItem->getImgSrcUrl(sfConfig::get('app_aUserSubmittedMedia_unapprovedWidth', 300), sfConfig::get('app_aUserSubmittedMedia_unapprovedHeight', false), 's') ?>" />
        <?php echo link_to("Edit", "@aUserSubmittedMedia_approve?id=" . $mediaItem->getId()) ?>
        <?php echo link_to('<span class="icon"></span>'.__("Delete", null, 'apostrophe'), "@aUserSubmittedMedia_delete?id=" . $mediaItem->getId(), array("confirm" => __('Are you sure? This operation can not be undone.', null, 'apostrophe'), 'class' => 'a-btn icon a-delete alt lite', 'title' => __('Delete', null, 'apostrophe'))) ?>
    </li>
<?php endforeach ?>

<?php if($status==Asset::SCHEDULED): ?>
  <?php echo __('Scheduled for archiviation') ?>
<?php elseif($status==Asset::CACHED): ?>
  <?php echo __('Archived and still available on line') ?>
<?php elseif($status==Asset::ISO_IMAGE): ?>
  <?php echo __('Archived, ready for masterization') ?>
<?php elseif($status==Asset::DVDROM): ?>
  <?php echo __('Archived, masterized') ?>
  <?php if($Archive):?>
    - <?php echo __('Available in archive %id% «%slug%»', array('%id%'=>$Archive->getId(), '%slug%'=>$Archive->getslug())) ?>
  <?php endif ?>
<?php else: ?>
  <?php echo __('Unknown') ?>
<?php endif ?>
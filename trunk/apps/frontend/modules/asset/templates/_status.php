<?php if($status==Asset::SCHEDULED): ?>
  <?php echo __('Scheduled for archiviation') ?>
<?php elseif($status==Asset::CACHED): ?>
  <?php echo __('Archived and still available on line') ?>
<?php elseif($status==Asset::ISO_IMAGE): ?>
  <?php echo __('Archived, ready for masterization') ?>
<?php elseif($status==Asset::DVDROM): ?>
  <?php echo __('Archived, masterized') ?>
<?php else: ?>
  <?php echo __('Unknown') ?>
<?php endif ?>
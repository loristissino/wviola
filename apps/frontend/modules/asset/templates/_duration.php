<?php if ($Asset->hasVideoAsset()): ?>
	<?php echo $Asset->getVideoAsset()->getDuration() ?>
<?php endif ?>
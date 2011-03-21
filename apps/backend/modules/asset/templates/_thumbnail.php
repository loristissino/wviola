<?php use_helper('Wviola') ?>
<?php if ($Asset->getHasThumbnail()): ?>
	<?php $image_tag=image_tag(url_for_frontend('thumbnail', array('id'=>$Asset->getId(), 'sf_format'=>'jpeg')),
		array(
		'size'=>sprintf('%dx%d', $Asset->getThumbnailWidth(), $Asset->getThumbnailHeight()),
		'alt'=>$Asset->getNotes(),
		))
	?>
<?php else: ?>
	<?php $image_tag=image_tag('no' . $Asset->getAssetTypeCode() . '_thumbnail', array('alt'=>__('No thumbnail available'), 'size'=>'60x45')) ?>
<?php endif ?>
<?php echo $image_tag ?>
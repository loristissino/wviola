<?php if ($Asset->getHasThumbnail()): ?>
	<?php $image_tag=sprintf(
		'<img src="%s" alt="%s" width="%d" height="%s" />',
		url_for('asset/thumbnail?id=' . $Asset->getId() .'&sf_format=jpeg'),
		$Asset->getAssignedTitle(),
		$Asset->getThumbnailWidth(),
		$Asset->getThumbnailHeight()
		)  // We need to build this because standard image_tag function appends 'png' to the URL
	?>
<?php else: ?>
	<?php $image_tag=image_tag('no' . $Asset->getAssetTypeCode() . '_thumbnail', array('alt'=>__('No thumbnail available'), 'size'=>'60x45')) ?>
<?php endif ?>
<?php
	echo link_to(
	$image_tag,
	url_for('asset/show?id='.$Asset->getId()),
	array(
		'title'=>__('Show the asset «%title%»', array('%title%'=>$Asset->getAssignedTitle()))
		)
	)
?>

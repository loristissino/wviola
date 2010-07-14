<?php if ($Asset->getHasThumbnail()): ?>
	<?php $image_tag=image_tag(url_for('asset/thumbnail?id=' . $Asset->getId() .'&sf_format=jpeg'),
		array(
		'size'=>sprintf('%dx%d', $Asset->getThumbnailWidth(), $Asset->getThumbnailHeight()),
		'alt'=>$Asset->getNotes(),
		))
	?>
<?php else: ?>
	<?php $image_tag=image_tag('no' . $Asset->getAssetTypeCode() . '_thumbnail', array('alt'=>__('No thumbnail available'), 'size'=>'60x45')) ?>
<?php endif ?>
<?php
//  echo htmlentities($image_tag);
  if($link)
  {
    echo link_to(
    $image_tag,
    url_for('asset/show?id='.$Asset->getId()),
    array(
      'title'=>__('Show the asset «%title%»', array('%title%'=>$Asset->getNotes()))
      )
    );
  }
  else
  {
    echo $image_tag;
  }
?>
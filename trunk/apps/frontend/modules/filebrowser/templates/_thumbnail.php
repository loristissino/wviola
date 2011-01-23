<?php
  $image_tag=image_tag(url_for(
		sprintf(
			'filebrowser/thumbnail?path=%s&basename=%s&number=%d.jpeg',
			Generic::b64_serialize(Generic::standardizePath($file->getRelativePath())),
			Generic::b64_serialize(Generic::standardizePath($file->getBasename())),
			$number)
		)
		,
		array(
			'alt'=>'Position=' . $file->getWvInfo('thumbnail_' . $number . '_position', '0'),
			'size'=>sprintf('%dx%d', $file->getWvInfo('thumbnail_' . $number . '_width'), $file->getWvInfo('thumbnail_' . $number . '_height'))
		)
		);
  if ($link)
  {
    echo link_to(
      $image_tag,
      url_for('filebrowser/archive?name='. urlencode($file->getBaseName()) . '&thumbnail=' . $number),
      array(
        'title'=>__('Archive asset «%filename%»', 
          array('%filename%'=>$file->getBaseName())
          ))
    );
  }
  else
  {
    echo $image_tag;
  }
?>
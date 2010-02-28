<?php echo image_tag(url_for(
		sprintf(
			'filebrowser/thumbnail?path=%s&basename=%s&number=%d.jpeg',
			Generic::b64_serialize($file->getRelativePath()),
			Generic::b64_serialize($file->getBasename()),
			$number)
		)
		,
		array(
			'alt'=>'Position=' . $file->getWvInfo('thumbnail_' . $number . '_position', '0'),
			'title'=>'Position=' . $file->getWvInfo('thumbnail_' . $number . '_position'),
			'size'=>sprintf('%dx%d', $file->getWvInfo('thumbnail_' . $number . '_width'), $file->getWvInfo('thumbnail_' . $number . '_height'))
		)
		)
		
?>
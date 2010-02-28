<?php if ($has_thumbnails): ?>
	<?php for($i=0; $i<sizeof($file->getWvInfo('thumbnail')); $i++): ?>
		<?php include_partial('thumbnail', array('file'=>$file, 'number'=>$i)) ?>
	<?php endfor ?>
<?php endif ?>
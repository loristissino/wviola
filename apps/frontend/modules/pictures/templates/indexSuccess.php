<h1>Pictures</h1>

<ul>
<?php foreach($pictures as $picture): ?>
<li>
	<?php echo $picture->getPath() ?>
	- 
	<?php echo link_to(
		'edit',
		url_for('pictures/edit?id=' . $picture->getId())
		)
	?>
</li>
<?php endforeach ?>
</ul>

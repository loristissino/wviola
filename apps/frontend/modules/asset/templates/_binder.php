<?php if($Binder): ?>
	<?php echo link_to(
    $Binder->getNotes(),
    url_for('binder/show?id=' . $Binder->getId())
    )
  ?>
<?php endif ?>

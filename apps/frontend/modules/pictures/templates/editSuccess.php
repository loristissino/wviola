<h1>Editing picture <?php //echo $picture->getId() ?></h1>

<hr />
<form action="<?php echo url_for('pictures/edit') ?>" method="post">
<table>
<?php echo $form ?>
<tr>
<td colspan="2">
<input type="submit" value="save" />
</td>
</tr>
</table>
</form>

<hr />
<p><?php echo link_to(
	'back',
	url_for('pictures/index')
	) ?>
</p>

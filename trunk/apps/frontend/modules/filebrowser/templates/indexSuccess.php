<h1>SOURCES</h1>

<h2><?php echo $path ?></h2>

<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="notice"><?php echo $sf_user->getFlash('notice')?></div>
<?php endif; ?>
<?php if ($sf_user->hasFlash('error')): ?>
  <div class="error"><?php echo $sf_user->getFlash('error')?></div>
<?php endif; ?>

<?php if($path!='/'): ?>
<ul class="sf_admin_actions">
<li class="sf_admin_action_updir"><?php echo link_to(
	__('Up'),
	url_for('filebrowser/up')
	)
?>
</li>
</ul>
<?php endif ?>


<?php if (sizeof($folder_items)>0): ?>
<?php $i=0 ?>
<div class="sf_admin_list">

<table cellspacing="0">
  <thead>
    <tr>
      <th class="sf_admin_text"><?php echo __('Type') ?></th>
      <th class="sf_admin_text"><?php echo __('Name') ?></th>
      <th class="sf_admin_text"><?php echo __('Size') ?></th>
      <th class="sf_admin_text"><?php echo __('Date') ?></th>
      <th class="sf_admin_text"><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($folder_items as $item): ?>
    <tr class="sf_admin_row <?php echo (++$i & 1)? 'odd':'even' ?>">
      <td><?php // include_component('filebrowser', 'mimetype', array('mimetype'=>$item->getMimeType())) ?></td>
      <td><?php // echo $item->getName() ?></td>
      <td>
	<?php// if ($item->getFileType()!='directory'): ?>
		<?php //echo $item->getSize() ?>
	<?php //endif ?>
	</td>
      <td><?php //echo Generic::datetime($item->getTimestamp(), $sf_context) ?></td>
      <td>
	<ul class="sf_admin_td_actions">  
		<?php if($item->getFiletype()=='directory'): ?>
			<li class="sf_admin_action_opendir"><?php echo link_to(
				__('Open'),
				url_for('filebrowser/open?name='. urlencode($item->getName()))
				)
			?>
			</li>
		<?php endif ?>
		<?php if($item->getIsDownloadable()): ?>
			<li class="sf_admin_action_download"><?php echo link_to(
				__('Download'),
				url_for('filebrowser/download?name='. urlencode($item->getName()))
				)
			?>
			</li>
		<?php endif ?>
		<?php if($item->getIsRemovable()): ?>
			<li class="sf_admin_action_delete"><?php echo link_to(
				__('Remove'),
				url_for('filebrowser/remove?name='. urlencode($item->getName())),
				array('method' => 'put', 'confirm' => format_number_choice(__('[0]Are you sure?|[1]Are you sure?'), null, $sf_user->getProfile()->getIsMale()),
				))
			?>
			</li>
		<?php endif ?>
		</ul>
	  </td>
	</tr>
	<?php endforeach ?>
  </tbody>
</table>

<?php else: ?>
<p><?php echo __('This directory is empty.') ?></p>
<?php endif ?>


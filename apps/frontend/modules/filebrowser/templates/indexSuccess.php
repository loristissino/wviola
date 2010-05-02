<h1>File browser</h1>

<h2><?php echo $path ?></h2>

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
      <th class="sf_admin_text"><?php echo __('Thumbnails') ?></th>
      <th class="sf_admin_text"><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($folder_items as $item): ?>
    <tr class="sf_admin_row <?php echo (++$i & 1)? 'odd':'even' ?>">
    
      <td><?php include_component('filebrowser', 'mimetype', array('mimetype'=>$item->getGuessedInternetMediaType())) ?></td>
      <td><a name="<?php echo $item->getStat('ino') ?>"></a><?php echo $item->getBaseName() ?></td>
      <td>
	<?php if ($item->getFileType()!='directory'): ?>
		<?php echo $item->getStat('size') ?>
	<?php endif ?>
	</td>
      <td><?php echo Generic::datetime($item->getStat('mtime'), $sf_context) ?></td>
	  <td>
      <?php include_component('filebrowser', 'thumbnails', array('file'=>$item)) ?>
      <?php if($item->getWvInfo('file_asset_id')): ?>
        <br />
        <?php echo __('Looks like this asset is a duplicate of a one already archived.') ?>
      <?php endif ?>
    </td>  
      <td>
	<ul class="sf_admin_td_actions">  
		<?php if($item->getFiletype()=='directory'): ?>
			<li class="sf_admin_action_opendir"><?php echo link_to(
				__('Open'),
				url_for('filebrowser/open?name='. urlencode($item->getBaseName()))
				)
			?>
			</li>
		<?php endif ?>
		<?php if($item->getWvInfo('file_archivable')==true): ?>
			<li class="sf_admin_action_archive"><?php echo link_to(
				__('Archive'),
				url_for('asset/new?name='. urlencode($item->getBaseName())),
        array(
          'title'=>__('Archive asset «%filename%»', 
            array('%filename%'=>$item->getBaseName())
            ))
				)
			?>
		<?php endif ?>
		<?php if($item->getWvInfo('file_asset_id')!=null): ?>
			<li class="sf_admin_action_playvideo"><?php echo link_to(
				__('Show'),
				url_for('asset/show?id='. $item->getWvInfo('file_asset_id')),
        array(
          'title'=>__('Show already archived asset «%filename%»', 
            array('%filename%'=>$item->getBaseName())
            ))
				)
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


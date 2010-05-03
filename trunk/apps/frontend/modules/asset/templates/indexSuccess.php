<h1>Assets List</h1>
<?php include_partial('asset/assetpager', array('pager'=>$pager, 'action'=>'asset/index', 'item_name'=>'asset')) ?>
<?php if ($sf_user->hasCredential('video_encode')): ?>
<?php echo link_to(
  __('New asset'),
  url_for('filebrowser/index'),
  array(
    'title'=>__('Add a new asset by choosing a file to encode/transform'),
    )
  )
?>
<?php endif ?>
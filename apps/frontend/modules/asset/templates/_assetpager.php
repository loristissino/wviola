<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>$action, 'item_name'=>'asset')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>$action)) ?>

<?php if ($pager->getNbResults()>0): ?>
<?php include_partial('asset/list', array('Assets'=>$pager->getResults())) ?>
<?php endif ?>

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
  

<h1>Assets List</h1>
<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>'asset/index')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>'asset/index')) ?>

<?php if ($pager->getNbResults()>0): ?>
<table>
  <thead>
    <tr>
      <th>Type</th>
      <th>Thumbnail</th>
      <th>Title</th>
      <th>Category</th>
      <th>Notes</th>
      <th>Duration</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $Asset): ?>
    <tr>
	  <td>
		<?php include_partial('assettype', array('Asset'=>$Asset)) ?>
	  </td>
	  <td>
      	<?php include_partial('thumbnail', array('Asset'=>$Asset, 'link'=>true)) ?>
	  </td>
      <td>
        <?php echo $Asset->getAssignedTitle() ?></td>
	  <td>
		<?php include_partial('category', array('Category'=>$Asset->getCategory())) ?>
	  </td>
      <td><?php echo $Asset->getNotes() ?></td>
      <td>
		<?php include_partial('duration', array('Asset'=>$Asset)) ?>
	  </td>
      <td><?php echo $Asset->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
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
  


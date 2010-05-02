<h1>Sources List</h1>
<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>'source/index', 'item_name'=>'source')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>'source/index')) ?>

<?php if ($pager->getNbResults()>0): ?>
<table>
  <thead>
    <tr>
      <th>Relative path</th>
      <th>Filename</th>
      <th>Status</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $Source): ?>
    <tr>
      <td><?php echo link_to(
        $Source->getRelativePath(),
        url_for('filebrowser/opendir?code=' . Generic::b64_serialize($Source->getRelativePath()))
        )
        ?></td>
      <td><?php echo link_to(
        $Source->getBasename(),
        url_for('filebrowser/opendir?code=' . Generic::b64_serialize($Source->getRelativePath())) . '#' . $Source->getInode()
        )
        ?></td>
      <td><?php include_partial('sourcestatus', array('status'=>$Source->getStatus())) ?></td>
      <td><?php echo $Source->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif ?>

<h1>Binders List</h1>
<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>'binder/index', 'item_name'=>'binder')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>'binder/index')) ?>

<?php if ($pager->getNbResults()>0): ?>
<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>User</th>
      <th>Category</th>
      <th>Notes</th>
      <th>Event date</th>
      <th>Assets count</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $Binder): ?>
    <tr>
      <td><a href="<?php echo url_for('binder/show?id='.$Binder->getId()) ?>"><?php echo $Binder->getId() ?></a></td>
      <td><?php echo $Binder->getsfGuardUserProfile() ?></td>
      <td><?php echo $Binder->getCategory() ?></td>
      <td><?php echo $Binder->getNotes() ?></td>
      <td><?php echo $Binder->getEventDate() ?></td>
      <td><?php echo $Binder->countAssets() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif ?>

  <?php echo link_to(
    __('New binder'),
    url_for('binder/new')
    )
  ?>
  

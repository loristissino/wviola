<h1>Binders List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>User</th>
      <th>Category</th>
      <th>Notes</th>
      <th>Event date</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Binders as $Binder): ?>
    <tr>
      <td><a href="<?php echo url_for('binder/show?id='.$Binder->getId()) ?>"><?php echo $Binder->getId() ?></a></td>
      <td><?php echo $Binder->getUserId() ?></td>
      <td><?php echo $Binder->getCategoryId() ?></td>
      <td><?php echo $Binder->getNotes() ?></td>
      <td><?php echo $Binder->getEventDate() ?></td>
      <td><?php echo $Binder->getCreatedAt() ?></td>
      <td><?php echo $Binder->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('binder/new') ?>">New</a>

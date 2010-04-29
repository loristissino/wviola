<h1>Binder</h1>
<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $Binder->getId() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $Binder->getsfGuardUserProfile() ?></td>
    </tr>
    <tr>
      <th>Category:</th>
      <td><?php echo $Binder->getCategory() ?></td>
    </tr>
    <tr>
      <th>Notes:</th>
      <td><?php echo $Binder->getNotes() ?></td>
    </tr>
    <tr>
      <th>Event date:</th>
      <td><?php echo $Binder->getEventDate() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $Binder->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $Binder->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('binder/edit?id='.$Binder->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('binder/index') ?>">List</a>

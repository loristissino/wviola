<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $Source->getId() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $Source->getUserId() ?></td>
    </tr>
    <tr>
      <th>Relative path:</th>
      <td><?php echo $Source->getRelativePath() ?></td>
    </tr>
    <tr>
      <th>Filename:</th>
      <td><?php echo $Source->getFilename() ?></td>
    </tr>
    <tr>
      <th>Status:</th>
      <td><?php echo $Source->getStatus() ?></td>
    </tr>
    <tr>
      <th>Inode:</th>
      <td><?php echo $Source->getInode() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $Source->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('source/edit?id='.$Source->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('source/index') ?>">List</a>

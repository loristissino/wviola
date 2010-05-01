<h1>Sources List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>User</th>
      <th>Relative path</th>
      <th>Filename</th>
      <th>Status</th>
      <th>Inode</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Sources as $Source): ?>
    <tr>
      <td><a href="<?php echo url_for('source/show?id='.$Source->getId()) ?>"><?php echo $Source->getId() ?></a></td>
      <td><?php echo $Source->getUserId() ?></td>
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
      <td><?php echo $Source->getStatus() ?></td>
      <td><?php echo $Source->getInode() ?></td>
      <td><?php echo $Source->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('source/new') ?>">New</a>

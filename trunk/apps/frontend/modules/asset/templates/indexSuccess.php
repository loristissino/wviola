<h1>Assets List</h1>

<table>
  <thead>
    <tr>
      <th>Thumbnail</th>
      <th>Slug</th>
      <th>Asset type</th>
      <th>Assigned title</th>
      <th>Category</th>
      <th>Notes</th>
      <th>Duration</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Assets as $Asset): ?>
    <tr>
	  <td>
		<?php include_partial('thumbnail', array('Asset'=>$Asset)) ?>
	  </td>
      <td><?php echo $Asset->getSlug() ?></td>
      <td><?php echo $Asset->getAssetTypeId() ?></td>
      <td><?php echo $Asset->getAssignedTitle() ?></td>
      <td><?php echo $Asset->getCategoryId() ?></td>
      <td><?php echo $Asset->getNotes() ?></td>
      <td><?php echo $Asset->getDuration() ?></td>
      <td><?php echo $Asset->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('asset/new') ?>">New</a>

<table>
  <thead>
    <tr>
      <th>Type</th>
      <th>Thumbnail</th>
      <th>Title</th>
      <th>Binder</th>
      <th>Notes</th>
      <th>Duration</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Assets as $Asset): ?>
    <tr>
	  <td>
		<?php include_partial('asset/assettype', array('Asset'=>$Asset)) ?>
	  </td>
	  <td>
      	<?php include_partial('asset/thumbnail', array('Asset'=>$Asset, 'link'=>true)) ?>
	  </td>
      <td>
        <?php echo $Asset->getAssignedTitle() ?></td>
	  <td>
		<?php include_partial('asset/binder', array('Binder'=>$Asset->getBinder())) ?>
	  </td>
      <td><?php echo $Asset->getNotes() ?></td>
      <td>
		<?php include_partial('asset/duration', array('Asset'=>$Asset)) ?>
	  </td>
      <td><?php echo $Asset->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
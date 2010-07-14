<table>
  <thead>
    <tr>
      <th><?php echo __('Type') ?></th>
      <th><?php echo __('Thumbnail') ?></th>
      <th><?php echo __('Binder') ?></th>
      <th><?php echo __('Notes') ?></th>
      <th><?php echo __('Duration') ?></th>
      <th><?php echo __('Date') ?></th>
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
      <?php include_partial('asset/binder', array('Binder'=>$Asset->getBinder())) ?>
	  </td>
      <td><?php echo $Asset->getNotes() ?></td>
      <td>
		<?php include_partial('asset/duration', array('Asset'=>$Asset)) ?>
	  </td>
      <td><?php echo $Asset->getBinder()->getEventDate() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
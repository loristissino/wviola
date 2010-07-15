<table>
  <thead>
    <tr>
      <th><?php echo __('Type') ?></th>
      <th><?php echo __('Thumbnail') ?></th>
      <th><?php echo __('Binder') ?></th>
      <th><?php echo __('Notes') ?></th>
      <th><?php echo __('Duration') ?></th>
      <th><?php echo __('Date') ?></th>
      <th><?php echo __('Actions') ?></th>
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
      <td>
      <ul class="sf_admin_actions">
        <li class="sf_admin_action_show"><?php echo link_to(
          __('Show'),
          url_for('asset/show?id='.$Asset->getId()),
          array('title'=>__('Show the asset «%title%»', array('%title%'=>$Asset->getNotes())))
          )
        ?></li>
      </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
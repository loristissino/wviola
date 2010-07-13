<h1><?php echo __('Binder') ?></h1>
<table>
  <tbody>
    <tr>
      <th><?php echo __('Id') ?></th>
      <td><?php echo $Binder->getId() ?></td>
    </tr>
    <tr>
      <th><?php echo __('User') ?></th>
      <td><?php echo $Binder->getsfGuardUserProfile() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Category') ?></th>
      <td><?php echo $Binder->getCategory() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Notes') ?></th>
      <td><?php echo $Binder->getNotes() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Event date') ?></th>
      <td><?php echo $Binder->getEventDate() ?></td>
    </tr>
  </tbody>
</table>

<h2><?php echo __('Assets List') ?></h2>
<?php include_partial('asset/assetpager', array('pager'=>$pager, 'action'=>url_for('binder/show?id=' . $Binder->getId()), 'item_name'=>'asset')) ?>

<hr />
<ul class="sf_admin_actions">
  <?php if($Binder->getIsEditable()): ?>
  <li class="sf_admin_action_edit">
  <?php echo link_to(__('Edit'), url_for('binder/edit?id='.$Binder->getId())) ?>
  </li>
  <?php endif ?>
</ul>

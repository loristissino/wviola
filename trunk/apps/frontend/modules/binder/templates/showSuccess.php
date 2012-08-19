<?php include_partial('welcome/title', array('title'=>__('Binder %binder%', array('%binder%'=>$Binder)))) ?>
<table>
  <tbody>
    <tr>
      <th><?php echo __('Id') ?></th>
      <td><?php echo $Binder->getId() ?></td>
    </tr>
    <tr>
      <th><?php echo __('User') ?></th>
      <td><?php echo $Binder->getsfGuardUserProfile() ?>
      <?php if($sf_user->hasCredential('tagging') and $Binder->isOwnedBy($sf_user->getProfile()->getUserId())): ?>
        - <?php echo link_to(__('change owner...'), url_for('binder/changeowner?id=' . $Binder->getId())) ?>
      <?php endif ?>
      </td>
    </tr>
    <?php if($Binder->getTaggerUserId()): ?>
      <tr>
        <th><?php echo __('Tagger') ?></th>
        <td><?php echo $Binder->getTaggerProfile() ?></td>
      </tr>
    <?php endif ?>
    <tr>
      <th><?php echo __('Category') ?></th>
      <td><?php echo $Binder->getCategory() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Title') ?></th>
      <td><?php echo $Binder->getTitle() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Code') ?></th>
      <td><?php echo $Binder->getCode() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Event date') ?></th>
      <td><?php echo $Binder->getEventDate() ?></td>
    </tr>
  </tbody>
</table>

<h2><?php echo __('Assets List') ?></h2>
<?php include_partial('asset/assetpager', array('pager'=>$pager, 'action'=>url_for('binder/show?id=' . $Binder->getId()), 'item_name'=>'asset', 'params'=>'')) ?>

<hr />
<ul class="sf_admin_actions">
  <?php if($Binder->getIsEditable()): ?>
  <li class="sf_admin_action_edit">
  <?php echo link_to(__('Edit Binder'), url_for('binder/edit?id='.$Binder->getId())) ?>
  </li>
  <?php endif ?>
</ul>

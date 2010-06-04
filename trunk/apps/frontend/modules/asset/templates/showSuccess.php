<h1><?php echo $Asset ?></h1>

<?php if($Asset->hasVideoAsset()): ?>
	<?php include_partial('player', array('VideoAsset'=>$Asset->getVideoAsset())) ?>
<?php elseif($Asset->hasPhotoalbumAsset()): ?>
	<?php include_partial('albumviewer', array('PhotoalbumAsset'=>$Asset->getPhotoalbumAsset(), 'session'=>$session)) ?>
<?php else: ?>
	<?php include_partial('thumbnail', array('Asset'=>$Asset, 'link'=>false)) ?>
  <br />
  <br />
<?php endif ?>

<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $Asset->getId() ?></td>
    </tr>
    <tr>
      <th>Status:</th>
      <td><?php echo $Asset->getStatus() ?></td>
    </tr>
    <tr>
      <th>UniqId:</th>
      <td><?php echo $Asset->getUniqid() ?></td>
    </tr>
    <tr>
      <th>Asset type:</th>
      <td><?php echo $Asset->getAssetTypeCode() ?></td>
    </tr>
    <tr>
      <th>Assigned title:</th>
      <td><?php echo $Asset->getAssignedTitle() ?></td>
    </tr>
    <tr>
      <th>Binder:</th>
      <td>
      <?php echo link_to(
        $Asset->getBinderId(),
        url_for('binder/show?id=' . $Asset->getBinderId())
        ) ?>
        &nbsp;
      <?php echo $Asset->getBinder() ?>
      </td>
    </tr>
    <tr>
      <th>Notes:</th>
      <td><?php echo $Asset->getNotes() ?></td>
    </tr>
    <tr>
    <tr>
      <th>Source filename:</th>
      <td><?php echo $Asset->getSourceFilename() ?></td>
    </tr>
    <tr>
      <th>Source file date:</th>
      <td><?php echo $Asset->getSourceFileDatetime() ?></td>
    </tr>
    <tr>
      <th>Highquality md5sum:</th>
      <td><?php echo $Asset->getHighqualityMd5sum() ?></td>
    </tr>
  </tbody>
</table>

<?php if($editable): ?>
<ul class="sf_admin_td_actions">
<li class="sf_admin_action_edit"><?php echo link_to(
  __('Edit'),
  url_for('asset/edit?id='.$Asset->getId())
  )
?></li>
</ul>
<?php endif ?>

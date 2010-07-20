<?php include_partial('welcome/title', array('title'=>__('Asset %asset%', array('%asset%'=>$Asset)))) ?>
<?php use_helper('Wviola') ?>

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
      <th><?php echo __('Id') ?></th>
      <td><?php echo $Asset->getId() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Status') ?></th>
      <td><?php include_partial('asset/status', array('status'=>$Asset->getStatus())) ?></td>
    </tr>
    <tr>
      <th><?php echo __('UniqId') ?></th>
      <td><?php echo $Asset->getUniqid() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Asset Type') ?></th>
      <td><?php echo $Asset->getAssetTypeCode() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Binder') ?></th>
      <td>
      <?php echo link_to(
        $Asset->getBinder(),
        url_for('binder/show?id=' . $Asset->getBinderId())
        ) ?>
        &nbsp;
      (<?php echo $Asset->getBinderId() ?>)
      </td>
    </tr>
    <tr>
      <th><?php echo __('Notes') ?></th>
      <td><?php echo $Asset->getNotes() ?></td>
    </tr>
    <tr>
    <tr>
      <th><?php echo __('Source filename') ?></th>
      <td><?php echo $Asset->getSourceFilename() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Source file date') ?></th>
      <td><?php echo $Asset->getSourceFileDatetime() ?></td>
    </tr>
    <?php if($Asset->getStatus() > Asset::SCHEDULED): ?>
    <tr>
      <th><?php echo __('Highquality md5sum') ?></th>
      <td><?php echo $Asset->getHighqualityMd5sum() ?></td>
    </tr>
    <?php endif ?>
    <?php if($Asset->getIsDownloadable()): ?>
    <tr>
      <th><?php echo __('Highquality file size') ?></th>
      <td><?php echo $Asset->getHighQualityFileSize() ?></td>
    </tr>
    <?php endif ?>
  </tbody>
</table>

<ul class="sf_admin_actions">
<?php if($Asset->getIsEditable()): ?>
<li class="sf_admin_action_edit"><?php echo link_to(
  __('Edit Asset'),
  url_for('asset/edit?id='.$Asset->getId())
  )
?></li>
<?php endif ?>
<?php if($Asset->getIsDownloadable() && $sf_user->hasCredential('admin')): ?>
<li class="sf_admin_action_download"><?php echo link_to(
  __('Download'),
  url_for('asset/download?id='.$Asset->getId())
  )
?></li>
<?php endif ?>
<?php if($sf_user->hasCredential('admin')): ?>
<li class="sf_admin_action_viewlogs"><?php echo link_to(
  __('View access logs'),
  url_for_backend('access_log_assetfilter', array('id'=>$Asset->getId()))
  )
?></li>
<?php endif ?>
</ul>

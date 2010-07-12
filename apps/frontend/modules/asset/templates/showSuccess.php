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
      <th><?php echo __('Id') ?></th>
      <td><?php echo $Asset->getId() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Status') ?></th>
      <td><?php echo $Asset->getStatus() ?></td>
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
      <th><?php echo __('Assigned title') ?></th>
      <td><?php echo $Asset->getAssignedTitle() ?></td>
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
    <tr>
      <th><?php echo __('Highquality md5sum') ?></th>
      <td><?php echo $Asset->getHighqualityMd5sum() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Highquality file size') ?></th>
      <td><?php echo Generic::getHumanReadableSize($Asset->getPublishedFile('high')->getSize()) ?></td>
    </tr>
  </tbody>
</table>

<ul class="sf_admin_td_actions">
<?php if($Asset->getIsEditable()): ?>
<li class="sf_admin_action_edit"><?php echo link_to(
  __('Edit'),
  url_for('asset/edit?id='.$Asset->getId())
  )
?></li>
<?php endif ?>
<?php if($Asset->getIsDownloadable()): ?>
<li class="sf_admin_action_download"><?php echo link_to(
  __('Download'),
  url_for('asset/download?id='.$Asset->getId())
  )
?></li>
<?php endif ?>
</ul>

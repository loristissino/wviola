<h1><?php echo $Asset ?></h1>

<?php if($Asset->hasVideoAsset()): ?>
	<?php include_partial('player', array('VideoAsset'=>$Asset->getVideoAsset())) ?>
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
      <td><?php echo $Asset->getBinderId() ?></td>
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
    <tr>
      <th>Archived in:</th>
      <td><?php echo $Asset->getArchiveId() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('asset/edit?id='.$Asset->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('asset/index') ?>">List</a>

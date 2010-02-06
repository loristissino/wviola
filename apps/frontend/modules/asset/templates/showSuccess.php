<h1><?php echo $Asset ?></h1>

<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $Asset->getId() ?></td>
    </tr>
    <tr>
      <th>Slug:</th>
      <td><?php echo $Asset->getSlug() ?></td>
    </tr>
    <tr>
      <th>Asset type:</th>
      <td><?php echo $Asset->getAssetTypeId() ?></td>
    </tr>
    <tr>
      <th>Assigned title:</th>
      <td><?php echo $Asset->getAssignedTitle() ?></td>
    </tr>
    <tr>
      <th>Category:</th>
      <td><?php echo $Asset->getCategoryId() ?></td>
    </tr>
    <tr>
      <th>Notes:</th>
      <td><?php echo $Asset->getNotes() ?></td>
    </tr>
    <tr>
      <th>Duration:</th>
      <td><?php echo $Asset->getDuration() ?></td>
    </tr>
    <tr>
      <th>Source filename:</th>
      <td><?php echo $Asset->getSourceFilename() ?></td>
    </tr>
    <tr>
      <th>Source file date:</th>
      <td><?php echo $Asset->getSourceFileDate() ?></td>
    </tr>
    <tr>
      <th>Highquality width:</th>
      <td><?php echo $Asset->getHighqualityWidth() ?></td>
    </tr>
    <tr>
      <th>Highquality height:</th>
      <td><?php echo $Asset->getHighqualityHeight() ?></td>
    </tr>
    <tr>
      <th>Highquality video codec:</th>
      <td><?php echo $Asset->getHighqualityVideoCodec() ?></td>
    </tr>
    <tr>
      <th>Highquality audio codec:</th>
      <td><?php echo $Asset->getHighqualityAudioCodec() ?></td>
    </tr>
    <tr>
      <th>Highquality frame rate:</th>
      <td><?php echo $Asset->getHighqualityFrameRate() ?></td>
    </tr>
    <tr>
      <th>Highquality md5sum:</th>
      <td><?php echo $Asset->getHighqualityMd5sum() ?></td>
    </tr>
    <tr>
      <th>Archived in:</th>
      <td><?php echo $Asset->getArchiveId() ?></td>
    </tr>
    <tr>
      <th>Lowquality width:</th>
      <td><?php echo $Asset->getLowqualityWidth() ?></td>
    </tr>
    <tr>
      <th>Lowquality height:</th>
      <td><?php echo $Asset->getLowqualityHeight() ?></td>
    </tr>
    <tr>
      <th>Lowquality video codec:</th>
      <td><?php echo $Asset->getLowqualityVideoCodec() ?></td>
    </tr>
    <tr>
      <th>Lowquality audio codec:</th>
      <td><?php echo $Asset->getLowqualityAudioCodec() ?></td>
    </tr>
    <tr>
      <th>Lowquality frame rate:</th>
      <td><?php echo $Asset->getLowqualityFrameRate() ?></td>
    </tr>
    <tr>
      <th>Lowquality md5sum:</th>
      <td><?php echo $Asset->getLowqualityMd5sum() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $Asset->getUserId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $Asset->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $Asset->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('asset/edit?id='.$Asset->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('asset/index') ?>">List</a>

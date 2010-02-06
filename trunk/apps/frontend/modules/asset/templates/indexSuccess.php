<h1>Assets List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Slug</th>
      <th>Asset type</th>
      <th>Assigned title</th>
      <th>Category</th>
      <th>Notes</th>
      <th>Frames count</th>
      <th>Source filename</th>
      <th>Source file date</th>
      <th>Highquality width</th>
      <th>Highquality height</th>
      <th>Highquality video codec</th>
      <th>Highquality audio codec</th>
      <th>Highquality frame rate</th>
      <th>Highquality md5sum</th>
      <th>Lowquality width</th>
      <th>Lowquality height</th>
      <th>Lowquality video codec</th>
      <th>Lowquality audio codec</th>
      <th>Lowquality frame rate</th>
      <th>Lowquality md5sum</th>
      <th>User</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Assets as $Asset): ?>
    <tr>
      <td><a href="<?php echo url_for('asset/show?id='.$Asset->getId()) ?>"><?php echo $Asset->getId() ?></a></td>
      <td><?php echo $Asset->getSlug() ?></td>
      <td><?php echo $Asset->getAssetTypeId() ?></td>
      <td><?php echo $Asset->getAssignedTitle() ?></td>
      <td><?php echo $Asset->getCategoryId() ?></td>
      <td><?php echo $Asset->getNotes() ?></td>
      <td><?php echo $Asset->getFramesCount() ?></td>
      <td><?php echo $Asset->getSourceFilename() ?></td>
      <td><?php echo $Asset->getSourceFileDate() ?></td>
      <td><?php echo $Asset->getHighqualityWidth() ?></td>
      <td><?php echo $Asset->getHighqualityHeight() ?></td>
      <td><?php echo $Asset->getHighqualityVideoCodec() ?></td>
      <td><?php echo $Asset->getHighqualityAudioCodec() ?></td>
      <td><?php echo $Asset->getHighqualityFrameRate() ?></td>
      <td><?php echo $Asset->getHighqualityMd5sum() ?></td>
      <td><?php echo $Asset->getLowqualityWidth() ?></td>
      <td><?php echo $Asset->getLowqualityHeight() ?></td>
      <td><?php echo $Asset->getLowqualityVideoCodec() ?></td>
      <td><?php echo $Asset->getLowqualityAudioCodec() ?></td>
      <td><?php echo $Asset->getLowqualityFrameRate() ?></td>
      <td><?php echo $Asset->getLowqualityMd5sum() ?></td>
      <td><?php echo $Asset->getUserId() ?></td>
      <td><?php echo $Asset->getCreatedAt() ?></td>
      <td><?php echo $Asset->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('asset/new') ?>">New</a>

<?php echo format_number_choice('[0]There are no pictures in this album.|[1]There is one picture in this album.|(1,+Inf]There are %number% pictures in this album.', array('%number%' => $PhotoalbumAsset->getPicturesCount()), $PhotoalbumAsset->getPicturesCount()) ?>

<?php if(sizeof($PhotoalbumAsset->getPhotoalbumFile()->getFileList())>0): ?>
<ul>
<?php foreach($PhotoalbumAsset->getPhotoalbumFile()->getFileList() as $file): ?>
  <li><?php echo $file ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>

<p><?php echo format_number_choice('[0]There are no pictures in this album.|[1]There is one picture in this album.|(1,+Inf]There are %number% pictures in this album.', array('%number%' => $PhotoalbumAsset->getPicturesCount()), $PhotoalbumAsset->getPicturesCount($session)) ?></p>

<?php if(sizeof($PhotoalbumAsset->getPhotoalbumFile($session)->getFileList())>0): ?>
<?php for($i=0; $i<$PhotoalbumAsset->getPicturesCount($session); $i++): ?>
  <p><img src="<?php echo url_for(
    'asset/showpicture?album='. $PhotoalbumAsset->getAssetId() . 
    '&number='. $i
    ) ?>"
    width="<?php echo $PhotoalbumAsset->getPictureWidth($i, $session) ?>"
    height="<?php echo $PhotoalbumAsset->getPictureWidth($i, $session) ?>"
    alt="<?php echo __('Picture number %number%, original file name %name%',
      array('%number%'=>$i, '%name%' =>$PhotoalbumAsset->getFilename($i, $session))
      ) ?>" /><br />
  <?php echo __('%number%) «%filename%»', array('%number%'=>$i+1, '%filename%'=>$PhotoalbumAsset->getFilename($i, $session))) ?>
  </p>
<?php endfor ?>
<?php endif ?>

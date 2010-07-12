<?php use_javascript('prototype.js') ?>
<?php use_javascript('scriptaculous.js?load=effects,builder') ?>
<?php use_javascript('lightbox.js') ?>
<?php use_stylesheet('lightbox.css') ?>


<p><?php echo format_number_choice('[0]There are no pictures in this album.|[1]There is one picture in this album.|(1,+Inf]There are %number% pictures in this album.', array('%number%' => $PhotoalbumAsset->getPicturesCount()), $PhotoalbumAsset->getPicturesCount($session)) ?></p>

<?php if(sizeof($PhotoalbumAsset->getPhotoalbumFile($session)->getFileList())>0): ?>
<p><?php for($i=0; $i<$PhotoalbumAsset->getPicturesCount($session); $i++): ?>
  <?php echo link_to(
    '<img src="' . url_for(
      'asset/showpicture?album='. $PhotoalbumAsset->getAssetId() . 
      '&number='. $i) . '" width="' . $PhotoalbumAsset->getReducedPictureWidth($i, $session) . '" height="' . $PhotoalbumAsset->getReducedPictureHeight($i, $session) . '">',
    url_for(
    'asset/showpicture?album='. $PhotoalbumAsset->getAssetId() . 
    '&number='. $i
    ),
    array(
      'rel'=>'lightbox[' . $PhotoalbumAsset->getAssetId(). ']',
      'title'=>__(
        'Picture number %number%, original file name %name%',
        array('%number%'=>$i, '%name%' =>$PhotoalbumAsset->getFilename($i, $session))
      )
      )
    )?>
    <?php endfor ?>
</p>
<?php endif ?>

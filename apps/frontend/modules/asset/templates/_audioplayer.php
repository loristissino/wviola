<div>
<img src="<?php echo image_path('audio_cover') ?>" ?>
</div>

<audio controls controlsList="nodownload">
  <source src="<?php echo url_for('@audiomp3?id=' . $AudioAsset->getAssetId() .'&sf_format=mp3') ?>" type="audio/mpeg">
  Your browser does not support the audio element.
</audio> 


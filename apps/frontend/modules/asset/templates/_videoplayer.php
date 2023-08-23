<video width="<?php echo $VideoAsset->getLowQualityCorrectedWidth() ?>" height="<?php echo $VideoAsset->getLowQualityHeight() ?>" controls controlsList="nodownload">
  <source src="<?php echo url_for('asset/video/?id=' . $VideoAsset->getAssetId())  ?>" type="video/webm">
Your browser does not support the video tag.
</video> 


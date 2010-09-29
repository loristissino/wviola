<?php use_javascript('flowplayer-3.2.4.min.js') ?>
<p id="player" style="display:block;width:<?php echo $VideoAsset->getLowQualityCorrectedWidth() ?>px;height:<?php echo $VideoAsset->getLowQualityHeight() ?>px;"></p>
<script>
$f("player", "/flash/flowplayer/flowplayer-3.2.4.swf", {
		playlist: [
		{url: '<?php echo url_for('asset/video?id=' . $VideoAsset->getAssetId()) ?>'}
		]
		}
		)
</script>
	
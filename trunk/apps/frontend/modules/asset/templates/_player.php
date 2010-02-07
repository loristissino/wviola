<?php use_javascript('flowplayer-3.1.4.min.js') ?>
<p id="player" style="display:block;width:<?php echo $Asset->getLowQualityWidth() ?>px;height:<?php echo $Asset->getLowQualityHeight() ?>px;"></p>
<script>
	flowplayer("player", "/flash/flowplayer/flowplayer-3.1.5.swf", {
		playlist: [
		{url: '<?php echo url_for('asset/video?id=' . $Asset->getId()) ?>'}
		]
		}
		)
</script>
	
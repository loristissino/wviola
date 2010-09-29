<?php use_javascript('flowplayer-3.2.4.min.js') ?>
<p id="player" style="display:block;width:500px;height:200px;"></p>
<script>
$f("player", "/flash/flowplayer/flowplayer-3.2.4.swf", {

	clip: { 
	   url: '<?php echo url_for('@audiomp3?id=' . $AudioAsset->getAssetId() .'&sf_format=mp3') ?>',
	   
	   // this style of configuring the cover image was added in audio
	   // plugin version 3.2.3
	   coverImage: { url: '<?php echo image_path('audio_cover') ?>' } 
	}

});
</script>

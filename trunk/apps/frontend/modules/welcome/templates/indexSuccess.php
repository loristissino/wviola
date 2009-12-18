<?php use_javascript('flowplayer-3.1.4.min.js') ?>


<h1>Welcome to WVIOLA</h1>

<h2>What is WVIOLA?</h2>
<p>WVIOLA stands for <em>Web-based Video and Images On-Line Archiver</em>.</p>

<h2>What does WVIOLA do for me?</h2>
<p>At current time, absolutely nothing...</p>


<p id="player" style="display:block;width:282px;height:200px;"></p> 
	
<script>
	flowplayer("player", "flowplayer/flowplayer-3.1.5.swf", {
		
		playlist: [ 
        {url: 'http://e1h13.simplecdn.net/flowplayer/flowplayer.flv'}  
    ], 
		
		});
</script>


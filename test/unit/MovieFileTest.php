<?php

require_once dirname(__FILE__).'/../bootstrap/FileSystem.php';
 
$t = new lime_test(5, new lime_output_color());

$t->diag('MovieFile functions');

$file=new MovieFile('/var/wviola/data/filesystem/sources/videos/bigbuckbunny01.avi');

$frame=$file->getFrameAsJpegBase64(0, 640, 480, 60, 45);

$tempname=tempnam('/tmp', 'wvtest');
$fp = fopen($tempname, 'w');
fwrite($fp, base64_decode($frame));
fclose($fp);

list($width, $height, $type, $attr) = getimagesize($tempname);

unlink($tempname);

$t->is(($width==60 && $height==45), true, '->getFrameAsJpegBase64() returns the correct frame');

$frame=$file->getFrameAsJpegBase64(10, 640, 480, 60, 45);

$t->is($frame, false, '->getFrameAsJpegBase64() returns false when frame is not extracted');

$t->is($file->getExplicitAspectRatio(), false, '->getExplicitAspectRatio() returns false for an AVI file');

unset($file);

$file=new MovieFile('/var/wviola/data/filesystem/sources/videos/bigbuckbunny02.mpeg');

$t->is($file->getExplicitAspectRatio(), 1.33469665985, '->getExplicitAspectRatio() returns the correct Aspect Ratio (DAR) for an MPEG file');

unset($file);

$file=new MovieFile('/var/wviola/data/filesystem/sources/videos/bigbuckbunny01.ogv');

$t->is($file->getExplicitAspectRatio(), false, '->getExplicitAspectRatio() returns false for a theora file without explicit DAR');


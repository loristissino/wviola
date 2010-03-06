<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(3, new lime_output_color());

$uniqid='vid_4ab00000000000.10000000';
$video= new ThumbnailFile($uniqid);

$t->is($video->getUniqid(), $uniqid, '->getUniqid() returns the correct uniqid');
$t->is($video->getAssetType(), 'thumbnail', '->getAssetType() returns the correct asset type');
$t->is($video->getStandardExtension(), 'jpeg', '->getStandardExtension() returns the correct extension');

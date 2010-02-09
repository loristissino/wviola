<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(3, new lime_output_color());

$slug='video2009_00000001';
$video= new VideoFile($slug);

$t->is($video->getSlug(), $slug, '->getSlug() returns the correct slug');
$t->is($video->getAssetType(), 'video', '->getAssetType() returns the correct asset type');
$t->is($video->getStandardExtension(), 'flv', '->getStandardExtension() returns the correct extension');

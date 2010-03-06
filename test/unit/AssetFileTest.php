<?php

require_once dirname(__FILE__).'/../bootstrap/FileSystem.php';
 
$t = new lime_test(2, new lime_output_color());

$t->diag('AssetFile functions');

$uniqid='vid_4ab00000000000.10000000';
$file=new AssetFile($uniqid, 'flv');

$t->is($file->getUniqid(), $uniqid, '->getUniqid() returns the uniq id');
$t->is($file->getExtension(), 'flv', '->getExtension() returns the extension');

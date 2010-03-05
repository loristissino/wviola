<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(2, new lime_output_color());

$t->diag('Asset');

$uniqid='vid_4ab00000000000.10000000';

$Asset=AssetPeer::retrieveByUniqid($uniqid);
$t->is($Asset->getAssetTypeCode(), 'video', '->getAssetTypeCode() returns the correct code for videos');
$t->is($Asset->getAssetTypeShortCode(), 'vid', '->getAssetTypeCode() returns the correct code for videos');
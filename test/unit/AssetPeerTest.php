<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(2, new lime_output_color());

$t->diag('AssetPeer');

$uniqid='vid_4ab00000000000.10000000';

$Asset=AssetPeer::retrieveByUniqid($uniqid);
$t->is($Asset->getAssignedTitle(), 'Outdoor meeting', '::retrieveByUniqid() retrieves the correct object');
unset($Asset);

$Asset=AssetPeer::retrieveBySourceSizeAndMd5sum(260288, '8df3f37d4cb351d5129b92d251985455:f');
$t->is($Asset->getAssignedTitle(), 'Apple', '::retrieveBySourceSizeAndMd5sum() retrieves the correct asset');
<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(1, new lime_output_color());

$t->diag('AssetPeer');

$uniqid='vid_4ab00000000000.10000000';

$Asset=AssetPeer::retrieveByUniqid($uniqid);
$t->is($Asset->getAssignedTitle(), 'Outdoor meeting', '::retrieveByUniqid() retrieves the correct object');
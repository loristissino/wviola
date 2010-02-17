<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(1, new lime_output_color());

$t->diag('AssetPeer');

$slug='video2009_00000001';

$Asset=AssetPeer::retrieveBySlug($slug);
$t->is($Asset->getAssignedTitle(), 'Outdoor meeting', '::retrieveBySlug() retrieves the correct object');
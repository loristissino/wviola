<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(3, new lime_output_color());

$t->diag('Asset');

$uniqid='vid_4ab00000000000.10000000';

$Asset=AssetPeer::retrieveByUniqid($uniqid);
$t->is($Asset->getAssetTypeCode(), 'video', '->getAssetTypeCode() returns the correct code for videos');
$t->is($Asset->getAssetTypeShortCode(), 'vid', '->getAssetTypeCode() returns the correct code for videos');

unset($Asset);


$uniqid='vid_4ab00000000000.20000000';

$user = sfGuardUserProfilePeer::getByUsername('matthew');
$user_id=$user->getId();

$cookie=md5('abc');

AssetPeer::retrieveByUniqid($uniqid)->logAccess($user_id, $cookie);
AssetPeer::retrieveByUniqid($uniqid)->logAccess($user_id, $cookie);
AssetPeer::retrieveByUniqid($uniqid)->logAccess($user_id, $cookie);

$cookie=md5('def');
AssetPeer::retrieveByUniqid($uniqid)->logAccess($user_id, $cookie);

$Asset=AssetPeer::retrieveByUniqid($uniqid);
$t->is($Asset->countAccessLogEvents(), 2, '->logAccess() logs the access once per session');
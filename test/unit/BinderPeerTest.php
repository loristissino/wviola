<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(1, new lime_output_color());

$t->diag('BinderPeer');

$user=sfGuardUserProfilePeer::getByUsername('matthew');

$binders = BinderPeer::retrieveByUserId($user->getId());

$t->is(sizeof($binders), 3, '::retrieveByUserId() retrieves the correct binders');

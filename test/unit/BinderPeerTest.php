<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(3, new lime_output_color());

$t->diag('BinderPeer');

$user=sfGuardUserProfilePeer::getByUsername('matthew');

$binders = BinderPeer::retrieveByUserId($user->getId());

$t->is(sizeof($binders), 22, '::retrieveByUserId() retrieves the correct binders');

$binders = BinderPeer::retrieveByTitle('Spring');

$t->is($binders[0]->getEventDate('Y-m-d'), '2009-12-21', '::retrieveByTitle() retrieves the correct binders');

$binders = BinderPeer::retrieveByTitle('S');

$t->is(sizeof($binders), 2, '::retrieveByTitle() works with LIKE criteria');

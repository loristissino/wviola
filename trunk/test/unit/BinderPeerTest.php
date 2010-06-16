<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(3, new lime_output_color());

$t->diag('BinderPeer');

$user=sfGuardUserProfilePeer::getByUsername('matthew');

$binders = BinderPeer::retrieveByUserId($user->getId());

$t->is(sizeof($binders), 20, '::retrieveByUserId() retrieves the correct binders');

$binders = BinderPeer::retrieveByNotes('Spring');

$t->is($binders[0]->getEventDate('Y-m-d'), '2009-12-21', '::retrieveByNotes() retrieves the correct binders');

$binders = BinderPeer::retrieveByNotes('S');

$t->is(sizeof($binders), 2, '::retrieveByNotes() works with LIKE criteria');

<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(1, new lime_output_color());

$t->diag('sfGuardUserProfile');

$user=sfGuardUserProfilePeer::getByUsername('matthew');

$c = $user->getProfile()->getBinderCriteria();

$t->isa_ok($c, 'Criteria', '->getBinderCriteria() returns a Criteria object');

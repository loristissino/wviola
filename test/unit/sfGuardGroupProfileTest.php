<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(2, new lime_output_color());

$t->diag('sfGuardGroupProfile');

$list=sfGuardGroupProfilePeer::retrieveAllGuardGroupsAsArray();

$t->is(is_array($list), true, '::retrieveAllGuardGroupsAsArray() returns an array');
$t->is(count($list), 3, '::retrieveAllGuardGroupsAsArray() returns an array of three elements');


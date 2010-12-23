<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(2, new lime_output_color());

$t->diag('ArchivePeer');

$max=ArchivePeer::getMaxByType(ArchivePeer::HIGH_QUALITY_ARCHIVE);
$t->is($max, 2, '::getMaxByType(1) returns the correct value');

$max=ArchivePeer::getMaxByType(ArchivePeer::LOW_QUALITY_ARCHIVE);
$t->is($max, 0, '::getMaxByType(2) returns the correct value');


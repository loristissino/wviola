<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(7, new lime_output_color());

$t->diag('SourceFile functions');

$file=new SourceFile('/videos', 'video3.avi');

$t->is($file->getBasicPath(), '/var/wviola/data/filesystem/sources', '->getBasicPath() returns the correct value');
$t->is($file->getBasename(), 'video3.avi', '->getBasename() returns the correct value');
$t->is($file->getWvDirPath(), '/var/wviola/data/filesystem/sources/videos/.wviola', '->getWvDirPath() returns the correct value');

$t->is($file->getWvDirIsReadable(), false, '->getWvDirIsReadable() returns the correct value');
$t->is($file->getWvDirIsWriteable(), false, '->getWvDirIsWriteable() returns the correct value');
$t->is($file->canWriteWvDir(), true, '->canWriteWvDir() returns the correct value');

$t->is($file->getMD5Sum(), 'e3344ad61822bef9d5ccaa10d78a4d27', '->getMD5Sum() returns the correct value');



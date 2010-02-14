<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(7, new lime_output_color());

$t->diag('SourceFile functions');

$t->comment('Copying the files needed for the test to start with a clean directory...');
Generic::executeCommand('rm -rf "/var/wviola_filesystem/sources"');
Generic::executeCommand('mkdir "/var/wviola_filesystem/sources"');
Generic::executeCommand('rsync -avz --progress "/var/wviola_filesystem/original_sources/" "/var/wviola_filesystem/sources"');
$t->comment('... done');

$file=new SourceFile('/videos', 'video3.avi');

$t->is($file->getBasicPath(), '/var/wviola_filesystem/sources', '->getBasicPath() returns the correct value');
$t->is($file->getBasename(), 'video3.avi', '->getBasename() returns the correct value');
$t->is($file->getWvDirPath(), '/var/wviola_filesystem/sources/videos/.wviola', '->getWvDirPath() returns the correct value');

$t->is($file->getWvDirIsReadable(), false, '->getWvDirIsReadable() returns the correct value');
$t->is($file->getWvDirIsWriteable(), false, '->getWvDirIsWriteable() returns the correct value');
$t->is($file->canWriteWvDir(), true, '->canWriteWvDir() returns the correct value');

$file->loadWvInfoFile();

$file->setWvInfo('video_frame_width', 320);
$t->is($file->getWvInfo('video_frame_width'), 320, '->getWvInfo() returns the correct value');

echo $file->getWvInfoFilePath() . "\n";

$file->saveWvInfoFile();
//var_dump($file->getCompleteWvInfo());
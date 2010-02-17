<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(10, new lime_output_color());

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

$t->is($file->getHasWvInfo(), false, '->getHasWvInfo() returns false if there are not information about the file');

$file->setWvInfo('video_frame_width', 320);
$file->setWvInfo('video_frame_height', 240);
$t->is($file->getWvInfo('video_frame_width'), 320, '->getWvInfo() returns the correct value');
$t->is($file->getHasWvInfo(), true, '->getHasWvInfo() returns true if there are information about the file');

$file->saveWvInfoFile();
// we save the file, unset the object and get a new instance for the same file...
unset($file);
$file=new SourceFile('/videos', 'video3.avi');
$t->is($file->getWvInfo('video_frame_width'), 320, '->saveWvInfoFile() correctly saved the information on the file');

$file->gatherWvInfo();

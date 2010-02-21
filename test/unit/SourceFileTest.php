<?php

require_once dirname(__FILE__).'/../bootstrap/FileSystem.php';
 
$t = new lime_test(14, new lime_output_color());

$t->diag('SourceFile functions');

$file=new SourceFile('/videos', 'bigbuckbunny01.avi');

$t->is($file->getBasicPath(), '/var/wviola/data/filesystem/sources', '->getBasicPath() returns the correct value');
$t->is($file->getBasename(), 'bigbuckbunny01.avi', '->getBasename() returns the correct value');
$t->is($file->getWvDirPath(), '/var/wviola/data/filesystem/sources/videos/.wviola', '->getWvDirPath() returns the correct value');

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
$file=new SourceFile('/videos', 'bigbuckbunny01.avi');
$t->is($file->getWvInfo('video_frame_width'), 320, '->saveWvInfoFile() correctly saved the information on the file');

$t->comment('Now we test information gathering...');
$file->gatherWvInfo();
$file->saveWvInfoFile();

$t->is($file->getWvInfo('video_frame_width'), 854, '->saveWvInfoFile() correctly saved the information on the file');
$t->is($file->getWvInfo('video_aspect_ratio'), 1.77916666667, '->gatherWvInfo() correctly finds the aspect ratio for an AVI file');

unset($file);

$file=new SourceFile('/videos', 'bigbuckbunny02.mpeg');
$file->gatherWvInfo();
$file->saveWvInfoFile();

$t->is($file->getWvInfo('video_aspect_ratio'), 1.33469665985, '->gatherWvInfo() correctly finds the aspect ratio for an MPEG file');

$image=base64_decode($file->getWvInfo('thumbnail_0_base64content'));

$tempfile=tempnam('/tmp', 'wviola');
file_put_contents($tempfile, $image);

$t->is_deeply(getimagesize($tempfile), array (0 => 60,  1 => 45,  2 => 2,  3 => 'width="60" height="45"',  'bits' => 8,  'channels' => 3,  'mime' => 'image/jpeg'), '->gatherWvInfo() produces a thumbnail as base64 content');

unlink($tempfile);

unset($file);
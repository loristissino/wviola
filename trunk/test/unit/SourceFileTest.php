<?php

require_once dirname(__FILE__).'/../bootstrap/FileSystem.php';
 
$t = new lime_test(34, new lime_output_color());

$t->diag('SourceFile functions');

$file=new SourceFile('/newvideos', 'fakevideo.mpeg');

$t->is($file->getRelativePath(), '/newvideos', '->getRelativePath() returns the correct value');

$t->is($file->getBasicPath(), '/var/wviola/data/filesystem/sources', '->getBasicPath() returns the correct value');
$t->is($file->getBasename(), 'fakevideo.mpeg', '->getBasename() returns the correct value');
$t->is($file->getWvDirPath(), '/var/wviola/data/filesystem/sources/newvideos/.wviola', '->getWvDirPath() returns the correct value');

$t->is($file->getWvDirIsReadable(), false, '->getWvDirIsReadable() returns the correct value');
$t->is($file->getWvDirIsWriteable(), false, '->getWvDirIsWriteable() returns the correct value');
$t->is($file->canWriteWvDir(), true, '->canWriteWvDir() returns the correct value');

$t->is($file->getHasWvInfo(), false, '->getHasWvInfo() returns false if there is no information about the file');

unset($file);

$file=new SourceFile('/videos', 'bigbuckbunny01.avi');

$file->setWvInfo('video_frame_width', 320);
$file->setWvInfo('video_frame_height', 240);
$t->is($file->getWvInfo('video_frame_width'), 320, '->getWvInfo() returns the correct value');
$t->is($file->getHasWvInfo(), true, '->getHasWvInfo() returns true when information about the file is present');


$file->gatherWvInfo(true);
//we need to gather some basic info about the file, in order to allow timestamp comparisons...
$file->saveWvInfoFile();

// we save the file, unset the object and get a new instance for the same file...

//echo $file->getStat('ino');
unset($file);
//die();
$file=new SourceFile('/videos', 'bigbuckbunny01.avi');
$t->is($file->getWvInfo('video_frame_width'), 320, '->saveWvInfoFile() correctly saved the information on the file');

$t->comment('Now we test information gathering...');
$file->gatherWvInfo();
$file->saveWvInfoFile();

$t->is($file->getWvInfo('video_frame_width'), 854, '->saveWvInfoFile() correctly saved the information on the file');
$t->is($file->getWvInfo('video_aspect_ratio'), 1.77916666667, '->gatherWvInfo() correctly finds the aspect ratio for an AVI file');
$t->is($file->getWvInfo('file_archivable'), true, '->gatherWvInfo() correctly sets archivable to true for an AVI file');

unset($file);

$file=new SourceFile('/videos', 'bigbuckbunny02.mpeg');
$file->gatherWvInfo();
$file->saveWvInfoFile();

$t->is($file->getWvInfo('video_aspect_ratio'), 1.33469665985, '->gatherWvInfo() correctly finds the aspect ratio for an MPEG file');

$image=base64_decode($file->getWvInfo('thumbnail_0_base64content'));

$tempfile=tempnam('/tmp', 'wviola');
file_put_contents($tempfile, $image);

$t->is_deeply(getimagesize($tempfile), array (0 => 60,  1 => 45,  2 => 2,  3 => 'width="60" height="45"',  'bits' => 8,  'channels' => 3,  'mime' => 'image/jpeg'), '->gatherWvInfo() produces a thumbnail as base64 content');

$t->is(sizeof($file->getWvInfo('thumbnail')), 8, '->gatherWvInfo() produces an array of thumbnails');

unlink($tempfile);

unset($file);

$file=new SourceFile('/videos', 'bigbuckbunny02.mpeg');
$t->is($file->getHasWvInfo(), true, '->getHasWvInfo() returns true if information about the file was already collected');

$t->is($file->getHasMd5Sum(), false, '->getHasMD5Sum() returns false when MD5 was not already computed');

$t->comment('computing MD5Sum');
$file->appendMD5Sum();


$t->is($file->getHasMd5Sum(), true, '->getHasMD5Sum() returns true when MD5 was already computed');

$filepath=$file->getFullPath();

unset($file);

touch($filepath);

$file=new SourceFile('/videos', 'bigbuckbunny02.mpeg');

$t->is($file->getHasWvInfo(), false, '->getHasWvInfo() returns false when a file has been changed');

$t->is(sizeof($file->getCompleteWvInfo()), 0, '->getCompleteWvInfo() returns an empty array when a file has been modified');

unset($file);

foreach(array(
'bigbuckbunny01.avi' => false,
'bigbuckbunny02.mpeg' => false,
'bigbuckbunny01.link.avi' => true,
'tobeskipped.avi~' => true,
'tobeskipped.doc' => true,
'tobeskipped.DOC' => true,
'tobeskipped.odt' => true,
) as $key=>$value)
{
	$file=new SourceFile('/videos', $key);
	$t->is($file->getShouldBeSkipped(), $value, '->getShouldBeSkipped() returns ' . ($value?'true':'false') . ' for ' . $key);
	unset($file);
}

$file=new SourceFile('/videos', 'tobeskipped.doc');
$file->gatherWvInfo();
$t->isnt($file->getWvInfo('file_archivable'), true, '->gatherWvInfo() does not set archivable to true for not archivable documents');
unset($file);


$file=new SourceFile('/videos', 'big_buck_apple_duplicate.mpeg');
$file
->gatherWvInfo()
->appendMD5Sum();
$id=$file->getWvInfo('file_asset_id');

$t->isnt($id, null, '->getWvInfo() returns the id of an asset that has the same size and md5sum');

$t->diag('->moveToScheduled()');

unset($file);
$file=new SourceFile('/videos', 'bigbuckbunny01.avi');
$uniqid=$file->moveFileToScheduled('vid');
$t->cmp_ok($uniqid, '!==', false, '->moveFileToScheduled() returns the uniqid of the file');
$t->is(file_exists(wvConfig::get('directory_scheduled') . '/' . $uniqid), true, '->moveFileToScheduled() actually moves the file');
$t->is(file_exists($file->getWvInfoFilePath()), false, '->moveFileToScheduled() deletes the wvinfo file');


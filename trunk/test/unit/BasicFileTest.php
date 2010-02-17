<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(10, new lime_output_color());

$t->diag('BasicFile functions');

$tmpfname = tempnam('/tmp', 'foo');

$handle = fopen($tmpfname, "w");
fwrite($handle, "bar");
fclose($handle);

$file=new BasicFile($tmpfname);

$t->is($file->getFullPath(), $tmpfname, '->getFullPath() returns the correct fullpath');

$t->is($file->getStat('size'), 3, '->getStat() returns the correct stat value (size)');

$t->is(is_array($file->getStats()), true, '->getStats() returns the complete array of stat values');

unset($file);

$file=new BasicFile(dirname($tmpfname), basename($tmpfname));
$t->is($file->getFullPath(), $tmpfname, '->__construct() works with two parameters');

unset($file);

unlink($tmpfname);

try
{
	$file=new BasicFile($tmpfname);
	$t->fail('an exception is not thrown when the file does not exist or is unreadable');
}
catch (Exception $e)
{
	$t->pass('an exception is thrown when the file does not exist or is unreadable');
}

unset($file);

$file=new BasicFile('/var/wviola_filesystem/sources/videos/video3.avi');
$t->is($file->getMD5Sum(), 'e3344ad61822bef9d5ccaa10d78a4d27', '->getMD5Sum() returns the correct value');

$t->is($file->executeCommand('/bin/echo foo'), 'foo', '->executeCommand() returns the result of a command as a string');
$t->is_deeply($file->executeCommand('/bin/echo -e \'foo\nbar\''), array('foo', 'bar'), '->executeCommand() returns the result of a command');

try
{
	$file->executeCommand('/bin/foobar 2>/dev/null');
	$t->fail('->executeCommand() does not throw an exception when there is an error');
}
catch (Exception $e)
{
	$t->pass('->executeCommand() throws an exception when there is an error');
}

$t->is($file->getGuessedInternetMediaType(), 'video/x-msvideo', '->getMimeType() returns the correct MIME Type');
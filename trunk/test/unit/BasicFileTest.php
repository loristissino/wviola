<?php

require_once dirname(__FILE__).'/../bootstrap/FileSystem.php';
 
$t = new lime_test(11, new lime_output_color());

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

$file=new BasicFile('/var/wviola/data/filesystem/sources/videos/bigbuckbunny01.avi');
$t->is($file->getMD5Sum(), 'e2b994bdfeeebb07da40c284ce580bb3', '->getMD5Sum() returns the correct value');

$t->is($file->executeCommand('/bin/echo foo'), 'foo', '->executeCommand() returns the result of a command as a string');
$t->is_deeply($file->executeCommand('/bin/echo -e \'foo\nbar\''), array('foo', 'bar'), '->executeCommand() returns the result of a command');
$t->is($file->executeCommand('testcommand', true), 'This is a test', '->executeCommand() executes a custom command');


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
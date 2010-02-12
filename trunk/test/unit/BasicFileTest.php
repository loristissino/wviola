<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(5, new lime_output_color());

$t->diag('BasicFile functions on an existing file');

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




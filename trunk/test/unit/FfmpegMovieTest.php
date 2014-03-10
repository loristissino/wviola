<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(6, new lime_output_color());

$t->diag('FfmpegMovie test');

$movie = new FfmpegMovie('/tmp/VideoTest.avi');

$t->is($movie->getDuration(), 25.800000, '::getDuration() works');
$t->is($movie->getFrameWidth(), 704, '::getFrameWidth() works');
$t->is($movie->getFrameHeight(), 576, '::getFrameHeight() works');
$t->is($movie->getFrameRate(), 25, '::getFrameRate() works');
$t->is($movie->getVideoCodec(), 'mpeg2video', '::getVideoCodec() works');
$t->is($movie->getAudioCodec(), 'mp2', '::getAudioCodec() works');


/*
$t->is(wvConfig::get('directory_published_assets'), '/var/wviola/data/filesystem/published/assets', '::get() returns the correct value');
$t->is(wvConfig::get('foo', 'bar'), 'bar', '::get() returns the default value for missing parameters');

wvConfig::set('foo', 'bar');
$t->is(wvConfig::get('foo', 'bar'), 'bar', '::set() sets a value');
$t->is(wvConfig::has('foo'), true, '::has() returns true for an existing parameter');
$t->is(wvConfig::has('bar'), false, '::has() returns false for a non existing parameter');

$t->is(is_array(wvConfig::getAll()), true, '::getAll() returns an array of values');
*/
/*
This works, but since it's dependant on the config file, we can't use it for real tests...
$t->is_deeply(wvConfig::get('filebrowser_white_list'), 
array('/png$/i', '/jpg$/i', '/mov$/i', '/mpeg$/i', '/mpg$/i', '/avi$/i', '/ogv$/i', '/mp4$/i', '/zip$/i' ),
'::get() returns an array of items if an array is defined');
*/
/*
wvConfig::add(array('foo1'=>'bar1', 'foo2'=>'bar2'));
$t->is(wvConfig::get('foo1'), 'bar1', '::add() merges new parameters');
$t->is(wvConfig::get('foo'), 'bar', '::add() keeps old parameters');
*/

/*
The following does not work... I have to figure out why...

$configfile='/var/wviola/config/wviola.yml';

$stat=stat($configfile);

$t->diag('wvConfig test -- we try to simulate an exception cutting permissions on config file');

echo "before stat: " . fileperms($configfile);
clearstatcache();

chmod($configfile, "-r");
clearstatcache();
echo "now stat: " . fileperms($configfile);

try
{
	wvConfig::get('directory_published');
	$t->fail('An exception was not thrown for an unreadable config file');
}
catch (Exception $e)
{
	$t->pass('An exception was thrown for an unreadable config file');
}

$t->diag('wvConfig test -- we set the right permissions back');

chmod('/var/wviola/config/wviola.yml', $stat['mode']);

*/

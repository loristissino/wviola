<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(8, new lime_output_color());

$t->diag('wvConfig test -- this will only pass with default values of wviola.yml');

$t->is(wvConfig::get('directory_published'), '/var/wviola/data/filesystem/published', '::get() returns the correct value');
$t->is(wvConfig::get('foo', 'bar'), 'bar', '::get() returns the default value for missing parameters');

wvConfig::set('foo', 'bar');
$t->is(wvConfig::get('foo', 'bar'), 'bar', '::set() sets a value');
$t->is(wvConfig::get('foo'), true, '::has() returns true for an existing parameter');
$t->is(wvConfig::get('bar'), false, '::has() returns false for a non existing parameter');

$t->is(is_array(wvConfig::getAll()), true, '::getAll() returns an array of values');

wvConfig::add(array('foo1'=>'bar1', 'foo2'=>'bar2'));
$t->is(wvConfig::get('foo1'), 'bar1', '::add() merges new parameters');
$t->is(wvConfig::get('foo'), 'bar', '::add() keeps old parameters');



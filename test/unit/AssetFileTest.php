<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(3, new lime_output_color());

$t->diag('AssetFile functions');

$slug='video2009_00000001';
$file=new AssetFile($slug, 'flv');

$t->is($file->getSlug(), $slug, '->getSlug() returns the slug');
$t->is($file->getExtension(), 'flv', '->getExtension() returns the extension');

$t->is($file->getStat('size'), 232235, '->getStat() is correctly inherited');


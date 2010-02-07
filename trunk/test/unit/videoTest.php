<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(3, new lime_output_color());

$settings=sfYaml::load(sfConfig::get('sf_config_dir').'/wviola.yml');

$slug='video2009_00000001';
$video= new Video($slug);

$t->is($video->getSlug(), $slug, '->getSlug() returns the correct slug');
$t->is($video->getVideoSize(), 232235, '->getVideoSize() returns the correct video size');
$t->is($video->getFilename(), $settings['directory']['published'] . '/' . $slug . '.flv', '->getFilename() returns the correct filename');

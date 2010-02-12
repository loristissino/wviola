<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$loader = new sfPropelData();
$loader->loadData(sfConfig::get('sf_test_dir').'/fixtures');

$browser = new wvAuthenticatedTestFunctional(new sfBrowser());

$browser->
  get('/')->

  with('request')->begin()->
    isParameter('module', 'welcome')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()
	->isStatusCode(401)
  ->end()
;
	
$browser->
  get('/login')->
  with('request')->begin()->
	isParameter('module', 'sfGuardAuth')->
	isParameter('action', 'signin')->
  end()->
  
  with('response')->begin()->
    isStatusCode(401)->
  end()
;


<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$loader = new sfPropelData();
$loader->loadData(sfConfig::get('sf_test_dir').'/fixtures');

$browser = new wvAuthenticatedTestFunctional(new sfBrowser());

$browser->authenticate('matthew', 'matthewpwd');

$browser->
	get('/profile')->
	
	with('response')->begin()->
		isStatusCode(200)->
    checkElement('h1#maintitle', "/Matthew's profile/")->
	end()
	;

$browser->
	get('/')->
	
	with('response')->begin()->
		isStatusCode(200)->
		checkElement('h1', '/Welcome to WVIOLA/')->
	end()
	;

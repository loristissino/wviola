<?php

class wvAuthenticatedTestFunctional extends sfTestFunctional

{
	// From: http://forum.symfony-project.org/index.php/m/90239/
	/**
	 * Authenticates a user with a given username and password.
	 * 
	 * @param string $username username of the user
	 * @param string $password password of the user
	 * @param string $click value of the link or button to submit the login form
	 * @param string $nameFormat name format of the form
	 * 
	 * @return sfTestBrowser The current sfTestBrowser instance
	 */
	public function authenticate($username, $password, $click = 'sign in', $nameFormat = 'signin')  {
		
		$signin_url = sfConfig::get('sf_login_module','default').'/'.sfConfig::get('sf_login_action','default');
    

    return $this->get($signin_url)->click($click,
      array($nameFormat => array(
          'username' => $username,
          'password' => $password
      ))
    )->with('user')->isAuthenticated();
    
	}
	
}
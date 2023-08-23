<?php

class Authentication {

	static function testOnly($username, $password)
	{
		return true;
	}


	static function checkLdapPassword($username, $password)
	{
		$server=sfConfig::get('app_authentication_ad_host');
		$nisdomain=sfConfig::get('app_authentication_ad_nisdomain');

		if (!($connect = ldap_connect($server))) {
			die ("Could not connect to LDAP server\n");
		   }

		ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);

		return @ldap_bind($connect, $nisdomain . "\\" . $username, $password);
	}
    
}

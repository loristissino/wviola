<?php

class wviolaSyncusersTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
      new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'whether the execution will be logged in the DB', 'true'),

    ));

    $this->namespace        = 'wviola';
    $this->name             = 'sync-users';
    $this->briefDescription = 'synchronizes users from an external source (LDAP)';
    $this->detailedDescription = <<<EOF
The [wviola:sync-users|INFO] task synchronizes users from an external source.
The source is the same LDAP server specified in app.yml for authentication,
while the associations LDAP group => Wviola/sfGuardGroup are specified in 
Call it with:

  [php symfony wviola:sync-users|INFO]
EOF;

    $this->_foundUsers=Array();

    $this->_isLogged=true;
    $this->_logEvent;


  }
  
  protected function checkUser($user)
  {
    $username=$user[sfConfig::get('app_authentication_ldap_userattribute_username')][0];
    $email=@$user[sfConfig::get('app_authentication_ldap_userattribute_email')][0];
    $firstname=@$user[sfConfig::get('app_authentication_ldap_userattribute_firstname')][0];
    $lastname=@$user[sfConfig::get('app_authentication_ldap_userattribute_lastname')][0];
    
    $this->_foundUsers[]=$username;
    // we need this later to set not found users to "not active" status
    
    $sfuser=sfGuardUserProfilePeer::getByUsername($username);
    if(!$sfuser)
    {
      $sfuser=new sfGuardUser();
      $sfuser
      ->setUsername($username)
      ->setIsActive(true)
      ->setSalt('foo')
      ->setPassword('bar');
      $sfuser
      ->save();
      $profile=new sfGuardUserProfile();
      $profile
      ->update($firstname, $lastname, $email)
      ->setUserId($sfuser->getId())
      ->save();
      $this->logSection('user+', $username, null, 'INFO');
    }
    else
    {
      $sfuser->setIsActive(true)->save();
      $profile=$sfuser->getProfile();
      $profile
      ->update($firstname, $lastname, $email)
      ->save();
      $this->logSection('user', $username, null, 'COMMENT');
    }
    
  }
  
  
  protected function syncUsers()
  {

//$ATTRIBUTIU = array("objectClass", "dn", "cn", "sn", "displayName", "telephoneNumber", "title", "physicalDeliveryOfficeName", "mail", "uid", "uidNumber", "gidNumber", "mailRoutingAddress", "sambaPwdLastSet", "sambaLogonTime", "sambaPwdMustChange", "sambaAcctFlags");

$ATTRIBUTIG = array("cn", "gidNumber", "memberUid", "description");

    $server=sfConfig::get('app_authentication_ldap_host');
		$basedn=sfConfig::get('app_authentication_ldap_domain');
    $usersou=sfConfig::get('app_authentication_ldap_users');
    $groupsou=sfConfig::get('app_authentication_ldap_groups');
    
    $users_attributes=array(
      sfConfig::get('app_authentication_ldap_userattribute_username'),
      sfConfig::get('app_authentication_ldap_userattribute_email'),
      sfConfig::get('app_authentication_ldap_userattribute_firstname'),
      sfConfig::get('app_authentication_ldap_userattribute_lastname')
    );
    
    
    include('/home/loris/Scrivania/ldap_output.php');
    
   // print_r($users);
    
    for($i=0;$i<sizeof($users)-1; $i++)
    {
      // LDAP returns the count of items as 'count'=>..., so we skip it by going 
      // up to sizeof($users)-1
      $this->checkUser($users[$i]);
    }
    
    $oldUsers = sfGuardUserProfilePeer::retrieveByUsernames($this->_foundUsers, $selected=false);
    
    foreach($oldUsers as $sfuser)
    {
      $sfuser->setIsActive(false)->save();
      $this->logSection('user-', $sfuser->getUsername(), null, 'INFO');
    }
    
    
    
//    print_r($users);
/*
    echo $server . "\n";
	//	$dn = "uid=$username,ou=People,$basedn";

		if (!($connect = ldap_connect($server))) {
			die ("Could not connect to LDAP server\n");
		   }

		ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);

    
//    echo ldap_bind($connect)?'yes':'no';


    $sr = ldap_search($connect, $usersou. ',' . $basedn, "uid=*", $users_attributes);

$nr = ldap_count_entries($connect, $sr);
echo "Utenti: $nr\n";

if ($nr > 0) {
  $users = ldap_get_entries($connect, $sr);
print_r($users);
}

    $sr = ldap_search($connect, $groupsou. ',' . $basedn, "cn=*", $ATTRIBUTIG);

$nr = ldap_count_entries($connect, $sr);
echo "Gruppi: $nr\n";

if ($nr > 0) {
  $users = ldap_get_entries($connect, $sr);
print_r($users);
}



    echo "Connesso\n";
*/
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here
    
    if($this->_isLogged)
    {
      $taskLogEvent= new TaskLogEvent();
      $taskLogEvent->
      setTaskName($this->name)->
      setArguments(serialize($arguments))->
      setOptions(serialize($options))->
      setStartedAt(time())->
      save();
    }
    
    try
    {
      $this->syncUsers();
    }
    catch (Exception $e)
    {
      $this->log($this->formatter->format($e->getMessage(), 'ERROR'));
      if ($taskLogEvent)
      {
        $taskLogEvent->
        setTaskException($e->getMessage())->
        save();
      }
      return 1;
    }

    if($this->_isLogged)
    {
      $taskLogEvent->
      setFinishedAt(time())->
      save();
      // we update the record
    }


  }
}

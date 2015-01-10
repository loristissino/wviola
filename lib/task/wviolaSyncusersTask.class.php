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
      new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'Whether the execution will be logged in the DB', 'true'),
      new sfCommandOption('to-json', null, sfCommandOption::PARAMETER_OPTIONAL, 'The file where data from ldap connection will be stored', ''), 
      new sfCommandOption('from-json', null, sfCommandOption::PARAMETER_OPTIONAL, 'The file where data will be taken from, instead of connecting to ldap server', ''), 
      new sfCommandOption('test', null, sfCommandOption::PARAMETER_NONE, 'Run without an actual LDAP connection, loading data from a hard-coded source'),

    ));

    $this->namespace        = 'wviola';
    $this->name             = 'sync-users';
    $this->briefDescription = 'Synchronizes users from an external source (LDAP)';
    $this->detailedDescription = <<<EOF
The [wviola:sync-users|INFO] task synchronizes users from an external source.
The source is the same LDAP server specified in [app.yml|COMMENT] for authentication, where
you must also specify the associations LDAP group => Wviola/sfGuardGroup. 

Call it with:

  [php symfony wviola:sync-users --env=prod --application=frontend|INFO]
EOF;

    $this->_foundUsers=Array();

    $this->_guardGroups=Array();

    $this->_isLogged=true;
    $this->_logEvent=null;
    
    $this->_toJson = null;
    $this->_fromJson = null;
    $this->_test = false;

  }
  
  
  protected function setGuardGroups($groups)
  {
    $ldapGroupCN=sfConfig::get('app_authentication_ldap_groupattribute_cn');
    $ldapGroupMembers=sfConfig::get('app_authentication_ldap_groupattribute_members');
    
    $guardgroups=sfGuardGroupProfilePeer::retrieveAllGuardGroupsAsArray();
    foreach($guardgroups as $guardgroup)
    {
      $this->_guardGroups[$guardgroup]=Array();
    }
    
    foreach($this->_guardGroups as $guardGroupName=>&$guardGroupMembers)
    {
      $this->logSection('group*', $guardGroupName, null, 'COMMENT');

      $ldapGroups=sfConfig::get('app_authentication_guardgroup_' . $guardGroupName);
      
      foreach($ldapGroups as $ldapGroup)
      {
        
        for($i=0;$i<$groups['count']; $i++)
        {
          if($groups[$i][$ldapGroupCN][0]==$ldapGroup)
          {
            $this->logSection(' ldap*', $groups[$i][$ldapGroupCN][0], null, 'COMMENT');
            if(isset($groups[$i][$ldapGroupMembers]))
            {
              for($u=0;$u<$groups[$i][$ldapGroupMembers]['count'];$u++)
              {
                $guardGroupMembers[$groups[$i][$ldapGroupMembers][$u]]=1;
              }
            }
          }
        }
      }
    }
  }
  
  
  protected function checkUser($user)
  {
    /* FIXME This doesn't work as expected, we must check it 
    if(!in_array(
      sfConfig::get('app_authentication_ldap_useractive_objectclass_item'),
      $user['objectclass']
      ))
    {
      return;
    }
    */
    
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
      ->setImportedAt(time())
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
    
    
    foreach($this->_guardGroups as $guardGroupName=>$guardGroupMembers)
    {
      if(array_key_exists($username, $guardGroupMembers))
      {
        if(!$profile->getBelongsToGuardGroupByName($guardGroupName))
        {
          $profile->addToGuardGroup(sfGuardGroupProfilePeer::retrieveByName($guardGroupName));
          $this->logSection(' group+', $guardGroupName, null, 'INFO');
        }
      }
      else
      {
        if($profile->getBelongsToGuardGroupByName($guardGroupName))
        {
          $profile->removeFromGuardGroup(sfGuardGroupProfilePeer::retrieveByName($guardGroupName));
          $this->logSection(' group-', $guardGroupName, null, 'INFO');
        }
      }
    }
    
  }
  
  
  protected function syncUsers()
  {

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
    
    $groups_attributes=array(
      sfConfig::get('app_authentication_ldap_groupattribute_cn'),
      sfConfig::get('app_authentication_ldap_groupattribute_members'),
    );

    $data = array();

    if ($this->_test)
    {
      // USED FOR TESTS
      require('/etc/wviola/ldap_output.php');
    }
    else
    {
      // we do the real thing...
      
      if($this->_fromJson)
      {
        // our data come from the json file provided, not from LDAP connection
        $data = json_decode(file_get_contents($this->_fromJson), true);
      }
      else
      {

        // our data come from an LDAP connection
        if (!($connect = ldap_connect($server)))
        {
          throw new Exception("Could not connect to LDAP server");
        }

        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($connect);
        
        $sr = ldap_search($connect, $usersou. ',' . $basedn, "uid=*", $users_attributes);

        $nr = ldap_count_entries($connect, $sr);

        if ($nr > 0)
        {
          $data['users'] = ldap_get_entries($connect, $sr);
        }
        else
        {
          throw new Exception('No user entries found');
        }

        $sr = ldap_search($connect, $groupsou. ',' . $basedn, "cn=*", $groups_attributes);

        $nr = ldap_count_entries($connect, $sr);

        if ($nr > 0)
        {
          $data['groups'] = ldap_get_entries($connect, $sr);
        }
        else
        {
          throw new Exception('No group entries found');
        }
      }
      
    }
    
    // now we have the data, either from json file or from LDAP connection
    
    
    if($this->_toJson)
    {
      // we only save the data to the json file, without doing anything else
      file_put_contents($this->_toJson, json_encode($data));
      $this->logSection('file+', $this->_toJson, null, 'INFO');
    }
    else
    {
      // we use the data for what we need
      $this->setGuardGroups($data['groups']);
      
      for($i=0;$i<$data['users']['count']; $i++)
      {
        $this->checkUser($data['users'][$i]);
      }
      
      $oldUsers = sfGuardUserProfilePeer::retrieveByUsernames($this->_foundUsers, $selected=false);
      
      foreach($oldUsers as $sfuser)
      {
        if($sfuser->getIsActive())
        {
          $sfuser->setIsActive(false)->save();
          $this->logSection('user-', $sfuser->getUsername(), null, 'INFO');
        }
      }

    }
    

  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $this->_isLogged=Generic::normalizedBooleanValue($options['logged'], true);
    $options['logged']=Generic::normalizedBooleanDescription($this->_isLogged);

    $this->_test=Generic::normalizedBooleanValue($options['test'], false);
    $options['test']=Generic::normalizedBooleanDescription($this->_test);

    if($this->_fromJson=$options['from-json'])
    {
      if(!(file_exists($this->_fromJson) && is_readable($this->_fromJson)))
      {
        echo "File not readable: " . $this->_fromJson . "\n";
        return 1;
      }
    }
    
    if($this->_toJson=$options['to-json'])
    {
      if(file_exists($this->_toJson))
      {
        echo "File already exists, I won't overwrite: " . $this->_toJson . "\n";
        return 2;
      }
    }
    
    if($this->_fromJson && $this->_toJson)
    {
      echo "You cannot have both to-json and from-json options set for the same execution.\n";
      return 3;
    }
    

    // add your code here
    $this->logSection('started', date('c'), null, 'COMMENT');
        
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

    $this->logSection('completed', date('c'), null, 'COMMENT');
    return 0;

  }
}

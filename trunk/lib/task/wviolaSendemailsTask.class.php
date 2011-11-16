<?php

class wviolaSendemailsTask extends sfBaseTask
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
      new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'Whether the execution will be logged in the DB', 'true'), 
    ));



    $this->namespace        = 'wviola';
    $this->name             = 'send-emails';
    $this->briefDescription = 'Send emails to the user reminding them of the files that they have not yet scheduled.';
    $this->detailedDescription = <<<EOF
The [wviola:send-email|INFO] sends an email to the users who still have some files to schedule for archiviation.
  [php symfony wviola:send-emails --env=prod --application=frontend|INFO]

EOF;

	$this->_isLogged=true;
  $this->_logEvent=null;
  
  }



  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $this->_isLogged=Generic::normalizedBooleanValue($options['logged'], true);
    $options['logged']=Generic::normalizedBooleanDescription($this->_isLogged);
    
    if($this->_isLogged)
    {
      $taskLogEvent= new TaskLogEvent();
      $taskLogEvent->
      setTaskName($this->name)->
      setArguments(serialize($arguments))->
      setOptions(serialize($options))->
      setStartedAt(time())->
      save();
      
      $this->_logEvent=$taskLogEvent->getId();
    }

    $w=SourcePeer::retrieveUsersWithAssetsReadyForArchiviation();
    
    foreach($w as $row)
    {
      $row['profile']->sendSourceReadyNotice($this->getMailer(), $row['number']);
      $this->logSection('mail@', $row['profile']->getEmail() . ' (' . $row['number'] . ')', null, 'INFO');
    }
  
    if($this->_isLogged)
    {
      $taskLogEvent->
      setFinishedAt(time())->
      save();
      // we update the record
    }
    
    return 0;
  }
}

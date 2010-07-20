<?php

class wviolaListbindersTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
	
	  new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'whether the execution will be logged in the DB', 'true'),
    ));

    $this->namespace        = 'wviola';
    $this->name             = 'list-binders';
    $this->briefDescription = 'List binders';
    $this->detailedDescription = <<<EOF
The [wviola:list-binders|INFO] task lists all open binders. It may be useful to check if codes match some rules defined elsewhere (with some external program).

Call it with:

  [php symfony wviola:list-binders|INFO]

EOF;

	$this->_isLogged=true;
  $this->_logEvent=null;

}


  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here


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

  $Binders=BinderPeer::retrieveOpen();
  
  if (sizeof($Binders)>0)
  {
    echo "user:title:code:event_date:created_at:updated_at:assets_count\n";
    foreach($Binders as $Binder)
    {
      echo sprintf("%s:%s:%s:%s:%s:%s:%d\n", 
        $Binder->getSfGuardUserProfile()->getUsername(),
        $Binder->getTitle(),
        $Binder->getCode(),
        $Binder->getEventDate('Y/m/d'),
        $Binder->getCreatedAt('U'),
        $Binder->getUpdatedAt('U'),
        $Binder->countAssets()
        );
    }
  }
  else
  {
    $this->logSection('info', 'No open binders.', null, 'COMMENT');
  }
  
  unset($Binders);

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

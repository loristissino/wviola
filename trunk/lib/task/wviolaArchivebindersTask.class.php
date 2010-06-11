<?php

class wviolaArchivebindersTask extends sfBaseTask
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
    $this->name             = 'archive-binders';
    $this->briefDescription = 'Archives binders';
    $this->detailedDescription = <<<EOF
The [wviola:archive-binders|INFO] task closes binders after the specified time and prepares iso-images of DVDs for backup purposes.

Call it with:

  [php symfony wviola:archive-binders|INFO]

The task ends with an exception if something goes wrong (e.g. when a file could not be read or written).

EOF;

	$this->_isLogged=true;
  $this->_logEvent;

}


  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here

	$this->_isLogged=Generic::normalizedBooleanValue($options['logged'], true);
	$options['logged']=Generic::normalizedBooleanDescription($this->_isLogged);
  	
	$this->_cacheDirectory=wvConfig::get('directory_iso_cache');
	$this->_imagesDirectory=wvConfig::get('directory_iso_images');
  
	$this->_binderMaxAge=wvConfig::get('archiviation_binder_max_age');

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

  echo "\n";
  $this->logSection('binders', 'Closing aged out binders...', null, 'COMMENT');

  $Binders=BinderPeer::retrieveOpen();
  
  if (sizeof($Binders)>0)
  {
    foreach($Binders as $Binder)
    {
      $this->logSection('binder', $Binder->getId(), null, 'COMMENT');
      if ($Binder->closeIfAgedOut($this->_binderMaxAge))
      {
        $this->logSection('binder#', 'closed', null, 'INFO');
      }
    }
  }
  else
  {
    $this->logSection('info', 'No open binders.', null, 'COMMENT');
  }
  
  unset($Binders);

  echo "\n";
  $this->logSection('binders', 'Finding archivable binders...', null, 'COMMENT');


  $Archive = new Archive();
  
  $Binders=BinderPeer::retrieveClosed();
  
  $Archive->addBinders($Binders);
  
  if ($Archive->getIsFull())
  {
    $list = $Archive->prepareISOImage();
  }

  foreach($list as $file)
  {
    $this->logSection('file-', $file, null, 'INFO');
  }
  $this->logSection('file+', $Archive->getIsoImageFullPath());

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

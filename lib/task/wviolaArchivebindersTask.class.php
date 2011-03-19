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
      new sfCommandOption('dry-run', null, sfCommandOption::PARAMETER_NONE, 'whether the DB and the files will be left unchanged'),
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
  
  $this->_dryRun=Generic::normalizedBooleanValue($options['dry-run'], false);
	$options['dry-run']=Generic::normalizedBooleanDescription($this->_dryRun);

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
  
  if(!$this->_dryRun)
  {
    $this->logSection('binders', 'Closing aged out binders...', null, 'COMMENT');
    $Binders=BinderPeer::retrieveOpen();
  
    if (sizeof($Binders)>0)
    {
      foreach($Binders as $Binder)
      {
        if ($Binder->closeIfAgedOut($this->_binderMaxAge))
        {
          $this->logSection('binder', $Binder->getId() .' closed', null, 'INFO');
        }
        else
        {
          $this->logSection('binder', $Binder->getId() .' kept open', null, 'COMMENT');
        }
      }
    }
    else
    {
      $this->logSection('info', 'No open binders.', null, 'COMMENT');
    }
    unset($Binders);
  }

  echo "\n";
  $this->logSection('binders', 'Finding archivable binders...', null, 'COMMENT');

  $Archive = new Archive();
  $jobdone = false;
  
  $Binders=BinderPeer::retrieveClosed();
  
  $Archive->addBinders($Binders);

  if ($Archive->getIsFull())
  {
    if ($Archive->prepareISOImage($this->_dryRun))
    {
      $this->logSection('file+', $Archive->getIsoImageFullPath(), null, 'INFO');
      if(!$this->_dryRun)
      {
        $Archive->removeFiles();
        foreach($Archive->getFiles() as $file)
        {
          $this->logSection('file-', $file, null, 'INFO');
        }
      }
      $jobdone=true;
    }
    else
    {
      $this->logSection('archive', 'Something got wrong while preparing ISO image', null, 'ERROR');
    }
  }
  else
  {
    $this->logSection('binders', 'Not enough binders to make an ISO image', null, 'COMMENT');
  }

	if($this->_isLogged)
	{
		$taskLogEvent->
		setFinishedAt(time())->
		save();
		// we update the record
	}
    
  if ($jobdone)
  {
    $Archive->sendArchiveReadyNotice($this, $this->getMailer());
  }
  
	return 0;
	
  }
}

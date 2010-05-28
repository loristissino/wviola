<?php

class wviolaScheduleassetsTask extends sfBaseTask
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
	
      new sfCommandOption('user', null, sfCommandOption::PARAMETER_REQUIRED, 'Username of the user scheduling the archiviation', '/'),
      new sfCommandOption('subdir', null, sfCommandOption::PARAMETER_REQUIRED, 'Subdirectory name', '/'),
      new sfCommandOption('file', null, sfCommandOption::PARAMETER_REQUIRED, 'File name', '/'),
      new sfCommandOption('binder', null, sfCommandOption::PARAMETER_REQUIRED, 'Binder', ''),
      new sfCommandOption('title', null, sfCommandOption::PARAMETER_REQUIRED, 'Title', ''),
      new sfCommandOption('notes', null, sfCommandOption::PARAMETER_REQUIRED, 'Notes', ''),
      
	  new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'Whether the execution will be logged in the DB', 'true'),
    ));

    $this->namespace        = 'wviola';
    $this->name             = 'schedule-asset';
    $this->briefDescription = 'Schedules an asset for archiviation';
    $this->detailedDescription = <<<EOF
The [wviola:schedule-assets|INFO] task schedules an asset for archiviation.

Call it with:

  [php symfony wviola:schedule-asset|INFO]

This is probably useful only for testing purposes.

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

  if (!$user=sfGuardUserProfilePeer::getByUsername($options['user']))
  {
    throw new Exception('User not found.');
  };

  $subdir=$options['subdir'];
  Generic::normalizeDirName(&$subdir);

  $sourcefile = new SourceFile($subdir, $options['file']);

  $binders=BinderPeer::retrieveByNotes($options['binder']);
  if (sizeof($binders)>0)
  {
    $binder=$binders[0];
  }
  else
  {
    throw new Exception('Binder not found.');
  }

  $Asset = new Asset();
  if ($Asset->scheduleSourceFileForArchiviation(
    $user->getId(),
    $sourcefile,
    array(
      'binder_id'=>$binder->getId(),
      'assigned_title'=>$options['title'],
      'notes'=>$options['notes'], 
    )
    ))
  {
    $this->logSection('asset', $sourcefile->getFullPath(), null, 'INFO');
  }
  else
  {
    $this->logSection('asset', $sourcefile->getFullPath(), null, 'ERROR');
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

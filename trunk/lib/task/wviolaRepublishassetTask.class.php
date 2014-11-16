<?php

class wviolaRepublishassetTask extends sfBaseTask
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
    
      $this->addArguments(array(
        new sfCommandArgument('id', sfCommandArgument::REQUIRED, 'Id of the Asset to republish'),
        ));

    $this->namespace        = 'wviola';
    $this->name             = 'republish-asset';
    $this->briefDescription = 'Republishes an asset previously published';
    $this->detailedDescription = <<<EOF
The [wviola:republish-asset|INFO] task republishes an asset already published,
if it is still available in trash directory.

Call it with:

  [php symfony wviola:republish-asset|INFO]

The task ends with an exception if something goes wrong (e.g. when a file could not be
read or written).

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
  $this->logSection('started', date('c'), null, 'COMMENT');

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

  $Asset = AssetPeer::retrieveByPK($arguments['id']);
  
  if (!$Asset)
  {
    $this->logSection('Asset', sprintf('Asset %d not found.', $arguments['id']), null, 'ERROR');
  }
  else
  {
    try
    {
      $Asset->republish();
    }
    catch (Exception $e)
    {
      $this->log($this->formatter->format($e->getMessage(), 'ERROR'));
      if ($taskLogEvent)
      {
        $taskLogEvent->
        setTaskException($taskLogEvent->getTaskException() . "\n" . $e->getMessage())->
        save();
      }
      $check=false;
      // return 1;
    }
    $this->logSection('file+', wvConfig::get('directory_published_assets') . '/' . $Asset->getUniqId(), null, 'INFO');
    $this->logSection('file+', wvConfig::get('directory_iso_cache') . '/' . $Asset->getUniqId(), null, 'INFO');
    $this->logSection('file-', wvConfig::get('directory_scheduled') . '/' . $Asset->getUniqId(), null, 'INFO');
  
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

<?php

class wviolaPublishassetsTask extends sfBaseTask
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
    $this->name             = 'publish-assets';
    $this->briefDescription = 'Publishes scheduled assets';
    $this->detailedDescription = <<<EOF
The [wviola:publish-assets|INFO] task publishes the assets that are scheduled for archiviation.

Call it with:

  [php symfony wviola:publish-assets|INFO]

The task ends with an exception if something goes wrong (e.g. when a file could not be
read or written).

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
  	
	$this->_sourcesDirectory=wvConfig::get('directory_sources');

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


  $Assets=AssetPeer::retrieveByStatus(Asset::SCHEDULED);
  
//  print_r($Assets);
  if (sizeof($Assets)>0)
  {
    foreach($Assets as $Asset)
    {
      $this->logSection('asset', $Asset->getId(), null, 'COMMENT');
      try
      {
        $Asset->publish();
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
      $this->logSection('file+', wvConfig::get('directory_published_assets') . '/' . $Asset->getUniqId(), null, 'INFO');
      $this->logSection('file+', wvConfig::get('directory_iso_cache') . '/' . $Asset->getUniqId(), null, 'INFO');
      $this->logSection('file-', wvConfig::get('directory_scheduled') . '/' . $Asset->getUniqId(), null, 'INFO');
      
    }
  }
  else
  {
    $this->logSection('info', 'No scheduled assets.', null, 'COMMENT');
  }

/*
	try
	{
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
*/	
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

<?php

class wviolaListassetsTask extends sfBaseTask
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
    $this->name             = 'list-assets';
    $this->briefDescription = 'List assets';
    $this->detailedDescription = <<<EOF
The [wviola:list-assets|INFO] task lists all assets.

Call it with:

  [php symfony wviola:list-assets|INFO]

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

  $Assets=AssetPeer::doSelect(new Criteria());
  
  if (sizeof($Assets)>0)
  {    
    $d=stripcslashes(wvConfig::get('tasks_list_delimiter', "\n"));
    
    echo implode($d, array(
      'id',
      'binder_id',
      'status',
      'asset_type',
      'source_size',
      'highquality_size',
      'lowquality_size',
      'created_at',
      'updated_at'
      )) . "\n";
    foreach($Assets as $Asset)
    { 
      $Asset->updateData();
      // this is here only because we needed to update data from filesize
      
      echo implode($d, array(
        $Asset->getId(),
        $Asset->getBinderId(),
        $Asset->getStatus(),
        $Asset->getAssetType(),
        $Asset->getSourceSize(),
        $Asset->getHighQualitySize(),
        $Asset->getLowQualitySize(),
        $Asset->getCreatedAt('U'),
        $Asset->getUpdatedAt('U'),
        )) . "\n";
    }
  }
  else
  {
    $this->logSection('info', 'No assets.', null, 'COMMENT');
  }
  
  unset($Binders);

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

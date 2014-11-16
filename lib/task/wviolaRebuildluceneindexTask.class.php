<?php

class wviolaRebuildluceneindexTask extends sfBaseTask
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
    $this->name             = 'rebuild-lucene-index';
    $this->briefDescription = 'Rebuilds lucene index from scratch';
    $this->detailedDescription = <<<EOF
The [wviola:rebuild-lucene-index|INFO] task rebuilds lucene index from scratch, using the information stored in the database.

Call it with:

  [php symfony wviola:rebuild-lucene-index|INFO]

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
  
  $count=0;
  $size=sizeof($Assets);
  foreach($Assets as $Asset)
  {
    $Asset->updateLuceneIndex();
    $this->logSection('asset', sprintf('Asset %d indexed (%3.2f%%)', $Asset->getId(), 100*(++$count/$size)), null, 'INFO');
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

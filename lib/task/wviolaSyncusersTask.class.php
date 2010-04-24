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
      new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'whether the execution will be logged in the DB', 'true'),

    ));

    $this->namespace        = 'wviola';
    $this->name             = 'sync-users';
    $this->briefDescription = 'syncronize users from an external source';
    $this->detailedDescription = <<<EOF
The [wviola:sync-users|INFO] task does things.
Call it with:

  [php symfony wviola:sync-users|INFO]
EOF;
  }
  
  protected function syncUsers()
  {
    echo "doing nothing...\n";
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here
    
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


  }
}

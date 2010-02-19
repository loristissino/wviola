<?php

class wviolaScansourcesTask extends sfBaseTask
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
	
//      new sfCommandOption('directory', null, sfCommandOption::PARAMETER_OPTIONAL, 'The directory name', wvConfig::get('directory_sources')),
	
    ));

    $this->namespace        = 'wviola';
    $this->name             = 'scan-sources';
    $this->briefDescription = 'Finds useful information about source asset files';
    $this->detailedDescription = <<<EOF
The [wviola:scan-sources|INFO] task scans the source asset directory in order to find useful information and prepare thumbnails.
Call it with:

  [php symfony wviola:scan-sources|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here

	$file=new SourceFile('/videos', 'senso.mpg');
	$this->log($this->formatter->format('File: ' . $file->getFullPath()), 'NOTICE');
	$this->log($this->formatter->format('Gathering information...'), 'NOTICE');
	$file->
	gatherWvInfo()
	->saveWvInfoFile();
	$this->log($this->formatter->format('Computing MD5Sum...'), 'NOTICE');
	$file->
	appendMD5Sum()
	->saveWvInfoFile();
	
  }
}

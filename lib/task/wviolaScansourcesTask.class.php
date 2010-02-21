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
	
      new sfCommandOption('directory', null, sfCommandOption::PARAMETER_OPTIONAL, 'The directory name', wvConfig::get('directory_sources')),
	
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


  protected function recursivelyScanDirectory($directory, $strlen)
	{
		$filenames=scandir($directory);
		foreach($filenames as $basename)
		{
			if (substr($basename, 0, 1)=='.')
			{
				continue;
			}

			$filepath=$directory . '/'. $basename;
	
			if (is_dir($filepath))
			{
				$this->recursivelyScanDirectory($filepath, $strlen);
			}
			
			$file=new SourceFile(substr($directory, $strlen), $basename);
			$this->log($this->formatter->format('  File: ' . $file->getFullPath(), 'COMMENT'));
			
			// do the stuff
			
			unset($file);
			
		}
		
	}  

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here

	$directory=$options['directory'];
	
	$sourcesDirectory=wvConfig::get('directory_sources');
	
	$strlen=strlen($sourcesDirectory);
	
	if(substr($directory,0,$strlen)!=$sourcesDirectory)
	{
		$this->log($this->formatter->format('You cannot use this command to scan directory outside	 ' . $sourcesDirectory, 'ERROR'));
		return 1;
	}
	
	
	$this->log($this->formatter->format('Scanning directory: ' . $directory, 'COMMENT'));
	
	$this->recursivelyScanDirectory($directory, $strlen);
	
	die();

	$file=new SourceFile('/videos', 'senso.mpg');
	$this->log($this->formatter->format('File: ' . $file->getFullPath(), 'COMMENT'));
	$this->log($this->formatter->format('Gathering information...', 'ERROR'));
	$this->log($this->formatter->format('INFO...', 'INFO'));
	$file->
	gatherWvInfo()
	->saveWvInfoFile();
	
	/*
	$this->log($this->formatter->format('Computing MD5Sum...'), 'NOTICE');
	$file->
	appendMD5Sum()
	->saveWvInfoFile();
	*/
	
  }
}

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
	
      new sfCommandOption('subdir', null, sfCommandOption::PARAMETER_OPTIONAL, 'Subdirectory name', ''),
      new sfCommandOption('recursive', null, sfCommandOption::PARAMETER_OPTIONAL, 'whether recursion will be applied', false),
	
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


  protected function ScanDirectory($sourcesDirectory, $subdir, $recursive=false)
	{
		$completeDirPath=Generic::getCompletePath($sourcesDirectory, $subdir);
		
		if(is_dir($completeDirPath))
		{
			$filenames=@scandir($completeDirPath);
			
			if (!$filenames)
			{
				throw new Exception("Could not read directory: $completeDirPath");
			}
			
			foreach($filenames as $basename)
			{
				if (substr($basename, 0, 1)=='.')
				{
					continue;
				}
				
				$newsubdir=Generic::getCompletePath($subdir, $basename);
				$totalpath=Generic::getCompletePath($sourcesDirectory, $newsubdir);
				
				if (is_dir($totalpath))
				{
					$this->scanDirectory($sourcesDirectory, $newsubdir, $recursive);
				}
				else
				{
					Generic::normalizeDirName($subdir);
					
					$file=new SourceFile($subdir, $basename);
					
					$this->logsection('file', $file->getFullPath(), null, 'INFO');
					
					$this->log($this->formatter->format('Gathering information...', 'COMMENT'));
					$file->gatherWvInfo();
					
					$this->log($this->formatter->format('Computing MD5 hash...', 'COMMENT'));
					$file->appendMD5sum();
					
					$file->saveWvInfoFile();
					$this->log($this->formatter->format('Saved information.', 'INFO'));

					unset($file);
				}
			
			}
		}
		else
		{
			throw new Exception("Not a directory: $completeDirPath");
		}
		
	}

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here

	$recursion=in_array($options['recursive'], array(1, 'true', 'yes', 'y')); 
	
	$subdir=$options['subdir'];
	Generic::normalizeDirName($subdir, '/');
	
	$sourcesDirectory=wvConfig::get('directory_sources');
	
	$completeDirPath=Generic::getCompletePath($sourcesDirectory, $subdir);
	
	$this->log($this->formatter->format(sprintf('Scanning directory: «%s»', $completeDirPath), 'COMMENT'));


	try
	{
		$this->ScanDirectory($sourcesDirectory, $subdir, $recursion);
	}
	catch (Exception $e)
	{
		$this->log($this->formatter->format($e->getMessage(), 'ERROR'));
		return 2;
	}
	
	return 0;
	
  }
}

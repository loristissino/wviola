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
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
	
      new sfCommandOption('subdir', null, sfCommandOption::PARAMETER_OPTIONAL, 'Subdirectory name', '/'),
      new sfCommandOption('recursive', null, sfCommandOption::PARAMETER_OPTIONAL, 'whether recursion will be applied', 'false'),
      new sfCommandOption('size-limit-for-md5sum', null, sfCommandOption::PARAMETER_OPTIONAL, 'size in bytes over which md5sums will not be computed (0 means no limit)', 0),
	
    ));

    $this->namespace        = 'wviola';
    $this->name             = 'scan-sources';
    $this->briefDescription = 'Finds useful information about source asset files';
    $this->detailedDescription = <<<EOF
The [wviola:scan-sources|INFO] task scans the source asset directory in order to find useful information and prepare thumbnails.
Call it with:

  [php symfony wviola:scan-sources|INFO]
EOF;

	$this->_isRecursive=false;
	$this->_sourcesDirectory='';


  }


  protected function mustComputeMD5Sum($size)
	{
		if($this->_size_limit_for_md5sum==0)
		{
			return true;
		}
		return $size < $this->_size_limit_for_md5sum;
	}

	protected function processFile($subdir, $basename)
	{
		$file=new SourceFile($subdir, $basename);
		
		$this->logSection('source', 'Opening candidate source file...', null, 'COMMENT');
		$this->logsection('file', $file->getFullPath(), null, 'INFO');
				
		if (!$file->getHasWvInfo())
		{
			$this->logSection('info', 'Gathering information...', null, 'COMMENT');
			$file->gatherWvInfo();
		}
		else
		{
			$this->logSection('info', 'Basic information gathering skipped (already present).', null, 'COMMENT');
		}
		
		if($this->mustComputeMD5Sum($file->getStat('size')))
		{
			if(!$file->getHasMD5Sum())
			{
				$this->logSection('md5sum', 'Computing MD5 hash...', null, 'COMMENT');
				$file->appendMD5sum();
			}
			else
			{
				$this->logSection('md5sum', 'MD5 computing already done.', null, 'COMMENT');
			}
		}
		else
		{
			$this->logSection('md5sum', 'MD5 computing skipped.', null, 'COMMENT');
		}
		
		if ($file->getWvInfoChanged())
		{
			$file->saveWvInfoFile();
			$this->logSection('info', 'Writing information file...', null, 'INFO');
			$this->logSection('file+', $file->getWvInfoFilePath(), null, 'INFO');
		}
		else
		{
			$this->logSection('info', 'Information saving skipped (no need).', null, 'COMMENT');
		}
		
		

		unset($file);
		
	}



  protected function ScanDirectory($subdir)
	{
		$completeDirPath=Generic::getCompletePath($this->_sourcesDirectory, $subdir);
		
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
				$totalpath=Generic::getCompletePath($this->_sourcesDirectory, $newsubdir);
				
				if (is_dir($totalpath))
				{
					if ($this->_isRecursive)
					{
						$this->scanDirectory($newsubdir);
					}
				}
				else
				{
					Generic::normalizeDirName($subdir);
					
					$this->processFile($subdir, $basename);
					
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

	$tasklog= new TaskLog();
	$tasklog->
	setTaskName($this->name)->
	setArguments(serialize($arguments))->
	setOptions(serialize($options))->
	save();

	$this->_isRecursive=Generic::positiveOption($options['recursive']); 
		
	$subdir=$options['subdir'];
	Generic::normalizeDirName($subdir, '/');
	
	$this->_sourcesDirectory=wvConfig::get('directory_sources');
	
	$this->_size_limit_for_md5sum=(float)$options['size-limit-for-md5sum'];
	
	$completeDirPath=Generic::getCompletePath($this->_sourcesDirectory, $subdir);
	
	$this->log($this->formatter->format(sprintf('Scanning directory: «%s»', $completeDirPath), 'COMMENT'));
	$this->log($this->formatter->format(sprintf('Recursion is %s.', $this->_isRecursive? 'on': 'off'), 'COMMENT'));

	try
	{
		$this->ScanDirectory($subdir);
	}
	catch (Exception $e)
	{
		$this->log($this->formatter->format($e->getMessage(), 'ERROR'));
		return 1;
	}
	
	
	$tasklog->
	setTaskFinishedAt(time())->
	save();
	// we update the record

	return 0;
	
  }
}

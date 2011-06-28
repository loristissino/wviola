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
      new sfCommandOption('recursive', null, sfCommandOption::PARAMETER_OPTIONAL, 'Whether recursion will be applied', 'false'),
      new sfCommandOption('ignore-scanned-files', null, sfCommandOption::PARAMETER_NONE, 'Whether files for which the yml file is already present are ignored'),

//      new sfCommandOption('size-limit-for-md5sum', null, sfCommandOption::PARAMETER_OPTIONAL, 'size in bytes over which md5sums will not be computed (0 means no limit)', 0),
	  new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'Whether the execution will be logged in the DB', 'true'),
	
    ));

    $this->namespace        = 'wviola';
    $this->name             = 'scan-sources';
    $this->briefDescription = 'Finds useful information about source asset files';
    $this->detailedDescription = <<<EOF
The [wviola:scan-sources|INFO] task scans the source asset directory in order to find useful information and prepare thumbnails.
Call it with:

  [php symfony wviola:scan-sources --env=prod --application=frontend|INFO]

The subdirectory name can be specified either as '[/foo|COMMENT]', '[foo/|COMMENT]', '[foo|COMMENT]' or '[/foo/|COMMENT]'.
Anyway, it must exist and must be under the path specified in [wviola.yml|COMMENT] for sources.

The task ends with an exception if something goes wrong (e.g. when a file could not be
read or written).

Please note that the user who launches this script must have sudo privileges in order 
to create zip file for pictures collections (photoalbums) and chown them to the owner
of the pictures collected: if this script is lauched in a cron job, you might need to specify the NOPASSWD option in your [/etc/sudoers|COMMENT] file.

EOF;

	$this->_isRecursive=false;
	$this->_sourcesDirectory='';
	$this->_isLogged=true;
//	$this->_size_limit_for_md5sum=0;
  $this->_logEvent=null;
  
//  $this->_photoAlbumItems=wvConfig::get('filebrowser_photo_album_items');

  }

/*
  protected function mustComputeMD5Sum($size)
	{
		if($this->_size_limit_for_md5sum==0)
		{
			return true;
		}
		return $size < $this->_size_limit_for_md5sum;
	}
*/
	protected function processFile($subdir, $basename)
	{
		$this->log('');

    try
    {
      $file=new SourceFile($subdir, $basename);
    }
    catch (BadNameException $e)
    {
      $this->logSection('file', $e->getMessage(), null, 'ERROR');
      return;
    }
		
		$this->logSection('source', 'Opening candidate source file...', null, 'COMMENT');
		
		$this->logsection('file', $file->getFullPath(), null, 'INFO');

		if ($file->getShouldBeSkipped())
		{
			$this->logSection('info', 'Skipped for file name not beeing in white list.', null, 'COMMENT');
			unset($file);
			return;
		}
    
    if ($this->_ignoreScannedFiles and $file->getHasWvInfo())
    {
			$this->logSection('info', 'Skipped because already scanned', null, 'COMMENT');
			unset($file);
			return;
    }
		
		if ($file->getIsBeingCopied())
		{
			$this->logSection('info', 'Skipped for file beeing copied right now.', null, 'COMMENT');
			unset($file);
			return;
		}
				
		if (!$file->getHasWvInfo())
		{
			$this->logSection('info', 'Gathering information...', null, 'COMMENT');
			$file->gatherWvInfo();
		}
		else
		{
			$this->logSection('info', 'Basic information gathering skipped (already present).', null, 'COMMENT');
		}
		
//		if($this->mustComputeMD5Sum($file->getStat('size')))
//		{
			if(!$file->getHasMD5Sum())
			{
				$this->logSection('md5sum', 'Computing MD5 hash...', null, 'COMMENT');
				$file->appendMD5sum();
			}
			else
			{
				$this->logSection('md5sum', 'MD5 computing already done.', null, 'COMMENT');
			}
//		}
//		else
//		{
//			$this->logSection('md5sum', 'MD5 computing skipped.', null, 'COMMENT');
//		}
		
		if ($file->getWvInfoChanged())
		{
			$file->saveWvInfoFile();
			$this->logSection('info', 'Writing information file...', null, 'INFO');
			$this->logSection('file+', $file->getWvInfoFilePath(), null, 'INFO');
      
      $user = sfGuardUserProfilePeer::getByUsername($file->getOwner());
      if($user)
      {
        $source = new Source();
        $source
        ->setUserId($user->getId())
        ->setRelativePath($file->getRelativePath())
        ->setBasename($file->getBasename())
        ->setStatus(SourcePeer::STATUS_READY)
        ->setInode($file->getStat('ino'))
        ->setTaskLogEventId($this->_logEvent)
        ->save();
        $this->logSection('db+', $user->getUsername(), null, 'INFO');
      }
		}
		else
		{
			$this->logSection('info', 'Information saving skipped (no need).', null, 'COMMENT');
		}
		unset($file);
		
	}

  protected function preparePhotoAlbums($completeDirPath)
  {
    $filenames=@scandir($completeDirPath);
			
		if (!$filenames)
		{
			throw new Exception("Could not read directory: $completeDirPath");
		}
    
    $files=array();
    
    foreach($filenames as $basename)
    {
      if (Generic::matchesOneOf(wvConfig::get('filebrowser_photoalbum_items'), $basename))
      {
        $file= new BasicFile($completeDirPath, $basename);
        $files[$basename]=$file->getOwner();
        unset($file);
      }
    }
    
    $users=array_values(array_flip(array_flip($files)));
    
    if (sizeof($users)>0)
    {
      foreach($users as $user)
      {
        $this->logSection('album', $user, null, 'COMMENT');
        $photoAlbum= new PhotoAlbum($completeDirPath, $files, $user);
        $photoAlbum->processFileList();
        $this->logSection('file+', $photoAlbum->getCompletePath());
        foreach($photoAlbum->getFiles() as $image)
        {
          $this->logSection('file-', $image, null, 'INFO');
        }
        unset($photoAlbum);
      }
    }
    
    
  }



  protected function ScanDirectory($subdir)
	{
		$completeDirPath=Generic::getCompletePath($this->_sourcesDirectory, $subdir);
		
		if(is_dir($completeDirPath))
		{
      $this->preparePhotoAlbums($completeDirPath);
      
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

	$this->_isLogged=Generic::normalizedBooleanValue($options['logged'], true);
	$options['logged']=Generic::normalizedBooleanDescription($this->_isLogged);
	
	$this->_isRecursive=Generic::normalizedBooleanValue($options['recursive'], false); 
	$options['recursive']=Generic::normalizedBooleanDescription($this->_isRecursive);
  
  $this->_ignoreScannedFiles=Generic::normalizedBooleanValue($options['ignore-scanned-files'], false);
	$options['ignore-scanned-files']=Generic::normalizedBooleanDescription($this->_ignoreScannedFiles);
		
	$subdir=$options['subdir'];
	Generic::normalizeDirName($subdir, '/');
	$options['subdir']=$subdir;
	
	$this->_sourcesDirectory=wvConfig::get('directory_sources');

/*
	$this->_size_limit_for_md5sum=(float)$options['size-limit-for-md5sum'];
	
	$options['size-limit-for-md5sum']=$this->_size_limit_for_md5sum;
*/

	$completeDirPath=Generic::getCompletePath($this->_sourcesDirectory, $subdir);
	
	$this->logSection('directory', $completeDirPath, null, 'COMMENT');
	
	foreach(array(
		'subdir',
		'recursive',
//		'size-limit-for-md5sum',
		'logged',
		) as $key)
	{
		$this->logSection($key, $options[$key], null, 'COMMENT');
	}


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

  echo "\n";

	try
	{
		$this->ScanDirectory($subdir);
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
  
  if($this->_isLogged)
  {
    $notices = $taskLogEvent->retrieveUsersToSendEmailsTo();
    
    if(sizeof($notices)>0)
    {
      echo "\n";
      $this->logSection('mail', 'Email notices sent', null, 'COMMENT');
      foreach($notices as $user=>$number)
      {
        $profile=sfGuardUserProfilePeer::retrieveByPK($user);
        $profile->sendSourceReadyNotice($this->getMailer(), $number);
        $this->logSection('mail@', $profile->getEmail() . ' (' . $number . ')', null, 'INFO');
      }
    }
  }

	return 0;
	
  }
}

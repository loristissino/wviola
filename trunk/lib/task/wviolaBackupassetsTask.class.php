<?php

class wviolaBackupassetsTask extends sfBaseTask
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
      new sfCommandOption('list-only', null, sfCommandOption::PARAMETER_OPTIONAL, 'whether the execution will just list files never backed up', 'false'),
    ));

    $this->namespace        = 'wviola';
    $this->name             = 'backup-assets';
    $this->briefDescription = 'Backs up low-quality assets files into an ISO image';
    $this->detailedDescription = <<<EOF
The [wviola:backup-assets|INFO] task prepares an ISO image of a DVD-ROM where low-quality assets files are stored, for backup purposes. Optionally, prints a list of files never backed up.

Call it with:

  [php symfony wviola:backup-assets|INFO]

If you just want a list of files that have never been backed up in a DVD-ROM, use the  [--list-only|COMMENT] option:

  [./symfony doctrine:migrate --list-only=true|INFO]

The task ends with an exception if something goes wrong (e.g. when a file could not be read or written).

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

	$this->_isLogged=Generic::normalizedBooleanValue($options['logged'], true);
	$options['logged']=Generic::normalizedBooleanDescription($this->_isLogged);
  
  $this->_listOnly=Generic::normalizedBooleanValue($options['list-only'], false); 
	$options['list-only']=Generic::normalizedBooleanDescription($this->_listOnly);
  	
	$this->_publishedAssetsDirectory=wvConfig::get('directory_published_assets');
	$this->_publishedThumbnailsDirectory=wvConfig::get('directory_published_thumbnails');
	$this->_imagesDirectory=wvConfig::get('directory_iso_images');
  
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
  
  $Assets=AssetPeer::retrieveAssetsNotBackedUp();
  
  if($this->_listOnly)
  {
    foreach($Assets as $Asset)
    {
      echo Generic::getCompletePath(
        $this->_publishedAssetsDirectory,
        $Asset->getLowQualityFilename()
        ). "\n";
      echo Generic::getCompletePath(
        $this->_publishedThumbnailsDirectory,
        $Asset->getThumbnailFilename()
        ). "\n";
    }
      
  }
  
  else
  {
    $Archive = new Archive(ArchivePeer::LOW_QUALITY_ARCHIVE);
    $jobdone = false;
    
    $Archive->addAssets($Assets);

    if ($Archive->getIsFull())
    {
      if ($Archive->prepareISOImage())
      {
        $this->logSection('file+', $Archive->getIsoImageFullPath(), null, 'INFO');
        $jobdone=true;
      }
      else
      {
        $this->logSection('archive', 'Something got wrong while preparing ISO image', null, 'ERROR');
      }
    }
    else
    {
      $this->logSection('assets', 'Not enough files to make an ISO image', null, 'COMMENT');
    }
  }


	if($this->_isLogged)
	{
		$taskLogEvent->
		setFinishedAt(time())->
		save();
		// we update the record
	}
  
  if ($jobdone)
  {
    if($username=wvConfig::get('archiviation_notice_to'))
    {
      echo "\n";
      $user=sfGuardUserProfilePeer::getByUsername($username);
      if ($user)
      {
        $profile = $user->getProfile();
        if ($profile->sendArchiveReadyNotice($this->getMailer(), $Archive))
        {
          $this->logSection('mail', 'Email notice sent', null, 'COMMENT');
          $this->logSection('mail@', $profile->getEmail(), null, 'INFO');
        }
        
      }
    }
    
  }

  
	return 0;
	
  }
}

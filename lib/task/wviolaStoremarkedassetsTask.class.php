<?php

class wviolaStoremarkedassetsTask extends sfBaseTask
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

    $this->namespace       = 'wviola';
    $this->name             = 'store-marked-assets';
    $this->briefDescription = 'Stores marked assets in the proper directory';
    $this->detailedDescription = <<<EOF
The [wviola:publish-assets|INFO] task moves the assets marked for archiviation to the directory set.

Call it with:

  [php symfony wviola:store-marked-assets|INFO]

The task ends with an exception if something goes wrong (e.g. when a file could not be
read or written).

EOF;

    $this->_isLogged=true;
    $this->_logEvent=null;
  }

  protected function moveFiles()
  {
    $files=scandir($this->_markedDirectory);
    
    $fixes = array();
    
    foreach($files as $file)
    {
		if(substr($file, 0, 1)!='.')
		{
			if(substr($file, -4) !='.yml')
			{
				echo "Copying file " . $file . "... ";
        $sf = $this->_markedDirectory . '/' . $file;
        $if = $this->_markedDirectory . '/' . $file . '.yml';
        $tf = $this->_scheduledDirectory . '/' . $file;
				if(copy($sf, $tf))
				{
					echo "done.\n";
				}
				$asset=AssetPeer::retrieveByUniqid($file);
        if(!$asset)
        {
          echo "Could not find db information about the asset identified by " . $file . ".\n";
          
          $info=sfYaml::load($if);
          
          if(is_array($info) && isset($info['file']))
          {
            if(isset($info['file']['originalpath']))
            {
              echo "* The file should be moved back to " . $info['file']['originalpath'] . "\n";
              $fixes[] = sprintf("sudo mv -v '%s' '%s'", $sf, $info['file']['originalpath']);
            }
            if(isset($info['file']['uid']))
            {
              echo "* The file owner (uid) should be set back to " . $info['file']['uid'] . "\n";
              $fixes[] = sprintf("sudo chown -v %s '%s'", $info['file']['uid'], $info['file']['originalpath']);
            }
            if(isset($info['file']['gid']))
            {
              echo "* The file owner (gid) should be set back to " . $info['file']['gid'] . "\n";
              $fixes[] = sprintf("sudo chgrp -v %s '%s'", $info['file']['gid'], $info['file']['originalpath']);
            }
          }
          
          echo "\n";
          
          continue;
        }
				$copiedFile = new BasicFile($sf);
				echo "Checking md5... ";
				if($copiedFile->getMD5Sum($asset->getSourceLmd5sum())==$asset->getSourceLmd5sum())
				{
					echo "OK.\n";
          // since we moved the file to a different file system, we update the inode number
          $originalFile = new BasicFile($tf);
          if ($source = SourcePeer::retrieveByInode($originalFile->getStat('ino')))
          {
            $source->setInode($copiedFile->getStat('ino'));
            $source->save();
          }
          $this->logSection('file+', $tf, null, 'INFO');
          if(unlink($this->_markedDirectory . '/' . $file))
          {
            $this->logSection('file-', $sf, null, 'INFO');
          }
          if(file_exists($sf.'.yml') && unlink($sf.'.yml'))
          {
            $this->logSection('file-', $sf.'.yml', null, 'INFO');
          }
				}
				
			}
		}
	}


    if(sizeof($fixes))
    {
      $tempname = tempnam(sys_get_temp_dir(), 'wviola_generated_');
      file_put_contents($tempname, "#!/bin/bash\n" . implode("\n", $fixes) . "\n");
      $this->logSection('file+', $tempname, null, 'INFO');
      echo 'Some duplicates have been found. If you want to restore them, run '. $tempname . "\n";
    }

  }



  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $this->logSection('started', date('c'), null, 'COMMENT');

    $this->_isLogged=Generic::normalizedBooleanValue($options['logged'], true);
    $options['logged']=Generic::normalizedBooleanDescription($this->_isLogged);
      
    $this->_markedDirectory=wvConfig::get('directory_marked');
    $this->_scheduledDirectory=wvConfig::get('directory_scheduled');

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
    
    
    if($this->_markedDirectory == $this->_scheduledDirectory)
    {
		echo "Marked and Scheduled directories are the same. Nothing to do.\n";
	}
	else
	{
		$this->moveFiles();
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

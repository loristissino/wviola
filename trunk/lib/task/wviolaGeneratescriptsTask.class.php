<?php

class wviolaGeneratescriptsTask extends sfBaseTask
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
      new sfCommandOption('logged', null, sfCommandOption::PARAMETER_OPTIONAL, 'Whether the execution will be logged in the DB', 'true'),

    ));

    $this->namespace        = 'wviola';
    $this->name             = 'generate-scripts';
    $this->briefDescription = 'Generates bash scripts to call for low- and high-quality assets';
    $this->detailedDescription = <<<EOF
The [wviola:generate-scripts|INFO] task generates bash scripts to call for the 
production of low quality and high quality versions of source asset files.
Call it with:

  [php symfony wviola:generate-scripts --env=prod --application=frontend|INFO]

The scripts are generated on the base of the [wviola.yml|COMMENT] config file, so whenever
you update the file you should call this task to regenerate them.
EOF;

    $this->_isLogged=true;
    $this->_logEvent;
    
  }
  
  protected function getStandardBaseScript()
  {
    return <<<EOF
#!/bin/bash

# This script was generated automatically on the base of wviola.yml config file.
# DO NOT EDIT directly, unless you know what you are doing.
#
# To regenerate the scripts, run the task
#     symfony wviola:generate-scripts
#
# See
#     symfony help wviola:generate-scripts
#  
# for details

EOF;
  }
  
  protected function getTargetDir()
  {
    return wvConfig::get('directory_executables');
  }

  protected function saveFile($name, $content)
  {
    $name=$this->getTargetDir() .'/'. $name;
    if (is_writable($this->getTargetDir()))
    {
      file_put_contents($name, $content, LOCK_EX);
      chmod($name, 0770);
      $this->logSection('file+', $name, null, 'INFO');
    }
    else
    {
      $this->logSection('file', $name, null, 'ERROR');
    }
  }

  
  protected function generateScripts()
  {
    // I must generate at least:
    
    /*

    publish_video
    publish_photoalbum

    */
    
    $content=$this->getStandardBaseScript();
    
    $content.=<<<EOF

if [[ $# -ne 1 ]]; then
	echo $0 source
	exit 1
fi

UNIQID="$1"

EOF;

    $command=wvConfig::get('publishing_video_low_quality_command');
    $height=wvConfig::get('publishing_video_height');
    $width=wvConfig::get('publishing_video_width');
    

    $command=Generic::str_replace_from_array(array(
      '%source%'=>wvConfig::get('directory_scheduled') . '/$UNIQID',
      '%width%'  =>$width,
      '%height%' =>$height,
      '%target%'=>wvConfig::get('directory_published_assets') . '/$UNIQID' . wvConfig::get('publishing_video_low_quality_extension'),
      ),
      $command
    );

    $content .= $command . " || exit 2\n"; 
//    mv "$SOURCE" "$TRASH_DIR"
    

    $command=wvConfig::get('publishing_video_high_quality_command');

    $command=Generic::str_replace_from_array(array(
      '%source%'=>wvConfig::get('directory_scheduled') . '/$UNIQID',
      '%target%'=>wvConfig::get('directory_iso_cache') . '/$UNIQID' . wvConfig::get('publishing_video_high_quality_extension'),
      ),
      $command
    );

    $content .= $command . " || exit 3\n\n"; 

    $command = 'mv -v "%source%" "%target%"';
    $command = Generic::str_replace_from_array(array(
      '%source%'=>wvConfig::get('directory_scheduled') . '/$UNIQID',
      '%target%'=>wvConfig::get('directory_trash'),
      ),
      $command
    ); 

    $content .= $command . " || exit 4\n\n\n";
    
    $command = "echo 'PUBLISHED'\n";

    $content .= $command . "\n";

    $this->saveFile('publish_video', $content);

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
      $this->generateScripts();
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

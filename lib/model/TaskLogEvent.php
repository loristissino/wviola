<?php

require 'lib/model/om/BaseTaskLogEvent.php';


/**
 * Skeleton subclass for representing a row from the 'task_log_event' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Sat Feb 27 09:27:33 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class TaskLogEvent extends BaseTaskLogEvent {

  public function retrieveUsersToSendEmailsTo()
  {
    // Couldn't figure out how to get this with Propel addGroupBy function
    
    $c = new Criteria();
    $c->add(SourcePeer::TASK_LOG_EVENT_ID, $this->getId());
    
    $infos=SourcePeer::doSelect($c);
    
    $users=array();
    
    foreach($infos as $info)
    {
      $key=$info->getUserId();
      if(!array_key_exists($key, $users))
      {
        $users[$key] = 1;
      }
      else
      {
        $users[$key]++;
      }
    }
    
    return $users;
    
  }
  
  public function addTaskException($text, $con=null)
  {
    if($this->getTaskException())
    {
      $text = $this->getTaskException() . "\n" . $text;
    }
    $this
    ->setTaskException($text)
    ->save($con)
    ;
    return $this;
  }


} // TaskLogEvent

<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(1, new lime_output_color());

$t->diag('TaskLogEvent');

$c=new Criteria();
$c->add(TaskLogEventPeer::TASK_NAME, 'foo1');
$tasklog_event=TaskLogEventPeer::doSelectOne($c);

$data = $tasklog_event->retrieveUsersToSendEmailsTo();

$t->is(sizeof($data), 2, '->retrieveUsersToSendEmailsTo() returns the correct number of users');

print_r($data);
/*
foreach($data as $record)
{
  print_r($record);
}
*/


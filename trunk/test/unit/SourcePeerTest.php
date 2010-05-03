<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(1, new lime_output_color());

$t->diag('SourcePeer');

$c=new Criteria();
$c->add(TaskLogEventPeer::TASK_NAME, 'foo1');
$tasklog_event=TaskLogEventPeer::doSelectOne($c);

$data = SourcePeer::retrieveByTasklogEvent($tasklog_event->getId());

$t->is(sizeof($data), 2, '::retrieveByTasklogEvent() returns the correct number of users');

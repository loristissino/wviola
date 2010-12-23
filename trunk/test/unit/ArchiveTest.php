<?php

require_once dirname(__FILE__).'/../bootstrap/Propel.php';
 
$t = new lime_test(4, new lime_output_color());

$t->diag('Archive');

$Archive = new Archive(1);

$t->is($Archive->getSlug(), date('Ymd-His').'_high_3', '->getSlug() returns the correct slug');

$t->is($Archive->getIsoImageName(), $Archive->getSlug() . '.iso', '->getIsoImageName() returns the correct name');

$Binders = BinderPeer::retrieveClosed();

$Archive->addBinders($Binders);

$added_items=$Archive->getItems();
$t->is(sizeof($added_items), 14, '->addBinders() adds the correct number of items');

$t->is($Archive->getIsFull(), true, '->getIsFull() returns true for a filled up archive');

/*
if ($Archive->getIsFull())
{
  $list = $Archive->prepareISOImage();
}
*/
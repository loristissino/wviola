<?php

require 'lib/model/om/BaseBinderPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'binder' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Fri Mar 12 22:47:42 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class BinderPeer extends BaseBinderPeer {

  public static function retrieveByUserId($user_id)
  {
    $c = new Criteria();
    $c->add(BinderPeer::USER_ID, $user_id);
    return BinderPeer::doSelect($c);
  }
  
  
  public static function retrieveByTitle($text)
  {
    $c = new Criteria();
    $c->add(BinderPeer::TITLE, '%' . $text .'%', Criteria::LIKE);
    return BinderPeer::doSelect($c);
  }
  
  public static function retrieveOpen()
  {
    $c = new Criteria();
    $c->add(BinderPeer::IS_OPEN, true);
    return BinderPeer::doSelect($c);
  }
  
  public static function retrieveClosed()
  {
    $c = new Criteria();
    $c->add(BinderPeer::IS_OPEN, false);
    $c->addAscendingOrderByColumn(BinderPeer::CREATED_AT);
    $c->addJoin(BinderPeer::ID, AssetPeer::BINDER_ID);
    $c->add(AssetPeer::STATUS, Asset::CACHED);
    return BinderPeer::doSelect($c);
  }
  
  public static function getCriteriaForUser($userId, $onlyOpen=false)
  {
    $c = new Criteria();
    $c->add(BinderPeer::USER_ID, $userId);
    if ($onlyOpen)
    {
      $c->add(BinderPeer::IS_OPEN, true);
    }
    return $c;
  }


} // BinderPeer

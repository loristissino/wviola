<?php

class sfGuardUserProfilePeer extends BasesfGuardUserProfilePeer
{
  public static function getByUsername($username)
  {
    $c=new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, $username);
    return sfGuardUserPeer::doSelectOne($c);
  }
  
/*
  public static function retrieveOldProfiles($timestamp)
  {
    $c=new Criteria();
    $c->add(sfGuardUserProfilePeer::UPDATED_AT, $timestamp-2, Criteria::LESS_THAN);
    return sfGuardUserProfilePeer::doSelect($c);
  }
*/

  public static function retrieveByUsernames($usernames, $selected=true)
	{
    $crit=$selected? Criteria::IN : Criteria::NOT_IN;
    
		$objs = null;
		if (empty($usernames)) {
			$objs = array();
		} else {
			$criteria = new Criteria(sfGuardUserProfilePeer::DATABASE_NAME);
			$criteria->add(sfGuardUserPeer::USERNAME, $usernames, $crit);
			$objs = sfGuardUserPeer::doSelect($criteria);
		}
		return $objs;
	}
  
  public static function selectAllActiveSorted()
  {
    $c = new Criteria();
    $c->addJoin(sfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
    $c->add(sfGuardUserPeer::IS_ACTIVE, true);
    $c->addAscendingOrderByColumn(sfGuardUserProfilePeer::LAST_NAME);
    $c->addAscendingOrderByColumn(sfGuardUserProfilePeer::FIRST_NAME);
    return self::doSelectJoinsfGuardUser($c);
  }

  
}

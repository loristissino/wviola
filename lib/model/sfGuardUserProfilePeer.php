<?php

class sfGuardUserProfilePeer extends BasesfGuardUserProfilePeer
{
  public static function getByUsername($username)
  {
    $c=new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, $username);
    return sfGuardUserPeer::doSelectOne($c);
  }
  
}

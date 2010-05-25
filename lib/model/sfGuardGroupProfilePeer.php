<?php

/**
 * Subclass for performing query and update operations on the 'sf_guard_group_profile' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfGuardGroupProfilePeer extends sfGuardGroupPeer
{
	
	static public function retrieveGuardGroupByName($name)
	{
	  $c = new Criteria;
	  $c->add(sfGuardGroupPeer::NAME, $name);
	  return sfGuardGroupPeer::doSelectOne($c); 
	}
	
	
	static public function retrieveAllPermissions($name)
	{
	  $c = new Criteria;
	  $c->add(sfGuardGroupPeer::NAME, $name);
	  return sfGuardGroupPeer::doSelectOne($c); 
	}
  

  static public function retrieveAllGuardGroupsAsArray()
  {
    $ret=Array();
	  $gg = sfGuardGroupPeer::doSelect(new Criteria());
    foreach ($gg as $g)
    {
      $ret[]=$g->getName();
    }
    return $ret;
    
  }

}

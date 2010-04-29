<?php

class sfGuardUserProfile extends BasesfGuardUserProfile
{
	
	public function __toString()
	{
		return $this->getFirstName() . ' ' . $this->getLastName();
	}
	
	public function getUsername()
	{
		return $this->getSfGuardUser()->getUsername();
	}
  
  public function getBinderCriteria()
  {
    $c = new Criteria();
    $c->add(BinderPeer::USER_ID, $this->getUserId());
    return $c;
  }
  
}

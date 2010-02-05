<?php

class sfGuardUserProfile extends BasesfGuardUserProfile
{
	
	public function __toString()
	{
			return $this->getFirstName() . ' ' . $this->getLastName();
	}
}

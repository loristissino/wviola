<?php

class sfGuardUserProfile extends BasesfGuardUserProfile
{

		public function getBelongsToGuardGroup(sfGuardGroup $group)
		{
			$c=new Criteria();
			$c->add(sfGuardUserGroupPeer::USER_ID, $this->getUserId());
			$c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());
			if ($user_group = sfGuardUserGroupPeer::doSelectOne($c))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		
		public function getBelongsToGuardGroupByName($groupname)
		{
			$group=sfGuardGroupProfilePeer::retrieveByName($groupname);
			return $this->getBelongsToGuardGroup($group);
		}
		
		public function getGuardGroups()
		{
			$c=new Criteria();
			$c->add(sfGuardUserGroupPeer::USER_ID, $this->getUserId());
			$c->addJoin(sfGuardUserGroupPeer::GROUP_ID, sfGuardGroupPeer::ID);
			$t = sfGuardUserGroupPeer::doSelectJoinsfGuardGroup($c);
			return $t;
		}
		

		public function addToGuardGroup(sfGuardGroup $group)
		{
			if ($this->getBelongsToGuardGroup($group))
			{
				return $this;
			}
			
			$usergroup = new sfGuardUserGroup();
			$usergroup
			->setUserId($this->getUserId())
			->setGroupId($group->getId())
			->save();
			
			return $this;
		}

		public function removeFromGuardGroup(sfGuardGroup $group)
		{
			$c=new Criteria();
			$c->add(sfGuardUserGroupPeer::USER_ID, $this->getUserId());
			$c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());
			$user_group = sfGuardUserGroupPeer::doSelectOne($c);
			if ($user_group)
			{
				$user_group->delete();
			}
			return $this;
		}



  public function update($firstname, $lastname, $email)
  {
    $this
    ->setFirstname($firstname)
    ->setLastname($lastname)
    ->setEmail($email);
    
    return $this;
  }
  
	public function __toString()
	{
		return $this->getUsername() . '=>' . $this->getFirstName() . ' ' . $this->getLastName();
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
  
  public function getAssetCriteria()
  {
    $c = new Criteria();
    $c->addJoin(AssetPeer::BINDER_ID, BinderPeer::ID);
    $c->add(BinderPeer::USER_ID, $this->getUserId());
    return $c;
  }
  
  public function getSourceCriteria()
  {
    $c = new Criteria();
    $c->add(SourcePeer::USER_ID, $this->getUserId());
    $c->add(SourcePeer::STATUS, SourcePeer::STATUS_SCHEDULED, Criteria::LESS_THAN);
    return $c;
  }
  
  private function _composeEmail($template_code)
  {
    $filename=wvConfig::get($template_code);
    if (!is_readable($filename))
    {
      throw new Exception('File not readable: ' . $filename);
    }
    $template=sfYaml::load($filename);
    return array(
      'subject'=>$template['message']['subject'], 
      'body'=>$template['message']['body']
      );
  }
  
  
  public function sendSourceReadyNotice(sfMailer $mailer, $number)
  {
    if (!$this->getEmail())
    {
      return;
    }
   
    $message=$this->_composeEmail('mail_sourceready_template');
   
    $subject=str_replace('%number%', $number, $message['subject']);
    $body=str_replace('%number%', $number, $message['body']);
    
    $message = $mailer->compose(
      array(wvConfig::get('mail_bot_address') => wvConfig::get('mail_bot_address')),
      $this->getEmail(),
      $subject,
      $body);
 
    $mailer->send($message);
    return $this;
    
  }
  
  
}

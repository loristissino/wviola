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
		return $this->getUsername();
	}
	
	public function getUsername()
	{
		return $this->getSfGuardUser()->getUsername();
	}
  
  public function getBinderCriteria($onlyOpen=false)
  {
    return BinderPeer::getCriteriaForUser($this->getUserId(), $onlyOpen);
  }
  
  public function getOpenBinders()
  {
    $c = $this->getBinderCriteria(true);
    return BinderPeer::doSelect($c);
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
    $c->addAscendingOrderByColumn(SourcePeer::RELATIVE_PATH);
    $c->addAscendingOrderByColumn(SourcePeer::BASENAME);
    return $c;
  }

  private function _getSources($status)
  {
    $c = new Criteria();
    $c->add(SourcePeer::USER_ID, $this->getUserId());
    $c->add(SourcePeer::STATUS, $status);
    $c->addAscendingOrderByColumn(SourcePeer::RELATIVE_PATH);
    $c->addAscendingOrderByColumn(SourcePeer::BASENAME);
    return SourcePeer::doSelect($c);
  }
  
  public function getJustScannedSources()
  {
    return self::_getSources(SourcePeer::STATUS_READY);
  }
  
  public function getWaitingSources()
  {
    return self::_getSources(SourcePeer::STATUS_EMAILSENT);
  }
  
  private function _composeEmail($template_code)
  {
    if (!$template_code)
    {
      throw new Exception('Template name not set in wviola.yml: ', $template_code);
    }
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
  
  
  public function sendSourcesReadyNotice(sfMailer $mailer, $number)
  {
    if (!$this->getEmail())
    {
      return;
    }
       
    $Sources=$this->getJustScannedSources();
    $links='';
    $count=0;
    foreach($Sources as $Source)
    {
      $links.=++$count . '. ' . $Source->getBasename().":\n";
      $links.=wvConfig::get('web_frontend_url').'/filebrowser/opendir?code=' . Generic::b64_serialize($Source->getRelativePath()) . '#' . $Source->getInode()."\n\n";
      $Source
      ->setStatus(SourcePeer::STATUS_EMAILSENT)
      ->save()
      ;
    }   
   
    $message=$this->_composeEmail('mail_sourcesready_template');
   
    $subject=str_replace('%number%', $number, $message['subject']);
    $body=str_replace('%number%', $number, $message['body']);
    $body=str_replace('%sourceslist%', $links, $body);
    
    $message = $mailer->compose(
      array(wvConfig::get('mail_bot_address') => wvConfig::get('mail_bot_address')),
      $this->getEmail(),
      $subject,
      $body);
 
    $mailer->send($message);
    return $this;
    
  }

  public function sendSourcesWaitingNotice(sfMailer $mailer, $number)
  {
    if (!$this->getEmail())
    {
      return;
    }
       
    $Sources=$this->getWaitingSources();
    $links='';
    $count=0;
    foreach($Sources as $Source)
    {
      $links.=++$count . '. ' . $Source->getBasename().":\n";
      $links.=wvConfig::get('web_frontend_url').'/filebrowser/opendir?code=' . Generic::b64_serialize($Source->getRelativePath()) . '#' . $Source->getInode()."\n\n";
    }   
   
    $message=$this->_composeEmail('mail_sourceswaiting_template');
   
    $subject=str_replace('%number%', $number, $message['subject']);
    $body=str_replace('%number%', $number, $message['body']);
    $body=str_replace('%sourceslist%', $links, $body);
    
    $message = $mailer->compose(
      array(wvConfig::get('mail_bot_address') => wvConfig::get('mail_bot_address')),
      $this->getEmail(),
      $subject,
      $body);
 
    $mailer->send($message);
    return $this;
    
  }


  
  public function sendArchiveReadyNotice(sfMailer $mailer, Archive $Archive)
  {
    if (!$this->getEmail())
    {
      return false;
    }
   
    $message=$this->_composeEmail('mail_archiveready_template');
   
    $subject=str_replace('%slug%', $Archive->getSlug(), $message['subject']);
    $body=str_replace('%slug%', $Archive->getSlug(), $message['body']);
    
    $message = $mailer->compose(
      array(wvConfig::get('mail_bot_address') => wvConfig::get('mail_bot_address')),
      $this->getEmail(),
      $subject,
      $body);
 
    if ($mailer->send($message))
    {
      return $this;
    }
    else
    {
      return false;
    }
    
  }
  
}

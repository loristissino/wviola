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
    $template=file(wvConfig::get($template_code));
    $subject=$template[0];
    $body='';
    for($i=1; $i<sizeof($template); $i++)
    {
      if(substr($template[$i],0,1)!='#')
      {
        $body.=$template[$i];
      }
    }
    return array('subject'=>$subject, 'body'=>$body);
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

<?php
class adminComponents extends sfComponents
{
  
  public function executeKeyvalues(sfWebRequest $request)
  {
    $unserialized=unserialize($this->serializedvalues);
    $this->values=$unserialized;
    
  }

}  

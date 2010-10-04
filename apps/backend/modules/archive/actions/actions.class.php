<?php

require_once dirname(__FILE__).'/../lib/archiveGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/archiveGeneratorHelper.class.php';

/**
 * archive actions.
 *
 * @package    wviola
 * @subpackage archive
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class archiveActions extends autoArchiveActions
{
  
  public function executeListMarkAsBurned()
  {
    $Archive = $this->getRoute()->getObject();
    
    $result = $Archive->markAsBurned($this->getUser()->getProfile()->getUserId());
 
    if ($result)
    {
      $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('The archive has been successfully marked as burned.'));
    }
    else
    {
      $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('The archive could not be marked as burned.'));
    }
 
    $this->redirect('archive');
  }

  public function executeListGetInfo()
  {
    $this->Archive = $this->getRoute()->getObject();
    
  }



}

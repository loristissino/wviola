<?php

require_once dirname(__FILE__).'/../lib/accesslogGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/accesslogGeneratorHelper.class.php';

/**
 * accesslog actions.
 *
 * @package    wviola
 * @subpackage accesslog
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class accesslogActions extends autoAccesslogActions
{
  public function executeAssetfilter(sfWebRequest $request)
  {
    $this->forward404Unless($Asset=AssetPeer::retrieveByPK($request->getParameter('id')));
    $this->setFilters(array('asset_id'=>$Asset->getId()));
    Generic::logMessage('assetfilter', 'set: ' . $Asset->getId());
    $this->redirect('@access_log_event');
  }

}

<?php

require_once dirname(__FILE__).'/../lib/assetGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/assetGeneratorHelper.class.php';

/**
 * asset actions.
 *
 * @package    wviola
 * @subpackage asset
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class assetActions extends autoAssetActions
{
    public function executeEdit(sfWebRequest $request)
  {
    $this->Asset = AssetPeer::retrieveByPK($request->getParameter('id'));//$this->getRoute()->getObject();
    $this->form = new AssetBackendForm($this->Asset);
    Generic::logMessage('exeEdit', 'passato');
  }

}

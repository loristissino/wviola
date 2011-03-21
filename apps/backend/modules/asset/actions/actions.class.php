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
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->Asset = AssetPeer::retrieveByPK($request->getParameter('id'));//$this->getRoute()->getObject();
    $this->form = new AssetBackendForm($this->Asset);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeChangethumbnail(sfWebRequest $request)
  {
    $this->Asset = AssetPeer::retrieveByPK($request->getParameter('id'));//$this->getRoute()->getObject();
    $this->form = new AssetThumbnailForm($this->Asset);
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid())
      {
        $thumbnail=$this->form->getValue('thumbnail');
        
        if($this->Asset->changeThumbnail($thumbnail, $this->form->getValue('thumbnail_position')))
        {
          $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Thumbnail updated.'));
        }
        else
        {
          $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('Thumbnail not updated.'). ' ' . $this->getContext()->getI18N()->__('See logs for details.'));
        }
        $this->redirect('@changethumbnail?id=' . $this->Asset->getId());
      }
    }
    
  }


}

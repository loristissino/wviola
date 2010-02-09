<?php

/**
 * asset actions.
 *
 * @package    wviola
 * @subpackage asset
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class assetActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->Assets = AssetPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Asset = AssetPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Asset);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AssetForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new AssetForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->form = new AssetForm($Asset);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->form = new AssetForm($Asset);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $Asset->delete();

    $this->redirect('asset/index');
  }


  public function executeThumbnail(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($Asset->hasThumbnail());
	
	$response=$this->getContext()->getResponse();
	$response->setHttpHeader('Pragma', '');
	$response->setHttpHeader('Cache-Control', '');
	$response->setHttpHeader('Content-Length', $Asset->getThumbnailSize());
	$response->setHttpHeader('Content-Type', $Asset->getThumbnailMimeType());

	$response->setContent($Asset->getThumbnailData());
	return sfView::NONE;

  } 

  public function executeVideo(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($Asset->hasVideoAsset());
	
	$response=$this->getContext()->getResponse();
	$response->setHttpHeader('Pragma', '');
	$response->setHttpHeader('Cache-Control', '');
	$response->setHttpHeader('Content-Length', $Asset->getVideoAsset()->getVideo()->getStat('size'));
	$response->setHttpHeader('Content-Type', 'video/x-flv');

	readfile($Asset->getVideoAsset()->getVideo()->getFullPath());
	return sfView::NONE;


  } 



  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Asset = $form->save();

      $this->redirect('asset/edit?id='.$Asset->getId());
    }
  }
}

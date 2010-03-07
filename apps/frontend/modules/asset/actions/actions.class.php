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
//    $this->Assets = AssetPeer::doSelect(new Criteria());


    $this->pager = new sfPropelPager(
      'Asset',
      sfConfig::get('app_max_asset_per_page')
    );

//    $this->pager->setCriteria($this->category->getActiveJobsCriteria());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Asset = AssetPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Asset);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($this->sourcefile=$this->getUser()->getAttribute('sourcefile'));
    $this->form = new AssetForm();
    $this->form->addThumbnailWidget($this->sourcefile, $this->getContext());
    $this->form->setDefault('thumbnail', $request->getParameter('thumbnail', 0));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forward404Unless($this->sourcefile=$this->getUser()->getAttribute('sourcefile'));

    $this->form = new AssetForm();
    $this->form->addThumbnailWidget($this->sourcefile, $this->getContext());
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
/*
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->form = new AssetForm($Asset);
  }
*/
/*
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->form = new AssetForm($Asset);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
*/
/*
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $Asset->delete();

    $this->redirect('asset/index');
  }
*/

  public function executeThumbnail(sfWebRequest $request)
  {

    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($Asset->getHasThumbnail());
	
	$this->forward404Unless($file=$Asset->getThumbnailFile());
	
	$response=$this->getContext()->getResponse();
	$response->setHttpHeader('Pragma', '');
	$response->setHttpHeader('Cache-Control', '');
	$response->setHttpHeader('Content-Length', $file->getStat('size'));
	$response->setHttpHeader('Content-Type', $file->getMimeType());

	$response->setContent(fread(fopen($file->getFullPath(), 'r'), $file->getStat('size')));
	return sfView::NONE;
  } 

  public function executeVideo(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($Asset->hasVideoAsset());
    $this->forward404Unless($file=$Asset->getVideoAsset()->getVideoFile());

    $Asset->logAccess($this->getUser()->getProfile()->getUserId(), $request->getCookie('wviola'));
	
    $response=$this->getContext()->getResponse();
    $response->setHttpHeader('Pragma', '');
    $response->setHttpHeader('Cache-Control', '');
    $response->setHttpHeader('Content-Length', $file->getStat('size'));
    $response->setHttpHeader('Content-Type', $file->getMimeType());

  //	$response->setContent(fread(fopen($file->getFullPath(), 'r'), $file->getStat('size')));

    /* For big files, not to be read in memory, this should be better:
       see http://forum.symfony-project.org/index.php/m/63030/
    */
    $response->sendHttpHeaders();
    readfile($file->getFullPath());
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

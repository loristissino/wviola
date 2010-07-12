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
  
  protected function luceneBuildQuery($values)
  {
    $query='';
    foreach(array('title', 'notes', 'binder', 'date') as $field)
    {
      if(array_key_exists($field, $values) && $values[$field]!='')
      {
        $query.=sprintf('%s:"%s"', $field, $values[$field]);
      }
    }
      return $query;
  }
  
  
  public function executeAdvancedsearch(sfWebRequest $request)
  {
    $this->form = new AdvancedSearchForm($request->getParameter('query'));
    
    if ($request->getParameter('actionrequested')=='search')
    {
      $this->form->bind($request->getParameter('query'));
      if ($this->form->isValid())
      {
        $this->redirect('asset/search?query='.$this->luceneBuildQuery($this->form->getValues()));
      }

    }
//    $this->form = new AdvancedSearchForm($request->getParameter('query'));
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    $this->query = $request->getParameter('query');
    
    $this->Assets = AssetPeer::getForLuceneQuery($this->query);
    
    if ($request->isXmlHttpRequest())
    {
      if ('*' == $this->query || !$this->Assets)
      {
        return $this->renderPartial('asset/noresults');
      }

      return $this->renderPartial('asset/list', array('Assets' => $this->Assets));
    }

  }

  
  public function executeIndex(sfWebRequest $request)
  {
//    $this->Assets = AssetPeer::doSelect(new Criteria());
    $this->pager = new sfPropelPager(
      'Asset',
      sfConfig::get('app_max_assets_per_page')
    );
    
    $this->pager->setCriteria($this->getUser()->getProfile()->getAssetCriteria());

    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Asset = AssetPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Asset);
    $this->editable=$this->getUser()->getProfile()->getUserId()===$this->Asset->getBinder()->getUserId();
    $this->session=$request->getCookie('wviola');
    $this->Asset->logAccess($this->getUser()->getProfile()->getUserId(), $this->session);
    
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($this->sourcefile=$this->getUser()->getAttribute('sourcefile'));
    $this->form = new AssetForm($this->getUser()->getProfile()->getUserId());
    
    if($this->sourcefile->getThumbnailNb()>0)
    {
      $this->form->addThumbnailWidget($this->sourcefile, $this->getContext());
      $this->form->setDefault('thumbnail', $request->getParameter('thumbnail', 0));
      $this->form->setOption('thumbnail', true);
    }
    
    if ($this->getUser()->hasAttribute('last_binder'))
    {
      $this->form->setDefault('binder_id', $this->getUser()->getAttribute('last_binder'));
      Generic::logMessage('binder', $this->getUser()->getAttribute('last_binder'));
    }

    
    $this->binderform = new BinderForm(null, array('embedded'=>true));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forward404Unless($this->sourcefile=$this->getUser()->getAttribute('sourcefile'));

    $this->binderform = new BinderForm();

    $this->form = new AssetForm($this->getUser()->getProfile()->getUserId());
    if($this->sourcefile->getThumbnailNb()>0)
    {
      $this->form->addThumbnailWidget($this->sourcefile, $this->getContext());
      $this->form->setOption('thumbnail', true);
    }
    
    $this->processForm($request, $this->form, $this->sourcefile);

    $this->setTemplate('new');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($Asset->getBinder()->getUserId()==$this->getUser()->getProfile()->getUserId());
    
    $this->form = new AssetForm($this->getUser()->getProfile()->getUserId());
    $this->form
    ->setDefault('id', $Asset->getId())
    ->setDefault('binder_id', $Asset->getBinderId())
    ->setDefault('assigned_title', $Asset->getAssignedTitle())
    ->setDefault('notes', $Asset->getNotes())
    ;
    
    $this->form->setOption('thumbnail', false);
    
    $this->binderform = new BinderForm(null, array('embedded'=>true));

  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($this->Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($this->Asset->getBinder()->getUserId()==$this->getUser()->getProfile()->getUserId());
    $this->form = new AssetForm($this->getUser()->getProfile()->getUserId());

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
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
   // $this->forward404Unless($Asset->getHasThumbnail());
	
	$this->forward404Unless($file=$Asset->getThumbnailFile());
	
	$response=$this->getContext()->getResponse();
	$response->setHttpHeader('Pragma', '');
	$response->setHttpHeader('Cache-Control', '');
	$response->setHttpHeader('Content-Length', $file->getStat('size'));
	$response->setHttpHeader('Content-Type', $file->getMimeType());

	$response->setContent(fread(fopen($file->getFullPath(), 'r'), $file->getStat('size')));
	return sfView::NONE;
  }
  
  
  public function executeShowpicture(sfWebRequest $request)
  {
    $this->forward404Unless($PhotoalbumAsset = PhotoalbumAssetPeer::retrieveByPk($request->getParameter('album')), sprintf('Object PhotoalbumAsset does not exist (%s).', $request->getParameter('album')));
    
    $this->forward404Unless($request->getParameter('number') < $PhotoalbumAsset->getPicturesCount(), sprintf('Picture does not exist (%d).', $request->getParameter('number')));
    
    $PhotoalbumAsset->getPhotoalbumFile($request->getCookie('wviola'))->prepareDeliveryOfFile($this->getContext()->getResponse(), $request->getParameter('number'));
    Generic::logMessage('cookie',$request->getCookie('wviola'));

    return sfView::NONE;
    
  }

  public function executeVideo(sfWebRequest $request)
  {
    $this->forward404Unless($Asset = AssetPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Asset does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($Asset->hasVideoAsset());
    $this->forward404Unless($file=$Asset->getVideoAsset()->getVideoFile());

	
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



  protected function processForm(sfWebRequest $request, sfForm $form, SourceFile $sourcefile=null)
  {
    if ($sourcefile)
    {
      $filename=$sourcefile->getBaseName();
    }
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      if (!$this->Asset) // it's getting scheduled
      {
        $Asset = new Asset();
        if ($Asset->scheduleSourceFileForArchiviation(
          $this->getUser()->getProfile()->getUserId(),
          $sourcefile,
          $form->getValues()
          ))
        {
          $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Source file «%filename%» correctly scheduled for archiviation.', array('%filename%'=>$filename)));
          $this->getUser()->setAttribute('last_binder', $Asset->getBinderId());
        }
        else
        {
          $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('Something went wrong with scheduling.'));
        }
          
        $this->redirect('filebrowser/index');
      }
      else // it's a data update
      {
        try
        {
          $this->Asset->updateValuesFromForm($form->getValues());
          $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Data updated'));
          $this->getUser()->setAttribute('last_binder', $Asset->getBinderId());
        }
        catch (Exception $e)
        {
          $this->getUser()->setFlash('error', 'Sorry, Could not update data.');
          $this->redirect('asset/show?id='. $Asset->getId());
        }
      }
    }
  }
  
}

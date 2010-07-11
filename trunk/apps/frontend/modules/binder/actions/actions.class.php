<?php

/**
 * binder actions.
 *
 * @package    wviola
 * @subpackage binder
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class binderActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfPropelPager(
      'Binder',
      sfConfig::get('app_max_binders_per_page')
    );
    $this->pager->setCriteria($this->getUser()->getProfile()->getBinderCriteria());

    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Binder = BinderPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Binder);
    
    $this->pager = new sfPropelPager(
      'Asset',
      sfConfig::get('app_max_assets_per_page')
    );
    $this->pager->setCriteria($this->Binder->getAssetsCriteria());

    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    
  }

  public function executeNew(sfWebRequest $request)
  {
    $embedded = preg_match('/asset\/create/', $request->getReferer())
      || preg_match('/filebrowser\/archive/', $request->getReferer());
    
    $this->form = new BinderForm(null, array('embedded'=>$embedded));
    if($embedded)
    {
      $this->setLayout('popup');
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $embedded = $request->getParameter('embedded');

    $this->form = new BinderForm(null, array('embedded'=>$embedded));
    
    $this->processForm($request, $this->form, $embedded);

    if(!$embedded)
    {
      $this->setTemplate('new');
    }
    else
    {
      $this->forward('binder', 'embedded');
    }
  
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Binder = BinderPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Binder does not exist (%s).', $request->getParameter('id')));
    
    $embedded = $request->getParameter('embedded');
    
    $this->form = new BinderForm($Binder, $embedded);
    
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Binder = BinderPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Binder does not exist (%s).', $request->getParameter('id')));
    $this->form = new BinderForm($Binder);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Binder = BinderPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Binder does not exist (%s).', $request->getParameter('id')));
    
    try
    {
      $Binder->delete();
      $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('The item has been successfully removed.'));
    }
    catch (Exception $e)
    {
      $this->getUser()->setFlash('error', 'Something went wrong.' . ' ' . $e->getMessage());
      $this->redirect('binder/edit?id=' . $Binder->getId());
  
    }

    $this->redirect('binder/index');
  }
  
  public function executeEmbedded(sfWebRequest $request)
  {
    $this->Binders=$this->getUser()->getProfile()->getOpenBinders();
    $this->selected=$this->getUser()->getAttribute('selected_binder');
    $this->BinderValues=$this->getUser()->getAttribute('binder_values');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $embedded = false)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $values=$form->getValues();
      $Binder=BinderPeer::retrieveByPK($values['id']);
      
      if(!$Binder)
      {
        $Binder = new Binder();
      }
      
      $Binder->setFromForm(
        $this->getUser()->getProfile()->getUserId(),
        $form->getValues()
        )
      ->save();
            
      if ($embedded)
      {
        $this->getUser()->setAttribute('selected_binder', $Binder->getId());
        $this->getUser()->setAttribute('binder_values', null);
        $this->forward('binder', 'embedded');
      }
      
      $this->redirect('binder/edit?id='.$Binder->getId() . ($embedded? '&embedded=true':''));
    }
    else
    {
      $this->getUser()->setAttribute('binder_values', $form->getTaintedValues());
      $this->getUser()->setAttribute('selected_binder', null);
    }
  }
}

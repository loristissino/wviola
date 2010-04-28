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
    $this->Binders = BinderPeer::retrieveByUserId($this->getUser()->getProfile()->getUserId());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Binder = BinderPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Binder);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new BinderForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new BinderForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Binder = BinderPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Binder does not exist (%s).', $request->getParameter('id')));
    $this->form = new BinderForm($Binder);
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
    $Binder->delete();

    $this->redirect('binder/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Binder = $form->save();

      $this->redirect('binder/edit?id='.$Binder->getId());
    }
  }
}

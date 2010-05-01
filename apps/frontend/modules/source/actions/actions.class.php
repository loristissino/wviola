<?php

/**
 * source actions.
 *
 * @package    wviola
 * @subpackage source
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sourceActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->Sources = SourcePeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Source = SourcePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Source);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SourceForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SourceForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Source = SourcePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Source does not exist (%s).', $request->getParameter('id')));
    $this->form = new SourceForm($Source);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Source = SourcePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Source does not exist (%s).', $request->getParameter('id')));
    $this->form = new SourceForm($Source);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Source = SourcePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Source does not exist (%s).', $request->getParameter('id')));
    $Source->delete();

    $this->redirect('source/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Source = $form->save();

      $this->redirect('source/edit?id='.$Source->getId());
    }
  }
}

<?php

/**
 * pictures actions.
 *
 * @package    wviola
 * @subpackage pictures
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class picturesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	$this->pictures=PicturePeer::doSelect(new Criteria());
  }

  public function executeEdit(sfWebRequest $request)
  {

	$this->picture=PicturePeer::retrieveByPK($request->getParameter('id'));
	
	$this->form=new PictureForm($this->picture);
	
	if($this->picture)
	{
		foreach($this->picture->getSortedDescriptions() as $index=>$description)
		{
			$descriptionForm=new DescriptionForm($description);
			$this->form->embedForm('description[' . $index . ']', $descriptionForm);
		}


	}

	if ($request->isMethod('post'))
	{
		$this->form->getValidatorSchema()->setOption('allow_extra_fields', true);
		$this->form->getValidatorSchema()->setOption('filter_extra_fields', false);

		$this->form->bind($request->getParameter('picture'));
		if ($this->form->isValid())
		  {
			$parameters = $this->form->getValues();
			
			$picture=PicturePeer::retrieveByPK($parameters['id']);
			$picture
			->setPath($parameters['path'])
			->save();
			
			if (sizeof($parameters['description'])>0)
			{
				foreach($parameters['description'] as $description_parameters)
				{
					$description=DescriptionPeer::retrieveByPK($description_parameters['id']);
					$description
					->setText($description_parameters['text'])
					->save();
				}
			}
			
			$this->redirect('pictures/edit?id=' . $picture->getId());
		}
	}
	
	
  }

}

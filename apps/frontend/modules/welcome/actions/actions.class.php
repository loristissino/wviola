<?php

/**
 * welcome actions.
 *
 * @package    wviola
 * @subpackage welcome
 * @author     Loris Tissino  <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class welcomeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }
  public function executeUpload(sfWebRequest $request)
  {
  }
  public function executeGetvideo(sfWebRequest $request)
  {
	// this is just a proof of concept...  
	sfConfig::set('sf_web_debug', false);
	
	$savepath='/var/wviola/web/videos/';
	$filename=rand(1000000, 9999999);
	if (!@move_uploaded_file($_FILES['videofile']["tmp_name"], $savepath.$filename))
	{
		return $this->renderText('some error occured');
		
	}
	else
	{
		return $this->renderText($savepath.$filename);
	}
	  
  }
  public function executeThanks(sfWebRequest $request)
  {
	// this must be symfony-zed!  
	// Check for the file id we should have gotten from SWFUpload
	if (isset($_POST["hidFileID"]) && $_POST["hidFileID"] != "" )
	{
		$this->id = $_POST["hidFileID"];
	}
	else
	{
		$this->id='???';  
	}
	$this->firstname=$request->getParameter('firstname');
	
  }


}

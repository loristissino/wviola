<?php

/**
 * filebrowser actions.
 *
 * @package    wviola
 * @subpackage filebrowser
 * @author     Loris Tissino <loris.tissino@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class filebrowserActions extends sfActions
{

  public function preExecute()
	{
		$this->profile=$this->getUser()->getProfile();
		$this->path = $this->getUser()->getAttribute('path', '/');
		$this->folder= new SourceFolder(wvConfig::get('directory_sources'), $this->path);
		if (!$this->folder->getPathExists())
		{
      $this->_changeDirectory('/');
		}
		$this->getUser()->setAttribute('oldpath', $this->path);
		
    $this->extra=wvConfig::get('directory_sources');
	}
	
  
  public function executeOpendir(sfWebRequest $request)
  {
		$this->_changeDirectory(Generic::b64_unserialize($request->getParameter('code')));
  }
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	
		$this->path=$this->folder->getPath();
		//$this->folder->scanSourcesInBackground($this->getContext());
		$this->folder_items=$this->folder->getFolderItems(
      $this->getUser()->hasCredential('tagging')? '' : $this->profile->getUsername()
      );
	
  }
  public function executeOpen(sfWebRequest $request)
  {
		$current=$this->folder->getPath();
		if ($current=='/')
		{
			$current='';
		}
		
		$this->_changeDirectory($current. '/' . Generic::standardizePath($request->getParameter('name')));
		
  }

  public function executeArchive(sfWebRequest $request)
  {
		$this->folder=$this->folder->getPath();
    $this->filename=$request->getParameter('name');
    $this->thumbnail=$request->getParameter('thumbnail', '');
    
    $error=false;
    
		try
    {
      $this->sourcefile= new SourceFile(
        Generic::standardizePath($this->folder), 
        Generic::standardizePath($this->filename)
        );
    }
    catch (Exception $e)
    {
      $error=true;
    }



    if (!$error && ($this->thumbnail!='') && !$this->sourcefile->getThumbnail($this->thumbnail))
    {
      $this->forward404();
    }

    if(!$error && !$this->sourcefile->getIsArchivable())
    {
      $error=true;
    }
    
    
    if ($error)
    {
      $this->getUser()->setFlash('error',
        $this->getContext()->getI18N()->
        __('For some reason, it is not possible to schedule file «%filename%» for archiviation.',
        array('%filename%'=>$this->filename)) .
        
        ($this->sourcefile->getDuplicateOfAssetId() ?
          (' ' . $this->getContext()->getI18N()->
            __('Looks like it is a a duplicate of asset %id%.',
            array('%id%'=>$this->sourcefile->getDuplicateOfAssetId())))
            /*
            . 
            ' <a href="' . $this->getController()->genUrl('asset/show?id='. $this->sourcefile->getDuplicateOfAssetId(), true) .
            '">' . $this->getContext()->getI18N()->
              __('Show') . '</a>')
            */
            
          : ''
        ));
      $this->redirect('filebrowser/index');
      
    }
    
    $this->getUser()->setAttribute('sourcefile', $this->sourcefile);
    
    $this->forward('asset', 'new');
    
  }



/*
  public function executeRemove(sfWebRequest $request)
  {
		$filename=$request->getParameter('name');
		try
		{
			$this->folder->removeFile(urldecode($filename));
			$this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('The file "%filename%" has been removed.', array('%filename%'=>$filename)));
		}
		catch (Exception $e)
		{
			$this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('The file "%filename%" cannot be removed.', array('%filename%'=>$filename)));
		}
		
		$this->redirect('filebrowser/index');
  }
*/
   private function _changeDirectory($newpath)
	{
		$this->getUser()->setAttribute('path', $newpath);
		$this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Directory changed to %directoryname%.', array('%directoryname%'=>$newpath)));
		$this->forward('filebrowser', 'index');
		
	}

	public function executeUp(sfWebRequest $request)
  {
		$this->_changeDirectory(dirname($this->folder->getPath()));
  }

	public function executeThumbnail(sfWebRequest $request)
	{
		$this->forward404Unless($file=new SourceFile(Generic::b64_unserialize($request->getParameter('path')), Generic::b64_unserialize($request->getParameter('basename'))));
		
		$this->forward404Unless($this->thumbnail=$file->getThumbnail($request->getParameter('number')));
		
		$content=base64_decode($this->thumbnail['base64content']);
		
		$response=$this->getContext()->getResponse();
		$response->setHttpHeader('Pragma', '');
		$response->setHttpHeader('Cache-Control', '');
		$response->setHttpHeader('Content-Length', sizeof($content));
		$response->setHttpHeader('Content-Type', 'image/jpeg');

		$response->setContent($content);
		return sfView::NONE;

	}

/*
  public function executeDownload(sfWebRequest $request)
  {
		$filename=$request->getParameter('name');
		try
		{
			$this->folder->serveFile(urldecode($filename), $this->getContext()->getResponse());
			return sfView::NONE;

		}
		catch (Exception $e)
		{
			$this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('The file "%filename%" cannot be downloaded.', array('%filename%'=>$filename)));
		}
		
		$this->redirect('filebrowser/index');
  }
*/
/*
	public function executeUpload(sfWebRequest $request)
	{
		$this->form = new UploadFileForm();
		
		if ($request->isMethod('post'))
		{
		  $this->form->bind($request->getParameter('info'), $request->getFiles('info'));
		  
		  if ($this->form->isValid())
		  {
			$file = $this->form->getValue('file');
			try
			{
				$this->folder->acceptFile($file);
				$this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('File uploaded.'));
			}
			catch (Exception $e)
			{
				$this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('The file could not be uploaded.'));
			}
			
			$this->redirect('filebrowser/index');

		  }
		}
		else
		{
			$this->forward404();
		}
	}
*/
/*
	public function executeMakedir(sfWebRequest $request)
	{
		$this->form = new MakeDirForm();
		
		if ($request->isMethod('post'))
		{
		  $this->form->bind($request->getParameter('info'), $request->getFiles('info'));
		  
		  if ($this->form->isValid())
		  {
			$directory = $this->form->getValue('directory');
			try
			{
				$this->folder->makeDirectory($directory);
				$this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Directory created.'));
			}
			catch (Exception $e)
			{
				$this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('The directory could not be created.'));
			}
			
			$this->redirect('filebrowser/index');

		  }
		}
		else
		{
			$this->forward404();
		}
	}
*/

}



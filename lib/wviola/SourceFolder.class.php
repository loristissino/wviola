<?php

class SourceFolder
{
	
	private $_basicpath;
	private $_path;
	private $_folderItems;
	
	public function __construct($basicpath, $path)
		{
			$this->setBasicPath($basicpath);
			$this->setPath($path);
			$this->_folderItems=Array();
		}

  public function __toString()
  {
    return $this->getPath();
  }

	public function getPath()
		{
			return $this->_path;
		}

	public function setPath($value)
		{
			$this->_path=$value;
			return $this;
		}
				
	private function getBasicPath()
		{
			return $this->_basicpath;
		}
		
	private function setBasicPath($value)
		{
			$this->_basicpath=$value;
			return $this;
		}
		
	public function getPathExists()
	{
		return is_dir($this->getCompleteDirPath());
	}
		
	public function getCompleteDirPath()
	{
		return Generic::getCompletePath($this->getBasicPath(), $this->getPath());
	}
		
	public function getFolderItems()
		{
			$fileList = scandir($this->getCompleteDirPath());
			foreach ($fileList as $file)
			{
				if (substr($file, 0, 1)!='.')
				{
					$sourceFile=new SourceFile($this->getPath(), $file);
					if ($sourceFile->getShouldBeSkipped())
					{
						unset($sourceFile);
						continue;
					}
					else
					{
						$this->_folderItems[]=$sourceFile;
					}
				}
				
			}
			
//			usort($this->_folderItems, array('FolderItem', 'compare_items'));
			return $this->_folderItems;
		}
		
		
	private function _getFullPathOfFile($name)
	{
		$separator=$this->getPath()=='/' ? '': '/';
//		return str_replace(array('(', ')'), array('\(', '\)'), $this->getPath() . $separator . $name);
		return html_entity_decode($this->getPath() . $separator . $name, ENT_QUOTES, 'UTF-8');
	}
	
	
	public function scanSourcesInBackground(sfContext $sfContext=null)
	{
		if(!$sfContext)
		{
			throw new Exception('This function should not be called without context');
		} 
		
		$command=sprintf(
			'symfony wviola:scan-sources --recursive=false --subdir="%s" --logged=false --env=%s 2>/dev/null >/dev/null &',
			$this->getPath(),
			$sfContext->getConfiguration()->getEnvironment()
			);
		
		$info=Generic::executeCommand($command, false);
		
	}
	
	
/*	

	public function serveFile($name, sfWebResponse $response)
	{
		
		if (!$folderItem=$this->_getFileInfo($name))
		{
			throw new Exception('file could not be served');
		}
		
		try
		{
			$info=Generic::executeCommand(sprintf('posixfolder_copyfile %s "%s"', 
				$this->getUsername(),
				$this->_getFullPathOfFile($name)
				), 
				false);
		}
		catch (Exception $e)
		{
				throw $e;
		}
		
		$response->setHttpHeader('Pragma', '');
		$response->setHttpHeader('Cache-Control', '');
		$response->setHttpHeader('Content-Length', $folderItem->getSize());
		$response->setHttpHeader('Content-Type', $folderItem->getMimeType());
		$response->setHttpHeader('Content-Disposition', 'attachment; filename="' . html_entity_decode($name, ENT_QUOTES, 'UTF-8') . '"');
		
		$tmpfile=fopen($info['TMPNAME'], 'r');
		$response->setContent(fread($tmpfile, $folderItem->getSize()));
		fclose($tmpfile);
		$tmpfile=fopen($info['TMPNAME'], 'w');
		fwrite($tmpfile, '');
		// we rewrite the file with no data, because we cannot remove it
				
	}
*/
/*	
	public function removeFile($name)
	{
		
		if (!$folderItem=$this->_getFileInfo($name))
		{
			throw new Exception('file does not exist or is unreadable');
		}
		
		try
		{
			$info=Generic::executeCommand(sprintf('posixfolder_removefile %s "%s"', 
				$this->getUsername(),
				$this->_getFullPathOfFile($name)
				), 
				false);
		}
		catch (Exception $e)
		{
				throw $e;
		}
		
	}
*/
/*
	public function makeDirectory($name)
	{
				
		try
		{
			$info=Generic::executeCommand(sprintf('posixfolder_makedir %s "%s"', 
				$this->getUsername(),
				$this->_getFullPathOfFile($name)
				), 
				false);
		}
		catch (Exception $e)
		{
				throw $e;
		}
		
	}
/*
	public function acceptFile(sfValidatedFile $file)
	{
		try
		{
			$info=Generic::executeCommand(sprintf('posixfolder_putfile %s %s "%s"', 
				$this->getUsername(), 
				$file->getTempName(),
				$this->_getFullPathOfFile($file->getOriginalName())
				));
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
*/
		
};


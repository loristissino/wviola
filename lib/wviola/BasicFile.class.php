<?php

class BasicFile
{
	protected
		$_basename,
		$_path,
		$_stat;
	
	public function __construct()
	{
		switch(func_num_args())
		{
			case 1:
				$this->_path=dirname(func_get_arg(0));
				$this->_basename=basename(func_get_arg(0));
				break;
			case 2:
				$this->_path=func_get_arg(0);
				Generic::removeLastCharIf($this->_path, '/');
				$this->_basename=func_get_arg(1);
				break;
		}
    
    $list=wvConfig::get('publishing_extensions_used');
    
    $found=false;
    $orig=$this->getBasename();
    foreach($list as $ext)
    {
      $this->setBasename($orig . $ext);
      if ($this->_stat = @stat($this->getFullPath()))
      {
        $found=true;
        break;
      }
    }
    
		if (!$found)
		{
			throw new Exception(sprintf('Not a valid file: %s* (tried %s)', $orig, $this->getFullPath()));
		}
		
		if ($this->getStat('size')<0)
		{
			/* for big files, stat gets wrong results... */
			$command='stat --dereference --format "%s" "' . $this->getFullPath() . '"';
			$this->_stat['size']=(float) $this->executeCommand($command); 
		}
		
	}
	
	public function getPath()
	{
		return $this->_path;
	}
	
	public function getBasename()
	{
		return $this->_basename;
	}
  
	public function setBasename($v)
	{
		$this->_basename=$v;
		return $this;
	}
	
	public function getFullPath()
	{
		return Generic::getCompletePath($this->getPath(), $this->getBasename());
	}
  
  public function getPathName()
  {
    return $this->getFullPath();
  }

	public function getStat($name)
	{
		return $this->_stat[$name];
	}
	
	public function getStats()
	{
		return $this->_stat;
	}
  
  public function getSize()
  {
    return $this->getStat('size');
  }
	
	public function getMD5Sum($limit='')
	{
    if ($limit=='')
    {
      return md5_file($this->getFullPath());
    }
    else
    {
      $info=$this->executeCommand(
        sprintf('limitedmd5sum "%s" %s', $this->getFullPath(), $limit),
        true);
      list($key, $value)=explode('=', $info);
      return $value;
    }
	}
	
	public function executeCommand($command, $custom=false)
	{
		return Generic::executeCommand($command, $custom);
	}
	
	public function getGuessedInternetMediaType()
	{
		$command=sprintf('file --dereference --brief --mime-type "%s"', $this->getFullPath());
		$mimeType=$this->executeCommand($command);
		
    if (!strpos($mimeType, '/'))
    {
      return null;
      // if the file is not readable or for other problems...
    }
    
		list($type, $subtype)=explode('/', $mimeType);
		
		if($type=='application')
		{
			// we need this because sometimes mpeg videos are reported as application/octet-stream
			$command=sprintf('file --dereference --brief "%s"', $this->getFullPath());
			$description=$this->executeCommand($command);
			if (preg_match('/MPEG sequence/', $description))
			{
				return 'video/mpeg';
			}
			if (preg_match('/Theora video/', $description))
			{
				return 'video/ogg';
			}
			if ($subtype=='ogg')
			{
				// FIXME This is likely not always true...
				return 'video/ogg';
			}
		}
		return $mimeType;
	}
  
  public function getMimeType()
  {
    return $this->getGuessedInternetMediaType();
  }
  
	
	public function getFileType()
	{
		if (is_dir($this->getFullPath()))
		{
			return 'directory';
		}
		if (is_link($this->getFullPath()))
		{
			return 'link';
		}
		if (is_file($this->getFullPath()))
		{
			return 'file';
		}
		return 'unknown';

	}

	public function getOwner()
	{
		$command='stat -c %U' . sprintf(' "%s"', $this->getFullPath());
		$user=$this->executeCommand($command);
		return $user;
  }
  
  public function prepareDelivery(sfWebResponse $response, $attachment=true)
  {
		$response->setHttpHeader('Pragma', '');
		$response->setHttpHeader('Cache-Control', '');
		$response->setHttpHeader('Content-Length', $this->getSize());
		$response->setHttpHeader('Content-Type', $this->getMimeType());
    if ($attachment)
    {
      $response->setHttpHeader('Content-Disposition', 'attachment; filename="' . html_entity_decode($this->getDeliveryName(), ENT_QUOTES, 'UTF-8') . '"');
    }

		$tmpfile=fopen($this->getPathName(), 'r');

		$response->setContent(fread($tmpfile, $this->getSize()));
    fclose($tmpfile);
  
  }
  
  public function setDeliveryName($name)
  {
    $this->_deliveryName = $name;
    return $this;
  }
  
  public function getDeliveryName()
  {
    return $this->_deliveryName=='' ? $this->getFilename() : $this->_deliveryName;
    
  }


  
	
}
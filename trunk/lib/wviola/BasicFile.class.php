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
		$this->_stat = @stat($this->getFullPath());
		
		if (!$this->_stat)
		{
			throw new Exception(sprintf('Not a valid file: %s', $this->getFullPath()));
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
	
	public function getFullPath()
	{
		return Generic::getCompletePath($this->getPath(), $this->getBasename());
	}

	public function getStat($name)
	{
		return $this->_stat[$name];
	}
	
	public function getStats()
	{
		return $this->_stat;
	}
	
	public function getMD5Sum()
	{
		return md5_file($this->getFullPath());
	}
	
	public function executeCommand($command, $custom=false)
	{
		if ($custom)
		{
			$command=wvConfig::get('directory_executables') . '/'. $command;
		}
		
		return Generic::executeCommand($command);
	}
	
	public function getGuessedInternetMediaType()
	{
		$command=sprintf('file --dereference --brief --mime-type "%s"', $this->getFullPath());
		$mimeType=$this->executeCommand($command);
		
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

	
}
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
				$this->_basename=func_get_arg(1);
				break;
		}
		$this->_stat = @stat($this->getFullPath());
		
		if (!$this->_stat)
		{
			throw new Exception(sprintf('Not a valid file: %s', $this->getFullPath()));
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
		return $this->getPath() . '/' . $this->getBasename();
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

	
}
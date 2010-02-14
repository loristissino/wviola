<?php

class SourceFile extends BasicFile
{
	
	const WV_DIR= '.wviola';
	
	protected
		$_relativePath,
		$_basicPath,
		$_fileInfo;

	public function __construct($relativePath, $basename)
	{
		$this->_basicPath=wvConfig::get('directory_sources');
		parent::__construct($this->getBasicPath() . $relativePath, $basename);
		$this->loadWvInfoFile();
	}
	
	public function loadWvInfoFile()
	{
		if ($_fileInfo)
		{
			return;
		}
		
		if (is_readable($this->getWvInfoFilePath()))
		{
			$this->_fileInfo=sfYaml::load($this->getWvInfoFilePath());
		}
		else
		{
			$this->_fileInfo=array();
		}
		
	}
	
	public function saveWvInfoFile()
	{
		if ($_fileInfo)
		{
			return;
		}
		
		if (
			(!is_dir($this->getWvDirPath()))
			&&
			($this->canWriteWvDir())
			)
		{
			try
			{
				mkdir($this->getWvDirPath());
				//clearstatcache();
			}
			catch (Exception $e)
			{
				throw new Exception (sprintf('Could not make dir %s', $this->getWvDirPath()));
			}
		}
		
		if (is_writeable($this->getWvInfoFilePath()) || (!file_exists($this->getWvInfoFilePath())))
		{
			$fp=fopen($this->getWvInfoFilePath(), 'w');
			$yaml=sfYaml::dump($this->_fileInfo, 4);
			fwrite($fp, $yaml, strlen($yaml)); 
		}
		else
		{
			throw new Exception(sprintf('Could not write to file "%s"', $this->getWvInfoFilePath()));
		}
		return $this;
		
	}
	

	private function key2RealKey($key)
	{
		$rk=str_replace('_', "']['", $key);
		$rk="['" . $rk . "']";
		return $rk;
	}

	public function setWvInfo($key, $value)
	{
		eval('$this->_fileInfo' . $this->key2RealKey($key) . '=$value;');
		return $this;
	}
	
	public function getWvInfo($key, $default='')
	{
		$value='';
		eval('$value=$this->_fileInfo' . $this->key2RealKey($key) . ';');
		return $value?$value: $default;
	}
	
	public function getCompleteWvInfo()
	{
		return $this->_fileInfo;
	}
	
	public function getBasicPath()
	{
		return $this->_basicPath;
	}
	
	public function getWvInfoFilePath()
	{
		return $this->getWvDirPath() . '/' . $this->getStat('ino') . '.yml';
	}
	
	public function getWvDirPath()
	{
		return $this->getPath() . '/' . self::WV_DIR;
	}
	
	public function getWvDirIsReadable()
	{
		return is_dir($this->getWvDirPath()) && is_readable($this->getWvDirPath());
	}
	
	public function getWvDirIsWriteable()
	{
		return is_dir($this->getWvDirPath()) && is_writeable($this->getWvDirPath());
	}
	
	public function canWriteWvDir()
	{
		return is_writeable($this->getPath());
	}
	

}
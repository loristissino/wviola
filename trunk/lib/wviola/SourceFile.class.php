<?php

class SourceFile extends BasicFile
{
	
	const WV_DIR= '.wviola';
	
	protected
		$_relativePath,
		$_basicPath;

	public function __construct($relativePath, $basename)
	{
		$this->_basicPath=wvConfig::get('directory_sources');
		parent::__construct($this->getBasicPath() . $relativePath, $basename);
	}
	
	public function getBasicPath()
	{
		return $this->_basicPath;
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
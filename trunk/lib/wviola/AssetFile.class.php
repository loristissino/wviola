<?php

class AssetFile extends BasicFile
{
	protected 
		$_uniqid,
		$_extension;

	public function __construct($uniqid, $extension, $thumbnail=false)
	{
		$this->_uniqid=$uniqid;
		$this->_extension=$extension;
		$parameter='directory_published_' . ($thumbnail ? 'thumbnails' : 'assets');
		parent::__construct(wvConfig::get($parameter), $this->getUniqid() . '.' . $this->getExtension());
	}
	
	public function getUniqid()
	{
		return $this->_uniqid;
	}
	
	public function getExtension()
	{
		return $this->_extension;
	}
	
	public function getMimeType()
	{
		throw new Exception('this should be implemented in a subclass');
	}
	
}
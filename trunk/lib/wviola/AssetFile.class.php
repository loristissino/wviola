<?php

class AssetFile extends BasicFile
{
	protected 
		$_slug,
		$_extension;

	public function __construct($slug, $extension, $thumbnail=false)
	{
		$this->_slug=$slug;
		$this->_extension=$extension;
		$parameter='directory_published_' . ($thumbnail ? 'thumbnails' : 'assets');
		parent::__construct(wvConfig::get($parameter), $this->getSlug() . '.' . $this->getExtension());
	}
	
	public function getSlug()
	{
		return $this->_slug;
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
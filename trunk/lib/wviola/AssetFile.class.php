<?php

class AssetFile extends BasicFile
{
	protected 
		$_slug,
		$_extension;

	public function __construct($slug, $extension)
	{
		$this->_slug=$slug;
		$this->_extension=$extension;
		parent::__construct(wvConfig::get('directory_published'), $this->getSlug() . '.' . $this->getExtension());
	}
	
	public function getSlug()
	{
		return $this->_slug;
	}
	
	public function getExtension()
	{
		return $this->_extension;
	}
}
<?php

class PhotoalbumFile extends AssetFile
{

	const
		EXTENSION = 'zip';
	
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::EXTENSION);
	}
	
	public function getAssetType()
	{
		return 'photoalbum';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}
	
	public function getMimeType()
	{
		return 'application/zip';
	}
  
}
<?php

class ThumbnailFile extends AssetFile
{

	const
		EXTENSION = 'jpeg';
	
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::EXTENSION, true);
	}
	
	public function getAssetType()
	{
		return 'thumbnail';
	}
	
	public function getMimeType()
	{
		return 'image/jpeg';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}

}
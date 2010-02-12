<?php

class ThumbnailFile extends AssetFile
{

	const
		EXTENSION = 'jpeg';
	
	public function __construct($slug)
	{
		parent::__construct($slug, self::EXTENSION, true);
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
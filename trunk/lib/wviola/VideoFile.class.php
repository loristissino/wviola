<?php

class VideoFile extends AssetFile
{

	const
		EXTENSION = 'flv';
	
	public function __construct($slug)
	{
		parent::__construct($slug, self::EXTENSION);
	}
	
	public function getAssetType()
	{
		return 'video';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}

}
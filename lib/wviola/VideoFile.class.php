<?php

class VideoFile extends AssetFile
{

	const
		EXTENSION = 'flv';
	
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::EXTENSION);
	}
	
	public function getAssetType()
	{
		return 'video';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}
	
	public function getMimeType()
	{
		return 'video/x-flv';
	}

}
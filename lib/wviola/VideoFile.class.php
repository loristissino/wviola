<?php

class VideoFile extends AssetFile
{
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::getStandardExtension());
	}
	
	public function getAssetType()
	{
		return 'video';
	}
	
	public function getStandardExtension()
	{
		return 'webm';//self::EXTENSION;
	}
	
	public function getMimeType()
	{
		return 'video/webm';
	}

}

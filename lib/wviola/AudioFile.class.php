<?php

class AudioFile extends AssetFile
{

	const
		EXTENSION = 'mp3';
	
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::EXTENSION);
	}
	
	public function getAssetType()
	{
		return 'audio';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}
	
	public function getMimeType()
	{
		return 'audio/mp3';
	}

}
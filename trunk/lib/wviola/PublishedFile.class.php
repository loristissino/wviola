<?php

class PublishedFile extends BasicFile
{
	protected 
		$_uniqid;

	public function __construct($uniqid, $quality)
	{
		$this->_uniqid=$uniqid;
    switch($quality)
    {
      case 'high':
        $directory=wvConfig::get('directory_iso_cache');
        break;
      case 'low':
        $directory=wvConfig::get('directory_published_assets');
        break;
    }
    
    parent::__construct($directory, $uniqid);    
	}
	
	public function getUniqid()
	{
		return $this->_uniqid;
	}
	
}
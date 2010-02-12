<?php

require 'lib/model/om/BaseAsset.php';


/**
 *
 * @package    lib.model
 */
class Asset extends BaseAsset {

    private $_AssetTypeCodes=Array(
		1=> 'video',
		2=> 'picture',
		3=> 'photoalbum',
		4=> 'audio',
		);

	public function __toString()
	{
		return sprintf('%d (%s)', $this->getId(), $this->getAssignedTitle());
	}
	
	public function getAssetTypeCode()
	{
		return $this->_AssetTypeCodes[$this->getAssetType()];
	}
		
	public function hasVideoAsset()
	{
		return $this->getVideoAsset()!=null; 
	}
		
	public function getThumbnailFile()
	{
		$file=new ThumbnailFile($this->getSlug());
		return $file;
	}


} // Asset

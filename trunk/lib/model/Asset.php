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
	
	public function hasThumbnail()
	{
		return $this->getThumbnail()!=null;
	}
	
	public function hasVideoAsset()
	{
		return $this->getVideoAsset()!=null; 
	}
	
	public function getThumbnailMimeType()
	{
		return 'image/jpeg';
	}
	
	public function setThumbnailFromBase64($v)
	{
		$this
		->setThumbnail(base64_decode($v));
		return $this;
	}
	
	public function setThumbnail($v)
	{
		$this
		->setThumbnailSize(strlen($v));
		parent::setThumbnail($v);
		return $this;
	}
	
	public function getThumbnailData()
	{
		$content='';
		$data=$this->getThumbnail();

		if (is_resource($data))
		{
			while(!feof($data))
			{
				$content.= fread($data, 1024);
			}
			rewind($data);
			return $content;	
		} else { 
			return $data;
		}
		
	}
	
	public function getVideo()
	{
		$video=new Video($this->getSlug());
		return $video;
	}


} // Asset

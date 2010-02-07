<?php

require 'lib/model/om/BaseAsset.php';


/**
 *
 * @package    lib.model
 */
class Asset extends BaseAsset {

	public function __toString()
	{
		return sprintf('%d (%s)', $this->getId(), $this->getAssignedTitle());
	}
	
	public function hasThumbnail()
	{
		return $this->getThumbnail()!=null;
	}
	
	public function hasVideo()
	{
		return true; //FIXME
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

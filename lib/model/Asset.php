<?php

require 'lib/model/om/BaseAsset.php';


/**
 *
 * @package    lib.model
 */
class Asset extends BaseAsset {
  
    const
      SCHEDULED = 1,
      CACHED = 2,
      ISO_IMAGE = 3,
      DVDROM = 4;

    private $_AssetTypeCodes=Array(
		1=> 'video',
		2=> 'picture',
		3=> 'photoalbum',
		4=> 'audio',
		);
    private $_AssetTypeShortCodes=Array(
		1=> 'vid',
		2=> 'pic',
		3=> 'alb',
		4=> 'aud',
		);

	public function __toString()
	{
		return sprintf('%d (%s)', $this->getId(), $this->getAssignedTitle());
	}
	
	public function getAssetTypeCode()
	{
		return $this->_AssetTypeCodes[$this->getAssetType()];
	}
  
	public function getAssetTypeShortCode()
	{
		return $this->_AssetTypeShortCodes[$this->getAssetType()];
	}
		
	public function hasVideoAsset()
	{
		return $this->getVideoAsset()!=null; 
	}
		
	public function getThumbnailFile()
	{
		$file=new ThumbnailFile($this->getUniqid());
		return $file;
	}

  public function logAccess($user_id, $cookie)
  {
    try
    {
      $entry=new AccessLogEvent();
      $entry
      ->setUserId($user_id)
      ->setAsset($this)
      ->setSession($cookie)
      ->save();
    }
    catch (Exception $e)
    {
      /* nothing to do here...
      This should happen when a user accesses the same asset twice
      in the same session: we don't need to log it twice
      */
    }
  }


  public function scheduleSourceFileForArchiviation($userId, SourceFile $sourcefile, $values)
  {
    
    $fullpath=$sourcefile->getFullPath();
    
    $this
    ->setAssetType($sourcefile->getWvInfo('source_type'))
    ->setAssetType($this->getAssetType())
    ->setSourceFileName($sourcefile->getBaseName())
    ->setSourceFileDatetime($sourcefile->getStat('mtime'))
    ->setSourceSize($sourcefile->getStat('size'))
    ->setSourceLmd5Sum($sourcefile->getWvInfo('file_lmd5sum'))
    ;
    
    $thumbnail=$sourcefile->getThumbnail($values['thumbnail']);

    $uniqid = $sourcefile->moveFileToScheduled($this->getAssetTypeShortCode());

    try
    {
      $fp=fopen(wvConfig::get('directory_published_thumbnails'). '/' . $uniqid . '.jpeg', 'w');
      $content=base64_decode($thumbnail['base64content']);
      fwrite($fp, $content, strlen($content));
      fclose($fp);
      $this
      ->setHasThumbnail(true)
      ->setThumbnailWidth($thumbnail['width'])
      ->setThumbnailHeight($thumbnail['height'])
      ->setThumbnailPosition($thumbnail['position'])
      ;
    }
    catch (Exception $e)
    {
      // TODO: what else, if a thumbnail cannot be written?
      $this->setHasThumbnail(false);
    }

    if ($uniqid)
    {
       
      $this
      ->setUniqid($uniqid)
      ->setBinderId($values['binder_id'])
      ->setNotes($values['notes'])
      ->setAssignedTitle($values['assigned_title'])
      ->setStatus(self::SCHEDULED)
      ->save();
    }
    else
    {
      throw new Exception(sprintf('Could not move file «%s» to Scheduled directory', $fullpath));
    }
    
    
  }
  
  

} // Asset

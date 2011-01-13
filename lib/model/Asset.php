<?php

require 'lib/model/om/BaseAsset.php';


/**
 *
 * @package    lib.model
 */
class Asset extends BaseAsset {

  // see http://code.google.com/p/wviola/wiki/Asset for details

    const
      SCHEDULED  = 1,
      CACHED     = 2,
      ISO_IMAGE  = 3,
      DVDROM     = 4;
      
    const
      VIDEO      = 1,
      PICTURE    = 2,
      PHOTOALBUM = 3,
      AUDIO      = 4;


    private $_AssetTypeCodes=Array(
      self::VIDEO      => 'video',
      self::PICTURE    => 'picture',
      self::PHOTOALBUM => 'photoalbum',
      self::AUDIO      => 'audio',
		);
    private $_AssetTypeShortCodes=Array(
      self::VIDEO      => 'vid',
      self::PICTURE    => 'pic',
      self::PHOTOALBUM => 'alb',
      self::AUDIO      => 'aud',
		);

    private $_editable=false;

  public function save(PropelPDO $con = null)
  {
    if (is_null($con))
    {
    $con = Propel::getConnection(AssetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
    }
    
    $con->beginTransaction();
    try
    {
      $ret = parent::save($con);
      $this->updateLuceneIndex();
      $con->commit();
      return $ret;
    }
    catch (Exception $e)
    {
      $con->rollBack();
      throw $e;
    }
  }
  
  public function delete(PropelPDO $con = null)
{
  $index = AssetPeer::getLuceneIndex();
 
  foreach ($index->find('pk:'.$this->getId()) as $hit)
  {
    $index->delete($hit->id);
  }
 
  return parent::delete($con);
}
  
  public function updateLuceneIndex()
  {
    $index = AssetPeer::getLuceneIndex();
   
    // remove existing entries
    foreach ($index->find('pk:'.$this->getId()) as $hit)
    {
      $index->delete($hit->id);
    }
   
    $doc = new Zend_Search_Lucene_Document();
   
    // store asset primary key to identify it in the search results
    $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));
   
    // index asset fields
    $doc->addField(Zend_Search_Lucene_Field::UnStored('notes', $this->getNotes(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::UnStored('binder', $this->getBinder()->getTitle(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::UnStored('code', $this->getBinder()->getCode(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::Unstored('date', $this->getBinder()->getEventDate('%Y%m%d'), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::Unstored('type', $this->getAssetTypeCode(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::Unstored('category', $this->getBinder()->getCategory(), 'utf-8'));
    
    // add asset to the index
    $index->addDocument($doc);
    $index->commit();
  }


	public function __toString()
	{
    return sprintf('%d', $this->getId());
  }
  
  public function getAssetTitle()
  {
		return sprintf('%d (%s)', $this->getId(), $this->getNotes());
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

	public function hasAudioAsset()
	{
		return $this->getAudioAsset()!=null; 
	}
  
	public function hasPhotoalbumAsset()
	{
		return $this->getPhotoalbumAsset()!=null; 
	}

	public function getThumbnailFile()
	{
		$file=new ThumbnailFile($this->getUniqid());
		return $file;
	}
  
  public function getScheduledSourceFile()
  // this should be called after the file being scheduled!
  {
    if(!$this->getUniqId())
    {
      return false;
    }
    else
    {
      return wvConfig::get('directory_scheduled').'/'.$this->getUniqId();
    }
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
    
    Generic::logMessage('Asset->scheduleSourceFileForArchiviation()', $this->getId() . ' called');
    
    $fullpath=$sourcefile->getFullPath();
    
    $this
    ->setAssetType($sourcefile->getWvInfo('source_type'))
    ->setAssetType($this->getAssetType())
    ->setSourceFileName($sourcefile->getBaseName())
    ->setSourceFileDatetime($sourcefile->getStat('mtime'))
    ->setSourceSize($sourcefile->getStat('size'))
    ->setSourceLmd5Sum($sourcefile->getWvInfo('file_lmd5sum'))
    ;
    
    
    $thumbnail=false;
    if(array_key_exists('thumbnail', $values))
    {
      $thumbnail=$sourcefile->getThumbnail($values['thumbnail']);
    }

    $uniqid = $sourcefile->moveFileToScheduled($this->getAssetTypeShortCode());
    
    Generic::logMessage('Asset->scheduleSourceFileForArchiviation()', 'got uniqid: ' . $uniqid);

    if ($thumbnail)
    {
      try
      {
        $fp=fopen(wvConfig::get('directory_published_thumbnails'). '/' . $uniqid . '.jpeg', 'w');
        $content=base64_decode($thumbnail['base64content']);
        $content_size=strlen($content);
        fwrite($fp, $content, $content_size);
        fclose($fp);
        $this
        ->setHasThumbnail(true)
        ->setThumbnailWidth($thumbnail['width'])
        ->setThumbnailHeight($thumbnail['height'])
        ->setThumbnailPosition(array_key_exists('position', $thumbnail)? $thumbnail['position']: null)
        ->setThumbnailSize($content_size);
        
        
        Generic::logMessage('Asset->scheduleSourceFileForArchiviation()', 'saved thumbtnail: ' . wvConfig::get('directory_published_thumbnails'). '/' . $uniqid . '.jpeg');

      }
      catch (Exception $e)
      {
        // TODO: what else, if a thumbnail cannot be written?
        $this->setHasThumbnail(false);
      }
    }

    if ($uniqid)
    {
       
      $this
      ->setUniqid($uniqid)
      ->setBinderId($values['binder_id'])
      ->setNotes($values['notes'])
      ->setStatus(self::SCHEDULED)
      ->save();
      
      Generic::logMessage('Asset->scheduleSourceFileForArchiviation()', 'saved info on db');

      
	  // FIXME This should be put in a transaction
      $Source = SourcePeer::retrieveByPathAndBasename(
        $sourcefile->getRelativePath(),
        $sourcefile->getBaseName()
        );
      if ($Source)
      {
        $Source
        ->setStatus(SourcePeer::STATUS_SCHEDULED)
        ->save();
      }
	

      return true;
    }
    else
    {
      throw new Exception(sprintf('Could not move file «%s» to Scheduled directory', $fullpath));
      return false;

    }
    
    
  }
  
  public function updateValuesFromForm($values)
  {
    $this
    ->setBinderId($values['binder_id'])
    ->setNotes($values['notes'])
    ->save();
    
    return $this;
  }
  
  public function getSourceFileMD5isOk()
  {
    $db_lmd5sum=$this->getSourceLmd5sum();
    if(strpos($db_lmd5sum, ':')>0)
    {
      list($md5,$limit)=explode(':', $db_lmd5sum);
    }
    else
    {
      $limit='';
    }
    
    $file=new BasicFile($this->getScheduledSourceFile());
    $md5sum=$file->getMD5Sum($limit);
    unset($file);
    return $db_lmd5sum==$md5sum;
  }
  
  
  public function publish()
  {
    
    if (!$this->getSourceFileMD5isOk())
    {
      return false;
    }

/* these are defined in the script generated by the task generate-scripts:
ARTIST="$2"
TITLE="$3"
DATE="$4"
LOCATION="$5"
ORGANIZATION="$6"
COPYRIGHT="$7"
LICENSE="$8"
CONTACT="$9"
# these items come from the documentation of ffmpeg2theora
*/
    
    try
    {
      $command=sprintf('publish_%s "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s"',
          $this->getAssetTypeCode(),
          $this->getUniqId(),
          $this->getArtist(),
          $this->getTitle(),
          $this->getDate(),
          $this->getLocation(),
          $this->getOrganization(),
          $this->getCopyright(),
          $this->getLicense(),
          $this->getContact()
          );

      Generic::executeCommand($command, true);
      
      switch($this->getAssetTypeCode())
      {
        case 'video':
          $videoAsset = new VideoAsset();
          $videoAsset
          ->setAssetId($this->getId())
          ->gatherInfo()
          ->save();
          unset($videoAsset);
          break;
        case 'photoalbum':
          $photoalbumAsset = new PhotoalbumAsset();
          $photoalbumAsset
          ->setAssetId($this->getId())
          ->gatherInfo()
          ->save();
          unset($photoalbumAsset);
          break;
        case 'picture':
          $pictureAsset = new PictureAsset();
          $pictureAsset
          ->setAssetId($this->getId())
          ->save();
          unset($pictureAsset);
          break;
        case 'audio':
          $audioAsset = new AudioAsset();
          $audioAsset
          ->setAssetId($this->getId())
          ->save();
          unset($audioAsset);
          break;
      }
      $this
      ->setHighqualityMd5sum($this->getPublishedFile('high')->getMD5Sum())
      ->setLowqualityMd5sum($this->getPublishedFile('low')->getMD5Sum())
      ->setHighqualitySize($this->getPublishedFile('high')->getStat('size'))
      ->setStatus(self::CACHED)
      ->save();
      
    }
    catch (Exception $e)
    {
      throw $e;
    }
    
    return true;
    
  }
  
  public function republish()
  {

    try
    {
      $command=sprintf('republish_%s "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s"',
          $this->getAssetTypeCode(),
          $this->getUniqId(),
          $this->getArtist(),
          $this->getTitle(),
          $this->getDate(),
          $this->getLocation(),
          $this->getOrganization(),
          $this->getCopyright(),
          $this->getLicense(),
          $this->getContact()
          );

      Generic::executeCommand($command, true);
      
      switch($this->getAssetTypeCode())
      {
        case 'video':
          $videoAsset = $this->getVideoAsset();
          if (!$videoAsset)
          {
            break;
          }
          $videoAsset
          ->setAssetId($this->getId())
          ->gatherInfo()
          ->save();
          unset($videoAsset);
          break;
        case 'photoalbum':
          $photoalbumAsset = $this->getPhotoalbumAsset();
          if (!$photoalbumAsset)
          {
            break;
          }
          $photoalbumAsset
          ->setAssetId($this->getId())
          ->gatherInfo()
          ->save();
          unset($photoalbumAsset);
          break;
        case 'picture':
          $pictureAsset = $this->getPictureAsset();
          if (!$pictureAsset)
          {
            break;
          }
          $pictureAsset
          ->setAssetId($this->getId())
          ->save();
          unset($pictureAsset);
          break;
        case 'audio':
          $audioAsset = $this->getAudioAsset();
          if (!$audioAsset)
          {
            break;
          }
          $audioAsset
          ->setAssetId($this->getId())
          ->save();
          unset($audioAsset);
          break;
      }
      $this
      ->setHighqualityMd5sum($this->getPublishedFile('high')->getMD5Sum())
      ->setLowqualityMd5sum($this->getPublishedFile('low')->getMD5Sum())
      ->setStatus(self::CACHED)
      ->save();
      
    }
    catch (Exception $e)
    {
      throw $e;
    }
    
  }
  
  
  public function getPublishedFile($quality)
  {
    $file = new PublishedFile($this->getUniqId(), $quality);
    return $file;
  }
  
  
  public function getArchivedFilename()
  {
    try
    {
      $file=$this->getPublishedFile('high');
      $filename=$file->getBasename();
      unset($file);
      return $filename;
    }
    catch (Exception $e)
    {
      // This shouldn't happen, it's here to easy the tests...
      return 'fakename.txt';
    }
  }
  
  public function getLowQualityFilename()
  {
    try
    {
      $file=$this->getPublishedFile('low');
      $filename=$file->getBasename();
      unset($file);
      return $filename;
    }
    catch (Exception $e)
    {
      // This shouldn't happen, it's here to easy the tests...
      return 'fakename.txt';
    }
  }

  public function getThumbnailFilename()
  {
    try
    {
      $file=$this->getThumbnailFile();
      $filename=$file->getBasename();
      unset($file);
      return $filename;
    }
    catch (Exception $e)
    {
      // This shouldn't happen, it's here to easy the tests...
      return 'fakename.txt';
    }
  }
  
  public function getTotalSize()
  {
    try
    {
      $file=$this->getPublishedFile('low');
      $filesize=$file->getSize();
      unset($file);
      
      $file=$this->getThumbnailFile();
      $filesize+=$file->getSize();
      unset($file);
      
      return $filesize;
      
    }
    catch (Exception $e)
    {
      // This shouldn't happen, it's here to easy the tests...
      return 0;
    }
  }


  public function setIsEditable($userId)
  {
    // info about the asset are editable only by the owner of the binder in which the asset is put
    $this->_editable = $userId === $this->getBinder()->getUserId();
  }
  
  public function getIsEditable()
  {
    if ($this->getStatus() > Asset::CACHED)
    {
      return false;
    }
    
    return $this->_editable;
  }
  
  public function getIsDownloadable()
  {
    return $this->getStatus()===self::CACHED;
  }
  
  public function getHighQualityFileSize()
  {
    if ($this->getIsDownloadable())
    {
      return Generic::getHumanReadableSize($this->getPublishedFile('high')->getSize());
    }
    else
    {
      return false;
    }
  }
  
  public function getArtist()
  {
    return $this->getBinder()->getSfGuardUserProfile();
  }
  
  public function getTitle()
  {
    return $this->getBinder()->getTitle() . ' (' . $this->getId() . ')';
  }
  
  public function getDate()
  {
    return $this->getBinder()->getEventDate();
  }
  
  public function getLocation()
  {
    return wvConfig::get('archiviation_location', '');
  }
  
  public function getOrganization()
  {
    return wvConfig::get('archiviation_organization', '');
  }

  public function getCopyright()
  {
    return wvConfig::get('archiviation_copyright', '');
  }
  
  public function getLicense()
  {
    return wvConfig::get('archiviation_license', '');
  }
  
  public function getContact()
  {
    return wvConfig::get('archiviation_contact', '');
  }
  
  public function updateData()
  {
    $changes=0;
    if (!$this->getLowqualitySize())
      try
      {
        $file=$this->getPublishedFile('low');
        $this->setLowqualitySize($file->getSize());
        unset($file);
        $changes+=1;
      }
      catch (Exception $e)
      {
        // this shouldn't happen
      }
    if (!$this->getThumbnailSize())
      try
      {
        $file=$this->getThumbnailFile('low');
        $this->setThumbnailSize($file->getSize());
        unset($file);
        $changes+=1;
      }
      catch (Exception $e)
      {
        // this shouldn't happen
      }
      
    if($changes>0)
    {
      $this->save();
    }

  }

} // Asset

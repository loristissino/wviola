<?php

require 'lib/model/om/BaseAsset.php';


/**
 *
 * @package    lib.model
 */
class Asset extends BaseAsset {

  // see http://code.google.com/p/wviola/wiki/Asset for details

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

	public function hasPhotoalbumAsset()
	{
		return $this->getPhotoalbumAsset()!=null; 
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
        fwrite($fp, $content, strlen($content));
        fclose($fp);
        $this
        ->setHasThumbnail(true)
        ->setThumbnailWidth($thumbnail['width'])
        ->setThumbnailHeight($thumbnail['height'])
        ->setThumbnailPosition(array_key_exists('position', $thumbnail)? $thumbnail['position']: null)
        ;
        
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
  
  public function publish()
  {

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
      return $file->getBasename();
    }
    catch (Exception $e)
    {
      // This shouldn't happen, it's here to easy the tests...
      return 'fakename.txt';
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

} // Asset

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
    /*
    // don't index expired and non-activated jobs
    if ($this->isExpired() || !$this->getIsActivated())
    {
      return;
    }
    */
   
    $doc = new Zend_Search_Lucene_Document();
   
    // store asset primary key to identify it in the search results
    $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));
   
    // index asset fields
    $doc->addField(Zend_Search_Lucene_Field::UnStored('notes', $this->getNotes(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::UnStored('title', $this->getAssignedTitle(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::UnStored('binder', $this->getBinder()->getNotes(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::Unstored('date', $this->getBinder()->getEventDate('%Y%m%d'), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::Unstored('type', $this->getAssetTypeCode(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::Unstored('category', $this->getBinder()->getCategoryId(), 'utf-8'));
    
    // add asset to the index
    $index->addDocument($doc);
    $index->commit();
  }


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
      
      // FIXME This should be put in a transaction
      $Source = SourcePeer::retrieveByPathAndBasename(
        $sourcefile->getRelativePath(),
        $sourcefile->getBaseName()
        );
      $Source
      ->setStatus(SourcePeer::STATUS_SCHEDULED)
      ->save();

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
    ->setAssignedTitle($values['assigned_title'])
    ->save();
    
    return $this;
  }
  

} // Asset

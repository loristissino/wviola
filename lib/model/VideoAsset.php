<?php

require 'lib/model/om/BaseVideoAsset.php';


/**
 * Skeleton subclass for representing a row from the 'video_asset' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Mon Feb  8 22:36:15 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class VideoAsset extends BaseVideoAsset {
	
	protected
		$_uniqid,
		$_assetFile;

	public function getVideoFile()
	{
    // returns the low quality file
		$this->_uniqid=$this->getAsset()->getUniqid();
		$this->_assetFile=new VideoFile($this->_uniqid);
		return $this->_assetFile;
	}
  
  
  public function gatherInfo()
  {
    
    $high_movie=new MovieFile(wvConfig::get('directory_iso_cache') . '/'. $this->getAsset()->getUniqId());
    if (!$high_movie)
    {
      throw new Exception(sprintf('A problem with file «%s» occured', $this->getAsset()->getUniqId()));
    }
    $info_high=$high_movie->retrieveInfo('high');
    unset($high_movie);
    
    $low_movie=new MovieFile(wvConfig::get('directory_published_assets') . '/'. $this->getAsset()->getUniqId());
    if (!$low_movie)
    {
      throw new Exception(sprintf('A problem with file «%s» occured', $this->getAsset()->getUniqId()));
    }
    $info_low=$low_movie->retrieveInfo('low');
    unset($low_movie);
    
    $info = array_merge($info_high, $info_low);
    
    foreach($info as $key=>$value)
    {
      $this->setByName($key, $value, BasePeer::TYPE_FIELDNAME);
    }
    
    return $this;
    
  }
  
  public function getLowQualityCorrectedWidth()
  {
    if (!$this->getHighQualityAspectRatio())
    {
      throw new Exception('Aspect Ratio is not set for Video ' . $this->getAssetId());
    }
    return floor($this->getLowQualityHeight()*$this->getHighQualityAspectRatio());
  }
  

} // VideoAsset

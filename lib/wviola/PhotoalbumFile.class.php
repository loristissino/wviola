<?php

class PhotoalbumFile extends AssetFile
{

	const
		EXTENSION = 'zip';
    
  private
    $_filelist;
	
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::EXTENSION);
	}
	
	public function getAssetType()
	{
		return 'photoalbum';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}
	
	public function getMimeType()
	{
		return 'application/zip';
	}
  
  public function getFileList()
  {
    if ($this->_filelist)
    {
      return $this->_filelist;
    }

    try
    {
      $this->_filelist=$this->executeCommand(sprintf('zipinfo -1 "%s"', $this->getFullPath()));
      return $this->_filelist;
    }
    catch (Exception $e)
    {
      throw new Exception("Could not read file " . $this->getFullPath());
    }
  }

  public function getPicturesCount()
  {
    return sizeof($this->getFileList());
  }
  
}
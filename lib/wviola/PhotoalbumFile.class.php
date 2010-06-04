<?php

class PhotoalbumFile extends AssetFile
{

	const
		EXTENSION = 'zip';
    
  private
    $_filelist,
    $_tempdir,
    $_widths,
    $_heights;
	
	public function __construct($uniqid, $session='')
	{
		parent::__construct($uniqid, self::EXTENSION);
    
    $this->setTempdir(sys_get_temp_dir() . '/photoalbum-'. $this->getBasename() . '-' . ($session? $session : time('Uu')));
    if (!is_dir($this->getTempdir()))
    {
      mkdir($this->getTempdir());
      $this->executeCommand(sprintf('unzip "%s" -d "%s"',
        $this->getFullPath(),
        $this->getTempdir()
      ));
    }
    
    
	}
  
  public function setTempdir($v)
  {
    $this->_tempdir = $v;
    return $this;
  }
  
  public function getTempdir()
  {
    return $this->_tempdir;
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
  
  public function gatherImageInfo()
  {
    list($width, $height, $type, $attr) = getimagesize($this->getFile($number));
    $this->_widths[$number]=$width;
    $this->_heights[$number]=$height;
  }
  
  public function getPictureWidth($number)
  {
    if (!array_key_exists($number, $this->_widths))
    {
      $this->gatherImageInfo();
    }
    return $this->widths[$number];
  }
  public function getPictureHeight($number)
  {
    if (!array_key_exists($number, $this->_widths))
    {
      $this->gatherImageInfo();
    }
    return $this->heights[$number];
  }

  public function getFilename($number)
  {
    $names=$this->getFileList();
    if (array_key_exists($number, $names))
    {
      return $names[$number];
    }
    else
    {
      return false;
    }
  }
  
  public function getFile($number)
  {
    return $this->getTempdir() . '/' . $this->getFilename($number);
  }
  
  
  public function prepareDeliveryOfFile(sfWebResponse $response, $number)
  {
    $file=new BasicFile($this->getFile($number));
    $file->prepareDelivery($response, false);
  }


}
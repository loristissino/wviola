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
      $list=$this->executeCommand(sprintf('zipinfo -1 "%s"', $this->getFullPath()));
      if (is_string($list) && $list!='')
      {
        $this->_filelist[]=$list;
      }
      else
      {
        $this->_filelist=$list;
      }
      
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
  
  public function gatherImageInfo($number)
  {
    list($width, $height, $type, $attr) = getimagesize($this->getFile($number));
    $this->_widths[$number]=$width;
    $this->_heights[$number]=$height;
  }
  
  public function getPictureWidth($number)
  {
    if (!is_array($this->_widths) || !array_key_exists($number, $this->_widths))
    {
      $this->gatherImageInfo($number);
    }
    return $this->_widths[$number];
  }
  public function getPictureHeight($number)
  {
    if (!is_array($this->_heights) || !array_key_exists($number, $this->_heights))
    {
      $this->gatherImageInfo($number);
    }
    return $this->_heights[$number];
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
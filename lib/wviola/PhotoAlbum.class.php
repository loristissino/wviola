<?php

class PhotoAlbum
{
  private
    $_directory,
    $_filelist,
    $_username,
    $_files,
    $_wvinfopath
    ;
  
  public function __construct($directory, $filelist, $username)
  {
    $this
    ->setDirectory($directory)
    ->setFileList($filelist)
    ->setUsername($username)
    ;
  }
  
  public function setDirectory($v)
  {
    $this->_directory=$v;
    return $this;
  }
  public function setFilelist($v)
  {
    $this->_filelist=$v;
    return $this;
  }
  public function setUsername($v)
  {
    $this->_username=$v;
    return $this;
  }
  public function getDirectory()
  {
    return $this->_directory;
  }
  public function getFilelist()
  {
    return $this->_filelist;
  }
  public function getUsername()
  {
    return $this->_username;
  }
  
  public function processFileList()
  {
    $this->_files=array();
    
    $zipcommand =  sprintf('cd "%s"; ', $this->getDirectory());
    $zipcommand .= sprintf('zip --move "%s" ', $this->getFileName());
    
    foreach($this->getFileList() as $filename=>$user)
    {
      if($user==$this->getUsername())
      {
        $this->_files[]=$filename;
        $zipcommand .= '"' . $filename . '" ';
      }
    }
//    echo $zipcommand . "\n";
    
    $info=Generic::executeCommand($zipcommand);
    
  }
   
  public function getCompletePath()
  {
    return sprintf('%s/%s',
      $this->getDirectory(),
      $this->getFileName()
      );
  }
  
  public function getFileName()
  {
    return sprintf('%s_%s.zip',
      date('Ymd'),
      $this->getUsername()
      );
  }
  
  public function getFiles()
  {
    return $this->_files;
  }

}
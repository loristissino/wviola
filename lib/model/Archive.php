<?php

require 'lib/model/om/BaseArchive.php';


/**
 * Skeleton subclass for representing a row from the 'archive' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Wed Feb  3 19:07:27 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Archive extends BaseArchive {


  private
    $_maxSize,
    $_currentSize,
    $_items,
    $_files,
    $_isopaths,
    $_full;

  public function __toString()
  {
    return 'archive_'.$this->getId();
  }
  
  public function __construct()
  {
    parent::__construct();
    $this->setMaxSize(wvConfig::get('archiviation_iso_image_size')*1024*1024);
    $this->setIsFull(false);
    $this->_files=array();
    $this->_isopaths=array();
    $this->setSlug(date('Ymd-His'));
  }
  
  public function setMaxSize($v)
  {
    $this->_maxSize = $v;
    return $this;
  }

  public function getMaxSize()
  {
    return $this->_maxSize;
  }
  
  public function setIsFull($v)
  {
    $this->_full = $v;
    return $this;
  }

  public function getIsFull()
  {
    return $this->_full;
  }
  
  public function getItems()
  {
    return $this->_items;
  }

  public function hasPlaceForBinder(Binder $Binder)
  {
    Generic::logMessage('binder ' . $Binder->getId(), 'evaluating place. Size: ' . $Binder->getTotalSize());
    return $Binder->getTotalSize() + $this->getCurrentSize() <= $this->getMaxSize();
  }
  
  public function addBinder(Binder $Binder)
  {
    foreach($Binder->getArchivableAssets() as $Asset)
    {
      $this->_items[$Binder->getId()][$Asset->getId()] = $Asset->getHighQualitySize();
      $this->incCurrentSize($Asset->getHighQualitySize());
      Generic::logMessage('asset ' . $Asset->getId(), 'added asset');
    }
  }
  
  public function addFile($filepath, $folder='', $remove=true)
  {
    $this->_isopaths[]=sprintf('%s/=%s', $folder, $filepath);
    if($remove)
    {
      $this->_files[]=$filepath;
    }
    return $this;
  }
  public function getIsopaths()
  {
    return $this->_isopaths;
  }
  public function getFiles()
  {
    return $this->_files;
  }
  
  protected function getIsopathListForCommand()
  {
    $list='';
    foreach($this->getIsopaths() as $f)
    {
      $list.=sprintf(' "%s"', $f);
    }
    return $list;
  }
  
  protected function getFileListForCommand()
  {
    $list='';
    foreach($this->getFiles() as $f)
    {
      $list.=sprintf(' "%s"', $f);
    }
    return $list;
  }

  
  public function getIsoImageName()
  {
    return $this->getSlug(). '.iso';
  }
  
  public function getIsoImageFullPath()
  {
    return wvConfig::get('directory_iso_images') . '/'. $this->getIsoImageName();
  }
  
  
  public function incCurrentSize($v)
  {
    $this->_currentSize += $v;
    return $this;
  }

  public function getCurrentSize()
  {
    return $this->_currentSize; 
  }


  public function addBinders($Binders = Array())
  {
    Generic::logMessage('archive ' . $this->getId(), 'adding binders...');

    foreach ($Binders as $Binder)
    {
      if ($this->hasPlaceForBinder($Binder))
      {
        Generic::logMessage('binder ' . $Binder->getId(), 'added. Current size: ' . $this->getCurrentSize());
        $this->addBinder($Binder);
      }
      else
      {
        $this->setIsFull(true);
        Generic::logMessage('binder ' . $Binder->getId(), 'not added. Current size: ' . $this->getCurrentSize());
        break;
      }
    }
  }
  
  
  public function prepareISOImage()
  {
    if (!$this->getItems())
    {
      return false;
    }

    $this->addFile($this->saveIndexWebPage());
    
    $extrafiles=wvConfig::get('archiviation_extra_files');
    if(is_array($extrafiles))
    {
      foreach($extrafiles as $extrafile)
      {
        $this->addFile($extrafile, '', false);
      }
    }
    
    $binders_ids=array_keys($this->getItems());
    $Binders=BinderPeer::retrieveByPKs($binders_ids);
    foreach($Binders as $Binder)
    {
      foreach($Binder->getArchivableAssets() as $Asset)
      {
        $file=$Asset->getPublishedFile('high');
        $this->addFile($file->getFullPath(), sprintf(wvConfig::get('archiviation_folder_name_schema'), $Binder->getId()));
      }
    }
    
    $conn=Propel::getConnection(ArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
    $conn->beginTransaction();

    try
    {
      $command=sprintf('genisoimage -iso-level 3 -J -R -o "%s" -graft-points %s', 
        $this->getIsoImageFullPath(),
        $this->getIsopathListForCommand()
        );
        
      Generic::executeCommand($command);
      
      $isofile = new BasicFile($this->getIsoImageFullPath());
      $this->setMD5Sum($isofile->getMD5Sum());
      
      $this->save($conn);
    
      foreach($Binders as $Binder)
      {
        $Binder
        ->setArchiveId($this->getId())
        ->save($conn)
        ;
        foreach($Binder->getArchivableAssets() as $Asset)
        {
          $Asset
          ->setStatus(ASSET::ISO_IMAGE)
          ->save($conn)
          ;
        }
      }
      $conn->commit();
    }
    catch(Exception $e)
    {
      $conn->rollBack();
      throw $e;
    }
    return true;
  }
  
  public function removeFiles()
  {
    $filelist=$this->getFileListForCommand();
    
    if ($filelist)
    {
      try
      {   
        $command=sprintf('mv %s "%s" ', 
        $this->getFileListForCommand(),
        wvConfig::get('directory_trash')
        );
        Generic::executeCommand($command);
      }
      catch (Exception $e)
      {
        throw $e;
      }
    }
    
  }
  
  public function saveIndexWebPage()
  {
    $filename=wvConfig::get('directory_iso_cache'). '/index.html';
    $text=$this->getIndexWebPage();
    file_put_contents($filename, $text);
    return $filename;
  }
  
  public function getIndexWebPage()
  {
    $filename=wvConfig::get('archiviation_index_template');
    if (!is_readable($filename))
    {
      throw new Exception('Could not read template file: ' . $filename);
    }
    
    ob_start();
    
    $title=wvConfig::get('archiviation_index_title', 'Binders archived');
    $title=Generic::str_replace_from_array(array(
      '%date%'=>date('d/m/Y'),
      ),
      $title
      );
    
    $binders_ids=array_keys($this->getItems());
    
    $Binders=BinderPeer::retrieveByPKs($binders_ids);
    
    include_once($filename);
    
    $text = ob_get_contents();
    ob_end_clean();
    
    return $text;
  }
  
  
  public function markAsBurned($user_id)
  {
    $con = Propel::getConnection(ArchivePeer::DATABASE_NAME);
    try
    {
      $con->beginTransaction();
      $this
      ->setBurnedAt(time())
      ->setUserId($user_id)
      ->save($con);
      
      foreach($this->getBinders() as $Binder)
      {
        foreach($Binder->getAssets() as $Asset)
        {
          Generic::logMessage('Asset DVDROM', $Asset->getId());
          $Asset
          ->setStatus(Asset::DVDROM)
          ->save($con);
        }
      }
      
      $con->commit();
      return true;
    } catch (PropelException $e)
    {
      $con->rollback();
      return false;
    }
    
  }


} // Archive

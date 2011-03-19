<?php

require 'lib/model/om/BaseArchive.php';


/**
 * Skeleton subclass for representing a row from the 'archive' table.
 *
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
  
  public function __construct($type=ArchivePeer::HIGH_QUALITY_ARCHIVE)
  {
    parent::__construct();
    $this->setMaxSize(wvConfig::get('archiviation_iso_image_size')*1024*1024);
    $this->setIsFull(false);
    $this->_files=array();
    $this->_isopaths=array();
    $this->setGeneralAttributes($type);
  }

  public function setGeneralAttributes($type)
  {
    $this->setArchiveType($type);
    $this->setPosition(ArchivePeer::getMaxByType($type)+1);
    $this->setSlug(date('Ymd-His').'_'.
      ArchivePeer::getTypeDescription($type).'_'.
      $this->getPosition()
      );
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
    Generic::logMessage('binder ' . $Binder->getId(), 'evaluating place. Binder size: ' . $Binder->getTotalSize());
    return $Binder->getTotalSize() + $this->getCurrentSize() <= $this->getMaxSize();
  }

  public function hasPlaceForAsset(Asset $Asset)
  {
    Generic::logMessage('asset ' . $Asset->getId(), 'evaluating place. Asset size: ' . $Asset->getTotalSize());
    return $Asset->getTotalSize() + $this->getCurrentSize() <= $this->getMaxSize();
  }



  public function addBinder(Binder $Binder)
  {
    foreach($Binder->getArchivableAssets() as $Asset)
    {
      $this->_items[$Binder->getId()][$Asset->getId()] = $Asset->getHighQualitySize();
      $this->incCurrentSize($Asset->getHighQualitySize());
    }
  }
  
  public function addAsset(Asset $Asset)
  {
    $this->_items[$Asset->getId()][0] = $Asset->getTotalSize();
    $this->incCurrentSize($Asset->getTotalSize());
    Generic::logMessage('asset ' . $Asset->getId(), 'added asset. Current Archive size: '. $this->getCurrentSize());
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
        $this->addBinder($Binder);
        Generic::logMessage('binder ' . $Binder->getId(), 'added. Current size: ' . $this->getCurrentSize());
      }
      else
      {
        $this->setIsFull(true);
        Generic::logMessage('binder ' . $Binder->getId(), 'not added. Current size: ' . $this->getCurrentSize());
        break;
      }
    }
  }
  
  public function addAssets($Assets = Array())
  {
    Generic::logMessage('archive ' . $this->getId(), 'adding assets...');

    foreach ($Assets as $Asset)
    {
      if ($this->hasPlaceForAsset($Asset))
      {
        Generic::logMessage('asset ' . $Asset->getId(), 'added. Current size: ' . $this->getCurrentSize());
        $this->addAsset($Asset);
      }
      else
      {
        $this->setIsFull(true);
        Generic::logMessage('asset ' . $Asset->getId(), 'not added. Current size: ' . $this->getCurrentSize());
        break;
      }
    }
  }
  
  
  
  public function prepareISOImage($dryrun=false)
  {
    if (!$this->getItems())
    {
      return false;
    }

    switch($this->getArchiveType())
    {
      case ArchivePeer::HIGH_QUALITY_ARCHIVE:
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
        };
        break;
      case ArchivePeer::LOW_QUALITY_ARCHIVE:
        $assets_ids=array_keys($this->getItems());
        $Assets=AssetPeer::retrieveByPKs($assets_ids);
        foreach($Assets as $Asset)
        {
          $file=$Asset->getPublishedFile('low');
          $this->addFile($file->getFullPath(), 'assets', false);
          unset($file);
          if ($Asset->getHasThumbnailFile())
          {
            $file=$Asset->getThumbnailFile();
            $this->addFile($file->getFullPath(), 'thumbnails', false);
            unset($file);
          }
        };
        break;
        
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
      
      if(!$dryrun)
      {
        $this->setMD5Sum($isofile->getMD5Sum());
        $this->save($conn);

        switch($this->getArchiveType())
        {
          case ArchivePeer::HIGH_QUALITY_ARCHIVE:
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
            break;
          case ArchivePeer::LOW_QUALITY_ARCHIVE:
            foreach($Assets as $Asset)
            {
              $Asset
              ->setArchiveId($this->getId())
              ->save($conn)
              ;
            }
          break;
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
  
  public function sendArchiveReadyNotice(sfBaseTask $task, sfMailer $mailer)
  {
    if($username=wvConfig::get('archiviation_notice_to'))
    {
      echo "\n";
      $user=sfGuardUserProfilePeer::getByUsername($username);
      if ($user)
      {
        $profile = $user->getProfile();
        if ($profile->sendArchiveReadyNotice($mailer, $this))
        {
          $task->logSection('mail', 'Email notice sent', null, 'COMMENT');
          $task->logSection('mail@', $profile->getEmail(), null, 'INFO');
        }
        
      }
    }
  }


} // Archive

<?php

class SourceFile extends BasicFile
{
	
	const
    WV_DIR= '.wviola',
    VIDEO = 1,
    PICTURE = 2,
    PHOTOALBUM = 3,
    AUDIO = 4;
	
	protected
		$_relativePath,
		$_basicPath,
		$_fileInfo,
		$_infoChanged;

	public function __construct($relativePath, $basename)
	{
    
    if(strpos($basename, '"')>0)
    {
      throw new BadNameException(sprintf('Filename "%s/%s" invalid.', $relativePath, $basename));
    }
		$this->_basicPath=wvConfig::get('directory_sources');
		parent::__construct($this->getBasicPath() . $relativePath, $basename);
		$this->setRelativePath($relativePath);
		$this->loadWvInfoFile();
	}
  
	public function getHasWvInfo()
	{
		return (!is_null($this->_fileInfo));
	}
	
	public function getWvInfoChanged()
	{
		return $this->_infoChanged;
	}
	
	private function setWvInfoChanged($v)
	{
		$this->_infoChanged=$v;
		return $this;
	}
	
	private function setRelativePath($v)
	{
		$this->_relativePath = $v;
		return $this;
	}
	
	public function getRelativePath()
	{
		return $this->_relativePath;
	}
	
	public function getHasMD5Sum()
	{
		return $this->getWvInfo('file_lmd5sum')!='';
	}

	public function appendMD5Sum()
	{
		$this->
		setWvInfo('file_lmd5sum', 
      $this->getMD5Sum(
        wvConfig::get('filebrowser_md5sum_limit'))
      );
    
    if($Asset=AssetPeer::retrieveBySourceSizeAndMd5sum(
      $this->getWvInfo('file_size'),
      $this->getWvInfo('file_lmd5sum')
      ))
    {
      $this->setWvInfo('file_asset_id', $Asset->getId());
      $this->setWvInfo('file_archivable', false);
    }
    
		return $this;
	}
	
	public function gatherWvInfo($onlyBasicInfo=false)
	{
		$this->
		setWvInfo('file_mtime', $this->getStat('mtime'))->
		setWvInfo('file_ctime', $this->getStat('ctime'))->
		setWvInfo('file_atime', $this->getStat('atime'))->
		setWvInfo('file_size', $this->getStat('size'))->
		setWvInfo('file_mediatype', $this->getGuessedInternetMediaType())->
		setWvInfo('file_type', $this->getFileType())
		;
		
		if(!$onlyBasicInfo)
		{
			list($type,$subtype)=explode('/', $this->getWvInfo('file_mediatype'));
			switch($type)
			{
				case 'video':
					$this->_gatherVideoInfo();
					break;
				case 'image':
					$this->_gatherPictureInfo();
					break;
				case 'application':
          if($subtype=='zip')
          {
            $this->_gatherPhotoAlbumInfo();
          }
					break;
        case 'audio':
          $this->_gatherAudioInfo();
          break;
			}
		}
		
		return $this;
	}
	
	
	private function _gatherPictureInfo()
	{
    $this->setWvInfo('source_type', self::PICTURE);
		return;
	}
  
  public function _gatherPhotoalbumInfo()
  {
    $this->setWvInfo('source_type', self::PHOTOALBUM);

    $thumbnailsNumber=wvConfig::get('thumbnail_number', 5);

		$thumbnailWidth=wvConfig::get('thumbnail_width', 60);
		$thumbnailHeight=wvConfig::get('thumbnail_height', 45);

    $i=0;
    $count=0;
    
    try
    {
      $ziplist=$this->executeCommand(sprintf('zipinfo -1 "%s"', $this->getFullPath()));
      $tempdir=sys_get_temp_dir() . '/'. $this->getBasename() . '-' . date('Uu');
      mkdir($tempdir);
      $list=array();
      
      if (!is_array($ziplist) && $ziplist!='')
      {
        $filelist[]=$ziplist;
      }
      else
      {
        $filelist=$ziplist;
      }
            
      foreach($filelist as $imagefile)
      {
        if (Generic::matchesOneOf(wvConfig::get('filebrowser_photoalbum_items'), $imagefile))
        {
          
          if ($i<$thumbnailsNumber)
          {
            $this->executeCommand(sprintf('unzip "%s" "%s" -d "%s"',
              $this->getFullPath(),
              $imagefile,
              $tempdir
              ));
//            Generic::logMessage('File unzipped', $imagefile);
            
            $thumbnail = new sfThumbnail($thumbnailWidth, $thumbnailHeight);
            $thumbnail->loadFile($tempdir . '/'. $imagefile);
            $thumbnail->save($tempdir . '/thumb.jpeg', 'image/jpeg');
            
            $position=$i;
            
            $content=base64_encode(file_get_contents($tempdir . '/thumb.jpeg'));
            
            $this->setWvInfo('thumbnail_' . $i . '_width', $thumbnail->getThumbWidth());
            $this->setWvInfo('thumbnail_' . $i . '_height', $thumbnail->getThumbHeight());
            $this->setWvInfo('thumbnail_' . $i . '_base64content', $content);          
            
            unlink($tempdir . '/thumb.jpeg');
            unlink($tempdir . '/' . $imagefile);
//            Generic::logMessage('File removed', $imagefile);
            $i++;
            unset($thumbnail);
          }
          $count++;
          $list[]=$imagefile; // some files may be not images, so we exclude them
        }
      }
      
      
      rmdir($tempdir);
//      Generic::logMessage('Directory removed', $tempdir);

    }
    catch (Exception $e)
    {
      $this->setWvInfo('file_archivable', false);
      return;
    }
    
    $this->setWvInfo('file_archivable', true);
    $this->setWvInfo('pictures_count', $count); // FIXME
    $this->setWvInfo('pictures_list', $list);
        
		return;
  }
	
	private function _gatherVideoInfo()
	{
    $this->setWvInfo('source_type', self::VIDEO);
		try
		{
			$movie= new ffmpeg_movie($this->getFullPath());
			$this->
			setWvInfo('video_duration', $movie->getDuration())->
			setWvInfo('video_framecount', $movie->getFrameCount())->
			setWvInfo('video_framerate', $movie->getFrameRate())->
			setWvInfo('video_comment', $movie->getComment())->
			setWvInfo('video_title', $movie->getTitle())->
			setWvInfo('video_frame_width', $movie->getFrameWidth())->
			setWvInfo('video_frame_height', $movie->getFrameHeight())->
			setWvInfo('video_codec', $movie->getVideoCodec())->
			setWvInfo('audio_codec', $movie->getAudioCodec())
			;

			$moviefile=new MovieFile($this->getFullPath());

			$sourceAspectRatio=$moviefile->getExplicitAspectRatio();
			
			if(!$sourceAspectRatio)
			{
        if ($movie->getFrameHeight())
        // for some streams we don't have video at all, so we should avoid
        // divisions by zero...
        {
          $sourceAspectRatio=$movie->getFrameWidth()/$movie->getFrameHeight();
        }
        else
        {
          $sourceAspectRatio=1;
        }
			}

			$this->setWvInfo('video_aspect_ratio', $sourceAspectRatio);
		
			$thumbnailsNumber=wvConfig::get('thumbnail_number', 5);

			$thumbnailWidth=wvConfig::get('thumbnail_width', 60);
			$thumbnailHeight=wvConfig::get('thumbnail_height', 45);
			
			$thumbnailAspectRatio=$thumbnailWidth/$thumbnailHeight;
			
			$cropH=$movie->getFrameHeight();
			$cropW=$movie->getFrameWidth()*$thumbnailAspectRatio/$sourceAspectRatio;
      
      if($cropW > $movie->getFrameWidth())
      {
        $cropW=$movie->getFrameWidth();
        $cropH=$movie->getFrameHeight()*$sourceAspectRatio/$thumbnailAspectRatio;
      }
			      
			for($i=0; $i<$thumbnailsNumber;$i++)
			{
				$position=$i*($movie->getDuration()/($thumbnailsNumber));
				$frame=$moviefile->getFrameAsJpegBase64($position, $cropW, $cropH, $thumbnailWidth, $thumbnailHeight);
				if ($frame)
				{
					$this->setWvInfo('thumbnail_' . $i . '_position', $position);
					$this->setWvInfo('thumbnail_' . $i . '_width', $thumbnailWidth);
					$this->setWvInfo('thumbnail_' . $i . '_height', $thumbnailHeight);
					$this->setWvInfo('thumbnail_' . $i . '_base64content', $frame);
				}
        else
        {
          //echo "Could not get frame!\n";
        }

			}
			unset($moviefile);
			unset($movie);
		}
		catch (Exception $e)
		{
      if(isset($moviefile))
      {
        unset($moviefile);
      }
      if(isset($movie))
      {
        unset($movie);
      }
      
			//throw new Exception(sprintf('Could not gather information about file %s', $this->getFullPath()));
      $this->setWvInfo('file_archivable', false);
      
		}
    
    $this->setWvInfo('file_archivable', true);
    
	}
	
	private function _gatherAudioInfo()
	{
    $this->setWvInfo('source_type', self::AUDIO);
    
    try
    {
      $command=sprintf('ffprobe "%s" 2>&1 | grep "  Duration:" | head -1 | sed -e "s/.*Duration: //" -e "s/,.*//"', $this->getFullPath());
      $duration=$this->executeCommand($command);
      list($secs, $dec) = explode('.', $duration);
      list($hours, $minutes, $seconds) = explode(':', $secs);
      
      $this->setWvInfo('audio_duration', $seconds + $minutes*60 + $hours*3600 + $dec/100);
    }
    catch (Exception $e)
    {
      $this->setWvInfo('file_archivable', false);
    }
    
    $this->setWvInfo('file_archivable', true);
	}


  public function loadWvInfoFile()
	{
		$this->setWvInfoChanged(false);
		if ($this->_fileInfo)
		{
			return;
		}
		
		if (is_readable($this->getWvInfoFilePath()))
		{
			$this->_fileInfo=sfYaml::load($this->getWvInfoFilePath());
		}
		else
		{
			$this->resetWvInfo();
		}
		
		if ($this->getStat('mtime')>$this->getWvInfo('file_mtime'))
		{
			$this->resetWvInfo();
		}
	}
	
	
	public function getShouldBeSkipped()
	{
    // we skip symbolic links...
    if($this->getFileType()=='link')
		{
				return true;
		}
    
    if($this->getFileType()=='directory')
    {
      return false;
    }
    
    // we don't skip files with the extension in the white list
    return ! Generic::matchesOneOf(wvConfig::get('filebrowser_white_list'), $this->getBaseName());
	}
  
  private function makeWvDirPathIfNeeded()
  {
		if (
			(!is_dir($this->getWvDirPath()))
			&&
			($this->canWriteWvDir())
			)
		{
			try
			{
				mkdir($this->getWvDirPath());
        chmod($this->getWvDirPath(), wvConfig::get('filebrowser_info_perms_dir'));
        Generic::executeCommand(sprintf('sudo /bin/chown %s:%s "%s"', 
          wvConfig::get('filebrowser_info_user'),
          wvConfig::get('filebrowser_info_group'),
          $this->getWvDirPath())
          ); 

				//clearstatcache();
			}
			catch (Exception $e)
			{
				throw new Exception (sprintf('Could not make dir %s', $this->getWvDirPath()));
			}
		}
  }
  
	
	public function saveWvInfoFile()
	{
		if (!$this->getWvInfoChanged())
		{
			return;
		}
		
		if (!$this->_fileInfo)
		{
			return;
		}
		
    $this->makeWvDirPathIfNeeded();
		
		try
		{
			$fp=fopen($this->getWvInfoFilePath(), 'w');
			$yaml=sfYaml::dump($this->_fileInfo, 4);
      
      if (@flock($fp, LOCK_EX))
      {
        fwrite($fp, $yaml, strlen($yaml));
        fclose($fp);
        @flock($fp, LOCK_UN);
        chmod($this->getWvInfoFilePath(), wvConfig::get('filebrowser_info_perms_file'));
        Generic::executeCommand(sprintf('sudo /bin/chown %s:%s "%s"', 
          wvConfig::get('filebrowser_info_user'),
          wvConfig::get('filebrowser_info_group'),
          $this->getWvInfoFilePath())); 
      }
      else
      {
        throw new Exception(sprintf('Could not acquire lock to file "%s"', $this->getWvInfoFilePath()));
      }

		}
		catch (Exception $e)
		{
			throw new Exception(sprintf('Could not write to file "%s"', $this->getWvInfoFilePath()));
		}
		return $this;
		
	}
	
	public function getHasThumbnails()
	{
		return is_array($this->getWvInfo('thumbnail'));
	}
  
  public function getThumbnailNb()
  {
    
//    Generic::logMessage('TN', $this->getWvInfo('thumbnail'));
    if($this->getWvInfo('thumbnail'))
    {
      return sizeof($this->getWvInfo('thumbnail'));
    }
    else
    {
      return 0;
    }
  }
	
	
	public function getThumbnail($number)
	{
		Generic::removeLastCharIf($number, '.jpeg');
		Generic::removeLastCharIf($number, '.png');
		
		$key='thumbnail_' . $number;
		if (!$this->getHasWvInfoKey($key))
		{
			return false;
		}

		if (array_key_exists('base64content', $this->getWvInfo($key)))
		{
			return $this->getWvInfo($key);
		}
		else
		{
			return false;
		}	
	}
	

	private function key2RealKey($key)
	{
		$rk=str_replace('_', "']['", $key);
		$rk="['" . $rk . "']";
		return $rk;
	}

	public function setWvInfo($key, $value)
	{
		eval('$this->_fileInfo' . $this->key2RealKey($key) . '=$value;');
		$this->setWvInfoChanged(true);
		
		return $this;
	}
  
  public function getHasWvInfoKey($key)
  {
    return $this->getWvInfo($key)? true: false;
  }

	public function resetWvInfo()
	{
		unset($this->_fileInfo);
		$this->_fileInfo=null;
	}


	public function getWvInfo($key, $default='')
	{
		$value='';
		@eval('$value=$this->_fileInfo' . $this->key2RealKey($key) . ';');
		return $value!==null?$value: $default;
	}
	
	public function getCompleteWvInfo()
	{
		return $this->_fileInfo;
	}
	
	public function getBasicPath()
	{
		return $this->_basicPath;
	}
	
	public function getWvInfoFilePath()
	{
		return $this->getWvDirPath() . '/' . $this->getStat('ino') . '.yml';
	}
  
	public function getWvDirPath()
	{
		return $this->getPath() . '/' . self::WV_DIR;
	}
	
	public function getWvDirIsReadable()
	{
		return is_dir($this->getWvDirPath()) && is_readable($this->getWvDirPath());
	}
	
	public function getWvDirIsWriteable()
	{
		return is_dir($this->getWvDirPath()) && is_writeable($this->getWvDirPath());
	}
	
	public function canWriteWvDir()
	{
		return is_writeable($this->getPath());
	}

    public function moveFileToScheduled($prefix)
    {
      $uniqid=uniqid($prefix . '_', true);
      
      Generic::logMessage('sourcefile::moveFileToScheduled()', 'started');

      if (!rename(
        $this->getWvInfoFilePath(),
        wvConfig::get('directory_scheduled') . '/' . $uniqid . '.yml'
        ))
      {
        Generic::logMessage('sourcefile::moveFileToScheduled()', sprintf('could not move "%s" to "%s"', $this->getWvInfoFilePath(),wvConfig::get('directory_scheduled') . '/' . $uniqid . '.yml'));
        return false;
      }
      else
      {
        Generic::logMessage('sourcefile::moveFileToScheduled()', sprintf('moved "%s" to "%s"', $this->getWvInfoFilePath(),wvConfig::get('directory_scheduled') . '/' . $uniqid . '.yml'));
      }

      if (!rename(
          $this->getFullPath(),
          wvConfig::get('directory_scheduled') . '/' . $uniqid
          ))
      {
        // This shouldn't happen, since we were able to write the yml info file...
        Generic::logMessage('sourcefile::moveFileToScheduled()', sprintf('could not move "%s" to "%s"', $this->getFullPath(), wvConfig::get('directory_scheduled') . '/' . $uniqid));
        return false;
      }
      else
      {
        Generic::logMessage('sourcefile::moveFileToScheduled()', sprintf('moved "%s" to "%s"', $this->getFullPath(), wvConfig::get('directory_scheduled') . '/' . $uniqid));
      }
    
      return $uniqid;
  }
  
  public function getIsBeingCopied()
  {
    // we need to check if the file is being copied right now.
    // we'll check the size after few seconds
    $waittime=wvConfig::get('filebrowser_file_being_copied_check_waittime', 10);
    $showinfo=wvConfig::get('filebrowser_file_being_copied_check_showinfo', false);
    $originalsize=$this->getStat('size');
    if($showinfo)
    {
      echo 't0 size: ' . $originalsize . "\n";
      echo sprintf('Waiting %d second(s) before checking size again... ', $waittime) . "\n";
    }
    sleep($waittime);
    $this->retrieveStat();
    $currentsize=$this->getStat('size');
    if($showinfo)
    {
      echo 't' . $waittime . ' size: ' . $currentsize . "\n";
    }
    return $originalsize!=$currentsize;
  }
	
}



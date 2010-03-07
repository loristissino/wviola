<?php

class SourceFile extends BasicFile
{
	
	const WV_DIR= '.wviola';
	
	protected
		$_relativePath,
		$_basicPath,
		$_fileInfo,
		$_infoChanged;

	public function __construct($relativePath, $basename)
	{
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
		return $this->getWvInfo('file_md5sum')!='';
	}

	public function appendMD5Sum()
	{
		$this->
		setWvInfo('file_md5sum', $this->getMD5Sum())
		;
		
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
					$this->_gatherImageInfo();
					break;
				case 'application':
					// zip file?
					break;
			}
		}
		
		return $this;
	}
	
	
	private function _gatherImageInfo()
	{
		return;
	}
	
	private function _gatherVideoInfo()
	{
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
				$sourceAspectRatio=$movie->getFrameWidth()/$movie->getFrameHeight();
			}



			$this->setWvInfo('video_aspect_ratio', $sourceAspectRatio);
		
			$thumbnailsNumber=wvConfig::get('thumbnail_number', 5);

			$thumbnailWidth=wvConfig::get('thumbnail_width', 60);
			$thumbnailHeight=wvConfig::get('thumbnail_height', 45);
			
			$thumbnailAspectRatio=$thumbnailWidth/$thumbnailHeight;
			
			$cropH=$movie->getFrameHeight();
			$cropW=$movie->getFrameWidth()*$thumbnailAspectRatio/$sourceAspectRatio;
			
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

			}
			unset($moviefile);
			
		}
		catch (Exception $e)
		{
			throw new Exception(sprintf('Could not gather information about file %s', $this->getFullPath()));
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
    
		foreach(wvConfig::get('filebrowser_skipped_files') as $regexp)
		{
			if(preg_match($regexp, $this->getBaseName()))
			{
				return true;
			}
			
			if($this->getFileType()=='link')
			{
				return true;
			}
		}
		return false;
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
        chmod($this->getWvDirPath(), 0777);
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
        chmod($this->getWvInfoFilePath(), 0666);
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
    return sizeof($this->getWvInfo('thumbnail'));
  }
	
	
	public function getThumbnail($number)
	{
		
		Generic::removeLastCharIf($number, '.jpeg');
		Generic::removeLastCharIf($number, '.png');
		
		$key='thumbnail_' . $number;
		if (!$this->getHasWvInfo($key))
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
	
}



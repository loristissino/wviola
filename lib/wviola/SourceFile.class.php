<?php

class SourceFile extends BasicFile
{
	
	const WV_DIR= '.wviola';
	
	protected
		$_relativePath,
		$_basicPath,
		$_fileInfo;

	public function __construct($relativePath, $basename)
	{
		$this->_basicPath=wvConfig::get('directory_sources');
		parent::__construct($this->getBasicPath() . $relativePath, $basename);
		$this->loadWvInfoFile();
	}
	
	public function getHasWvInfo()
	{
		return is_array($this->_fileInfo);
	}
	
	public function gatherWvInfo()
	{
		
		$this->
		setWvInfo('file_mtime', $this->getStat('mtime'))->
		setWvInfo('file_ctime', $this->getStat('ctime'))->
		setWvInfo('file_atime', $this->getStat('atime'))->
		setWvInfo('file_size', $this->getStat('size'))->
		setWvInfo('file_md5sum', $this->getMD5Sum())
		;
		
		list($type,$subtype)=explode('/', $this->getGuessedInternetMediaType());
		
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
		$this->saveWvInfoFile();
		
		return $this;
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
			
			
			$command=sprintf('ffprobe "%s" 2>&1 | grep "DAR " | sed -e "s/^.*DAR //" -e "s/].*//"', $this->getFullPath());
			/*
			With this command we find the Display Aspect Ratio, stored in MPEG files
			ffprobe outputs on the standard error, hence the redirection
			*/
			$ratio=$this->executeCommand($command);
			if(strpos($ratio, ':'))
			{
				list($width, $height)=explode(':', $ratio);
				$ratio=$width/$height;
				$ratioCorrection=true;
			}
			else
			{
				$ratio=$movie->getFrameWidth()/$movie->getFrameHeight();
				$ratioCorrection=false;
			}
			
			$this->setWvInfo('video_aspect_ratio', $ratio);
		
			$thumbnailsNumber=wvConfig::get('thumbnail_number', 5);

			$thumbnailWidth=wvConfig::get('thumbnail_width', 60);
			$thumbnailHeight=wvConfig::get('thumbnail_height', 45);
			$thumbnailAspectRatio=$thumbnailWidth/$thumbnailHeight;

			for($i=1; $i<=$thumbnailsNumber;$i++)
			{
				$number=(int)($i*$movie->getFrameRate()/($thumbnailsNumber+1));
				$frame=$movie->getFrame($number)->toGDImage();

				if($ratioCorrection)
				{
					$newWidth=$movie->getFrameWidth();
					$newHeight=(int)($movie->getFrameWidth()/$ratio);
					$resampledFrame=imagecreatetruecolor($newWidth, $newHeight);
					imagecopyresampled($resampledFrame, $frame, 0, 0, 0, 0, $newWidth, $newHeight, $movie->getFrameWidth(), $movie->getFrameHeight());
				}
				else
				{
					$resampledFrame=$frame;
				}
				
				if ($ratio>$thumbnailAspectRatio)
				{
					$srcW=(int)(imagesx($resampledFrame)*$thumbnailAspectRatio);
					$srcH=imagesy($resampledFrame);
					$srcX=(int)((imagesx($resampledFrame)-$srcW)/2);
					$srcY=0;
				}
				else
				{
					$srcW=imagesx($resampledFrame);
					$srcH=(int)(imagesx($resampledFrame)/$thumbnailAspectRatio);
					$srcX=0;(int)((imagesx($resampledFrame)-$srcW)/2);
					$srcY=(int)((imagesy($resampledFrame)-$srcH)/2);
				}

				$thumbnail=imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
				
				imagecopyresampled($thumbnail, $resampledFrame, 0, 0, $srcX, $srcY, $thumbnailWidth, $thumbnailHeight, $srcW, $srcH);

				$tempfile=tempnam('/tmp', 'wviola');

				imagejpeg($thumbnail, $tempfile);
				
				$text=base64_encode(file_get_contents($tempfile));

				$this->setWvInfo('thumbnail_' . $i . '_width', $thumbnailWidth);
				$this->setWvInfo('thumbnail_' . $i . '_height', $thumbnailHeight);
				$this->setWvInfo('thumbnail_' . $i . '_base64content', $text);
				
				unlink($tempfile);
				
				imagedestroy($thumbnail);
				imagedestroy($frame);
				if(is_object($resampledFrame))
				{
					imagedestroy($resampledFrame);
				}
				
			}

			
		}
		catch (Exception $e)
		{
			throw new Exception(sprintf('Could not gather information about file %s', $this->getFullPath()));
		}
	}
	
	public function loadWvInfoFile()
	{
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
			$this->_fileInfo=null;
		}
		
	}
	
	public function saveWvInfoFile()
	{
		if (!$this->_fileInfo)
		{
			return;
		}
		
		if (
			(!is_dir($this->getWvDirPath()))
			&&
			($this->canWriteWvDir())
			)
		{
			try
			{
				mkdir($this->getWvDirPath());
				//clearstatcache();
			}
			catch (Exception $e)
			{
				throw new Exception (sprintf('Could not make dir %s', $this->getWvDirPath()));
			}
		}
		
		if (is_writeable($this->getWvInfoFilePath()) || (!file_exists($this->getWvInfoFilePath())))
		{
			$fp=fopen($this->getWvInfoFilePath(), 'w');
			$yaml=sfYaml::dump($this->_fileInfo, 4);
			fwrite($fp, $yaml, strlen($yaml));
			fclose($fp);
		}
		else
		{
			throw new Exception(sprintf('Could not write to file "%s"', $this->getWvInfoFilePath()));
		}
		return $this;
		
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
		return $this;
	}
	
	public function getWvInfo($key, $default='')
	{
		$value='';
		eval('$value=$this->_fileInfo' . $this->key2RealKey($key) . ';');
		return $value?$value: $default;
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



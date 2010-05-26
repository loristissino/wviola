<?php

class MovieFile extends BasicFile
{
  
  private $info=Array();

	private function _getFrame($position, $cropW, $cropH, $thumbnailWidth, $thumbnailHeight, $format='jpeg')
	{
		$cropW=round($cropW);
		$cropH=round($cropH);
		
		$command=sprintf('makethumbnail "%s" %f %s %s %s',
				$this->getFullPath(),
				$position,
				$cropW . ':' . $cropH,
				$thumbnailWidth . ':' . $thumbnailHeight,
				$format
				);
		$result=$this->executeCommand($command, true);
		
		list($key, $value)=explode('=', $result);
		
		if($value=='none')
		{
			return false;
		}
		
		$text=base64_encode(file_get_contents($value));
		unlink($value);
		
		return $text;
	}

	public function getFrameAsJpegBase64($position, $cropW, $cropH, $thumbnailWidth, $thumbnailHeight)
	{
		return $this->_getFrame($position, $cropW, $cropH, $thumbnailWidth, $thumbnailHeight, 'jpeg');
	}
	
	
	public function getExplicitAspectRatio()
	{
		$command=sprintf('ffprobe "%s" 2>&1 | grep "DAR " | sed -e "s/^.*DAR //" -e "s/].*//"', $this->getFullPath());
		/*
		With this command we find the Display Aspect Ratio, stored in MPEG files.
		ffprobe outputs on the standard error, hence the redirection
		*/
		$AspectRatio=$this->executeCommand($command);
		if(@strpos($AspectRatio, ':'))
		{
			list($width, $height)=explode(':', $AspectRatio);
			$AspectRatio=$width/$height;
			return $AspectRatio;
		}
		else
		{
			return false;
		}

	}
  
  
  public function retrieveInfo($type)
  {
    // this is used after publishing, to check what we produced and save
    // the info in the db
    // we call it twice, for the low and for the high-quality video
    
    $movie= new ffmpeg_movie($this->getFullPath());
    
    switch($type)
    {
      case 'high':
        $info['duration']=$movie->getDuration();
        $info['highquality_frame_rate']=$movie->getFrameRate();
        $info['highquality_width']=$movie->getFrameWidth();
        $info['highquality_height']=$movie->getFrameHeight();
        $info['highquality_video_codec']=$movie->getVideoCodec();
        $info['highquality_audio_codec']=$movie->getAudioCodec();
        $info['highquality_aspect_ratio']=$this->getExplicitAspectRatio();
        return $info;
      case 'low':
        $info['lowquality_width']=$movie->getFrameWidth();
        $info['lowquality_height']=$movie->getFrameHeight();
        $info['lowquality_video_codec']=$movie->getVideoCodec();
        $info['lowquality_audio_codec']=$movie->getAudioCodec();
        $info['lowquality_frame_rate']=$movie->getFrameRate();
        return $info;
    }
  }

}


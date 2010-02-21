<?php

class MovieFile extends BasicFile
{

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
		if(strpos($AspectRatio, ':'))
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

}


<?php

class FfmpegMovie
{
  private $_data = array();
  
  public function __construct($path)
  {
    //$command = sprintf('cat /tmp/sample.json', $path);
    $command = sprintf('ffprobe -v quiet -print_format json -show_format -show_streams "%s"', $path);
    $info = json_decode(implode('', Generic::executeCommand($command)));
    
    if(!is_object($info))
    {
      $this->_data = false;
    }
    else
    {
      foreach($info->streams as $stream)
      {
        if($stream->codec_type == 'video')
        {
          $this->_gatherInfo(array(
            'codec_name'     => 'VideoCodec',
            'width'          => 'FrameWidth',
            'height'         => 'FrameHeight',
            'nb_frames'      => 'FrameCount',
            'duration'       => 'Duration',
            'avg_frame_rate' => 'FrameRate',
            ), $stream);
        }
        if($stream->codec_type == 'audio')
        {
          $this->_gatherInfo(array(
            'codec_name'    => 'AudioCodec',
            ), $stream);
        }
      }
    }
    
  }

  protected function _gatherInfo($keys, $source)
  {
    foreach($keys as $property=>$key)
    {
      if(isset($source->$property))
      {
        $this->_data[$key] = $source->$property;
      }
    }
  }
  
  public function get($name, $default=false)
  {
    if(isset($this->_data[$name]))
    {
      return $this->_data[$name];
    }
    else
    {
      return $default;
    }
  }

  public function getDuration()
  {
    return $this->get('Duration');
  }
  public function getFrameRate()
  {
    return $this->get('FrameRate');
  }
  public function getFrameWidth()
  {
    return $this->get('FrameWidth');
  }
  public function getFrameHeight()
  {
    return $this->get('FrameHeight');
  }
  public function getVideoCodec()
  {
    return $this->get('VideoCodec');
  }
  public function getAudioCodec()
  {
    return $this->get('AudioCodec');
  }
  public function getFrameCount()
  {
    return $this->get('FrameCount');
  }
  public function getComment()
  {
    return $this->get('Comment');
  }
  public function getTitle()
  {
    return $this->get('Title');
  }

  
}


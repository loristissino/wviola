<?php

/*
 * This file is part of the wviola package.
 * (c) 2009-2010 Loris Tissino <loris.tissino@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class that represents a generic file.
 *
 * @package    wviola
 * @subpackage files
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
class BasicFile
{
	/**
	 * File's basename.
	 * @var   string
	 */
	protected $_basename;
  
	/**
	 * File's path.
	 * @var   string
	 */
  protected $_path;
  
	/**
	 * File's information, coming from the execution of stat command.
	 * @var   array
	 */
  protected $_stat;
	
	/**
	 * File's delivery name.
	 * @var   string
	 */
  protected $_deliveryName;
  
	public function __construct()
	{
		switch(func_num_args())
		{
			case 1:
				$this->_path=dirname(func_get_arg(0));
				$this->_basename=basename(func_get_arg(0));
				break;
			case 2:
				$this->_path=func_get_arg(0);
				Generic::removeLastCharIf($this->_path, '/');
				$this->_basename=func_get_arg(1);
				break;
		}
    
    $list=wvConfig::get('publishing_extensions_used');
    
    $found=false;
    $orig=$this->getBasename();
    $tries=array();
    foreach($list as $ext)
    {
      $this->setBasename($orig . $ext);
      if ($this->retrieveStat())
      {
        $found=true;
        break;
      }
      $tries[]=$ext;
    }
    
		if (!$found)
		{
			throw new Exception(sprintf('Not a valid file: %s* (tried %s{%s})', $orig, $this->getFullPath(), implode(',', $tries)));
		}
		
	}
  
  public function retrieveStat()
  {
    $this->_stat = @stat($this->getFullPath());
    if ($this->getStat('size')<0)
		{
			/* for big files, stat gets wrong results... */
			$command='stat --dereference --format "%s" "' . $this->getFullPath() . '"';
			$this->_stat['size']=(float) $this->executeCommand($command); 
		}

    return $this->_stat;
  }
	
  /**
   * Get the [path] value.
   * 
   * @return     string
   */
	public function getPath()
	{
		return $this->_path;
	}
	
  /**
   * Get the [basename] value.
   * 
   * @return     string
   */
	public function getBasename()
	{
		return $this->_basename;
	}
  
  /**
   * Get the required path part from the file.
   * 
   * @return     string
   */
	public function getPathPart($part)
	{
    $path_parts = pathinfo($this->getFullPath());
    return array_key_exists($part, $path_parts)? $path_parts[$part]: '';
    // dirname, basename, extension, filename
    // see http://php.net/manual/en/function.pathinfo.php
	}
  
  
	/**
	 * Set the value of [basename].
	 * 
	 * @param      string $v new value
	 * @return     BasicFile The current object (for fluent API support)
	 */
	public function setBasename($v)
	{
		$this->_basename=$v;
		return $this;
	}
	
  /**
   * Get the [fullpath] value (path + basename).
   * 
   * @return     string
   */
	public function getFullPath()
	{
		return Generic::getCompletePath($this->getPath(), $this->getBasename());
	}
  
  /**
   * Get the [fullpath] value (path + basename).
   * This is just an alias for getFullPath() method.
   * 
   * @return     string
   */
  public function getPathName()
  {
    return $this->getFullPath();
  }

  /**
   * Get the [stat] information about the file.
   * 
   * @param      string $name key of the requested value
   * @return     array
   */
	public function getStat($name)
	{
		return $this->_stat[$name];
	}
	
  /**
   * Get the [stat] information about the file.
   * 
   * @return     array
   */
	public function getStats()
	{
		return $this->_stat;
	}
  
  /**
   * Get the size of the file.
   * 
   * @return     array
   */
  public function getSize()
  {
    return $this->getStat('size');
  }
	
  /**
   * Get the md5sum of the file.
   * 
   * @param      string $limit an hexadecimal figure specifying the number of bytes on which compute the md5sum
   * @return     array
   */
	public function getMD5Sum($limit='')
	{
    if ($limit=='')
    {
      return md5_file($this->getFullPath());
    }
    else
    {
      if(strpos($limit, ':')!==false)
      {
        list($sum,$limit)=explode(':',$limit);
      }
      $info=$this->executeCommand(
        sprintf('limitedmd5sum "%s" %s', $this->getFullPath(), $limit),
        true);
      list($key, $value)=explode('=', $info);
      return $value;
    }
	}
	
  /**
   * Execute an external command.
   * 
   * @param      string $command the command to execute
   * @param      boolean $custom whether the command is one of wviola library or not
   * @return     mixed the lines of command's output
   */
	public function executeCommand($command, $custom=false)
	{
		return Generic::executeCommand($command, $custom);
	}
	
  /**
   * Get the Internet Media Type of the file.
   * 
   * @return     string
   */
	public function getGuessedInternetMediaType()
	{
		$command=sprintf('file --dereference --brief --mime-type "%s"', $this->getFullPath());
		$mimeType=$this->executeCommand($command);
		
    if (!strpos($mimeType, '/'))
    {
      return null;
      // if the file is not readable or for other problems...
    }
    
		list($type, $subtype)=explode('/', $mimeType);
		
		if($type=='application')
		{
			// we need this because sometimes mpeg videos are reported as application/octet-stream
			$command=sprintf('file --dereference --brief "%s"', $this->getFullPath());
			$description=$this->executeCommand($command);
      
      foreach(wvConfig::get('filebrowser_description_matches') as $match)
      {
        if (preg_match($match['description'], $description))
        {
          return $match['result'];
        }
      }
      
      foreach(wvConfig::get('filebrowser_extension_matches') as $match)
      {
        if (strtolower($this->getPathPart('extension'))==$match['extension'])
        {
          return $match['result'];
        }
      }
      
      /*
			if ($subtype=='ogg')
			{
				// FIXME This is likely not always true...
				$type='video'; $subtype='ogg';
			}
      */
		}
    
    if($type=='video')
    {
			// we need this because sometimes mpeg videos do not have a Video stream
			$command=sprintf('ffprobe "%s" 2>&1 | grep "Stream.*Video" | cat', $this->getFullPath());
			$description=$this->executeCommand($command);
      if (is_array($description) && sizeof($description)==0)
      {
        $type='audio';
        // subtype remains the same, or not?
      }
    }
    
 	return $type . '/' . $subtype;
	}
  
  /**
   * Get the Internet Media Type of the file.
   * This is just an alias for getGuessedInternetMediaType() method.
   * 
   * @return     string
   */
  public function getMimeType()
  {
    return $this->getGuessedInternetMediaType();
  }
  
	
  /**
   * Get the the file type.
   * 
   * @return     string
   */
	public function getFileType()
	{
		if (is_dir($this->getFullPath()))
		{
			return 'directory';
		}
		if (is_link($this->getFullPath()))
		{
			return 'link';
		}
		if (is_file($this->getFullPath()))
		{
			return 'file';
		}
		return 'unknown';

	}
  
  public function getAdaptedFullPath($replacements)
  {
    if (is_array($replacements))
    {
      return preg_replace(array_keys($replacements), $replacements, $this->getFullPath());
    }
    else
    {
      return $this->getFullPath();  
    }
  }

  /**
   * Get the username of the owner of the file.
   * 
   * @return     string
   */
	public function getOwner()
	{
		$command='stat -c %U' . sprintf(' "%s"', $this->getFullPath());
		$user=$this->executeCommand($command);
		return $user;
  }
  
  /**
   * Prepare the delivery of the file.
   * 
   * @param      sfWebResponse $response the HTTP Response object
   * @param      boolean $attachment whether the file should be delivered as an attachment
	 * @return     BasicFile The current object (for fluent API support)
	 */
  public function prepareDelivery(sfWebResponse $response, $attachment=true)
  {
		$response->setHttpHeader('Pragma', '');
		$response->setHttpHeader('Cache-Control', '');
		$response->setHttpHeader('Content-Length', $this->getSize());
		$response->setHttpHeader('Content-Type', $this->getMimeType());
    if ($attachment)
    {
      $response->setHttpHeader('Content-Disposition', 'attachment; filename="' . html_entity_decode($this->getDeliveryName(), ENT_QUOTES, 'UTF-8') . '"');
    }

		$tmpfile=fopen($this->getPathName(), 'r');

		$response->setContent(fread($tmpfile, $this->getSize()));
    fclose($tmpfile);
    return $this;
  
  }
  
	/**
	 * Set the value of [deliveryName].
	 * 
	 * @param      string $v new value
	 * @return     BasicFile The current object (for fluent API support)
	 */
  public function setDeliveryName($name)
  {
    $this->_deliveryName = $name;
    return $this;
  }
  
  /**
   * Get the [deliveryName] value.
   * 
   * @return     string
   */
  public function getDeliveryName()
  {
    return $this->_deliveryName=='' ? $this->getBasename() : $this->_deliveryName;
    
  }

}

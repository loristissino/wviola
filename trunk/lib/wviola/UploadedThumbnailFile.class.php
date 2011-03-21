<?php

/*
 * This file is part of the wviola package.
 * (c) 2009-2010 Loris Tissino <loris.tissino@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class that represents a thumbnail file.
 *
 * @package    wviola
 * @subpackage files
 * @author     Loris Tissino <loris.tissino@gmail.com>
 */
class UploadedThumbnailFile extends BasicFile
{

  public function __construct(sfValidatedFile $thumbnail)
  {
    parent::__construct($thumbnail->getTempName());
    
    list(
      $this->_width,
      $this->_height,
      $this->_type,
      $this->_attr)
      = getimagesize($this->getFullPath());

  }
  public function getWidth()
  {
    return $this->_width;
  }
  public function getHeight()
  {
    return $this->_height;
  }

}
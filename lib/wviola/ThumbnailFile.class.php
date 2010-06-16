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
class ThumbnailFile extends AssetFile
{

	const
		EXTENSION = 'jpeg';
	
	public function __construct($uniqid)
	{
		parent::__construct($uniqid, self::EXTENSION, true);
	}
	
	public function getAssetType()
	{
		return 'thumbnail';
	}
	
	public function getMimeType()
	{
		return 'image/jpeg';
	}
	
	public function getStandardExtension()
	{
		return self::EXTENSION;
	}

}
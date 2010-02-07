<?php

class Video
{

	private $_path;
	private $_slug;
	private $_filename;
	private $_stat;
	
	public function __construct($slug)
	{
		$settings=sfYaml::load(sfConfig::get('sf_config_dir').'/wviola.yml');
		$this->setSlug($slug);
		$this->_setPath($settings['directory']['published']);
		$this->_setFilename($this->_getPath() . '/' . $this->getSlug() . '.flv');
		$this->_stat=@stat($this->getFilename());
		
		if (!$this->_stat)
		{
			throw new Exception(sprintf('Not a valid file: %s', $this->getFilename()));
		}
	}

	public function setSlug($v)
	{
		$this->_slug=$v;
		return $this;
	}

	public function getSlug()
	{
		return $this->_slug;
	}

	private function _setFilename($v)
	{
		$this->_filename=$v;
		return $this;
	}

	public function getFilename()
	{
		return $this->_filename;
	}
	
	private function _setPath($v)
	{
		$this->_path=$v;
		return $this;
	}

	private function _getPath()
	{
		return $this->_path;
	}
	
	public function getVideoSize()
	{
		return $this->_stat['size'];
	}
	

}
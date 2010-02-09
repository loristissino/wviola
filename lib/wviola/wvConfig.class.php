<?php

class wvConfig
{
	const CONFIG_FILE = 'wviola.yml';
	
	protected static
		$config = Array();

	private static function _setup()
	{
		if (self::$config)
		{
			return;
		}
		$filename=sfConfig::get('sf_config_dir') . '/' . self::CONFIG_FILE;
		if (!is_readable($filename))
		{
			throw new Exception('Config file '. $filename . ' not readable');
		}
		$config=sfYaml::load($filename);
		foreach($config as $key=>$value)
		{
			if (is_array($value))
			{
				foreach($value as $subkey=>$subvalue)
				{
					self::$config[$key . '_' . $subkey]=$subvalue;
				}
			}
			else
			{
				self::$config[$key]=$value;
			}
		}
	}
	
	public static function get($name, $default = '')
	{
		self::_setup();
		return isset(self::$config[$name]) ? self::$config[$name] : $default;
	}

	public static function has($name)
	{
		self::_setup();
		return array_key_exists($name, self::$config);
	}
	
	public static function set($name, $value)
	{
		self::_setup();
		self::$config[$name] = $value;
	}
	
	public static function add($parameters = array())
	{
		self::_setup();
		self::$config = array_merge(self::$config, $parameters);		
	}

	public static function getAll()
	{
		self::_setup();
		return self::$config;
	}
	
}
<?php 
class Generic{
	
	
	public static function return_bytes($val)
	{
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}
	
	public static function int_int_divide($x, $y) 
	{
		return ($x - ($x % $y)) / $y;
	}
  
  public static function getHumanReadableSize($bytes) 
  {
    if ($bytes < 1024)
    {
      return $bytes . ' B';
    }
    
    $bytes=(float)$bytes;
    $suffixes=array('B','KiB','MiB','GiB','TiB');
    $index=0;
    while($bytes>1024)
    {
      $index++;
      $bytes=$bytes/1024;
    }
    return number_format($bytes, 2) . ' '. $suffixes[$index];
  }
	
	public static function decode($text)
	{
		$text=str_replace('&#039;', "'", $text);
		return html_entity_decode($text);
	}
	
	public static function datetime($date, $context=null)
	{
			
			if ($date===null)
			{
				return null;
			}
			
			$datebegin= self::int_int_divide($date, 86400)*86400;
			
			$difference = time() - $datebegin; 
//			return time() . ' - ' . $datebegin;
			
			if (($difference<86400) && ($difference>0))
				{
					$prefix='Today, ';
					if ($context)
						{
							$prefix=$context->getI18N()->__($prefix);
						}
					return $prefix . date('H:i', $date);
				}
				
			if (($difference < 172800) && ($difference>0))
				{
					$prefix='Yesterday, ';
					if ($context)
						{
							$prefix=$context->getI18N()->__($prefix);
						}
					return $prefix . date('H:i', $date);
				}

			return date('d/m/Y', $date);
		
		}
		
		public static function date_difference_from_now($string)
		{
			// return the number of days of difference from the date expressed as Ymd (20091231)
			
			return floor((time() - mktime(0, 0, 0, substr($string,4,2), substr($string,6,2), substr($string,0,4)))/86400);
		}
		
		public static function date_from_array($array)
		{
			if (@checkdate($array['month'], $array['day'], $array['year']))
				{
					return mktime(0,0,0, $array['month'], $array['day'], $array['year']);
				}
			else
				{
					return null;
				}
		}
		
		static public function transliterate($text)
		{
		  foreach(array(
			'Đ'=>'Dj',
			'ø'=>'o',
			'Ø'=>'O',
			'ü'=>'ue',
			'å'=>'aa',
			) as $key=>$value)
		  {
			$text=str_replace($key, $value, $text);
		  }

		$text = iconv("UTF-8", "US-ASCII//TRANSLIT", $text);
		
		  return $text;
		}

		static public function slugify($text)
		{
		  $text=self::transliterate($text);
		  $text = str_replace(' ', '', $text);
		  $text = strtolower(trim($text, '-'));
		return $text;  
		}
		
		
	static public function strtolower_utf8($string)
	{
		  $convert_to = array(
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
			"v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï",
			"ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
			"з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
			"ь", "э", "ю", "я"
		  );
		  $convert_from = array(
			"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
			"V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï",
			"Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
			"З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
			"Ь", "Э", "Ю", "Я"
		  );

		  return str_replace($convert_from, $convert_to, $string); 
		
		}
		
		static public function transform_bad_diacritics($culture, $text)
		{
			switch($culture)
			{
				case 'it':
					$text=str_replace(array('’', '`'), "'", $text);
				    foreach(array(
						"a'"=>'à',
						"e'"=>'é',
						"i'"=>'ì',
						"o'"=>'ò',
						"u'"=>'ù',
						"A'"=>'À',
						"E'"=>'É',
						"I'"=>'Ì',
						"O'"=>'Ò',
						"U'"=>'Ù',
						) as $key=>$value)
					{
						$text=str_replace($key, $value, $text);
					}
				
					break;
				
				default:
					throw new Exception('invalid culture');
				
			}
			
			return $text;
		}

		static public function clever_ucwords($culture, $text)
		{
			$text = ucwords(Generic::strtolower_utf8(Generic::transform_bad_diacritics($culture, $text)));
			$text=preg_replace_callback("/'[aeiou]/", create_function('$matches', 'return strtoupper($matches[0]);'), $text);
			return $text;
		}
		
		static public function clever_date($culture, $value)
		{
			switch($culture)
			{
				case 'it':
					$format = '%d/%m/%Y';
					break;
				default:
					throw new Exception('invalid culture');
				}
			
				$info=strptime($value, $format);
				
				$date=($info['tm_year']+1900) . '-' . ($info['tm_mon']+1) . '-' . $info['tm_mday'];
				$date_object=date_create($date);
				return $date_object;
		}
		
		
		static public function strip_tags_and_attributes($str, $allowable_tags)
		{
//			$result=preg_replace('/\/U', '?P=tag', $str);
//			echo $str . ' ---> ' . $result . "\n";
			$str=strip_tags($str, $allowable_tags);
//			$str=preg_replace('/\<<tag>([a-z]*).*\>/U', '<P=tag>', $str); 
			$str=preg_replace('/\<([a-z]+)[^\>]*>/', '<\\1>', $str); 
			
			$str=str_replace(
				array(
					'<br>',
					'<hr>', 
				),
				array(
					'<br />', 
					'<hr />'
				), $str);  //this uniforms stand-alone elements 
			return ltrim(rtrim($str));
		}
		
		static public function executeCommand($command, $custom=false)
		{
			if ($custom)
			{
				$command=wvConfig::get('directory_executables') . '/'. $command;
			}
						
			$info=array();
			$result=array();
			$return_var=0;
			
			$command='LANG=it_IT.utf-8; ' . $command;
			// FIXME: this is needed, but it should be more general than it_IT.utf8

      self::logMessage('Generic::executeCommand()', $command . ($custom? ' [custom command]': ''));
			
			exec($command, $result, $return_var);

			if ($return_var!=0)
			{
				throw new Exception('Could not execute command '. $command . ' (got: '. serialize($result) . ')');
			}
			
      self::logMessage('Generic::executeCommand() result', $result);
			
			if (sizeof($result)==1)
			{
				return $result[0];
			}
			return $result;
			
		}
		
		
		
	public static function b64_serialize($var)
	{
		return str_replace('/', '_', base64_encode(serialize($var)));
	}
		
	public static function b64_unserialize($var)
	{
		$text=base64_decode(str_replace('_', '/', $var));
		return unserialize(base64_decode(str_replace('_', '/', $var)));
	}
	
	public static function removeLastCharIf(&$string, $char)
	{
		if (substr($string, -strlen($char))==$char)
		{
			$string=substr($string, 0, strlen($string)-strlen($char));
		}
	}
	
	public static function addFirstCharIfNot(&$string, $char)
	{
		if (substr($string, 0, strlen($char))!=$char)
		{
			$string=$char . $string;
		}
	}
	
	public static function normalizeDirName(&$name)
	{
		Generic::removeLastCharIf($name, '/');
		Generic::addFirstCharIfNot($name, '/');
	}
	
	public static function getCompletePath($maindir, $subdir)
	{
		if($maindir=='/')
		{
			$maindir='';
		}
		Generic::normalizeDirName($subdir);
		$path= $maindir . $subdir;
		Generic::normalizeDirName($path);
		return $path;
		
	}
	
	public static function normalizedBooleanDescription($option)
	{
		return $option? 'true': 'false';
	}
	
	public static function normalizedBooleanValue($v, $default)
	{
		if (in_array(strtoupper($v), array('0', 'NO', 'N', 'FALSE', 'OFF'), true))
		{
			return false;
		}
		elseif (in_array(strtoupper($v), array('1', 'YES', 'Y', 'TRUE', 'ON'), true))
		{
			return true;
		}
		else
		{
			return $default;
		}
	}
  
  static public function str_replace_from_array($replacements, $source)
  {
    foreach($replacements as $key=>$value)
    {
      $source=str_replace($key, $value, $source);
    }
    return $source;
  }
  
  static public function standardizePath($path)
  {
    return self::str_replace_from_array(array(
      '&#039;'=>"'",
      ),
      $path);
  }
  
  static public function getLuceneIndex($name)
  {
    ProjectConfiguration::registerZend();
   
    if (file_exists($index = self::getLuceneIndexFile($name)))
    {
      return Zend_Search_Lucene::open($index);
    }
   
    return Zend_Search_Lucene::create($index);
  }
 
  static public function getLuceneIndexFile($name)
  {
    return sprintf('%s/%s.%s.index',
      wvConfig::get('directory_lucene_index'),
      $name,
      sfConfig::get('sf_environment')
      );
  }


  static public function matchesOneOf($list, $expression)
  {
		foreach($list as $regexp)
		{
			if(preg_match($regexp, $expression))
			{
				return true;
			}
    }
		return false;
  }


  static public function logMessage($section, $content, $file='', $line='')
  {
    if (!wvConfig::get('debug_active'))
    {
      return;
    }
    
    ob_start();
    echo "\n--------- " . $section;
    if($line || $file)
    {
      echo "\n > " . $file . ' (line '. $line . ')';
    }
    echo "\n > " . date('H:i:s') . "\n";
    if($content)
    {
      print_r($content);
    }
    else
    {
      echo "[no content]";
    }
    
    echo "\n";
    $f=fopen(wvConfig::get('directory_logs') .  '/wviolalog.txt', 'a');
    fwrite($f, ob_get_contents());
    fclose($f);
    ob_end_clean();
  }

}
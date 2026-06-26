<?php
class View
{
	private $_path_ = null;
	private $_template_ = null;
	private $_var_ = array();

	public function __construct($path = '')
	{
		$this->_path_ = $path;
	}

	public function set($name, $value)
	{
		if(!in_array($name, array('_var_','_template_','_path_')))
		$this->_var_[$name] = $value;
		else die("Попытка передать в шаблон переменную с недопустимым именем $name!");
	}

	public function __get($name)
	{
		if (isset($this->_var_[$name])) return $this->_var_[$name];
		return '';
	}

	public function display($template, $strip = true)
	{
		if(!$template) die('Шаблон не задан!');
		$this->_template_ = $this->_path_.$template.'.tpl';
		if (!file_exists($this->_template_)) die('Шаблона ' . $this->_template_ . ' не существует!');

		ob_start();
		include($this->_template_);
		return ($strip) ? $this->_strip(ob_get_clean()) : ob_get_clean();
	}

	private function _strip($data)
	{
		$lit = array("\\t", "\\n", "\\n\\r", "\\r\\n", "  ");
		$sp = array('', '', '', '', '');
		return str_replace($lit, $sp, $data);
	}

	public function xss($data)
	{
		if (is_array($data)) {
			$escaped = array();
			foreach ($data as $key => $value) {
				$escaped[$key] = $this->xss($value);
			}
			return $escaped;
		}
		return htmlspecialchars($data, ENT_QUOTES);
	}
}

class Cache
{
	private  $path = null;
	private  $file = null;
	private  $alias = null;
	private  $lifetime = 3600;
	private  $content = array();
	private  $keylifetime = 'lifetime';
	
	public function __construct($path = '')
	{
		$this->path = $path;
	}
	
	public function init($content = null, $alias = null, $template = null, $lifetime = null)
	{
		$this->alias = $alias != null ? $alias : $this->alias;
		$this->lifetime = $lifetime != null ? $lifetime : $this->lifetime;
		$this->content = $content != null ? $content : $this->content;
		$this->keylifetime = md5('lifetime');
		if (($this->path == null) or ($this->alias == null)) $this->file = null;
		else $this->file = $this->path.'/'.$this->alias.'_'.$template.'.tmp';
	}
	
	public function writeFile($role='a')
	{
		$handle = @fopen($this->file, $role);
		if ($handle) {@fwrite($handle, $this->content); $result = true;}
	    else $result = false;
	    @fclose($handle);
	    return $result;
	}
	
	public function readFile($role='rb')
	{
		if(!file_exists($this->file)) return false;
		$handle = @fopen($this->file, $role);
		if($handle)
		{
			$contents = @fread($handle, filesize($this->file));
			@fclose($handle);
			return $contents;
		}
		else return false;			
	}
	
	public function setCache()
    {
    	$this->content = serialize(array_merge(array($this->keylifetime => (time()+$this->lifetime)), (array)$this->content));
    	$this->writeFile('w');
    	@chmod($this->file, 0666);
		return true;
    }
    
    public function getCache($ignore = false)
    {
		if(!file_exists($this->file)) return false;
		$content = unserialize($this->readFile());
		if($content[$this->keylifetime] < time()) {if($ignore) return $content; else /*unlink($this->file);*/ return false;}
		unset($content[$this->keylifetime]);
		return $content;
    }
}
?>
<?php
/**
 * 静态函数
 * @copyright lsx 2012/09/17
 * @package application.helpers
 */

class Helper
{
	// 获取url中文件的扩展名
	// $url='http://www.sina.com.cn/abc/de/fg.php?id=1';
	public static function getUrlExtension($url)
	{
		$urlinfo=parse_url($url);
		return pathinfo($urlinfo['path'], PATHINFO_EXTENSION);
	}
	
	// 获取路径中文件的扩展名
	// $path='/path/abc/123.inc.php'
	public static function getExtension($path)
	{
		return pathinfo($path, PATHINFO_EXTENSION);
	}
	
	/**
	 * 获取相对路径
	 * @$include string: 引用文件
	 * @$included string: 被引用文件
	 * @return string: 返回$include引用$included时$included的相对路径.
	 * @copyright lsx 2012/09/18
	 * 
	 * $p1 = '/aa/bb/cc/dd/e.php';
	 * $p2 = '/aa/bb/11/22/33/x.php';
	 * echo Helper::getRelativePath($p1, $p2); // 输出: /../../11/22/33/x.php
	 * echo Helper::getRelativePath($p2, $p1); // 输出: /../../../cc/dd/e.php
	 * 
	 * $p1 = '/dd/e.php';
	 * $p2 = '/x.php';
	 * echo Helper::getRelativePath($p1, $p2); // 输出: /../x.php
	 * echo Helper::getRelativePath($p2, $p1); // 输出: /dd/e.php
	 */
	public static function getRelativePath($include, $included)
	{
		// 必要时考虑文件的存在性
		//if(!file_exists($include) || !file_exists($included))
		//	return false;
		
		$include = str_replace('\\', '/', $include);
		$included = str_replace('\\', '/', $included);
		
		$include = ltrim($include, '/');
		$included = ltrim($included, '/');
		
		$include_arr = explode('/', $include);
		$included_arr = explode('/', $included);
		
		// 不考虑最后的文件名
		$include_arr_len = count($include_arr) - 1;
		$included_arr_len = count($included_arr) - 1;
		
		$limit = $include_arr_len < $included_arr_len ? $include_arr_len : $included_arr_len;
		
		for($i=0; $i<$limit; $i++)
		{
			if($include_arr[$i] == $included_arr[$i])
				unset($include_arr[$i], $included_arr[$i]);
			else
				break;
		}
		return str_repeat('/..', (count($include_arr) - 1)) . '/' . implode('/', $included_arr);
	}
	
	// 遍历指定目录下所有文件和子文件夹
	public static function directoryTraverse($path)
	{
		if(!realpath($path) || !is_dir($path))
			return false;
		
		$handle = opendir($path);
		$names = array();
		while(($name=readdir($handle)) !== false)
		{
			$filepath = $path . '/' . $name;
			if($name == '.' || $name == '..' || is_file($filepath))
			{
				$names[] = $name;
			}
			else
			{
				$names[$name] = self::directoryTraverse($filepath);
			}
		}
		closedir($handle);
		return $names;
	}
}

/*
We have so many needs in our life, but ultimately, all we need is to be needed. 

生命中，我们总是有那么多的渴求和需要。然而归根结底，我们最渴求的，不过是被人需要。

*/
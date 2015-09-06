<?php

/**
 * Markdown.
 * @author Daniel
 * @package application.controllers
 * @since 2014/12/09
 */
use Michelf\Markdown;

// 可以放在index.php包含（不推荐，因为用时才应该包含），但不能放在action里包含，
// 也不能在配置文件中用import包含
require_once(Yii::app()->getBasePath().'/vendors/markdown/Michelf/MarkdownInterface.php');
require_once(Yii::app()->getBasePath().'/vendors/markdown/Michelf/Markdown.php');

class MarkdownController extends Controller
{
	public $layout = '//layouts/markdown';
	public $packages = array();
	public $scriptsPath = '';
	
	public function actionIndex()
	{
		// 手册目录的父级目录 - 根目录
		$basePath = $this->pathFix(Yii::app()->getBasePath()) . '/manuals';
		$basePathHtml = $this->pathFix(Yii::app()->getBasePath()) . '/docs';
		
		// 获取根目录下所有md文件，依此取手册目录为手册名
		$options = array(
			'fileTypes'=>array('md'),
		);
		$files = CFileHelper::findFiles($basePath, $options);
		$manualNames = $this->manualNames($basePath, $files);
		
		// 生成手册相关文件
		foreach ($manualNames as $manualName)
		{
			echo "Building manual {$manualName}...<br/>";
			
			// 新建html目录
			$htmlPath = $basePathHtml . '/' . $manualName;
			$this->mkdir($htmlPath);
			
			// 解析md文件
			$sourcePath = $basePath . '/' . $manualName;
			$files = CFileHelper::findFiles($sourcePath,$options);
			
			echo 'Building pages...<br/>';
			foreach ($files as $file)
			{
				$this->scriptsPath = '';
				$pathinfo = $this->pathinfo($sourcePath, $file);
				
				// 创建html文件目录
				if ($pathinfo['parent_dirs_string'] != '')
				{
					$this->mkdirRecurse($htmlPath, $pathinfo['parent_dirs']);
				}
				
				// 保存html文件
				$filename = $pathinfo['filename'];
				$this->pageTitle = iconv('gbk', 'utf-8', $filename);
				$htmlfile = $htmlPath . '/' . $pathinfo['parent_dirs_string'] . $filename . '.html';
				$content = $this->render('index', array('content'=>$this->parse($file)), true);
				file_put_contents($htmlfile, $content);
				
				// 生成chm目录数据
				$this->appendPackageItem($this->packages, $pathinfo['parent_dirs'], $pathinfo['filename'], $pathinfo['parent_dirs_string'] . $filename . '.html');
			}
			
			// 复制脚本文件
			CFileHelper::copyDirectory($sourcePath . '/css', $htmlPath . '/css');
			CFileHelper::copyDirectory($sourcePath . '/js', $htmlPath . '/js');
			
			echo 'Building chm...<br/>';
			
			$this->sortPackages($this->packages);
			$this->hhp($htmlPath, $manualName);
			$this->hhc($htmlPath, $manualName);
			$this->hhk($htmlPath, $manualName);
			$this->packages = array();
		}
		
		echo 'Done!';
	}
	
	private function pathFix($path)
	{
		return str_replace('\\', '/', $path);
	}
	
	private function pathinfo($sourcePath, $file)
	{
		$file = str_replace('\\', '/', $file);
		$text = substr($file, strlen($sourcePath) + 1);
		
		if (strpos($text, '/') !== false)
		{
			$d = explode('/', $text);
			$basename = array_pop($d);
			$parent_dirs = $d;
		}
		else
		{
			$basename = $text;
			$parent_dirs = null;
		}
		$dd = explode('.', $basename);
		
		return array(
			'dirname'=>$sourcePath,
			'basename'=>$basename,
			'extension'=>$dd[1],
			'filename'=>$dd[0],
			'parent_dirs'=>$parent_dirs,
			'parent_dirs_string'=>is_array($parent_dirs) ? implode('/', $parent_dirs) . '/' : '',
		);
	}
	
	private function manualNames($basePath, $files)
	{
		$manualNames = array();
		foreach ($files as $file)
		{
			$file = $this->pathFix($file);
			$text = substr($file, strlen($basePath) + 1);
			$d = explode('/', $text);
			$manualName = $d[0];
			if (array_search($manualName, $manualNames) === false)
			{
				$manualNames[] = $manualName;
			}
		}
		return $manualNames;
	}
	
	private function mkdirRecurse($htmlPath, $dirs)
	{
		$dir_path = '';
		foreach ($dirs as $dir)
		{
			$dir_path .= '/' . $dir;
			$path = $htmlPath . $dir_path;
			$this->mkdir($path);
			$this->scriptsPath .= '../';
		}
	}
	
	private function mkdir($path)
	{
		if (!file_exists($path))
		{
			mkdir($path, 0777);
		}
	}
	
	private function parse($file)
	{
		$content = file_get_contents($file);
		return Markdown::defaultTransform($content);
	}
	
	private function appendPackageItem(&$packages, $dirs, $name, $local)
	{
		$key = '';
		if (is_array($dirs))
		{
			foreach ($dirs as $dir)
			{
				$key .= "['{$dir}']";
				
				if (!eval("return isset(\$packages{$key});"))
				{
					$s_s = "\$packages{$key}=array();";
					eval($s_s);
				}
			}
		}
		eval("\$packages{$key}['{$local}']='{$name}';");
	}
	
	private function sortPackages(&$packages)
	{
		ksort($packages);
		uasort($packages, array($this, 'sortCompare'));
		foreach ($packages as &$items)
		{
			if (is_array($items))
			{
				$this->sortPackages($items);
			}
		}
		$packages = array_reverse($packages, true);
	}
	private function sortCompare($a, $b)
	{
		if (is_string($a) && is_string($b))
		{
			return $a < $b;
		}
		return is_string($a);
	}
	
	public function renderPackagesRecurse($package, $space='')
	{
		$html = '';
		
		foreach ($package as $name=>$item)
		{
			if (is_array($item))
			{
				$space .= str_repeat(' ', 4);
				$html .= "\n{$space}" . '<li><object type="text/sitemap">
	'.$space.'<param name="Name" value="' . $name . '">
	'.$space.'</object>
'.$space.'<ul>';
				$html .= $this->renderPackagesRecurse($item, $space);
				$html .= "\n{$space}" . '</ul>';
				
			}
			else
			{
				$html .= "\n{$space}" . '<li><object type="text/sitemap">
	'.$space.'<param name="Name" value="' . $item . '">
	'.$space.'<param name="Local" value="' . $name . '">
	'.$space.'</object>';
			}
		}
		
		return $html;
	}
	
	private function hhp($htmlPath, $manualName)
	{
		$content = $this->render('chmProject', array('manualName'=>$manualName), true);
		file_put_contents($htmlPath . '/' . $manualName . '.hhp', $content);
	}
	
	private function hhc($htmlPath, $manualName)
	{
		$content = $this->render('chmContents', null, true);
		file_put_contents($htmlPath . '/' . $manualName . '.hhc', $content);
	}
	
	private function hhk($htmlPath, $manualName)
	{
		$content = $this->render('chmIndex', null, true);
		file_put_contents($htmlPath . '/' . $manualName . '.hhk', $content);
	}
}
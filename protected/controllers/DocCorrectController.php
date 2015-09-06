<?php

/**
 * 修正需要文档化的库文件以便文档化.
 * @author Daniel
 * @package application.controllers
 * @since 2014/12/06
 */

class DocCorrectController extends Controller
{
	/**
	 * 修正项目库文件.
	 */
	public function actionEcshop()
	{
		// 需要文档化的库文件根目录
		$path = Yii::app()->basePath . '\ecshop';
		
		// 文档化文件选择配置
		$options = array(
			'fileTypes'=>array('php'),
			'exclude'=>array(
				
			),
		);
		
		// 根据配置在指定目录找文件
		$files = CFileHelper::findFiles($path,$options);
		//D::pde($files);
		
		// 删掉影响文档化的非必要代码
		foreach ($files as $file)
		{
			$modified = false;
			$content = file_get_contents($file);
			
			// 非法访问检查代码
			$pattern = '/if\s*\(!defined\(\'IN_ECS\'\)\)\s*{\s*die\(\'Hacking\s*attempt\'\);\s*}/';
			if (preg_match($pattern, $content))
			{
				$content = preg_replace($pattern, '', $content);
				$modified = true;
			}
			
			// 字符集设置代码
			$pattern = '/if\s*\(!defined\(\'EC_CHARSET\'\)\)\s*{\s*define\(\'EC_CHARSET\',\s*\'utf-8\'\);\s*}/';
			if (preg_match($pattern, $content))
			{
				$content = preg_replace($pattern, '', $content);
				$modified = true;
			}
			
			// 函数包添加类定义
			if (strpos($file, 'lib_') !== false)
			{
				$className = pathinfo($file, PATHINFO_FILENAME);
				$insert = "\nclass {$className}\n{";
				if (strpos($content, $insert) === false)
				{
					$pos = strpos($content, '*/') + 2;
					$content = substr($content, 0, $pos) . $insert . rtrim(substr($content, $pos), "\n?>") . "\n\n}";
					$modified = true;
				}
			}
			
			if ($modified)
			{
				file_put_contents($file, $content);
			}
		}
		
		// 包含文件，以判断类定义是否合法
		$files = CFileHelper::findFiles($path,$options);
		foreach ($files as $index=>$file)
		{
			D::pd($file);
			require_once $file;
		}
		D::pd('done');
	}
}
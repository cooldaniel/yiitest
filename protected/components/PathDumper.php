<?php
/**
 * PathDumper class file.
 * @version 2011.05.26
 * @author lsx.
 * 
 * PathDumper是一个目录迭代遍历辅助工具类,用来遍历目录,而更重要的是基于获取的目录信息个性化定制自己需要的目录文件信息.
 * 例如,使用<ul/>打印目录树,获取指定特定的文件名等.
 * 
 * 该类的第一版{@version 2011.05.26}只是粗略的体现了以上意图,实际实现应该进一步完善.
 */
class PathDumper
{
	public $tagName='ul';
	public $itemTagName='li';
	public $htmlOptions=array('class'=>'dir');
	public $itemHtmlOptions=array('class'=>'');
	
	//要忽略的目录.
	public $dirToIgnore=array();
	//要保留的文件的扩展名.
	public $fileToKeep=array();
	
	private $_rdi;
	private $_files=array();
	private $_filesEx=array();
	
	//基于给定目录创建一个RecursiveDirectoryIterator对象.
	public function __construct($path)
	{
		$this->_rdi=new RecursiveDirectoryIterator($path);
	}
	
	public function registerClientScript()
	{
		$js=<<<EOD
jQuery(document).ready(function(){
	jQuery('#some ul li').toggle(function(){
		jQuery(this).children('ul').slideUp();
	},function(){
		jQuery(this).children('ul').slideDown();
	});
});
EOD;
		echo '<script type="text/javascript">'.$js.'</script>';
		
		$css='<style type="text/css">
/*ul.dir, ul.dir *{border:1px solid red; margin:3px;}*/
/*ul.dir{list-style:none; margin:0; padding:0;}*/
</style>';
		echo $css;
	}
	
	//显示目录树.
	public function dump()
	{
		$this->registerClientScript();
		$this->display($this->_rdi);
	}
	
	//显示目录树的真正方法.
	public function display($rdi,$p='')
	{
		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		foreach($rdi as $item)
		{
			if($item->isDir())
			{
				if(!in_array($item->getFileName(),$this->dirToIgnore))
				{
					//因为是直接输出所以不采用CHtml::tag('tagName')连缀的方式.
					//要使用链坠需要修改直接输出为字符串连接返回的方式.
					echo CHtml::openTag($this->itemTagName,$this->itemHtmlOptions);
					echo CHtml::link($item->getFileName().'(dir)','',array())."\n";
					if($rdi->hasChildren())
						$this->display($rdi->getChildren(),$p.'/'.$item->getFileName());
					echo CHtml::closeTag($this->itemTagName)."\n";
				}
			}
			else
			{
				if(in_array(pathinfo($item->getFileName(),PATHINFO_EXTENSION),$this->fileToKeep)||empty($this->fileToKeep))
				{
					echo CHtml::tag($this->itemTagName,array(),$item->getFileName())."\n";
					$this->_files[$item->getFileName()]=$item->getFileName();
					$this->_filesEx[$item->getFileName()]=$p.'/'.$item->getFileName();
				}
			}
		}
		echo CHtml::closeTag($this->tagName)."\n";
	}
	
	//显示文件名.
	public function files($sort=true)
	{
		sort($this->_files);
		foreach($this->_files as $file)
			echo $file."<br/>\n";
	}
	
	//带路径和后缀的文件名.
	public function filesEx($sort=true)
	{
		sort($this->_filesEx);
		foreach($this->_filesEx as $file)
			echo ltrim($file,'/')."<br/>\n";
	}
	
	public function filesArray()
	{
		sort($this->_filesEx);
		echo "array(<br/>\n";
		foreach($this->_filesEx as $file)
			echo '$basePath."/'.ltrim($file,'/')."\",<br/>\n";
		echo ")<br/>\n";
		
	}
}
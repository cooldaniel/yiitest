<?php
/**
 * CodeFormatView类文件
 * @version 2011.03.07
 * @since 1.0.0
 */

/**
 * @todo 最好可以控制区域是否默认关闭.
 */

/**
 * CodeFormatView主要用来方便调试代码
 */
class CodeFormatView extends CWidget
{
	/**
	 * @var string widget资源根目录
	 */
	public $baseScriptUrl;
	/**
	 * @var string 外部引用css文件
	 */
	public $cssFile;
	//@var string 调试文件路径
	/**
	 * @var string widget资源根目录
	 */
	public $file;
	/**
	 * @var string 调试文件代码执行后结果内容
	 */
	public $content;
	/**
	 * @var string 代码调试区<fieldset>元素的class属性
	 */
	public $shellClass='cfv_shell';
	/**
	 * @var string 内容项class属性
	 */
	public $itemClass='cfv_item';
	/**
	 * @var string 内容项标题class属性
	 */
	public $itemTitleClass='cfv_item_title';
	/**
	 * @var string 内容项内容区class属性
	 */
	public $itemContentClass='cfv_item_content';
	/**
	 * @var string <fieldset>元素的<legend>说明文本
	 */
	public $legend='template';
	/**
	 * @var boolean 是否默认关闭代码调试区
	 */
	public $defaultClose=true;
	/**
	 * @var boolean 使用滑动效果时点击的位置
	 */
	public $clickLegend=true;
	/**
	 * @var boolean 是否渲染html部分
	 */
	public $renderHtml=true;
	/**
	 * @var boolean 是否渲染code部分
	 */
	public $renderCode=true;
	
	private static $_counter=0;
	
	/**
	 * 初始化当前widget.
	 * 设置了widget资源根目录,以及应用css文件.
	 */
	public function init()
	{
		if($this->baseScriptUrl===null)
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets.assets')).'/codeformatview';
		
		if($this->cssFile!==false)
		{
			if($this->cssFile===null)
				$this->cssFile=$this->baseScriptUrl.'/styles.css';
			Yii::app()->getClientScript()->registerCssFile($this->cssFile);
		}
	}
	
	/**
	 * 运行当前widget组件对象.
	 * 注册客户端js脚本 {@see registerClientScript} 以及渲染widget内容 {@see renderContent()}
	 * 注意:CodeFormatView组件集成自CWidget,在CWidget及其之前的类树种没有renderContetn()方法,
	 * 而如果改继承CBaseListView类的话,要注意其中定义了renderContent()方法以及了解其子类写法.
	 */
	public function run()
	{
		$this->renderContent();
		$this->registerClientScript();
	}
	
	/**
	 * 注册客户端js脚本.
	 */
	public function registerClientScript()
	{
		//元素id
		$id=$this->getId();
		//js
		//调试区
		$options=array(
			'defaultClose'=>$this->defaultClose,
			'clickLegend'=>$this->clickLegend
		);
		$options=CJavaScript::encode($options);
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->baseScriptUrl.'/jquery.codeformatview.js');
		$cs->registerScript(__CLASS__.'#'.$id,"jQuery('#$id').codeFormatView($options);");
		for($i=0;$i<self::$_counter;$i++)
		{
			$options=array(
				'defaultClose'=>$i!=self::$_counter-1 //对默认排在最后一位的result内容项默认显示其内容
			);
			$options=CJavaScript::encode($options);
			$_id=$id.'_i'.$i;
			$cs->registerScript(__CLASS__.'#'.$_id,"jQuery('#$_id').codeFormatView($options)");
		}
		//重新初始化计数器
		self::$_counter=0;
	}
	
	/**
	 * 渲染code format widget内容.
	 */
	public function renderContent()
	{
		$itemHtml=$this->renderCode().$this->renderHtml().$this->renderResult();
		echo '<fieldset class="'.$this->shellClass.'" id="'.$this->getId().'"><legend class="'.$this->itemTitleClass.
		'">'.$this->legend.'</legend><div class="'.$this->itemContentClass.'">'.$itemHtml.'</div></fieldset>';
	}
	
	/**
	 * 渲染默认的code项.
	 * @return string 默认code项的HTML代码.
	 */
	public function renderCode()
	{
		if($this->renderCode)
		{
			//获取文件内容
			$c=file_get_contents($this->file);
			$c=preg_replace('/\s*\<\?php\s*ob_start\(\);\s*\?\>\s*/','',$c);
			$c=preg_replace('/\s*\<\?php\s*\$this-\>widget(?:[\s\S]*?)CodeFormatView(?:[\s\S]*?)\?\>\s*/','',$c);
			$c=highlight_string($c,true);
			//去除<br/>换行元素
			//$c=preg_replace('/\<br\s*\/\>/','',$c);
			return $this->renderItem('code',$c);
		}
	}
	
	/**
	 * 渲染默认的html项.
	 * @return string 默认html项的HTML代码.
	 */
	public function renderHtml()
	{
		if($this->renderHtml)
		{
			$html=$this->content;
			//$html=nl2br($html);
			$html=htmlspecialchars($html);
			$html='<pre>'.$html.'</pre>';
			//$html='<code>'.$html.'</code>';
			return $this->renderItem('html',$html);
		}
	}
	
	/**
	 * 渲染默认的result项.
	 * @return string 默认result项的HTML代码.
	 */
	public function renderResult()
	{
		return $this->renderItem('result',$this->content,false);
	}
	
	/**
	 * 渲染内容项.
	 * @param string 内容项标题.
	 * @param string内容项内容.
	 * @return string 内容项的HTML代码.
	 */
	public function renderItem($itemTitle,$itemContent)
	{
		$html='<div id="'.$this->getId().'_i'.self::$_counter.'" class="cfv_item">
			<div class="'.$this->itemTitleClass.'">'.$itemTitle.'</div>
			<div class="'.$this->itemContentClass.'">'.$itemContent.'</div>
		</div>';
		self::$_counter++;
		return $html;
	}
	
	/**
	 * 设置<legend>文本.
	 */
	public function setLegend($value)
	{
		$this->legend=(string)$value;
	}
}
?>
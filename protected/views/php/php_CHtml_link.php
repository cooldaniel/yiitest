<?php ob_start(); ?>
<?php
//普通链接
$text='百度'; //链接的显示文本
$url='http://www.baidu.com/'; //链接的地址
$htmlOptions=array( //链接的HTML属性
	'title'=>'点击链接到百度',
	'target'=>'_blank',
	'confirm'=>'确定打开链接?', //在普通的链接上用js提供了一种友好的确认提示
	//可以使用参数ajax构建ajax类型的链接,但是更适合的是 {@see ajaxLink}
);
echo CHtml::link($text,$url,$htmlOptions);

echo '<br/>';

//ajax链接
$text='百度'; //链接的显示文本
$url=$this->createUrl('script/ajaxResponse'); //ajax请求的url
$ajaxOptions=array( //ajax参数
	'data'=>'id=id',
	'beforeSend'=>'function(){alert("ajax request before send")}', //1
	'complete'=>'function(){alert("ajax request complete")}', //3
	'error'=>'function(){alert("ajax request error")}', //2
	/**
	 * 以下三个选项用于处理ajax请求返回结果
	 * success: 提供一段JavaScript代码来处理ajax请求返回结果,可以达到最灵活的处理,它存在时,update和replace都被忽略.
	 * update: 内容将被ajax请求返回结果替换的HTML元素的标识,可以是任何通过jQuery()函数可以用来获取元素的字符串.
	 * 如果没有success项则启用,启用时会将启用结果用作对success的替换.
	 * replace: 将被ajax请求返回结果替换的HTML元素的标识,可以是任何通过jQuery()函数可以用来获取元素的字符串.
	 * 如果没有success项则启用,启用时会将启用结果用作对success的替换.
	 */
	//'success'=>'function(response){alert("ajax request success with response: "+response)}', //2
	'update'=>'#update',
	//'replace'=>'#replace'
);
$htmlOptions=array( //链接的HTML属性
	'title'=>'点击获取ajax响应',
	'confirm'=>'您确定发送ajax请求?',
	//'submit'=>'', //存在则提交到此页面,
	//'ajax'=>array() //这里的ajax选项将被$ajaxOptions替代,构建ajaxLink是不需要这个参数
);
echo CHtml::ajaxLink($text,$url,$ajaxOptions,$htmlOptions);

//具体的链接构建方式请参考 {@see CHtml::tag} 和 {@see CHtml::clientChange}
?>
<div id="update" onclick="alert(this.id)">ajax结果更新区域,只更新其内容</div>
<div id="replace" onclick="alert(this.id)">ajax结果替换区域,整个区域都被替换,替换后不存在id为replace的div</div>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'legend'=>'CHtml::ajaxLink'
));
?>









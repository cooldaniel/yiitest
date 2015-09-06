<?php
/** 
 * jQuery ajax字符集测试.
 * 在使用jQuery ajax的GET方式提交中文时会因为字符集更改而在服务器端需要编码转换.
 * 有人说是因为GET提交会经过urlencode,未经证实.也有人说是因为服务器端程序和客户
 * 端页面编码不同导致(实际测试使用相同编码也出现了该错误).
 * 不管是什么原因,这里分别对GET和POST方式进行了测试,而POST方式则不会改变编码.
 * @version 2011.07.14
 * @author lsx
 */
?>

<?php ob_start(); ?>
<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');

//js
$getUrl=$this->createUrl('js/ajaxCommunicateGet');
$postUrl=$this->createUrl('js/ajaxCommunicatePost');
$js=<<<EOD
;(function($){
	//trigger by input
	$('#post_field').bind('change',function(){
		ajaxCommunicatePost('name='+this.value,'{$postUrl}');
	});
	//trigger by input
	$('#get_field').bind('change',function(){
		ajaxCommunicateGet('name='+this.value,'{$getUrl}');
	});
	//ajax by post
	function ajaxCommunicatePost(data,url){
		$.ajax({
			type:'POST',
			data:data,
			url:url,
			success:function(response){
				alert(response);
			},
			error:function(XHR){
				alert(XHR.responseText);
			}
		});
	};
	//ajax by get
	function ajaxCommunicateGet(data,url){
		$.ajax({
			type:'GET',
			data:data,
			url:url,
			success:function(response){
				alert(response);
			},
			error:function(XHR){
				alert(XHR.responseText);
			}
		});
	};
})(jQuery);
EOD;
$cs->registerScript('default',$js);
?>

By <em>GET</em> <input type="text" id="get_field" />
BY <em>POST</em> <input type="text" id="post_field" />

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'renderHtml'=>false,
	'legend'=>'charset test'
));
?>
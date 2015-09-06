<?php
/** 
 * jQuery ajax find filter测试
 * 
 * @version 2011.07.14
 * @author lsx
 */

/**
 * 总结
 * 1.find和filter都能从完整的html文件中检索出需要的元素.
 * 2.filter检索一组满足指定条件的元素,营造了一个缩小的范围.
 * 3.find检索精确匹配.
 * @version 2011.07.14
 * 在以下条件下find和filter依然能够正常工作:
 * 1.在不破坏被检索的元素条件下,该元素外部其它地方存在交错嵌套的HTML元素.
 * 2.在不破坏被检索的元素条件下,该元素外部其它地方存在不完整的HTML元素.
 * 3.在不破坏被检索的元素条件下,该元素内部其它地方存在交错嵌套的HTML元素.
 * 4.在不破坏被检索的元素条件下,该元素内部其它地方存在不完整的HTML元素.
 * 5.在破坏被检索的元素条件下(成对闭合标签未闭合),该元素内部或外部存在交错嵌套或不完整的HTML元素.
 * 综上,HTML元素的完整性与其能否被检索相互独立,理由如下:
 * (1)HTML成对闭合标签未闭合表示该开始标签之后的所有内容都在该标签之内,未成对闭合不表示该标签无效.
 * (2)既然可以确定目标HTML标签存在,就可以使用find和filter进行获取.
 * @version 2011.08.19
 */
?>

<?php ob_start(); ?>
<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');

//js
$url=$this->createUrl('js/ajaxReload');
$js=<<<EOD
;(function($){
	$('#reload_button').bind('click',function(){
		ajaxReload('{$url}');
	});
	function ajaxReload(url){
		$.ajax({
			type:'POST',
			url:url,
			success:function(response){
				//alert(response);
				//by find, it works
				$('#list_1').replaceWith($(response).find('#list_1'));
				//by find and filter, also works
				//$('#list_1').replaceWith($(response).find('ul').filter('#list_1'));
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

<input type="button" id="reload_button" value="reload" />

<?php $this->renderPartial('fragements/list_1'); ?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'renderHtml'=>false,
	'legend'=>'jquery_ajax_find_filter'
));
?>
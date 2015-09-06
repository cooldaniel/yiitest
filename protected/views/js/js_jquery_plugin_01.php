<?php
/**
 * 可外置的jQuery插件示例及分析.
 * 
 * 此插件设计与调用原理见实例的(1),(2),(3),(4),(5),(6)步骤说明.
 */
?>

<?php ob_start(); ?>
<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
?>
<script type="text/javascript">
/**
 * 可外置的jQuery插件函数定义脚本.
 */
;(function($){
	$.fn.myPlugin=function(){
		//(4)在插件方法中使用jQuery.each()来使得在each()指定的函数中可以通过this.id来获得HTML结构对象的id,从而把握了整个HTML结构.
		return $(this).each(function(options){
			var settings=$.extend({},$.fn.myPlugin.defaults,options||{});
			var id=$(this).attr('id');
			//保存配置以便在整个插件环境都可以通过$.fn.myPlugin.settings来使用
			//注意:这里通过id来标识分组,因为这个组件可复用,而后续在额外定义函数中应该使用此id来访问特定配置.
			$.fn.myPlugin.settings[id]=settings;
			//(5)基于HTML结构来控制该结构内部的元素(要求该结构是个良好的结构)
			var alwaysCheckedClass=settings.alwaysCheckedClass;
			//仅对非alwaysCheckedClass标识的li应用"鼠标经过更换颜色"、"隐藏内容显示"效果
			$('#'+id+' li').hover(function(){
				if(this.className!=alwaysCheckedClass){
					$(this).css('color','red');
				}
				$(this).children('span').eq(0).show();
			},function(){
				if(this.className!=alwaysCheckedClass){
					$(this).css('color','inherit');
				}
				$(this).children('span').eq(0).hide();
			});
			//(6)事件触发调用其它预定函数,在这些函数中将使用上面保存的配置数据.
			$('#'+id+' li span').live('click',function(){
				$.fn.myPlugin.someApp(id,'some content');
			});
		});
	};
	
	/**
	 * 用在插件和HTML中的配置.
	 * - alwaysCheckedClass: 总是选中的li的class名称
	 */
	$.fn.myPlugin.defaults={
		alwaysCheckedClass:'checked',
	};
	
	/**
	 * 用于保存初始配置的属性.
	 */
	$.fn.myPlugin.settings={};
	
	//@return string 返回插件的全名.
	$.fn.myPlugin.name=function(){
		return '$.fn.myPlugin';
	};
	
	/**
	 * 返回某些由服务器端脚本在构建HTML结构对象时渲染的额外数据.
	 */
	$.fn.myPlugin.someDynamic=function(id){
		return $('#'+id+' li.hidden > input').val();
	};
	
	//额外的使用$.fn.myPlugin.settings配置的例子函数.
	$.fn.myPlugin.someApp=function(id,content){
		alert('The class "alwaysCheckedClass" kept in "'+$.fn.myPlugin.name()+'" is: '+$.fn.myPlugin.settings[id].alwaysCheckedClass);
		alert('And the content passed to this function is : '+content);
		alert('And this is the id of the HTML structure: '+id);
		alert('And this is some content generated dynamicly: '+$.fn.myPlugin.someDynamic(id));
		alert('By $.fn.myPlugin.someApp()');
	}
})(jQuery);
</script>

<style type="text/css">
/**
 * 可外置的专用于该HTML结构和插件的css样式定义.
 */
li.checked{color:blue;}
li span.additional-content{display:none; color:#F6C; margin:auto 1em; position:relative;}
</style>

<?php
//(1)在php代码里确定元素id
$id='list_'.rand();
//(2)将id传递给HTML结构对象
?>
<ul id="<?php echo $id; ?>">
	<li class="hidden" style="display:none"><input type="text" value="<?php echo rand(); ?>" /></li>
	<li>one<span class="additional-content">about one</span></li>
    <li class="checked">two<span class="additional-content">about two</span></li>
    <li>three<span class="additional-content">about three</span></li>
</ul>
<?php
//(3)将id用在js中调用插件方法(在这里调用插件),调用时可传递额外的参数
$options=array(
	'alwaysCheckedClass'=>'node-checked',
);
$options=CJSON::encode($options);
$js=<<<EOD
$('#{$id}').myPlugin('{$options}');
EOD;
$cs->registerScript(rand(),$js);
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	//'renderHtml'=>false,
	'renderCode'=>false,
	'legend'=>'jquery plugin'
));
?>
<?php ob_start(); ?>
<?php
//$assetsUrl=Yii::app()->baseUrl.DIRECTORY_SEPARATOR.'normalassets'.DIRECTORY_SEPARATOR;
$assetsUrl=Yii::app()->baseUrl.'/normalassets/';
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($assetsUrl.'jQuery.plugins.default.js');
$cs->registerScriptFile($assetsUrl.'common.func.js');
$cs->registerScriptFile($assetsUrl.'default.js');

//js
$ajax=$this->createAbsoluteUrl('js/ajaxResponse');
$ajax=$this->createUrl('js/ajaxResponse');
$process='var process=function(response){alert(response)}; process(response);';
$process='kkk(response)';
$options=array(
	'url'=>$ajax,
	'debug'=>true,
	'process'=>$process,
	'event'=>'click'
);
$options=CJSON::encode($options);
$js=<<<EOD
//jQuery插件方式
jQuery('#btn').fetch($options);
//公共函数方式
jQuery('#btn2').click(function(){fetch($options)});
EOD;
$cs->registerScript('default',$js);

?>

<input type="button" name="btn" id="btn" value="jQuery.plugin" />
<input type="button" name="btn" id="btn2" value="common.func" />
<img src="<?php echo $assetsUrl.'1.png'; ?>" />
<div id="append">append...</div>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'renderHtml'=>false,
	'legend'=>'simple'
));
?>
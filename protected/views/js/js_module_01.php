<?php
/**
 * 使用model形式的Javascript设计测试.
 * @version 2011.03.19
 * @author lsx
 */
?>

<?php ob_start(); ?>

<?php
$assetManager=Yii::app()->assetManager;
$assetManager->publish(Yii::getPathOfAlias('application.views.assets'));
$assetUrl=$assetManager->getPublishedUrl(Yii::getPathOfAlias('application.views.assets'));
$scriptBaseUrl=$assetUrl.'/js/';
$cs=Yii::app()->clientScript;
$cs->registerScriptFile($scriptBaseUrl.'site.js');
$cs->registerScriptFile($scriptBaseUrl.'module1.js');
?>

<script type="text/javascript">
//调用module中定义的成员
site.m.property_1='property_1 assigned by public.';
site.m.function_1('call function_1 publicly.');
</script>
<div class="click" title="click test">click test</div>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'JavaScript module 01',
	'renderHtml'=>true
));
?>
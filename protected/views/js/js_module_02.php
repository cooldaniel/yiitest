<?php ob_start(); ?>

<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
?>



<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'JavaScript module 01',
	'renderHtml'=>true
));
?>
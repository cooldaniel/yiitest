<?php ob_start(); ?>
<?php
D::pd($this->createUrl('admin/default/index'));
D::pd(Yii::app()->createUrl('admin/default/index'));
D::pd(Yii::app()->urlManager->createUrl('admin/default/index'));
?>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'renderHtml'=>false,
	'legend'=>'createUrl'
));
?>
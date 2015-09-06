<?php
/**
 * page state表示同一页面需要循环传递的数据,这里借助post表单来实现.
 * @version 2011.07.21
 * @author lsx
 */
?>

<?php ob_start(); ?>
<?php
$this->pageTitle='Stateful form';
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'CForm'
));
?>
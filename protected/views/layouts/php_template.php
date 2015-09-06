<?php ob_start(); ?>
<?php

?>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	//'renderHtml'=>false,
	'renderCode'=>false,
	'legend'=>'template'
));
?>








<?php ob_start(); ?>
<?php
//test D class
$data=array(
	'one'=>range(1,3),
	'two',
	'three'=>array(
		'first'=>10,
		'second'=>array(
			'sadf','asjdkf'=>'sdjafkl'
		),
		'third'=>range(1,3)
	)
);

?>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'renderHtml'=>false,
	'legend'=>'dump'
));
?>
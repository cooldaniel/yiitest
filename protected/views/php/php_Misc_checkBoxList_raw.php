<?php ob_start(); ?>
<?php

$dataTree=array(
	array(
		'text'=>'Grampa', //must using 'text' key to show the text
		'children'=>array(//using 'children' key to indicate there are children
			array(
				'text'=>'Father',
				'children'=>array(
					array('text'=>'me'),
					array('text'=>'big sis'),
					array('text'=>'little brother'),
				)
			),
			array(
				'text'=>'Uncle',
				'children'=>array(
					array('text'=>'Ben'),
					array('text'=>'Sally'),
				)
			),
			array(
				'text'=>'Aunt',
			)
		)
	)
);

$this->widget('CTreeView',array(
	'data'=>$dataTree,
	'animated'=>'fast', //quick animation
	'collapsed'=>'false',//remember must giving quote for boolean value in here
	'htmlOptions'=>array(
			'class'=>'treeview-red',//there are some classes that ready to use
	),
));

?>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	//'renderHtml'=>false,
	'legend'=>'Raw checkBoxList'
));
?>
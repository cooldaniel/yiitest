<?php ob_start(); ?>
<?php
$name='num'; //名字全部相同
$select=1; //选中项值
$data=array(
	1=>'one',
	2=>'two',
	3=>'three'
);
$htmlOptions=array(
	'separator'=>' / ', //按钮之间的分割符,默认是 "&lt;br/&gt;\n"
	'template'=>'{input}{label}', //按钮渲染模板
	'title'=>'common html options for button', //每个button共用的HTML属性
	'labelOptions'=>array( //每个label共用的HTML属性,@version 1.0.10
		'title'=>'common html options for label'
	)
);
echo CHtml::radioButtonList($name,$select,$data,$htmlOptions);
?>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'legend'=>'CHtml::radioButtonList'
));
?>
<?php ob_start(); ?>
<?php
/**
 * 2011.06.08
 * 1.empty选项值不为空,似乎是个bug.
 * 2.这里的select为string,如何渲染多选下拉菜单?
 */
$name='num'; //select元素的名称
$select=3; //选中项的值
$data=array(
	1=>'one',
	2=>'two',
	3=>'three'
);
$htmlOptions=array(
	'empty'=>array('empty_01','empty_02','empty_03','empty_04','empty_05'), //值为空字符串的选项
	'prompt'=>'prompt', //值为空字符串的首选项
	'encode'=>true, //是否对选项内容进行编码,@version 1.0.5
	'options'=>array( //选项的HTML属性,通过选项值对应,@version 1.0.3
		1=>array('title'=>'one'),
		2=>array('title'=>'two')
	),
	'key'=>array() //@version 1.1.3
);
echo CHtml::dropDownList($name,$select,$data,$htmlOptions);
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'legend'=>'CHtml::dropDownList'
));
?>
 
 
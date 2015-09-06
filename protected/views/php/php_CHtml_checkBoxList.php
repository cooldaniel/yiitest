<style type="text/css">
div.checkbox-block{border:1px solid #CEDEFE;}
div.checkbox-block span.checkbox-item{border:0px solid red; display:inline-block; width:6em;}
div.checkbox-block span.checkbox-indent{display:inline-block; width:2em; border:none; background:none;}

div.test-form{border:1px solid #EFEFEF; margin:1em auto;}
</style>

<?php ob_start(); ?>

<?php
D::pd($_POST);

if(isset($_POST['checkbox-test']))
{
	$d=$_POST['checkbox-test'];
	foreach($d as $item)
	{
		
	}
}

for($i=0; $i<3; $i++)
{
	$name[]="num_{$i}"; //会自动换做 "num[]" 以用数组收集格式数据
	$data[]=array(
		1=>CHtml::tag('span',array('class'=>'checkbox-item'),'one_'.$i),
		2=>CHtml::tag('span',array('class'=>'checkbox-item'),'two_'.$i),
		3=>CHtml::tag('span',array('class'=>'checkbox-item'),'three_'.$i),
	);
	$select[]=array(1,3); //选中项列表
	$htmlOptions[]=array(
		'id'=>'list_01',
		'checkAll'=>"全选<input type=\"text\" id=\"add_{$i}\" size=\"12\" />&nbsp;<label for=\"add_{$i}\">添加</label>&nbsp;", //全选按钮名称,@version 1.0.4
		'checkAllLast'=>false, //全选按钮是否位于按钮列表的最后面,@version 1.0.4
		//'separator'=>"\n", //按钮之间的分割符,默认是 "&lt;br/&gt;\n"
		'separator'=>"\n<br/><span class=\"checkbox-indent\"></span>",
		'template'=>"{input}\n{label}", //按钮渲染模板
		'title'=>'common html options for button', //每个button共用的HTML属性
		'labelOptions'=>array( //每个label共用的HTML属性,@version 1.0.10
			'title'=>'common html options for label'
		)
	);
}

echo CHtml::openTag('div',array('class'=>'test-form'));

$this->beginWidget('CActiveForm',array(
	
));
	echo CHtml::tag('div',array('class'=>'checkbox-block'),"\n".CHtml::checkBoxList($name[0],$select[0],$data[0],$htmlOptions[0])."\n")."\n\n<br/>\n\n";
	echo CHtml::tag('div',array('class'=>'checkbox-block'),"\n".CHtml::checkBoxList($name[1],$select[1],$data[1],$htmlOptions[1])."\n")."\n\n<br/>\n\n";
	echo CHtml::tag('div',array('class'=>'checkbox-block'),"\n".CHtml::checkBoxList($name[2],$select[2],$data[2],$htmlOptions[2])."\n")."\n\n<br/>\n\n";

	echo CHtml::submitButton('submit');
	
$this->endWidget();

echo CHtml::closeTag('div');
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'legend'=>'CHtml::checkBoxList'
));
?>
<?php ob_start(); ?>

<?php
$model=Goods::model()->findByPk('109'); //检索商品记录
$model->gColor=explode('<###>',$model->gColor); //将字符串形式的商品颜色数据转化为数组
$colorData=Yii::app()->params['color']; //可选的颜色数据
foreach($colorData as $item) //基于可选颜色数据构建颜色选择列表样式
{
	$color[$item['value']]='<span style="display:inline-block; width:15px; height:15px; background-color:'.
	$item['value'].'; border:1px solid #EFEFEF;" title="'.$item['label'].'"></span><span style="display:inline;">&#40;'.
	$item['label'].'&#41;</span>';
}

//form
$form=$this->beginWidget('CActiveForm',array(
	//表单属性
));
?>
<div>
	<?php
	echo $form->labelEx($model,'gColor');
	echo $form->checkBoxList($model,'gColor',$color,array(
				'template'=>'{label}{input}',
				'separator'=>'',
				'checkAll'=>'全选',
				'title'=>'商品颜色',
				'labelOptions'=>array(
					'title'=>'商品颜色'
			 	)
			)
		);
	echo $form->error($model,'gColor');
	?>
</div>
<?php $this->endWidget(); ?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'legend'=>'CHtml::activeCheckBoxList'
));
?>
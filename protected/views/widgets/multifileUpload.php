<?php
ob_start();
$form=$this->beginWidget('CActiveForm',array(
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
));

$this->widget('system.web.widgets.CMultifileUpload',array(
	'name'=>'User[files]',
	'accept'=>'jpg|gif|png',
	'remove'=>'删除',
	'denied'=>'不允许',
	'selected'=>'已选择',
	'duplicate'=>'已存在',
	//'file'
));
echo $form->textField($model,'username');
echo $form->fileField($model,'files');
echo CHtml::submitButton('submit');
$this->endWidget();

$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'CMultifileUpload'
));
?>
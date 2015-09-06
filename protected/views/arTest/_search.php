<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'artId'); ?>
		<?php echo $form->textField($model,'artId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'artName'); ?>
		<?php echo $form->textField($model,'artName',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
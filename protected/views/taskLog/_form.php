<?php
/* @var $this TaskLogController */
/* @var $model TaskLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'task_name'); ?>
		<?php echo $form->textField($model,'task_name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'task_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'task_sn'); ?>
		<?php echo $form->textField($model,'task_sn',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'task_sn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'params'); ?>
		<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'child_count'); ?>
		<?php echo $form->textField($model,'child_count',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'child_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'child_finished_count'); ?>
		<?php echo $form->textField($model,'child_finished_count',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'child_finished_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_time'); ?>
		<?php echo $form->textField($model,'start_time'); ?>
		<?php echo $form->error($model,'start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_time'); ?>
		<?php echo $form->textField($model,'end_time'); ?>
		<?php echo $form->error($model,'end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_used'); ?>
		<?php echo $form->textField($model,'time_used',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'time_used'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
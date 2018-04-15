<?php

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Join');
$this->breadcrumbs=array(
	Yii::t('app', 'Join'),
);
?>

<h1><?php echo Yii::t('app', 'Join'); ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'join-form',
	//'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php if ($model->output != ''):  ?>
	<p>
		<span><b><?php echo $model->getAttributeLabel('totalCount') ?></b>: <span class="required"><i><?php echo $model->totalCount; ?><i></span></span>
		<span><b><?php echo $model->getAttributeLabel('activeCount') ?></b>: <span class="required"><i><?php echo $model->activeCount; ?><i></span></span>
		<span><b><?php echo $model->getAttributeLabel('emptyCount') ?></b>: <span class="required"><i><?php echo $model->emptyCount; ?><i></span></span>
	</p>
	<?php endif  ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'list'); ?>
		<?php echo $form->textArea($model,'list', array('cols'=>120, 'rows'=>15)); ?>
		<?php echo $form->error($model,'list'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'output'); ?>
		<?php echo $form->textArea($model,'output', array('cols'=>120, 'rows'=>15, 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'output'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
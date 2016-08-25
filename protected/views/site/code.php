<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Card Code');
$this->breadcrumbs=array(
	Yii::t('app', 'Card Code'),
);
?>

<h1><?php echo Yii::t('app', 'Card Code'); ?></h1>

<div style="position:absolute; top:160px; left:49%; color:red;" id="operationSucceeded"><?php echo $operationSucceeded; ?></div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	//'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cardNumList'); ?>
		<?php echo $form->textArea($model,'cardNumList', array('cols'=>60, 'rows'=>10)); ?>
		<?php echo $form->error($model,'cardNumList'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'codeList'); ?>
		<?php echo $form->textArea($model,'codeList', array('readonly'=>'readonly','cols'=>60, 'rows'=>10)); ?>
		<?php echo $form->error($model,'codeList'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'codeListWithCard'); ?>
		<?php echo $form->textArea($model,'codeListWithCard', array('readonly'=>'readonly','cols'=>60, 'rows'=>10)); ?>
		<?php echo $form->error($model,'codeListWithCard'); ?>
	</div>
    
    <?php if ($model->codeErrors) : ?>
    <div class="row">
    	<?php echo $form->labelEx($model,'codeErrors'); ?>
    	<p><?php echo $model->codeErrors; ?></p>
    </div>
    <?php endif ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(function(){
	var obj = $('#operationSucceeded');
	if (obj.length){
		setTimeout(function(){
			obj.fadeOut('slow');
		}, 800);
	}
});
</script>
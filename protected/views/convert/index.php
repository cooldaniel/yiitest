<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Convert');
$this->breadcrumbs=array(
	Yii::t('app', 'Convert'),
);
?>

<h1><?php echo Yii::t('app', 'Convert'); ?></h1>

<?php if (Yii::app()->user->hasFlash('operationSucceeded')): ?>
<div style="position:absolute; top:160px; left:49%; color:red;" id="operationSucceeded"><?php echo Yii::app()->user->getFlash('operationSucceeded'); ?></div>
<?php endif ?>

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
		<?php echo $form->labelEx($model,'json'); ?>
		<?php echo $form->textArea($model,'json', array('cols'=>120, 'rows'=>25)); ?>
		<?php echo $form->error($model,'json'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'array'); ?>
		<?php echo $form->textArea($model,'array', array('cols'=>120, 'rows'=>25)); ?>
		<?php echo $form->error($model,'array'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'likearray'); ?>
		<?php echo $form->textArea($model,'likearray', array('cols'=>120, 'rows'=>25)); ?>
		<?php echo $form->error($model,'likearray'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'postman'); ?>
		<?php echo $form->textArea($model,'postman', array('cols'=>120, 'rows'=>25)); ?>
		<?php echo $form->error($model,'postman'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'choice'); ?>
		<?php echo $form->radioButtonList($model,'choice',
			[
				ConvertHelper::CHOICE_JSON=>$model->attributeLabels()['json'],
				ConvertHelper::CHOICE_ARRAY=>$model->attributeLabels()['array'],
				ConvertHelper::CHOICE_LIKEARRAY=>$model->attributeLabels()['likearray'],
				ConvertHelper::CHOICE_POSTMAN=>$model->attributeLabels()['postman'],
			],
			[
				'separator'=>''
			]
		); ?>
		<?php echo $form->error($model,'choice'); ?>
	</div>
    
    <?php if ($model->convertErrors) : ?>
    <div class="row">
    	<?php echo $form->labelEx($model,'convertErrors'); ?>
    	<p><?php echo $model->convertErrors; ?></p>
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
<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Convert');
$this->breadcrumbs=array(
    Yii::t('app', 'Convert'),
);
?>

<style>
textarea {
    /*font: normal 1em Arial,Helvetica,sans-serif;*/
    /*border-radius: 3px;*/
    /*padding: 0.5em;*/
}
</style>

<h1><?php echo Yii::t('app', 'Convert'); ?></h1>

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
        <?php echo $form->labelEx($model,'json' . '&nbsp;&nbsp;(Data count: ' . $model->dataCount .' )'); ?>
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
        <?php echo $form->labelEx($model,'list'); ?>
        <?php echo $form->textArea($model,'list', array('cols'=>120, 'rows'=>25)); ?>
        <?php echo $form->error($model,'list'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'listspace'); ?>
        <?php echo $form->textArea($model,'listspace', array('cols'=>120, 'rows'=>25)); ?>
        <?php echo $form->error($model,'listspace'); ?>
    </div>

    <div style="position: fixed; right: 50px; top: 100px;">

        <div class="row">
            <?php echo $form->labelEx($model,'choice'); ?>
            <?php echo $form->dropDownList($model,'choice',
                [
                    ConvertHelper::CHOICE_JSON=>$model->attributeLabels()['json'],
                    ConvertHelper::CHOICE_ARRAY=>$model->attributeLabels()['array'],
                    ConvertHelper::CHOICE_LIKEARRAY=>$model->attributeLabels()['likearray'],
                    ConvertHelper::CHOICE_POSTMAN=>$model->attributeLabels()['postman'],
                    ConvertHelper::CHOICE_LIST=>$model->attributeLabels()['list'],
                    ConvertHelper::CHOICE_LISTSPACE=>$model->attributeLabels()['listspace'],
                ]
            ); ?>
            <?php echo $form->error($model,'choice'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?>
            <?php echo $form->radioButtonList($model,'sort',ConvertHelper::$sortList); ?>
            <?php echo $form->error($model,'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortByKey'); ?>
            <?php echo $form->checkBox($model,'sortByKey'); ?>
            <?php echo $form->error($model,'sortByKey'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortByRecurse'); ?>
            <?php echo $form->checkBox($model,'sortByRecurse'); ?>
            <?php echo $form->error($model,'sortByRecurse'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('app', 'Submit')); ?>
        </div>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
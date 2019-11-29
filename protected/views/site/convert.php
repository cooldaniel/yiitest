<?php
$this->pageTitle='数据对比-'.date('Y-m-d H:i:s').'-'.rand();
?>

<style>
textarea {
    /*font: normal 1em Arial,Helvetica,sans-serif;*/
    /*border-radius: 3px;*/
    /*padding: 0.5em;*/
}

table, tr, td{
    border: 1px solid #e5e5e5;
}
tr.even{
    background-color: #EFEFEF;
}

</style>

<h1><?php echo Yii::t('app', '数据对比'); ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'contact-form',
    //'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

    <div class="row">
        <?php echo CHtml::label('表名字', 'table'); ?>
        <?php echo CHtml::textField('table', $data['table']??'', array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label('记录主键名字', 'search_key'); ?>
        <?php echo CHtml::textField('search_key', $data['search_key']??'', array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label('记录主键值', 'search_value'); ?>
        <?php echo CHtml::textField('search_value', $data['search_value']??'', array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label('Json', 'json'); ?>
        <?php echo CHtml::textArea('json', $data['json']??'', array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row buttons submit-button">
        <?php echo CHtml::submitButton(Yii::t('app', 'Submit')); ?>
    </div>

    <div class="row">
        <?php echo $data['html']??'' ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
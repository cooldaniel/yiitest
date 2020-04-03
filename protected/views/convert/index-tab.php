<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Convert');
$this->breadcrumbs=array(
    Yii::t('app', 'Convert'),
);
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--    <link rel="stylesheet" href="/resources/demos/style.css">-->
<!--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    .ui-tabs .ui-tabs-panel {
        padding: 3px;
    }
    .ui-widget{
        border: none;
    }
    .ui-tabs{
        border: none;
    }
    .ui-widget.ui-widget-content {
        border: none;
    }
    .ui-tabs .ui-tabs-nav{
        padding: auto;
    }
    .ui-widget-header{
        border: none;
        background: none;
    }
    .ui-tabs .ui-tabs-nav li{
        border-width: 1px;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
</style>


<style>
    .search-condition{
        margin: -20px auto -21px;
    }
    textarea {
        /*font: normal 1em Arial,Helvetica,sans-serif;*/
        border-radius: 2px;
        padding: 2px;
        font-family: monospace !important;
    }
    label{
        display: inline-block !important;
    }
    label.main-label{
        border: none;
        width: 200px;
        text-align: right;
        margin-right: 1em;
    }
    input.submit-button{
        margin-left: 100px !important;
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

    <div class="search-condition">

        <div class="row">
            <?php echo $form->labelEx($model,'choice', ['class'=>'main-label']); ?>
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
            <?php echo CHtml::submitButton(Yii::t('app', 'Submit'), ['class'=>'submit-button']); ?>
            <?php echo $form->error($model,'choice'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort', ['class'=>'main-label']); ?>
            <?php echo $form->radioButtonList($model,'sort',ConvertHelper::$sortList, ['separator'=>'']); ?>
            <?php echo $form->error($model,'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortbykey', ['class'=>'main-label']); ?>
            <?php echo $form->checkBox($model,'sortbykey'); ?>
            <?php echo $form->error($model,'sortbykey'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortbyrecurse', ['class'=>'main-label']); ?>
            <?php echo $form->checkBox($model,'sortbyrecurse'); ?>
            <?php echo $form->error($model,'sortbyrecurse'); ?>
        </div>

        <div class="row buttons">

        </div>

    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'Data count: ' . $model->data_count .' '); ?>
    </div>

    <div id="tabs">

        <ul>
            <li><a href="#tabs-1">Json</a></li>
            <li><a href="#tabs-2">Array</a></li>
            <li><a href="#tabs-3">Likearray</a></li>
            <li><a href="#tabs-4">Postman</a></li>
            <li><a href="#tabs-5">List</a></li>
            <li><a href="#tabs-6">Listspace</a></li>
          </ul>

        <div id="tabs-1">
            <?php echo $form->textArea($model,'json', array('cols'=>120, 'rows'=>30)); ?>
            <?php echo $form->error($model,'json'); ?>
        </div>

        <div id="tabs-2">
            <?php echo $form->textArea($model,'array', array('cols'=>120, 'rows'=>30)); ?>
            <?php echo $form->error($model,'array'); ?>
        </div>

        <div id="tabs-3">
            <?php echo $form->textArea($model,'likearray', array('cols'=>120, 'rows'=>30)); ?>
            <?php echo $form->error($model,'likearray'); ?>
        </div>

        <div id="tabs-4">
            <?php echo $form->textArea($model,'postman', array('cols'=>120, 'rows'=>30)); ?>
            <?php echo $form->error($model,'postman'); ?>
        </div>

        <div id="tabs-5">
            <?php echo $form->textArea($model,'list', array('cols'=>120, 'rows'=>30)); ?>
            <?php echo $form->error($model,'list'); ?>
        </div>

        <div id="tabs-6">
            <?php echo $form->textArea($model,'listspace', array('cols'=>120, 'rows'=>30)); ?>
            <?php echo $form->error($model,'listspace'); ?>
        </div>

    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
$( function() {
$( "#tabs" ).tabs({
  //event: "mouseover"
});
} );
</script>
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

        <?php
            $data = [
                ['name'=>'json', 'text'=>''],
                ['name'=>'array', 'text'=>''],
                ['name'=>'sql', 'text'=>''],
                ['name'=>'likearray', 'text'=>''],
                ['name'=>'postman', 'text'=>''],
                ['name'=>'list', 'text'=>''],
                ['name'=>'listspace', 'text'=>''],
            ];
        ?>

        <!-- 标签头部 -->
        <ul>
            <?php foreach ($data as $index => $item): ?>
            <li><a href="#tabs-<?php echo $index; ?>"><?php echo ucfirst($item['name']); ?></a></li>
            <?php endforeach; ?>
        </ul>

        <!-- 标签内容 -->
        <?php foreach ($data as $index => $item): ?>
        <div id="tabs-<?php echo $index; ?>">

            <!-- 增加sql格式展示数组方式 -->
            <?php if ($item['name'] == 'sql'): ?>
                <?php echo CHtml::textArea(
                    $item['name'],
                    'array(' . substr($model->array, 1, -2) . ')',
                    array('cols'=>120, 'rows'=>30, 'readonly'=>true, 'title'=>'Array的另一个展示格式，只是改了首尾语法，方便复制做sql的IN条件，只做复制不能修改提交')
                ); ?>
            <?php else: ?>
                <?php echo $form->textArea($model,$item['name'], array('cols'=>120, 'rows'=>30)); ?>
                <?php echo $form->error($model,$item['name']); ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

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
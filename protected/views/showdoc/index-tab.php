<?php
/* @var $this ShowdocController */
/* @var $model ShowdocForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Showdoc');
$this->breadcrumbs=array(
    Yii::t('app', 'Showdoc'),
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
        width: 250px;
        text-align: right;
        margin-right: 1em;
    }
    input.submit-button{
        margin-left: 100px !important;
    }
</style>

<h1><?php echo Yii::t('app', 'Showdoc'); ?></h1>

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

        <div class="row buttons" style="margin: 50px auto;">
            <?php echo CHtml::submitButton(Yii::t('app', 'Submit'), ['class'=>'submit-button']); ?>
        </div>

    </div>

    <?php echo $form->errorSummary($model); ?>

    <div id="tabs">

        <?php
            $data = [
                ['name'=>'request', 'text'=>''],
                ['name'=>'response', 'text'=>''],
                ['name'=>'requestDoc', 'text'=>''],
                ['name'=>'responseDoc', 'text'=>''],
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
                    '(' . substr($model->array, 1, -2) . ')',
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
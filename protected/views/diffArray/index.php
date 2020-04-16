<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'DiffArray');
$this->breadcrumbs=array(
    Yii::t('app', 'DiffArray'),
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

<h1><?php echo Yii::t('app', 'DiffArray'); ?></h1>

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
            <?php echo $form->dropDownList($model,'choice', DiffArraytHelper::$choiceList); ?>
            <?php echo CHtml::submitButton(Yii::t('app', 'Submit'), ['class'=>'submit-button']); ?>
            <?php echo $form->error($model,'choice'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'direct', ['class'=>'main-label']); ?>
            <?php echo $form->radioButtonList($model,'direct',DiffArraytHelper::$directList, [
                'separator'=>'',
                'labelOptions'=>[
                    'style'=>'margin-right: 1em;',
                ]
            ]); ?>
            <?php echo $form->error($model,'direct'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort', ['class'=>'main-label']); ?>
            <?php echo $form->radioButtonList($model,'sort',ConvertHelper::$sortList, [
                'separator'=>'',
                'labelOptions'=>[
                    'style'=>'margin-right: 1em;',
                ]
            ]); ?>
            <?php echo $form->error($model,'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortByAssoc', ['class'=>'main-label']); ?>
            <?php echo $form->checkBox($model,'sortByAssoc'); ?>
            <?php echo $form->error($model,'sortByAssoc'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortByKey', ['class'=>'main-label']); ?>
            <?php echo $form->checkBox($model,'sortByKey'); ?>
            <?php echo $form->error($model,'sortByKey'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sortByRecurse', ['class'=>'main-label']); ?>
            <?php echo $form->checkBox($model,'sortByRecurse'); ?>
            <?php echo $form->error($model,'sortByRecurse'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'natsort', ['class'=>'main-label']); ?>
            <?php echo $form->checkBox($model,'natsort'); ?>
            <?php echo $form->error($model,'natsort'); ?>
        </div>

    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'Item counts: <span style="color: #cc0000;">' . $model->dataCount .'</span>'); ?>.
    </div>

    <div id="tabs">

        <?php
            $data = [
                ['name'=>'array1', 'text'=>''],
                ['name'=>'array2', 'text'=>''],
                ['name'=>'diff', 'text'=>''],
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

            <!-- 结果 -->
            <?php if ($item['name'] == 'diff'): ?>
                <?php echo CHtml::textArea(
                    $item['name'],
                    $model->diff,
                    array('cols'=>120, 'rows'=>30, 'readonly'=>true, 'title'=>'比较结果，只做复制不能修改提交')
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

    // $('textarea[name="DiffArrayForm[array1]"').swapcookiedata();
    // $('textarea[name="DiffArrayForm[array2]"').swapcookiedata();
} );
</script>
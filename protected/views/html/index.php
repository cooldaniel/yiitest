<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Html');
$this->breadcrumbs=array(
    Yii::t('app', 'Html'),
);
?>

<style>
textarea {
    /*font: normal 1em Arial,Helvetica,sans-serif;*/
    /*border-radius: 3px;*/
    /*padding: 0.5em;*/
}
</style>

<h1><?php echo Yii::t('app', 'Html'); ?></h1>

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
        <?php echo CHtml::label('Html', 'html'); ?>
        <?php echo CHtml::textArea('html', '', array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row buttons submit-button">
        <?php echo CHtml::button(Yii::t('app', 'View'), ['id'=>'viewButton']); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
$(function () {

    var obj = $('textarea[name="html"]').swapcookiedata();

    // 点击查看的时候从cookie读取文本显示
    $('#viewButton').on('click', function () {
        window.open('', "_blank",'').document.write(obj.getCookieData());
    });
})
</script>
<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Html');
$this->breadcrumbs=array(
    Yii::t('app', 'Html'),
);

$viewHtmlUrl = Yii::app()->createUrl('site/viewHtml');
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
        <?php echo CHtml::textArea('html', $html, array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row buttons submit-button">
        <?php echo CHtml::submitButton(Yii::t('app', 'Submit')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
var viewHtmlUrl = '<?php echo $viewHtmlUrl; ?>';
$(function () {
    window.open(viewHtmlUrl);
})
</script>
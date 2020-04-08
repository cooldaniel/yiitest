<?php
$this->pageTitle=Yii::app()->name . ' - ' . '数据对比-'.date('Y-m-d H:i:s').'-'.rand();
$this->breadcrumbs=array(
    Yii::t('app', 'DbCompare'),
);
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">

<script>
$(function() {
    $( "#tabs" ).tabs();
});
</script>

<style>
textarea {
    /*font: normal 1em Arial,Helvetica,sans-serif;*/
    /*border-radius: 3px;*/
    /*padding: 0.5em;*/
}

.container{
    width: 1140px;
}

table, tr, td{
    border: 1px solid #e5e5e5;
    border-collapse:collapse;
}
td{
    padding: 0.85em;
}
tr.even{
    background-color: #EFEFEF;
}
div.form div.row{
    /*border: 1px solid red;*/
}
div.form div.rowcolumn{
    /*border: 1px solid blue;*/
    display: inline-block;
    width: 250px;
}
div.form div.rowheader{
    margin: 0 auto 10px;
}
div.nodata {
    display: inline-block;
    color: red;
    margin-left: 10px;
}

/* tab */
.rowcontent{
    padding-top: 10px;
}

.ui-widget-content{
    margin: 0;
    padding: 0;
    border: none;
}
.ui-tabs .ui-tabs-nav{
    margin: 0;
    padding: 0;
    border: none;
    background: none;
}
.ui-widget{
    font-family: inherit;
    font-size: inherit;
}

.ui-tabs .ui-tabs-panel {
    display: block;
    border-width: 0;
    padding: 0;
    background: none;
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

    <div class="row rowheader">
        <div class="rowcolumn">
            源数据库
        </div>
        <div class="rowcolumn">
            对比数据库
        </div>
        <div class="rowcolumn">
            对比mongodb
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('IP', 'source_ip'); ?>
            <?php echo CHtml::textField('source_ip', $data['source_ip']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('IP', 'compare_ip'); ?>
            <?php echo CHtml::textField('compare_ip', $data['compare_ip']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('IP', 'mongodb_ip'); ?>
            <?php echo CHtml::textField('mongodb_ip', $data['mongodb_ip']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('端口', 'source_port'); ?>
            <?php echo CHtml::textField('source_port', $data['source_port']??'3306', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('端口', 'compare_port'); ?>
            <?php echo CHtml::textField('compare_port', $data['compare_port']??'3306', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('端口', 'mongodb_port'); ?>
            <?php echo CHtml::textField('mongodb_port', $data['mongodb_port']??'3306', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('数据库', 'source_database'); ?>
            <?php echo CHtml::textField('source_database', $data['source_database']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('数据库', 'compare_database'); ?>
            <?php echo CHtml::textField('compare_database', $data['compare_database']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('数据库', 'mongodb_database'); ?>
            <?php echo CHtml::textField('mongodb_database', $data['mongodb_database']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('用户名', 'source_username'); ?>
            <?php echo CHtml::textField('source_username', $data['source_username']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('用户名', 'compare_username'); ?>
            <?php echo CHtml::textField('compare_username', $data['compare_username']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('用户名', 'mongodb_username'); ?>
            <?php echo CHtml::textField('mongodb_username', $data['mongodb_username']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('密码', 'source_password'); ?>
            <?php echo CHtml::textField('source_password', $data['source_password']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('密码', 'compare_password'); ?>
            <?php echo CHtml::textField('compare_password', $data['compare_password']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('密码', 'mongodb_password'); ?>
            <?php echo CHtml::textField('mongodb_password', $data['mongodb_password']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('表名字', 'source_table'); ?>
            <?php echo CHtml::textField('source_table', $data['source_table']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('表名字', 'compare_table'); ?>
            <?php echo CHtml::textField('compare_table', $data['compare_table']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('集合名字', 'mongodb_table'); ?>
            <?php echo CHtml::textField('mongodb_table', $data['mongodb_table']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('记录主键名字', 'source_search_key'); ?>
            <?php echo CHtml::textField('source_search_key', $data['source_search_key']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('记录主键名字', 'compare_search_key'); ?>
            <?php echo CHtml::textField('compare_search_key', $data['compare_search_key']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('记录主键名字', 'mongodb_search_key'); ?>
            <?php echo CHtml::textField('mongodb_search_key', $data['mongodb_search_key']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <div class="rowcolumn">
            <?php echo CHtml::label('记录主键值', 'source_search_value'); ?>
            <?php echo CHtml::textField('source_search_value', $data['source_search_value']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('记录主键值', 'compare_search_value'); ?>
            <?php echo CHtml::textField('compare_search_value', $data['compare_search_value']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
        <div class="rowcolumn">
            <?php echo CHtml::label('记录主键值', 'mongodb_search_value'); ?>
            <?php echo CHtml::textField('mongodb_search_value', $data['mongodb_search_value']??'', array('cols'=>120, 'rows'=>25)); ?>
        </div>
    </div>

    <div class="row">
        <?php echo CHtml::label('对比Json', 'json'); ?>
        <?php echo CHtml::textArea('json', $data['json']??'', array('cols'=>120, 'rows'=>25)); ?>
    </div>

    <div class="row buttons submit-button">
        <?php echo CHtml::submitButton(Yii::t('app', 'Submit')); ?>
    </div>

    <div class="row rowcontent">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">对比Json</a></li>
                <li><a href="#tabs-2">对比数据库</a></li>
                <li><a href="#tabs-3">对比mongodb</a></li>
            </ul>
            <div id="tabs-1">
                <p><?php echo $data['html']['json_html']??'' ?></p>
            </div>
            <div id="tabs-2">
                <p><?php echo $data['html']['compare_html']??'' ?></p>
            </div>
            <div id="tabs-3">
                <p><?php echo $data['html']['mongodb_html']??'' ?></p>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
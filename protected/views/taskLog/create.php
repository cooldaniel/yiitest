<?php
/* @var $this TaskLogController */
/* @var $model TaskLog */

$this->breadcrumbs=array(
	'Task Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TaskLog', 'url'=>array('index')),
	array('label'=>'Manage TaskLog', 'url'=>array('admin')),
);
?>

<h1>Create TaskLog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
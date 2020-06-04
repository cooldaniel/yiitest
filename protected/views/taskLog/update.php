<?php
/* @var $this TaskLogController */
/* @var $model TaskLog */

$this->breadcrumbs=array(
	'Task Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TaskLog', 'url'=>array('index')),
	array('label'=>'Create TaskLog', 'url'=>array('create')),
	array('label'=>'View TaskLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TaskLog', 'url'=>array('admin')),
);
?>

<h1>Update TaskLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
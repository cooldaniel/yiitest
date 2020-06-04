<?php
/* @var $this TaskLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Task Logs',
);

$this->menu=array(
	array('label'=>'Create TaskLog', 'url'=>array('create')),
	array('label'=>'Manage TaskLog', 'url'=>array('admin')),
);
?>

<h1>Task Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

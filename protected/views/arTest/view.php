<?php
$this->breadcrumbs=array(
	'Ar Tests'=>array('index'),
	$model->artId,
);

$this->menu=array(
	array('label'=>'List ArTest', 'url'=>array('index')),
	array('label'=>'Create ArTest', 'url'=>array('create')),
	array('label'=>'Update ArTest', 'url'=>array('update', 'id'=>$model->artId)),
	array('label'=>'Delete ArTest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->artId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ArTest', 'url'=>array('admin')),
);
?>

<h1>View ArTest #<?php echo $model->artId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'artId',
		'artName',
	),
)); ?>

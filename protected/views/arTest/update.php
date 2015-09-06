<?php
$this->breadcrumbs=array(
	'Ar Tests'=>array('index'),
	$model->artId=>array('view','id'=>$model->artId),
	'Update',
);

$this->menu=array(
	array('label'=>'List ArTest', 'url'=>array('index')),
	array('label'=>'Create ArTest', 'url'=>array('create')),
	array('label'=>'View ArTest', 'url'=>array('view', 'id'=>$model->artId)),
	array('label'=>'Manage ArTest', 'url'=>array('admin')),
);
?>

<h1>Update ArTest <?php echo $model->artId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
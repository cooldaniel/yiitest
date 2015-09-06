<?php
$this->breadcrumbs=array(
	'Ar Tests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ArTest', 'url'=>array('index')),
	array('label'=>'Manage ArTest', 'url'=>array('admin')),
);
?>

<h1>Create ArTest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
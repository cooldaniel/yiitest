<?php
$this->breadcrumbs=array(
	'Ar Tests',
);

$this->menu=array(
	array('label'=>'Create ArTest', 'url'=>array('create')),
	array('label'=>'Manage ArTest', 'url'=>array('admin')),
);
?>

<h1>Ar Tests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

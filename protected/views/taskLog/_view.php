<?php
/* @var $this TaskLogController */
/* @var $data TaskLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_name')); ?>:</b>
	<?php echo CHtml::encode($data->task_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_sn')); ?>:</b>
	<?php echo CHtml::encode($data->task_sn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('child_count')); ?>:</b>
	<?php echo CHtml::encode($data->child_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('child_finished_count')); ?>:</b>
	<?php echo CHtml::encode($data->child_finished_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_time')); ?>:</b>
	<?php echo CHtml::encode($data->end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_used')); ?>:</b>
	<?php echo CHtml::encode($data->time_used); ?>
	<br />

	*/ ?>

</div>
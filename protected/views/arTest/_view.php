<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('artId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->artId), array('view', 'id'=>$data->artId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('artName')); ?>:</b>
	<?php echo CHtml::encode($data->artName); ?>
	<br />


</div>
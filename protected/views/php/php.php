<?php
$this->renderPartial('/layouts/block_list',array('title'=>'Php 测试','items'=>array(
	array('File system',$this->createUrl('php/fileSystem')),
	array('CHtml',$this->createUrl('php/chtml')),
	array('Misc',$this->createUrl('php/misc')),
	array('Oop',$this->createUrl('php/oop')),
	array('Blank',$this->createUrl('php/blank')),
)));
?>
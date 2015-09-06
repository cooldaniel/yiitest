<?php
$this->renderPartial('/layouts/block_items',array('back'=>$this->createUrl('php/index'),'title'=>'Misc','items'=>array(
	'php_Misc_createUrl',
	'php_Misc_dump',
	'php_Misc_checkBoxList_raw',
)));
?>
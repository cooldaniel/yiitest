<?php
$this->renderPartial('/layouts/block_items',array('back'=>$this->createUrl('php/index'),'title'=>'File System','items'=>array(
	'php_fileSystem_PathDumper',
)));
?>
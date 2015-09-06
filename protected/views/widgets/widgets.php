<?php
$this->renderPartial('/layouts/block_list',array('title'=>'Php 测试','items'=>array(
	array('CForm',$this->createUrl('widgets/Cform')),
	array('CListView',$this->createUrl('widgets/listView')),
	array('CGridView',$this->createUrl('widgets/gridView')),
	array('CDetailView',$this->createUrl('widgets/detailView')),
	array('CFlexWidget',$this->createUrl('widgets/flexWidget')),
	array('CMultifileUpload',$this->createUrl('widgets/multifileUpload')),
	array('CTreeView',$this->createUrl('widgets/treeView')),
	array('StatefulForm',$this->createUrl('widgets/statefulForm')),
)));
?>
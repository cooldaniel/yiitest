<?php
$this->renderPartial('/layouts/block_list',array('title'=>'JavaScript 测试','items'=>array(
	array('jquery_slide',$this->createUrl('js/jquerySlide')),
	array('jquery_ajax',$this->createUrl('js/jqueryAjax')),
	array('jquery_plugin',$this->createUrl('js/jqueryPlugin')),
	//array('jquery_slide',$this->createUrl('js/jquerySlide')),
	array('module',$this->createUrl('js/module')),
)));
?>
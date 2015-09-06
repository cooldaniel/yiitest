<?php
$this->renderPartial('/layouts/block_items',array('back'=>$this->createUrl('js/index'),'title'=>'jquery_ajax','items'=>array(
	'js_jquery_ajax_simple',
	'js_jquery_ajax_charset',
	'js_jquery_ajax_find_filter',
)));
?>
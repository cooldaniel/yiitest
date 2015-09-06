<?php
$this->renderPartial('/layouts/block_items',array('back'=>$this->createUrl('js/index'),'title'=>'jquery_slide','items'=>array(
	'js_jquery_slide_simple',
	'js_jquery_slide_toggle',
)));
?>
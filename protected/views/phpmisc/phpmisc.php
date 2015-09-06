<?php
$this->renderPartial('/layouts/block_list',array('title'=>'Php Misc','items'=>array(
	array('Form security',$this->createUrl('phpMisc/formSecurity')),
	array('Popup submit',$this->createUrl('phpMisc/popupSubmit')),
)));
?>
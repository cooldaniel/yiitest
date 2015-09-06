<?php
/**
 * Render each item by {@link CController::renderPartial} and corresponding view file.
 * @version 2011.07.04
 */
?>
<div class="block-back"><?php echo CHtml::button('back',array('onclick'=>'window.location.href="'.$back.'"'))."\n"; ?></div>
<div class="block"><?php echo $title; ?></div>
<?php
foreach($items as $item)
	$this->renderPartial($item);
?>
<div class="block-back"><?php echo CHtml::button('back',array('onclick'=>'window.location.href="'.$back.'"'))."\n"; ?></div>
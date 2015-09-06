<?php
/**
 * Render all by {@link CController::renderPartial} in single block.
 * @version 2011.07.26
 */
?>
<div class="block-back"><?php echo CHtml::button('back',array('onclick'=>'window.location.href="'.$back.'"'))."\n"; ?></div>
<div class="block"><?php echo $title; ?></div>
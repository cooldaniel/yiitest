<?php
/**
 * List template for listing all the items in <ul/>.
 * @version 2011.07.04
 */
?>
<div class="block"><?php echo $title; ?></div>
<?php
echo CHtml::openTag('ul',array())."\n";
foreach($items as $item)
	echo CHtml::tag('li',array(),CHtml::link($item[0],$item[1]))."\n";
echo CHtml::closeTag('ul')."\n";
?>
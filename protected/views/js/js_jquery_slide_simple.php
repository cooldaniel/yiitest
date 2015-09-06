<?php ob_start(); ?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<style type="text/css">
.shell{border:1px solid red;}
.c{border:1px solid blue; display:none; margin:0 auto;}
</style>

<script type="text/javascript">
jQuery(document).ready(function()
{
	var c=jQuery('.c');
	jQuery('.shell').live('click',function()
	{
		if(c.hasClass('down'))
		{
			c.slideDown();
			c.removeClass('down');
		}
		else
		{
			c.slideUp();
			c.addClass('down');
		}
	});
	c.slideUp();
	c.addClass('down');
});
</script>

<div class="shell">
<div>+</div>
<ul class="c">
	<li>one</li>
    <li>two</li>
    <li>three</li>
</ul>
</div>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'legend'=>'simple'
));
?>

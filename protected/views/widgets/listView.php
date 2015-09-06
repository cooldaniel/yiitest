<style type="text/css">
/*.list-view{border:1px solid blue;}
.items{border:1px solid red;}
.loadingCssClass{border:1px solid red;}*/
.items li{border:1px solid #F69;}
.items li span{display:inline-block; width:10%;}
</style>

<div id="one"><?php echo rand(1,10); ?></div>
<div id="two"><?php echo rand(); ?></div>
<?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_itemView',
	'pager'=>array(
		'class'=>'CListPager'
	),
	'htmlOptions'=>array(
		'class'=>'list-view'
	),
	'sortableAttributes'=>array('uId','uName','uEmail'),
	'ajaxUpdate'=>'one,two'
));
?>
<?php ob_start(); ?>
<?php
$dataTree=array(
	array(
		'text'=>'Grampa', //must using 'text' key to show the text
		'children'=>array(//using 'children' key to indicate there are children
			array(
				'text'=>'Father',
				'children'=>array(
					array('text'=>'me'),
					array('text'=>'big sis'),
					array('text'=>'little brother'),
				)
			),
			array(
				'text'=>'Uncle',
				'children'=>array(
					array('text'=>'Ben'),
					array('text'=>'Sally'),
				)
			),
			array(
				'text'=>'Aunt',
			)
		)
	)
);

$dataTree=array(
	array(
		'text'=>'<input type="checkbox" />All', //must using 'text' key to show the text
		'htmlOptions'=>array('class'=>'parent-li'),
		'expanded'=>true,
		'children'=>array(//using 'children' key to indicate there are children
			array(
				'text'=>'<input type="checkbox" />Part one',
				'htmlOptions'=>array('class'=>'parent-li'),
				'children'=>array(
					array('text'=>'<input type="checkbox" />me'),
					array('text'=>'<input type="checkbox" />big sis'),
					array('text'=>'<input type="checkbox" />little brother'),
				)
			),
			array(
				'text'=>'<input type="checkbox" />Part two',
				'htmlOptions'=>array('class'=>'parent-li'),
				'children'=>array(
					array(
						'text'=>'<input type="checkbox" />Ben',
						'htmlOptions'=>array('class'=>'parent-li'),
						'children'=>array(
							array('text'=>'<input type="checkbox" />one'),
							array('text'=>'<input type="checkbox" />two'),
							array('text'=>'<input type="checkbox" />three'),
						),
					),
					array('text'=>'<input type="checkbox" />Sally'),
				)
			),
			array(
				'text'=>'<input type="checkbox" />Part three',
			)
		)
	)
);

$widget=$this->widget('CTreeView',array(
	'data'=>$dataTree,
	'animated'=>'fast', //quick animation
	'collapsed'=>'false',//remember must giving quote for boolean value in here
	'htmlOptions'=>array(
			'class'=>'treeview-red',//there are some classes that ready to use
	),
));
$id=$widget->getId();
$js=<<<EOD
;((function($){
	$("#{$id} li.parent-li > input:checkbox").live('click',function(){
		var checked=$(this).attr('checked');
		$(this).nextAll('ul').eq(0).find('input:checkbox').each(function(){
			if(checked){
				$(this).attr('checked',checked)
			}else{
				$(this).removeAttr('checked');
			}
		});
		if(checked){
			$(this).nextAll('ul').eq(0).css('color','red');
		}else{
			$(this).nextAll('ul').eq(0).css('color','');
		}
	});
	
	$('#reload').click(function(){
		$.ajax({
			type:'POST',
			url:window.location.href,
			success:function(response){
				$('#{$id}').replaceWith($(response).find('#{$id}'));
				//重新调用treeview的js
				$('#{$id}').treeview({'animated':'fast','collapsed':'false'});
				alert('reloaded');
			}
		});
	});
})(jQuery));
EOD;
Yii::app()->getClientScript()->registerScript('tree-veiw-'.rand(),$js);
?>
<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	//'renderHtml'=>false,
	'legend'=>'CTreeView'
));
?>

<div id="reload">reload</div>
<style type="text/css">
.header-cell a{border:1px solid #FCF;}
.footer-cell{color:#E03FD8;}
.data-cell{background-color:#FCF;}

.fix-width-1{width:2.5em;}
</style>

<?php
ob_start();
?>
<?php
$delJs=<<<EOD
function(){
	THIS=$(this);
	var id=THIS.parents('.grid-view').attr('id');
	var url=THIS.attr('href');
	if(!confirm('确定删除?'))
		return false;
	$.fn.yiiGridView.update(id,{
		type:'POST',
		url:url,
		success:function(response){
			if(response=='success'){
				$.fn.yiiGridView.update(id);
			}else{
				alert(response);
				$('#'+id).removeClass($.fn.yiiGridView.settings[id].loadingClass);
			}
		}
	});
	return false;
}
EOD;

$this->widget('zii.widgets.grid.CGridView',array(
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'ajaxUpdate'=>false,
	'selectableRows'=>1,
	'columns'=>array(
		array(
			'value'=>'$row+1',
			'header'=>'行号',
			'htmlOptions'=>array('class'=>'fix-width-1')
		),
		'uId',
		'uName',
		'uEmail',
		//'uPwd',
		array(
			'name'=>'uSex',
			'filter'=>array(1=>'是',2=>'否'),
		),
		'uMoney',
		'uM',
		'uSn',
		array( //CDataColumn是数据单元默认的渲染类
			'class'=>'CDataColumn',
			'name'=>'uId',
			'header'=>'用户的id', //自定义表格列头部文本
			'footer'=>'标识用户', //自定义表格列脚部文本
			'headerHtmlOptions'=>array( //表格列头部单元的HTML属性
				//使用上面自定义的"header-cell"来修饰
				'class'=>'header-cell'
			),
			'footerHtmlOptions'=>array( //表格列脚部单元的HTML属性
				//使用上面自定义的"footer-cell"来修饰
				'class'=>'footer-cell'
			),
			'htmlOptions'=>array( //数据单元的HTML属性
				//使用css框架blurprint定义的"span-2"来限制列宽
				//使用上面自定义的"data-cell"来修饰
				'class'=>'span-2 data-cell',
				//如果使用预定义的css规则无效,可以使用下面的属性来修饰
				//'style'=>'color:black;'
			),
		),
		array( //链接类型的数据单元示例
			'class'=>'CLinkColumn'
		),
		array( //确认框类型的数据单元示例
			'class'=>'CCheckBoxColumn'
		),
		array( //按钮类型的数据单元示例
			'class'=>'CButtonColumn',
			'header'=>'默认的管理按钮',
			'buttons'=>array(
				//无法通过以下配置来更改删除按钮的默认的js行为
				//要实现自定制的删除按钮的js行为,可以通过自定义
				//整个删除按钮来实现
				'delete'=>array(
					'click'=>$delJs
				)
			)
		),
		array( //创建自己的删除按钮
			'class'=>'CButtonColumn',
			'template'=>'{del}', //按钮的渲染模板,只有标识出现在这里的按钮才会被渲染,默认是"{view} {update} {delete}"
			'header'=>'定制的删除按钮',
			'buttons'=>array( //可以定义一系列的按钮
				'del'=>array( //删除按钮
					'click'=>$delJs, //单击时js函数
					'url'=>'Yii::app()->controller->createUrl("user/delete",array("id"=>$data->uId))', //按钮的链接url
					'imageUrl'=>Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview/delete.png', //按钮的图片路径
					'options'=>array( //按钮标签的HTML属性
						'title'=>'删除'
					)
				)
			)
		)
	)
));
?>


<?php
$data=array(array('one'=>'first','two'=>'second'));
$keyField='one';

//$data=Yii::app()->db->createCommand('SELECT * FROM user')->queryAll();
//$keyField='uId';
$dataProvider=new CArrayDataProvider($data,array(
	'keyField'=>$keyField
));

$this->widget('zii.widgets.grid.CGridView',array(
	'dataProvider'=>$dataProvider,
));
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'CGridView',
	'renderHtml'=>false,
	'renderCode'=>false
));
?>
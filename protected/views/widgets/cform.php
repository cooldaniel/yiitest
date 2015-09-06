<?php ob_start(); ?>
<?php
$this->pageTitle='CForm test......';
//显示瞬间信息
if(Yii::app()->user->hasFlash('submit_data_user'))
	echo Yii::app()->user->getFlash('submit_data_user');
	
//用于创建特定表单的配置
$config=array(
	'title'=>'user login',
	'description'=>'input login infomation here please',
	'attributes'=>array( //<form>标签的HTML属性
		'style'=>'border:1px solid red; margin:1em; padding:1em; background-color:#EFEFEF;'
	),
	'elements'=>array( //元素类型见 {@see CFormInputElement::coreTypes}
		'uName'=>array(
			'visible'=>true,
			'type'=>'text',
			'class'=>'User_username_class',
			'id'=>'User_username_id',
			'name'=>'User_username_name', //这里定义的name属性不会被应用
			'value'=>'默认值'
		)
	),
	'buttons'=>array( //按钮类型见 {@see CFormButtonElement::coreTypes}
		'submit'=>array('type'=>'submit','visible'=>true,'value'=>'submit'),
		'reset'=>array('type'=>'reset','visible'=>true,'value'=>'reset')
	),
	'activeForm'=>array( //真正的表达对象
		'id'=>'user_form',
		'enableAjaxValidation'=>true,
		'method'=>'get',
		'action'=>$this->createUrl('user/index'),
		'clientOptions'=>array(
			
		),
		'htmlOptions'=>array(
			//
		)
	)
);
$form=new CForm($config,$model);
//一个表单
echo $form->render();

$config=array(
	'title'=>'用户登录',
	'description'=>'请填写以下登录信息',
	'method'=>'post', //优先级高于activeForm参数的method配置
	'inputElementClass'=>'CFormInputElement', //输入框类型元素的class属性值
	'buttonElementClass'=>'CFormButtonElement', //按钮类型元素的class属性值
	'attributes'=>array( //<form>标签的HTML属性
		'style'=>'border:1px solid red; margin:1em; padding:1em; background-color:#DEDEDE;'
	),
	'showErrorSummary'=>true, //是否汇总显示错误信息
	'elements'=>array( //元素类型见 {@see CFormInputElement::coreTypes}
		'username'=>array(
			'visible'=>true,
			'type'=>'text',
			'class'=>'User_username_class',
			'id'=>'User_username_id',
			'name'=>'User_username_name', //这里定义的name属性不会被应用
			'value'=>'默认值'
		),
		'password'=>array(
			'visible'=>true,
			'type'=>'password'
		),
		'form_02'=>$form
	),
	'buttons'=>array( //按钮类型见 {@see CFormButtonElement::coreTypes}
		'submit'=>array('type'=>'submit','visible'=>true,'value'=>'submit'),
		'reset'=>array('type'=>'reset','visible'=>true,'value'=>'reset')
	),
	'activeForm'=>array( //真正的表达对象
		'id'=>'user_form',
		'enableAjaxValidation'=>true,
		'method'=>'get',
		'action'=>$this->createUrl('user/index'),
		'clientOptions'=>array(
			
		),
		'htmlOptions'=>array(
			//
		)
	)
);
$form=new CForm($config,$model);
echo $form->render();

/**
 * CForm借助CActiveForm提供更轻便的基于AR数据模型创建表单的方法
 * 使用嵌套表单,可以将不同的表单提交到不同的url
 */
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'CForm'
));
?>
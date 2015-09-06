<?php
D::h();
$data=array(
	'user'=>array(
		'uName'=>'user_'.rand(),
		'uSex'=>rand(0,1),
		//'uEmail'=>'example@yahoo.cn',
		'uEmail'=>null,
		'uPwd'=>md5(time()),'uSn'=>1273849,
		'uMoney'=>789.9*rand(1,10),
		'uM'=>123.5*rand(1,100),
		
	),
	'infomation'=>array(
		'iNickName'=>'nickname_'.rand(),
		'iBirthday'=>time(),
		'iJob'=>'job_'.rand(),
		'iI.D.'=>'12345',
		'iUser'=>rand(1,3)
	)
);

$model->attributes=array(
	'uName'=>'user_'.rand(),
	'uSex'=>rand(0,1),
	//'uEmail'=>'example@yahoo.cn',
	'uEmail'=>null,
	'uPwd'=>md5(time()),'uSn'=>1273849,
	'uMoney'=>789.9*rand(1,10),
	'uM'=>123.5*rand(1,100),
);
$model->insert();
$model->attributes=$model->attributes=array(
	'uName'=>'user_'.rand(),
	'uSex'=>rand(0,1),
	//'uEmail'=>'example@yahoo.cn',
	'uEmail'=>null,
	'uPwd'=>md5(time()),'uSn'=>1273849,
	'uMoney'=>789.9*rand(1,10),
	'uM'=>123.5*rand(1,100),
);
//$model->update();


/*D::pd(date('Y-m-d H:i:s'));
for($i=0;$i<1;$i++)
	$model->insert($data);
D::pd(date('Y-m-d H:i:s'))*/;

//D::pd($model->update($data));
//D::pd($model->query('select * from user'));
//D::pd($model->queryRow('select * from user'));
//D::pd($model->queryAll('select * from user'));
//D::pd($model->queryColumn('select * from user'));
//D::pd($model->queryScalar('select * from user'));

/*$model=new TestData;
$model->validate();
//D::pd($model->getErrors());
//D::pd($model->attributes);
$model->one='one';
$model->two='two';
//D::pd($model->attributes);

$form=$this->beginWidget('CActiveForm',array(
	'id'=>'data',
	'enableAjaxValidation'=>true
));
echo $form->labelEx($model,'one');
echo $form->textField($model,'one');
echo $form->error($model,'one');
$this->endWidget();*/
?>
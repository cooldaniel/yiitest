<?php ob_start(); ?>
<?php
$this->breadcrumbs=array(
	'Cookie',
);

$request=Yii::app()->request;
$cc=$request->getCookies();

//读取cookie
function displayCookie()
{
	D::pd($_COOKIE);
	//D::pd($cc->toArray()); //以CHttpCookie对象为元素的数组
}

displayCookie();

//设置cookie
$cookie=new CHttpCookie('kkk','lll');
//$cookie->domain='www.yiitest.com'; //不存在的域名,客户端无法生成cookie
//$cookie->domain=''; //域名为空,生成域为url指定域的cookie
$cookie->expire=time()+86400;
$cc->add($cookie->name,$cookie);

//移除cookie
//$cc->remove($cookie->name);
?>
<?php $this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	'defaultClose'=>false,
	'legend'=>'cookie'
)); ?>
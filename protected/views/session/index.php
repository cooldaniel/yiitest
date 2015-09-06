<?php
/* @var $this SiteController */

$this->createPageTitle(array('session test'));



ini_set('session.gc_maxlifetime', 0);
ini_set('session.cookie_lifetime', 0);



//D::pde($_SESSION);

// 通过Yii应用程序实例来引用
$session = Yii::app()->getSession();
//$session->setTimeout(0);
$session['some'] = 'some';

D::pd(SID);
D::pd(array(
	'SID'=>SID,
	'session_name()'=>session_name(),
	'session_id()'=>session_id(),
	'getCookieParams'=>$session->getCookieParams(),
	
));

D::pde($_SESSION);

exit;

// 使用CHttpSession组件
$session = new CHttpSession;
$session->open();
$id = $session->getSessionId();
D::pd($id);
$session['some'] = 'some';
D::pd($session->toArray());

$session->regenerateID();
$id = $session->getSessionId();
D::pd($id);

$session->close();

// 使用session函数
session_start();
//session_regenerate_id();
$id = session_id();
D::pd($id);
$_SESSION['some'] = 'some';
D::pd($_SESSION);
session_write_close();


// 使用自定义的FileHttpSession
$session = new FileHttpSession;
$session->openSession(Yii::app()->getRuntimePath().'/sessiondata', '');
$id = $session->getSessionId();
D::pd($id);
$session->writeSession('some', 'some');
$session->writeSession('kkk', 'kkk');
$session->writeSession('daniel', 'daniel');
$session->close();










?>

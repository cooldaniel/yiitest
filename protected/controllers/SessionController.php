<?php

class SessionController extends Controller
{
    public function init()
    {
        parent::init();
        
        ini_set('session.gc_maxlifetime', 0);
        ini_set('session.cookie_lifetime', 0);
    }
    
    public function actionIndex()
    {	
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
        
        D::pd($_SESSION);
    }
    
    public function actionYii2()
    {
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
    }
    
    public function actionBase()
    {
        $output = array();
        
        // 使用session函数
        session_start();
        $_SESSION['some'] = 'some';
        $output[] = $_SESSION;
        
        session_destroy();
        $output[] = $_SESSION;
        
        setcookie('PHPSESSID', session_id(), -1);
        $output[] = $_SESSION;
        
        D::pd($output);
    }
    
    public function actionFile()
    {
        // 使用自定义的FileHttpSession
        $session = new FileHttpSession;
        $session->openSession(Yii::app()->getRuntimePath().'/sessiondata', '');
        $id = $session->getSessionId();
        D::pd($id);
        $session->writeSession('some', 'some');
        $session->writeSession('kkk', 'kkk');
        $session->writeSession('daniel', 'daniel');
        $session->close();
    }
}
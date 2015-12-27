<?php

/**
 * Yii 事件处理机制测试.
 * 
 * 详见代码注释中的步骤说明.
 * 
 * @package application.controllers
 */
class TestEventController extends Controller
{
    public function init()
    {
        parent::init();
        
        // 第3步：绑定事件
        $this->attachEventHandler('onBeginController', array($this, 'previousProcess'));
        $this->attachEventHandler('onAfterController', array($this, 'afteringProcess'));
        $this->attachEventHandler('onAfterController', array(__CLASS__, 'afteringProcessTwo'));
        $this->attachEventHandler('onAfterController', 'afteringProcessThreeForTestEventController');
    }
    
    public function actionIndex()
    {
        D::pd(__CLASS__);
        
        // 第4步：触发事件
        if ($this->hasEventHandler('onBeginController'))
            $this->onBeginController(new CEvent($this, array('foo'=>'123', 'bar'=>'abc')));
        if ($this->hasEventHandler('onAfterController'))
            $this->onAfterController(new CEvent($this, array('min'=>'789', 'max'=>'xyz')));
    }
    
    // 第1步：定义事件（内部触发事件的自动执行）
    // （定义事件即是指内部自动调用绑定的函数）
    public function onBeginController($event)
    {
        $this->raiseEvent('onBeginController', $event);
    }
    public function onAfterController($event)
    {
        $this->raiseEvent('onAfterController', $event);
    }
    
    // 第2步：定义事件处理器
    public function previousProcess($event)
    {
        D::pd(__METHOD__, $event, $event->params);
    }
    public function afteringProcess($event)
    {
        D::pd(__METHOD__, $event, $event->params);
    }
    public static function afteringProcessTwo($event)
    {
        // 静态方法用作事件处理器
        D::pd(__METHOD__, $event, $event->params);
    }
}

// 函数用作事件处理器
function afteringProcessThreeForTestEventController($event)
{
    D::pd(__FUNCTION__, $event, $event->params);
}
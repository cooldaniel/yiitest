<?php
/**
 * Yii 事件机制示例.
 * 
 * 该实例展示了以下方面：
 * 1.定义使用事件以及事件处理器的步骤和方法
 * 2.多种形式的事件处理器定义方式（实际上是多种形式的回调函数的定义方式）
 * 
 * @copyright lsx 2012/08/30
 * @package application.components
 */

class Event extends CComponent
{
	public function __construct()
	{
		// 绑定事件处理器
		$this->attachEventHandler('onClick', array($this, 'handlerOne'));
		$this->attachEventHandler('onClick', array(__CLASS__, 'handlerTwo'));
		$this->attachEventHandler('onClick', 'handlerThree');
		
		// 其它的一些代码
		// ......
		
		// 触发事件
		$this->triggerClick();
	}
	
	public function triggerClick()
	{
		// 为了安全，先检测是否绑定了事件处理器
		if($this->hasEventHandler('onClick'))
			$this->onClick(new CEvent($this,array('foo'=>'foo','bar'=>'bar')));
	}
	
	// 定义事件（即发起事件）
	public function onClick($event)
	{
		$this->raiseEvent('onClick',$event);
	}
	
	public function handlerOne($event)
	{
		echo 'handlerOne - ' .  $event->params[foo]. $event->params[bar] . '<br/>';
		// leave the event unhandled
		//$event->handled = true;
	}
	
	public static function handlerTwo($event)
	{
		echo 'handlerTwo - ' .  $event->params[foo]. $event->params[bar] . '<br/>';
		// leave the event unhandled
		//$event->handled = true;
	}
}

function handlerThree($event)
{
	echo 'handlerThree - ' .  $event->params[foo]. $event->params[bar] . '<br/>';
	// mark the event handled to stop continuting the event
	$event->handled = true;
}
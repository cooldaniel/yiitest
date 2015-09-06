<?php
/**
 * Yii behavior enhance 机制示例.
 * 
 * 行为附加宿主类BehaviorHost是CComponent的子类，具有附加和管理指定行为类的功能，
 * 该示例是从宿主类的角度来主动使用行为类增强自身，是合乎设计情理的使用行为类的方式.
 * 
 * BehaviorHost不仅仅调用Behavior的sayHell()方法，而且，还通过它的handlerOne()、
 * handlerTwo()方法来响应自己的onClick、onDbClick事件.但是，这种通过行为类来响应自身事件
 * 的好处是什么？
 * 
 * 在行为宿主类中定义事件，并且在行为类中定义事件处理器，这种协议是在CBehavior类中定义的.
 * CBehavior::attach()方法使用了一下语句实现了这种协议：
 *		$owner->attachEventHandler($event,array($this,$handler));
 * 其中$owner是行为宿主，$this是行为类，这就做了限制.
 * 
 * @copyright lsx 2012/08/30
 * @package application.components
 */

// 行为附加宿主测试类
class BehaviorHost extends CComponent
{
	public function __construct()
	{
		// 将行为Behavior附加到自己身上
		$this->attachBehavior('b','Behavior');
		
		$this->sayHello(); // 自己调用Behavior定义的sayHello方法
		$this->b->sayHello(); // 通过访问自身属性的方式访问Behavior
		
		$this->disableBehavior('b'); // 禁用
		$this->enableBehavior('b'); // 启用
		
		var_dump($this->asa('b')===null); // 判断指定的行为是否附加到自己身上，测试asa()方法的作用
		echo '<br/>';
		
		// 不要从behavior角度detach宿主，应该从宿主角度使用detachBehavior()销毁附加的行为对象
		// 这不合乎设计情理，因为CBehavior的attach()和detach()方法是行为类的使用接口方法，
		// 却不是行为宿主访问和管理行为的接口；行为宿主对此提供的接口在CComponent类中.
		// $this->b->detach($this);
		
		// 必须在附加行为后，因为事件处理器在行为类中
		// 注意：在前面使用attachBehavior()时会自动为事件指定处理器
		$this->triggerClick();
		$this->triggerDbClick();
		
		$this->detachBehavior('b'); // 正确的，合乎设计情理的销毁附加的行为Behavior对象的方法
	}
	
	public function triggerClick()
	{
		if($this->hasEventHandler('onClick'))
			$this->onClick(new CEvent($this), array('foo'=>'foo', 'bar'=>'bar'));
	}
	
	public function triggerDbClick()
	{
		if($this->hasEventHandler('onDbClick'))
			$this->onDbClick(new CEvent($this), array('foo'=>'foo', 'bar'=>'bar'));
	}
	
	public function onClick($event)
	{
		$this->raiseEvent('onClick', $event);
	}
	
	public function onDbClick($event)
	{
		$this->raiseEvent('onDbClick', $event);
	}
}

/**
 * 行为测试类
 * @package application.components
 */
class Behavior extends CBehavior
{
	public function sayHello()
	{
		echo 'Behavior says hello' . '<br/>';
	}
	
	// 为行为宿主的事件指定处理器
	public function events()
	{
		// 每个事件只需一个处理器
		return array_merge(parent::events(),array(
			'onClick' => 'handlerOne',
			'onDbClick' => 'handlerTwo',
		));
	}
	
	public function handlerOne($event)
	{
		echo 'handler for onClick of BehaviorHost' . '<br/>';
		$event->handled = true;
	}
	
	public function handlerTwo($event)
	{
		echo 'handler for onDbClick of BehaviorHost' . '<br/>';
		$event->handled = true;
	}
}
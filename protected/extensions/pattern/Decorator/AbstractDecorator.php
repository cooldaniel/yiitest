<?php
/**
 * 装饰模式抽象示例.
 * @version 2011.09.17
 * @author lsx
 */

/**
 * 客户端需要使用的类的接口,也就是装饰模式中要被装饰的类的接口.
 */
interface Component
{
	public function sampleOperation();
}

/**
 * 客户端实际使用的被装饰类,它将接受由装饰角色类附加给它的责任.
 */
class ConcreteComponent implements Component
{
	public function sampleOperation()
	{
		//在这里添加被装饰类的基本功能
	}
}

/**
 * 抽象装饰角色类.
 * 实现了客户端需要使用的接口{@see Component},因此它和它的子类和{@see ConcreteComponent}一样都是component,
 * 也就使得其构造函数可以接受ConcreteComponent或其子类或者Decorator或其子类两种类型的component,从而实现了责
 * 任嵌套叠加的效果.
 */
class Decorator implements Component
{
	private $_component;
	
	public function __construct($component)
	{
		$this->_component=$component;
	}
	
	public function sampleOperation()
	{
		$this->_component->sampleOperation();
	}
}

/**
 * 具体装饰角色类.
 */
class ConcreteDecorator1 extends Decorator
{
	public function sampleOperation()
	{
		parent::sampleOperation();
		$this->elseOperation();
	}
	
	public function elseOperation()
	{
		
	}
}

/**
 * 具体装饰角色类.
 */
class ConcreteDecorator2 extends Decorator
{
	public function sampleOperation()
	{
		parent::sampleOperation();
		$this->elseOperation();
	}
	
	public function elseOperation()
	{
		
	}
}

/**
 * 用例.
 */
$concreteComponent=new ConcreteComponent(); //首先是使用具体构件对象
$concreteDecorator1=new ConcreteDecorator1($concreteComponent); //给具体构件对象附加一项责任
$concreteDecorator2=new ConcreteDecorator2($concreteDecorator1); //给已经附加了一项责任的装饰结果对象附加更多的责任
// ...... 附加更多的责任
?>
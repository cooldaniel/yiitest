<?php
/**
 * 工厂方法模式抽象示例.
 * @version 2011.09.17
 * @author lsx
 */

/**
 * 抽象角色给出了该角色必须具备的接口,当需要增加该角色的具体类型时,只要实现对应接口就行.
 * 客户端对抽象角色的使用仅仅是通过其对外开发的接口,而不关心接口的内部实现.
 * 例如在简单工厂模式引入的ConcreteExample.php实例.
 */

interface Product
{
	
}

/**
 * 原简单工厂模式的工厂角色类变为现在的抽象工厂角色类,
 * 将不再负责所有产品的创建,而是将具体创建工作交给子类去做,
 * 仅负责给出具体工厂子类必须实现的接口,而不接触哪一个产品类应当被实例化这些细节.
 */
interface Creator
{
	public function factory();
}

class ConcreteCreator_1 implements Creator
{
	public function factory()
	{
		// 或者更负责的产品创建方式,具体参考简单工厂模式
		return new ConcreteProduct_1;
	}
}

class ConcreteCreator_2 implements Creator
{
	public function factory()
	{
		// 或者更负责的产品创建方式,具体参考简单工厂模式
		return new ConcreteProduct_2;
	}
}

class ConcreteProduct_1 implements Product
{
	public function __construct()
	{
		// 或者具有更丰富信息的产品,具体参考简单工厂模式
	}
}

class ConcreteProduct_2 implements Product
{
	public function __construct()
	{
		// 或者具有更丰富信息的产品,具体参考简单工厂模式
	}
}

// 使用
// 使用第一个工厂类创建该工厂类所负责的产品
$creator_1=new ConcreteCreator_1();
$product_1=$creator_1->factory();

// 使用第二个工厂类创建该工厂类所负责的产品
$creator_2=new ConcreteCreator_2();
$product_2=$creator_2->factory();

// 使用其它工厂类创建该工厂类所负责的产品
// ......
?>
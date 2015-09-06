<?php
/**
 * 从简单工厂模式角度探讨单例模式.
 * @version 2011.09.16
 * @author lsx
 */

/**
 * 从简单工厂模式角度探讨单例模式.
 * 首先,单例模式使用了简单工厂模式.单例模式体现的是具体产品类实例的唯一,简单工厂模式体现的是如何创建目标具体产品类实例,
 * 因此单例模式是对简单工厂模式的使用,而不是它的变体,即单例模式借助简单工厂模式来达到创建单例的目的.
 * 其次,被使用的简单工厂模式有若干种方式,完整的或者简化的,可以根据实际情况决定使用那一种具体的简单工厂模式来实现单例模式.
 */

/* ----- 方式一 ----- */

/**
 * 方式一：属于简单工厂模式中三种角色集于一身的情况.
 * 首先假设Single简单到没有抽象产品角色,也就是只有这么一个具体产品角色.
 * 其次将工厂类角色继承到Single中,使其能够使用自己的工厂方法创建自己的实例.
 * Single::single()使得可以在任何地方都可以使用这个唯一的单例实例.
 */

class Single
{
	private $_name;
	private static $_instance;
	
	//工厂方法
	public static function createSingle($name)
	{
		if(self::$_instance===null)
			self::createInstance($name);
		return self::$_instance;
	}
	
	//外部直接访问单例的静态方法
	public static function single()
	{
		return self::$_instance;
	}
	
	//创建自身单例的私有方法
	private static function createInstance($name)
	{
		self::$_instance=new Single;
		self::$_instance->_name=$name;
		return self::$_instance;
	}
	
	//单例实例的一个具体方法
	public function getName()
	{
		return $this->_name;
	}
}

//使用
$single=Single::createSingle('single'); //根据初始化配置创建单例对象
$single->getName(); //使用在创建后返回的单例
Single::single()->getName(); //直接通过静态方法引用单例

/* ----- 方式二 ----- */


/**
 * 方式二：属于简单工厂模式中没有抽象产品角色和具体产品角色基于一身的情况.
 * 首先假设Single简单到没有抽象产品角色,也就是只有这么一个具体产品角色.
 * 其次Factory代表工厂类角色提供了创建单例类实例的接口.
 * Factory::single()使得可以在任何地方都可以使用这个唯一的单例实例.
 * 尽管将工厂类角色和单例类角色分离开,但是由于单例类中使用了工厂类的{@see Factory::setSingle}使得单例模式得以实现.
 */

class Factory
{
	private static $_instance;
	
	//外部创建单例类实例的其中一个接口
	public static function createSingle($name)
	{
		return new Single($name);
	}
	
	//外部直接访问单例的静态方法
	public static function single()
	{
		return self::$_instance;
	}
	
	//任何外部设置单例类实例的方法
	public static function setInstance($instance)
	{
		if(self::$_instance===null||$instance===null)
			self::$_instance=$instance;
		else
			throw new CException('The single instance can only be created once.');
	}
}

class Single
{
	private $_name;
	
	//外部创建单例类实例的其中一个接口
	public function __construct($name)
	{
		Factory::setInstance($this);
		$this->_name=$name;
	}
	
	public function getName()
	{
		return $this->_name;
	}
}

//使用
$single=Factory::createSingle('single'); //通过工厂类单例类实例创建接口创建
$single->getName(); //使用在创建后返回的单例
Factory::single()->getName(); //使用工厂类的静态方法引用单例

$single=new Single('single'); //通过单例类的实例创建接口创建
$single->getName(); //使用在创建后返回的单例
Factory::single()->getName(); //使用工厂类的静态方法引用单例

?>
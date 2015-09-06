<?php
/**
 * 本文档展示了简单工厂模式的具体示例.
 * @version 2011.09.16
 * @author lsx
 */

//水果产品角色抽象接口.
interface Fruit
{
	//生长
	public function grow();	
	//收获
	public function harvest();
	//种植
	public function plant();
}

//葡萄,分无籽与有籽.
class Grape implements Fruit
{
	private $_seedless;
	
	public function grow()
	{
		
	}
	
	public function harvest()
	{
		
	}
	
	public function plant()
	{
		
	}
	
	public function getSeedless()
	{
		return $this->_seedless;
	}
	
	/**
	 * @param boolean 表示是否无籽葡萄的布尔值.
	 */
	public function setSeedless($value)
	{
		$this->_seedless=$value;
	}
}

//苹果,带树龄.
class Apple implements Fruit
{
	private $_treeAge;
	
	public function grow()
	{
		
	}
	
	public function harvest()
	{
		
	}
	
	public function plant()
	{
		
	}
	
	public function getTreeAge()
	{
		return $this->_treeAge;
	}
	
	/**
	 * @param floor 树龄值.
	 */
	public function setTreeAge($value)
	{
		$this->_treeAge=$value;
	}
}

//草莓.
class Strawberry implements Fruit
{
	public function grow()
	{
		
	}
	
	public function harvest()
	{
		
	}
	
	public function plant()
	{
		
	}
}

//请求错误的水果产品时的特定异常.
class BadFruitException
{
	private $_message;
	
	public function __construct($message)
	{
		$this->_message=$message;
	}
	
	public function getMessage()
	{
		return $this->_message;
	}
}

/**
 * 工厂类.
 * 根据传入的参量决定创建哪一种产品类的实例.
 * 根据其内部机制以及应用的不同,可以具体化为以下具体类型的设计:
 * (1)单例(任何时候都只创建一种产品的一个产品)
 * (2)直接返回创建的产品
 * (3)批量创建产品集
 */
class FruitGardener
{
	private static $_fruitNames=array('apple','grape','strawberry');
	
	public static function factory($fruitName)
	{
		if(in_array($fruitName,self::$_fruitNames))
		{
			//单例
			
			// 直接返回创建的产品
			return new ucfirst($fruitName);
			
			// 批量创建产品集
			
			// 其它类型设计
			// ......
		}
		else
			throw new BadFruitException($message);
	}
}

/**
 * 具体使用
 */
try
{
	// 直接返回创建的产品类型时
	$apple_01=FruitGardener::factory('apple');
	$apple_02=FruitGardener::factory('apple');
	$grape=FruitGardener::factory('grape');
	$strawbeery=FruitGardener::factory('strawbeery');
	// ......
}
catch(BadFruitException $e)
{
	// 处理异常
	// ......
}
?>
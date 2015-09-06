<?php
/**
 * 策略模式具体示例.
 * @version 2011.09.17
 * @author lsx
 */

/**
 * Java.awt类库运行时动态支持客户端决定一个Container对象怎么排列它所有的GUI组件.
 * 可用排列方式有: BorderLayout FlowLayout GridLayout GridBagLayout CardLayout.
 * 该示例展示了这些具体排列方式的动态选择.
 */

/**
 * 排序策略系统.
 */

/**
 * 环境角色类.
 * 供客户端使用,它借助抽象策略角色类使用具体的策略角色类进行排序.
 */
class Sorter
{
	/**
	 * 客户端指定具体的排序策略角色类.
	 */
	public $sortStrategy;
	
	public function sort()
	{
		$this->sortStrategy->sort();
	}
}

/**
 * 抽象策略角色类,指定具体策略角色类需要实现的功能.
 */
abstract class SortStrategy
{
	public abstract function sort();
}

/**
 * 具体策略角色类之二元排序类.
 */
class BinSort
{
	public function sort()
	{
		
	}
}

/**
 * 具体策略角色类之冒泡排序类.
 */
class BubbleSort
{
	public function sort()
	{
		
	}
}

/**
 * 具体策略角色类之堆栈排序类.
 */
class HeapSort
{
	public function sort()
	{
		
	}
}

/**
 * 具体策略角色类之快速排序类.
 */
class QuickSort
{
	public function sort()
	{
		
	}
}

/**
 * 具体策略角色类之基数排序类.
 */
class RadixSort
{
	public function sort()
	{
		
	}
}

/**
 * 购物车系统折扣示例(Shopping Cart System).
 * 示例中对每一个具体的折扣策略角色类都定义了构造函数、私有价格变量、价格获取方法,
 * 一是因为具体的折扣策略对象是在客户端创建的,创建时就可以给定特定价格数据通过该折
 * 扣策略类的构造函数创建折扣对象.二是希望创建的折扣对象只对应于这个给定的价格,也
 * 就是不希望后面还可以随时更改价格并计算新的折扣.同理,具体策略角色类中的其它属性设
 * 置也是出于此考虑.这是出于以上假设的一种实现,并不是规定要这样做,实际应用中可能会
 * 考虑总是使用一个折扣对象(单例)来用于任何打折情况.
 */

/**
 * 环境类.
 */
class DiscountCalculator
{
	/**
	 * @var DiscountStrategy 具体的折扣策略角色对象,由客户端决定使用那一种.
	 */
	public $discountStrategy;
	
	public function discount()
	{
		$this->discountStrategy->discount();
	}
}

/**
 * 策略抽象类.
 */
abstract class DiscountStrategy
{
	public abstract function discount();
}

/**
 * 具体策略类之不打折类.
 */
class NoDiscountStrategy
{	
	private $_price;
	
	public function __construct($price)
	{
		$this->_price=$price;
	}
	
	public function discount()
	{
		return 0;
	}
	
	/**
	 * @return floor 返回原价.
	 */
	public function getPrice()
	{
		return $this->_price;
	}
}

/**
 * 具体策略类之统一价折扣类.
 */
class FlatrateStrategy
{
	private $_flatrate;
	private $_price;
	
	public function __construct($price,$flatrate)
	{
		$this->_price=$price;
		$this->_flatrate=$flatrate;
	}
	
	public function discount()
	{
		return $this->_price*$this->flatrate;
	}
	
	/**
	 * @return floor 返回原价.
	 */
	public function getPrice()
	{
		return $this->_price;
	}
	
	/**
	 * @return floot 返回统一价.
	 */
	public function getFlatrate()
	{
		return $this->_flatrate;
	}
}

/**
 * 具体策略类之百分比折扣类.
 */
class PercentageStrategy
{
	private $_percentage;
	private $_price;
	
	public function __construct($price,$percentage)
	{
		$this->_price=$price;
		$this->_percentage=$percentage;
	}
	
	public function discount()
	{
		return $this->_price*$this->percentage;
	}
	
	/**
	 * @return floor 返回原价.
	 */
	public function getPrice()
	{
		return $this->_price;
	}
	
	/**
	 * @return floot 返回百分比.
	 */
	public function getPercentage()
	{
		return $this->_percentage;
	}
}
?>
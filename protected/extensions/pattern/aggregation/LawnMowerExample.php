<?php
/**
 * 聚合示例 -- 割草机装配.
 * @version 2011.09.17
 * @author lsx
 */

/**
 * 种类/分类/类与关联.
 * 
 * 几种引擎都可以用于某一种割草机: 引擎的分类可以按其中实现细节不同来分,因为这些类型的引擎的外部使用接口一样,所以可以用于同一种割草机,
 * 例如某种割草机可以使用若干种性能不同的引擎.
 * 
 * 某种引擎可以用于多种割草机: 从引擎的角度来看不存在分类问题,从割草机角度来看,导致这几种割草机分类的不是因为使用了这种引擎,而是因为其它.
 * 
 * 更完整专业的割草机装配系统:
 * 假设有若干种割草机: LawnMower1 LawnMower2 LawnMower3 ......
 * 假设有若干种刀片、引擎、车轮、挡板部件:
 * Blade1 Blade2 Blade3 ......
 * Engine1 Engine2 Engine3 ......
 * Wheel1 Wheel2 Wheel3 ......
 * Deck1 Deck 2 Deck3 ......
 * 且其中每一种刀片、引擎、车轮、挡板部件至少可以用于一种割草机,如此,部件与装配件是相互独立的.
 * 
 * 聚合体现部件拼凑成装配件的思想,装配件仅仅是使用各部件而已,当装配件不存在的时候,各部件可以存在,
 * 各部件只有按照该装配件的规格组合到一起才与该装配件形成部分与整体的关系.
 * 组合体现的是原本一开始这个部分就是整体的一部分,没有这个整体的话也就没有这个部分存在的意义.
 * 
 * 聚合的关键: 拼凑的部件如何获取?
 * 
 * 聚合阐明了类之间的关联,但没有指定要怎么实现.
 */

/**
 * 割草机装配件类.
 */
class LawnMower
{
	private $_bladeConfig;
	private $_engineConfig;
	private $_wheelsConfig;
	private $_deckConfig;
	
	//让割草机可以被个性定制.
	public function __construct($config)
	{
		$this->_bladeConfig=$config['blade'];
		$this->_engineConfig=$config['engine'];
		$this->_wheelsConfig=$config['wheels'];
		$this->_deckConfig=$config['deck'];
	}
	
	//获取刀片部件.
	protected function getBlade()
	{
		return new Blade($this->_bladeConfig);
	}
	
	//获取引擎部件.
	protected function getEngine()
	{
		return new Engine($this->_engineConfig);
	}
	
	//获取车轮部件.
	protected function getWheels()
	{
		$wheels=array();
		foreach($this->_wheelsConfig as $config)
			$wheels[]=new Wheel($config);
		return $wheels;
	}
	
	//获取挡板部件.
	protected function getDeck()
	{
		return new Deck($this->_deckConfig);
	}
	
	//组合各部件为整体.
	public function merge()
	{
		
	}
}

/**
 * 刀片部件类.
 */
class Blade
{
	public function __construct($config)
	{
		//配置实例
	}
}

/**
 * 引擎部件类.
 */
class Engine
{
	public function __construct($config)
	{
		//配置实例
	}
}

/**
 * 车轮部件类.
 */
class Wheel
{
	public function __construct($config)
	{
		//配置实例
	}
}

/**
 * 挡板部件类.
 */
class Deck
{
	public function __construct($config)
	{
		//配置实例
	}
}

/**
 * 割草机组装角色类.
 * 负责获取割草机需要的部件类实例并组装成割草机实例.
 */
class LawnMowerMaker
{
	
}
?>
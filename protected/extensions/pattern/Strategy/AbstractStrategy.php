<?php
/**
 * 策略模式抽象示例.
 * @version 2011.09.17
 * @author lsx
 * 
 * 这里假设只有一个具体的行为算法类,可作为策略模式的基本骨架.
 */

/**
 * 环境角色类.
 */
class Context
{
	private $strategy;
	
	public function contextInterface()
	{
		
	}
}

/**
 * 抽象策略角色类.
 * 给出所有具体策略角色类需要的接口.
 */
class Strategy
{
	public abstract function strategyInterface()
	{
		
	}
}

/**
 * 具体策略角色类.
 * 包装了相关的算法和行为.
 */
class ConcreteStrategy
{
	public function strategyInterface();
}
?>
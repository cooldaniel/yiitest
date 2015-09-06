<?php
/**
 * Oop test platform.
 * @version 2011.07.26
 */

// render the block title
$this->renderPartial('/layouts/block_single',array('back'=>$this->createUrl('php/index'),'title'=>'Oop'));

// test

/**
 * Normal class with static and non-static method.
 */
class one
{
	public function one()
	{
		D::pd('method one()');
	}
	
	public static function staticOne()
	{
		D::pd('static method staticOne()');
	}
}
$one=new one;
$one->one(); // Call non-static method by instance.
$one->staticOne(); // Call static method by instance.
//one::one(); // Fatal error: Non-static method one::one() cannot be called statically, assuming $this from incompatible context in E:\php\yiitest\protected\views\php\php_oop.php on line 27
one::staticOne(); // Call static method by statically.

/**
 * Abstract class.
 */
abstract class two
{
	abstract public function abstractOne();
	
	public function one()
	{
		D::pd('method one()');
	}
	
	public static function staticOne()
	{
		D::pd('static method staticOne()');
	}
}
two::one(); // Call non-static method by abstract class.
two::staticOne(); // Call static method by abstract class.
//$two=new two; // Fatal error: Cannot instantiate abstract class two in E:\php\yiitest\protected\views\php\php_oop.php on line 52
?>
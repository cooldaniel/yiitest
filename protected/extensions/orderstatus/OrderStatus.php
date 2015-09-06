<?php
/**
 * OrderStatus class file.
 * @version 2011.09.19
 * @author lsx
 */

/**
 * OrderStatus类表示订单状态项,其每一个实例对象均表示一个只读的订单状态项.
 * 每一个订单状态项都包括以下几项属性:
 * baseText: 状态想的状态点文本.
 * hintText: 状态项的状态预示文本.
 * currentText: 状态项标识当前状态的文本.
 * active: 是否已到达此状态点.
 * time: 该状态点设置的时间.
 * activeText: 当前状态文本,一般是{@link currentText}的补充,但可以作为它的替代文本.
 * 例如在显示订单状态流时显示currentText文本,但将此文本当做当前订单状态文本.如果在创建
 * 此状态项对象时没有设置此值,那么其默认取值等于currentText的值.
 * 
 * @todo
 * 1.是否应该添加一个标识来区分不同的状态点对象?
 * 分析:看在应用中是否需要通过区分不同的状态点对象来对特定的状态点进行操作.
 */
class OrderStatus extends CComponent
{
	private $_baseText;
	private $_hintText;
	private $_currentText;
	private $_isActive;
	private $_time;
	
	public function __construct($baseText,$hintText,$isActive,$time,$currentText=null)
	{
		$this->_baseText=$baseText;
		$this->_hintText=$hintText;
		$this->_isActive=$isActive;
		$this->_time=$time;
		$this->_currentText=$currentText===null?$this->_hintText:$currentText;
	}
	
	/**
	 * @return string 返回状态项的状态点文本.
	 */
	public function getBaseText()
	{
		return $this->_baseText;
	}
	
	/**
	 * @return string 返回状态项的状态预示文本.
	 */
	public function getHintText()
	{
		return $this->_hintText;
	}
	
	/**
	 * @return string 返回状态项表示当前状态的文本.
	 */
	public function getCurrentText()
	{
		return $this->_currentText;
	}
	
	/**
	 * @return boolean 返回标识状态项是否已发生的布尔值.
	 */
	public function getIsActive()
	{
		return $this->_isActive;
	}
	
	/**
	 * @return int 返回状态项发生时的时间戳.
	 */
	public function getTime()
	{
		return $this->_time;
	}
}
?>
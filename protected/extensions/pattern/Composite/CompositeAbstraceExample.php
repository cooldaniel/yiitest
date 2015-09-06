<?php
/**
 * 合成模式抽象示例.
 * @version 2011.09.17
 * @author lsx
 */

/**
 * 可能例子:
 * 1.PHP SPL DirectoryIterator: 迭代读取,只读,不带对读取到的对象的管理,读取对象的操作留给客户端,例如要删除一个目录下的所有非目录文件,
 * 首先借助该接口获取该目录下所有文件/目录对象,然后逐一判断是否为文件,是则删除,非则保留.
 * 2.PHP XML操作的DOM类树: DOMNode带有对子节点的管理.
 */

/**
 * 透明方式.
 */

/**
 * 
 */
interface Node
{
	public function add();
	
	public function remove();
	
	public function getChildNodes();
	
	public function hasChildNodes();
}

/**
 * 
 */
class LeafNode implements Node
{
	public function add()
	{
		
	}
	
	public function remove()
	{
		
	}
	
	public function getChildNodes()
	{
		
	}
	
	public function hasChildNodes()
	{
		return false;
	}
}

/**
 * 
 */
class BranchNode implements Node
{
	
	
	public function add()
	{
		
	}
	
	public function remove()
	{
		
	}
	
	public function getChildNodes()
	{
		
	}
	
	public function hasChildNodes()
	{
		
	}
}

/**
 * 安全方式
 */

/**
 * 
 */

/**
 * 
 */

/**
 * 
 */
?>
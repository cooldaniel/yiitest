<?php
class Data extends CFormModel
{
	private $_command;
	
	/**
	 * 添加记录
	 * 可以同时向多个表各自添加一条记录
	 * @param array 要添加的数据,格式如下:
	 * array(
	 * 		'table1'=>array(
	 * 			'field1'=>'value1',
	 * 			'field2'=>value2
	 *		),
	 * 		'table2'=>array(
	 * 			'field1'=>'value1',
	 * 			'field2'=>value2
	 *		)
	 * );
	 */
	public function insert($data)
	{
		foreach($data as $tableName=>$fields)
		{
			//构建sql模式
			$sql="INSERT INTO `{$tableName}`";
			$fieldsList=$valuesList='';
			foreach($fields as $field=>$value)
			{
				$paramName=$this->resolveParamName($field);
				$fieldsList.="`$field`,";
				$valuesList.=":$paramName,";
			}
			$fieldsList=rtrim($fieldsList,',');
			$valuesList=rtrim($valuesList,',');
			$sql.="($fieldsList) VALUES($valuesList)";
			$this->execute($sql,$fields);
		}
	}
	
	/**
	 * 更新记录
	 * 可以同时更新多个表的单条记录
	 * @param array 要新的数据,格式如下:
	 * array(
	 * 		'table1'=>array(
	 * 			'field1'=>'value1',
	 * 			'field2'=>value2
	 *		),
	 * 		'table2'=>array(
	 * 			'field1'=>'value1',
	 * 			'field2'=>value2
	 *		)
	 * );
	 */
	public function update($data)
	{
		foreach($data as $tableName=>$fields)
		{
			$sql="UPDATE `{$tableName}` SET ";
			$pairs='';
			foreach($fields as $field=>$value)
			{
				$paramName=$this->resolveParamName($field);
				$pairs.="`$field`=:$paramName,";
			}
			$sql.=rtrim($pairs,',');
			$this->execute($sql,$fields);
		}
	}
	
	/**
	 * 基于给定的sql语句创建CDbCommand对象并绑定参数执行
	 * @param string 给定的sql语句
	 * @param array 表字段与其值的键值对数组
	 */
	public function execute($sql,$params)
	{
		$c=$this->getCommand($sql);
		/*$c=Yii::app()->db->createCommand($sql);*/
		//绑定参数
		foreach($params as $field=>$value)
		{
			//注意:此循环中绑定参数使用引用变量方式,
			//因为bindParam()在command对象执行时
			//才根据变量名读取参数值
			if(is_string($value))
				$paramType=PDO::PARAM_STR;
			else if(is_bool($value))
				$paramType=PDO::PARAM_BOOL;
			else if(is_int($value))
				$paramType=PDO::PARAM_INT;
			else if(is_null($value))
				$paramType=PDO::PARAM_NULL;
			$paramName=$this->resolveParamName($field);
			$$paramName=$value;
			$c->bindParam(":$paramName",$$paramName,$paramType);
		}
		//D::pde($sql);
		//执行
		$c->execute();
	}
	
	/**
	 * 生成唯一的参数名字用于参数绑定
	 * @param string 字段的名字
	 * @return string 使用MD5函数生成唯一标识
	 */
	public function resolveParamName($param)
	{
		return 'p_'.md5($param);
	}
	
	public function query($sql)
	{
		$command=$this->getCommand($sql);
		return $command->queryRow();
	}
	
	public function queryRow($sql)
	{
		$command=$this->getCommand($sql);
		return $command->queryRow();
	}
	
	public function queryAll($sql)
	{
		$command=$this->getCommand($sql);
		return $command->queryAll();
	}
	
	public function queryColumn($sql)
	{
		$command=$this->getCommand($sql);
		return $command->queryColumn();
	}
	
	public function queryScalar($sql)
	{
		$command=$this->getCommand($sql);
		return $command->queryScalar();
	}
	
	/**
	 * 获取当前对象的CDbCommand对象
	 * @param string sql语句
	 * @return CDbCommand对象
	 */
	public function getCommand($sql)
	{
		//创建command对象
		if($this->_command===null)
			$this->_command=Yii::app()->db->createCommand($sql);
		else
			$this->_command->setText($sql);
		return $this->_command;
	}
	
	private static $_names;
	public function attributeNames()
	{
		$className=get_class($this);
		///if(!isset(self::$_names[$className]))
		//{
			$class=new ReflectionClass(get_class($this));
			$names=array();
			foreach($class->getProperties() as $property)
			{
				$name=$property->getName();
				if($property->isPublic() && !$property->isStatic())
					$names[]=$name;
			}
			//return self::$_names[$className]=$names;
			return $names;
		/*}
		else
			return self::$_names[$className];*/
	}
}
?>
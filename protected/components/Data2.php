<?php
class Data2 extends CFormModel
{
	private $_command;
	private $_new=false;
	
	public function __construct($scenario='')
	{
		$this->setIsNewRecord(true);
		parent::__construct($scenario);
	}
	
	public function tableName()
	{
		return get_class($this);
	}
	
	public function insert()
	{
		$tableName=$this->tableName();
		$sql="INSERT INTO `{$tableName}`";
		$attributeNames=$this->attributeNames();
		$fieldsList=$valuesList='';
		foreach($attributeNames as $attributeName)
		{
			$paramName=$this->resolveParamName($attributeName);
			$fieldsList.="`$attributeName`,";
			$valuesList.=":$paramName,";
		}
		$fieldsList=rtrim($fieldsList,',');
		$valuesList=rtrim($valuesList,',');
		$sql.="($fieldsList) VALUES($valuesList)";
		$this->execute($sql);
	}
	
	public function update()
	{
		if($this->getIsNewRecord())
			throw new CDbException(Yii::t('yii','The active record cannot be updated because it is new.'));
		$tableName=$this->tableName();
		$sql="UPDATE `{$tableName}` SET ";
		$pairs='';
		$attributeNames=$this->attributeNames();
		foreach($attributeNames as $attributeName)
		{
			$paramName=$this->resolveParamName($attributeName);
			$pairs.="`$attributeName`=:$paramName,";
		}
		$sql.=rtrim($pairs,',');
		$this->execute($sql);
	}
	
	public function setAttributes($values,$safeOnly=true)
	{
		parent::setAttributes($values,$safeOnly);
		$this->setIsNewRecord(false);
	}
	
	public function setIsNewRecord($value)
	{
		$this->_new=$value;
	}
	
	public function getIsNewRecord()
	{
		return $this->_new;
	}
	
	/**
	 * 基于给定的sql语句创建CDbCommand对象并绑定参数执行
	 * @param string 给定的sql语句
	 * @param array 表字段与其值的键值对数组
	 */
	public function execute($sql)
	{
		$c=$this->getCommand($sql);
		foreach($this->attributes as $field=>$value)
		{
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
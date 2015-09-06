<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 * 
 * @package application.models
 */
class DataTestModel extends CFormModel
{
	public $attrOne;
	public $attrTwo;
	public $attrThree;

	private $_identity;
	
	const DB_TYPE_MYSQL = 1;
	const DB_TYPE_MYSQLI = 2;
	const DB_TYPE_PDO = 3;
	const DB_TYPE_YII_DAO = 4;
	const DB_TYPE_YII_AR = 5;
	
	private $_mysqlConn;
	private $_mysqliConn;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	public function getDataList($type)
	{
		$dataList = array();
		
		if ($type === self::DB_TYPE_MYSQL)
		{
			$dataList = $this->getMysqlData();
		}
		elseif ($type === self::DB_TYPE_MYSQLI)
		{
			
		}
		elseif ($type === self::DB_TYPE_PDO)
		{
			
		}
		elseif ($type === self::DB_TYPE_YII_DAO)
		{
			$dataList = $this->getYiiDaoData();
		}
		else
		{
			$dataList = $this->getYiiArData();
		}
		
		return $dataList;
	}
	
	public function getMysqlConn()
	{
		if ($this->_mysqlConn === null)
		{
			$conn = mysql_connect('localhost', 'root', '123456');
			mysql_select_db('yiitest', $conn);
			$this->_mysqlConn = $conn;
		}
		return $this->_mysqlConn;
	}
	public function getMysqlData()
	{
		$dataList = array();
		
		$query = mysql_query($this->getSql(), $this->getMysqlConn());
		while($row = mysql_fetch_assoc($query))
		{
			$dataList[] = $row;
		}
		
		return $dataList;
	}
	
	public function getSql()
	{
		return "SELECT * FROM `user` LIMIT 3";
	}
	
	public function getYiiDaoData()
	{
		return Yii::app()->getDb()->createCommand($this->getSql())->queryAll();
	}
	
	public function getYiiArData()
	{
		$model = new User;
		
		$criteria = new CDbCriteria;
		$criteria->limit = 3;
		
		return $model->findAll($criteria);
	}
}

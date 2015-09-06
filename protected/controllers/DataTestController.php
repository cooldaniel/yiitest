<?php
/**
 * DataTestController Class file.
 * 
 * 在使用MVC结构的前提下，用该类对比DB数据操作方式，对比的情况按顺序有：
 * 1.用mysql扩展
 * 2.用mysqli扩展
 * 3.用PDO扩展
 * 4.用YII的DAO
 * 5.用YII的AR
 * 
 * @copyright lsx 2013/06/22
 * @package application.controllers
 */
class DataTestController extends Controller
{	
	private $_mysqlConn;
	private $_mysqliConn;
	
	public function actionIndex()
	{
		$mysqlData = $this->getMysqlData();
		$yiiDaoData = $this->getYiiDaoData();
		$yiiArData = $this->getYiiArData();
		
		$this->render('index', array(
			'mysqlData'=>$mysqlData,
			'yiiDaoData'=>$yiiDaoData,
			'yiiArData'=>$yiiArData,
		));
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
		$conn = $this->getMysqlConn();
		$sql = $this->getSql();
		$query = mysql_query($sql, $conn);
		while($row = mysql_fetch_assoc($query))
		{
			$dataList[] = $row;
		}
		//D::pd($dataList, 'mysql');
		return $dataList;
	}
	
	public function getSql()
	{
		$sql = "SELECT * FROM user LIMIT 3";
		return $sql;
	}
	
	public function getYiiConn()
	{
		return Yii::app()->getDb();
	}
	public function getYiiDaoData()
	{
		$dataList = array();
		$conn = $this->getYiiConn();
		$sql = $this->getSql();
		$dataList = $conn->createCommand($sql)->queryAll();
		//D::pd($dataList, 'YiiDao');
		return $dataList;
	}
	
	public function getYiiArData()
	{
		$model = new User;
		$criteria = new CDbCriteria;
		$criteria->limit = 3;
		$ars = $model->findAll($criteria);
		$dataList = $ars;
		D::pd($dataList, 'Yii ar');
		return $dataList;
	}
}
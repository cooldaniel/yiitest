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
 */
class DataTest2Controller extends Controller
{	
	public function init()
	{
		parent::init();
		$this->defaultAction = 'mysql';
	}
	
	public function actionMysql()
	{
		$model = new DataTestMysqlModel;
		$this->render('view', $model);
	}
	
	public function actionMysqli()
	{
		$model = new DataTestMysqlModeli;
		$this->render('view', $model);
	}
}
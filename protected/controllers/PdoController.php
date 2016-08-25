<?php

class PdoController extends Controller
{	
	public function init()
	{
		parent::init();
	}
	
	public function actionIndex()
	{
		$pdo = new PDO('mysql:dbname=yiitest;host=localhost', 'root', '123456');
		$sql = "SELECT * FROM user WHERE uId < 10";
		$statement = $pdo->prepare($sql);
	}
}
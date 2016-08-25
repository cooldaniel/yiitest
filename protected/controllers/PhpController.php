<?php
class PhpController extends Controller
{
	//index interface for php test page
	public function actionIndex()
	{
		$this->render('php');
	}
	
	//file system test
	public function actionFileSystem()
	{
		$this->render('php_fileSystem');
	}
	
	//Yii CHtml test
	public function actionChtml()
	{
		$this->render('php_CHtml');
	}
	
	//Misc test
	public function actionMisc()
	{
		$this->render('php_misc');
	}
	
	//Oop test
	public function actionOop()
	{
		$this->render('php_oop');
	}
	
	//Anything
	public function actionBlank()
	{
		$this->render('php_blank');
	}
}

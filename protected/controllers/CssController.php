<?php
class CssController extends Controller
{
	public function actionIndex()
	{
		$this->render('css');
	}
	
	//css style for table
	public function actionTable()
	{
		$this->render('css_table');
	}
}
?>
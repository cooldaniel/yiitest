<?php
class PhpMiscController extends Controller
{
	public function actionIndex()
	{
		$this->render('phpmisc');
	}
	
	public function actionFormSecurity()
	{
		if(isset($_POST['userinput']))
		{
			$d=addslashes($_POST['userinput']);
			
			//$sql="INSERT INTO 77frame.forall(`varchar`) VALUES('{$d}')";
			//D::log($sql);
			//Yii::app()->db->createCommand($sql)->query();
			
			$this->refresh();
		}
		$this->render('formSecurity');
	}
	
	// 弹窗提交表单
	public function actionPopupSubmit()
	{
		$this->render('popup_submit');
	}
	
	public function actionForm()
	{
		$this->layout='lite';
		$this->render('form');
	}
}

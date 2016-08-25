<?php
class FormController extends Controller
{
	public function actionIndex()
	{
		D::pds($_POST);
		
		$this->render('index');
	}
}
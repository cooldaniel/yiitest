<?php
class JsController extends Controller
{
	public function actionIndex()
	{
		$this->render('js');
	}
	
	//jQuery slide
	public function actionJquerySlide()
	{
		$this->render('js_jquery_slide');
	}
	
	//jQuery ajax
	public function actionJqueryAjax()
	{
		$this->render('js_jquery_ajax');
	}
	
	//jQuery plugin
	public function actionJqueryPlugin()
	{
		$this->render('js_jquery_plugin');
	}
	
	//module
	public function actionModule()
	{
		$this->render('js_module');
	}
	
	//ajax response test
	public function actionAjaxResponse()
	{
		if(isset($_REQUEST['id']))
			echo 'ajax response here with data: id='.$_REQUEST['id'];
		else
			echo 'ajax response here without data';
	}
	
	public function actionAjaxCommunicatePost()
	{
		echo $_POST['name'];
	}
	public function actionAjaxCommunicateGet()
	{
		echo $_GET['name'];
	}
	
	public function actionAjaxReload()
	{
		echo $this->render('fragements/list_1');
	}
}
?>
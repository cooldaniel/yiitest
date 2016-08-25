<?php

class CacheController extends Controller
{
	public function actionIndex()
	{
		//header('HTTP/1.1 304 Not Modified');
		header("expires=Thu, 01-Jan-2017 00:00:01 GMT");
		$this->render('index', array('rand'=>rand()));
	}
}
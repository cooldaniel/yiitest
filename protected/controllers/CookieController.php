<?php

class CookieController extends Controller
{
	public function actionIndex()
	{
		$this->pageTitle='cookie 测试';
		$this->render('index');
	}
}
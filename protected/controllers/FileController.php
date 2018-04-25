<?php

class FileController extends Controller
{
	public function actionIndex()
	{
		$this->pageTitle='文件系统遍历';

        $dir = $this->query->get('dir');

		$this->render('index');
	}
}
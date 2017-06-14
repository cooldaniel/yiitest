<?php
class FormController extends Controller
{
    public function actionIndex()
    {
        $this->withCoreJquery = true;
		$this->render('index');
    }
}



































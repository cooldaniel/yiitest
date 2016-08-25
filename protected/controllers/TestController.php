<?php

/**
 *
 * @package application.controllers
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        session_start();
        D::post();
        D::session();
        D::pd(Yii::getVersion());
    }

    public function actionPage()
    {
        $this->render('page');
    }

    public function actionIframe()
    {
        $this->render('iframe');
    }
}
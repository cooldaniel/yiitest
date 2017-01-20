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

    public function actionPhar()
    {
        D::pde('closed');
        $phar = new Phar('D:/phpunit.phar');
        D::pd('Begin');
        $phar->extractTo('D:/php/projects/yiitest/phpunit-src');
        D::pde('Done');
    }

    public function actionSocket()
    {
        D::bk();

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $con=socket_connect($socket,'127.0.0.1', 7379);
        if(!$con)
        {
            socket_close($socket);
            D::pde('can not connect');
        }
        echo "Link\n";

        D::pd($con);


        //while($con)
        {
            //$hear=socket_read($socket, 1024);
            //echo $hear;
            //$words=fgets(STDIN);
            $words = 'test';
            socket_write($socket,$words);
            //if($words=="bye\r\n"){
                //break;
            //}
        }
        socket_shutdown($socket);
        socket_close($socket);
    }
}
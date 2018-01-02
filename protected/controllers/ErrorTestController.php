<?php

set_error_handler('error_handler_here');

function error_handler_here($error, $message, $file, $line)
{
    restore_error_handler();
    restore_exception_handler();

    \D::pd(array('error: ', $error, $message, $file, $line));

    //exit;
    return false;
}

set_exception_handler('exception_handler_here');
function exception_handler_here($exception)
{
    restore_exception_handler();
    restore_error_handler();

    \D::pd($exception);
}

register_shutdown_function(function () {
    \D::pd(1);
    \D::pd(error_get_last());
});
register_shutdown_function(function () {
    \D::pd(2);
    \D::pd(error_get_last());
});
register_shutdown_function(function () {
    \D::pd(3);
    \D::pd(error_get_last());
});

class ErrorTestController extends Controller
{
    public function actionIndex()
    {
        throw new Exception('test');
    }

    public function actionOne()
    {
        new ddd();
        dd();
        \D::rand();
    }

    public function actionTwo()
    {
        try {
            //trigger_error('warning from two', E_USER_WARNING);
            //trigger_error('notice from two', E_USER_NOTICE);
            //trigger_error('error from two');
            echo $two;
            //throw new Exception('exception from two');
        } catch (Exception $e) {
            \D::fp();
            \D::pd($e);
            throw $e;
        }
    }

    public function actionThree()
    {
        sleep(10);
        \D::bk();
    }

    public function actionFour()
    {
        $data = $this->getData();
        if (!$data){
            echo '';
            exit;
        }

        foreach ($data as &$row) {
            $row['price'] = priceFormat($row['price']);
        }

        $map = $this->getMap();
        if (!$this->applyMap($data, $map)) {
            // fail to apply map
        }

        if (!$this->filterData($data)) {
            // fail to filter data
        }

        try {
            $res = $this->processData($data);
            if (!$res) {
                throw new Exception('');
            }
            $success = true;
        } catch (Exception $e) {
            $success = false;
            $this->log();
        }

        if ($success) {
            $json = json_encode($data);
            echo $json;
        } else {
            echo '';
        }
    }

    public function getData()
    {
        $id = getQuery('id');
        if (!$id){
            return false;
        }

        $data = [];

        $row = $this->getRow($id);
        if ($row){
            $data['name'] = $row['name'];
            $data['title'] = $row['title'];

            $item = $this->getItem();
            if ($item){
                $data['text'] = $item['text'];
            }
        }

        return count($data) ? $data : false;
    }

    public function getRow($id)
    {
        if (!is_int($id) || $id <= 0){
            return false;
        }

        $sql = "SELECT * FROM title WHERE id = '{$id}'";
        $res = Model::findRow($sql);
        return isset($res['id']) ? $res : false;
    }

    public function actionE()
    {
        $sql = "SELECD; * FROM table_not_exist";
        $c = Yii::app()->db->createCommand($sql);
        $r = $c->queryAll();
        D::pd($r);
    }
}
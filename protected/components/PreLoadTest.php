<?php


class PreLoadTest extends CApplicationComponent
{
    public function init()
    {
        parent::init();

        $this->autoLoadYiiExcel();

        //Yii::app()->attachEventHandler('onBeforeRequest',array($this,'setHttpResponseHeader'));
    }

    public function autoLoadYiiExcel()
    {
        // php excel
        Yii::import('ext.yiiexcel.YiiExcel', true);
        Yii::registerAutoloader(array('YiiExcel', 'autoload'), true);

        // Optional:
        //  As we always try to run the autoloader before anything else, we can use it to do a few
        //      simple checks and initialisations
        PHPExcel_Shared_ZipStreamWrapper::register();

        if (ini_get('mbstring.func_overload') & 2) {
            throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
        }
        PHPExcel_Shared_String::buildCharacterSets();
    }

    public function setHttpResponseHeader()
    {
        // 设置字符集
		header("Content-type: text/html; charset=utf-8");
    }
}
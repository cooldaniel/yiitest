<?php

/**
 * Yii 错误和日志测试.
 * 
 * 错误处理和日志是独立的：
 * 1.配置log处理日志.
 * 2.配置errorHandler, error_reporting(), YII_DEBUG, YII_TRACE_LEVEL, YII_ENABLE_EXCEPTION_HANDLER, YII_ENABLE_ERROR_HANDLER处理错误.
 * 
 * @package application.controllers
 */
class TestErrorLogController extends Controller
{  
    public function actionIndex()
    {
		// 打印未定义变量触发错误
        echo $d;
    }
	
	public function actionFunction()
	{
		test();
	}
	
	public function actionMethod()
	{
		$this->test();
	}
	
	public function actionClass()
	{
		new FooBarClass();
	}
}
<?php

require_once(dirname(__FILE__).'/../../D/autoload.php');
//require 'D:\code\xhgui\external\header.php';

require dirname(__FILE__).'/../protected/config/constans.php';

/**
 * 检查是否异步请求.
 * @return bool
 */
function getIsAjaxRequest()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
}

// 加载框架和配置
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';

// 调试模式
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
//defined('YII_DEBUG') or define('YII_DEBUG',isset($_GET['debug']));
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// 禁用Yii错误处理机制
//defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', false);
//defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', false);

// 要求处理除了 E_STRICT 之外的所有错误
//error_reporting(E_ALL | E_STRICT);

// 要求处理所有错误
error_reporting(E_ALL);

/*
// 使用自己的错误和异常处理函数
// 注意，这两个函数因为要在创建和运行Yii程序之前定义好，所以不能依赖Yii应用程序的惰性加载，
// 因此，要么像下面那样直接在该文件中定义，要么定义在一个外部文件中然后require_once进来.
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', false);
defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', false);
// 对应于Yii的handleError方法，用来处理PHP错误
function handleError(){
	restore_error_handler();
	restore_exception_handler();

	echo 'error or warning for PHP exception';
}

// 对应于Yii的handleException方法，用来处理开发者异常
function handleException(){
	restore_error_handler();
	restore_exception_handler();

	echo 'exception uncaptured';
}
set_error_handler('handleError');
set_exception_handler('handleException');
*/

require_once($yii);
$app = Yii::createWebApplication($config);

$app->run();
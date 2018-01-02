<?php

$path = Yii::app()->getBasePath() . '/vendors/psrlog/Psr/Log';
include $path . '/LoggerAwareInterface.php';
include $path . '/LoggerInterface.php';
include $path . '/AbstractLogger.php';
include $path . '/InvalidArgumentException.php';
include $path . '/LoggerAwareTrait.php';
include $path . '/LoggerTrait.php';
include $path . '/LogLevel.php';
include $path . '/NullLogger.php';
include $path . '/Logger.php';

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Psr\Log\Logger;

/**
 * 测试Yii的logging包使用
 * @copyright lsx 2012/10/24
 * @package application.controllers
 */
class LogController extends Controller
{
	public function actionIndex()
	{
		// 测试 info, trace, error, warning 四个级别的记录信息
		// 信息的分类信息用于告诉开发者记录的位置
		// 测试时，有些记录信息可能会写到 runtime 的记录文件中，这要看配置 log 组件的 CFileLogRoute 
		// 的 levels 选项值
		Yii::log('info_001',CLogger::LEVEL_INFO,'application');
		
		Yii::log('trace_001',CLogger::LEVEL_TRACE,'application');
		Yii::log('trace_002',CLogger::LEVEL_TRACE,'application');
		Yii::log('trace_003',CLogger::LEVEL_TRACE,'application');
		
		Yii::log('error_001',CLogger::LEVEL_ERROR,'application');
		Yii::log('error_002',CLogger::LEVEL_ERROR,'application');
		Yii::log('error_003',CLogger::LEVEL_ERROR,'application');
		
		Yii::log('warning_001',CLogger::LEVEL_WARNING,'php');
		Yii::log('warning_002',CLogger::LEVEL_WARNING,'php');
		Yii::log('warning_003',CLogger::LEVEL_WARNING,'php');
		
		Yii::log('warning_001',CLogger::LEVEL_WARNING,'system.web.CController');
		Yii::log('warning_002',CLogger::LEVEL_WARNING,'system.CModule');
		Yii::log('warning_003',CLogger::LEVEL_WARNING,'system.db.CDbConnection');
		
		
		// 使用专门的 profile log route
		// 分为 summary 和 callstack 两种显示方式
		Yii::beginProfile('ddd');
		sleep(1);
		
		Yii::beginProfile('d');
		sleep(0.5);
		Yii::endProfile('d');
		
		Yii::beginProfile('dd');
		sleep(1.5);
		Yii::endProfile('dd');
		
		Yii::endProfile('ddd');
		
		
		// 数据库操作，配置文件中开启CDbConnection::enableProfiling，所以会记录到profiling记录中
		$db=Yii::app()->db;
		//$db->createCommand('select * from user')->queryAll();
		$db->createCommand('select * from goods')->queryAll();
		//$db->createCommand('select * from infomation')->queryAll();
		
		$this->render('index');
	}

	public function actionPsr3()
    {
        $logger = new Logger;

        $message = "User {username} created";
        $context = array('username' => 'bolivar');
        $logger->notice($message, $context);

        $message = "User {username} created";
        $context = array('username' => 'jone');
        $logger->debug($message, $context);
    }

    /**
     * 分析带trace的日志代码如何组织.
     */
    public function actionTrace()
    {
        $data = [];

        if (!isset($data['foo'])){
            Yii::log('接口数据必须提供foo字段', CLogger::LEVEL_ERROR, 'application.product.sync');
        }


        // 错误的数据库请求
        $db=Yii::app()->db;
		//$db->createCommand('select * from user')->queryAll();
		$db->createCommand('select * from table_not_exists')->queryAll();
    }
}
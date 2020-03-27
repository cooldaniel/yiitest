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

    public function actionError()
    {
        Yii::log('trace', CLogger::LEVEL_TRACE);
        Yii::log('trace', CLogger::LEVEL_TRACE);
        Yii::log('trace', CLogger::LEVEL_TRACE);

        Yii::beginProfile('a');
        Yii::endProfile('a');

        \D::throw();

        \D::bk();

        // 错误生产者，产生的错误信息被CApplication::handleError()和CApplication::handleException()处理
        // 然后记录为CLogger::LEVEL_ERROR级别
        // 如果用php自带的错误报告，就会加上Notice、Warning、Fatal Error等前缀
        // 是否需要知道具体的细分类别？
        //
        // 除了php错误以外，系统里还有其它错误类型，因此CLogger组件定义的日志级别表示用户层错误级别含义
        // 例如：
        // 一个组件加载失败，可以是error、warning
        // 为了了解系统的加载过程，可以自己记录一些trace

        // user notice
//        \D::notice();

//        // notice
//        \D::($d);
//
//        // warning
//        include('ddd');
//
//        // error
//        dd();
//
//        // exception
//        \D::throw();

        // 如果想细分，可以重载这些handle方法，按补货到的错误类型加细分错误级别

        // 如果是php语法错误等产生的error日志，和系统里加载组件失败记录的error日志，它们用$category参数区分

        // 如果是exception则按类名和状态码做$category区分
    }

    public function actionLog()
    {
        // 日志记录组件：
        // 预定义错误类型
        // 用于调试
        Yii::log('info', CLogger::LEVEL_INFO);
        Yii::log('trace', CLogger::LEVEL_TRACE);
        Yii::log('profile', CLogger::LEVEL_PROFILE);
        // 用于重要错误
        Yii::log('warning', CLogger::LEVEL_WARNING);
        Yii::log('error', CLogger::LEVEL_ERROR);

        // 自定义类型
        Yii::log('dd', 'dd');

        // 可以根据标准的系统错误类型进行扩展

        // 记录的时候指定错误级别
        // 记录的时候错误信息保存到CLogger全局对象的$_logs数组里 - Yii::trace()的时候有YII_DEBUG限制，Yii::log()没有限制
        // autoFlush可以定量冲刷累计到内存里的数据，要么丢弃，要么刷到路由
        // 路由的时候可以有多种路由选择 - enabled属性决定是否开启路由
        // 每个路由都会独立收集关心错误级别的日志 - 收集的时候会过滤不关心级别的日志
        // 每个路由收集的日志，只有在$processLogs=true时才会进行路由处理 - autoFlush大于0时$processLogs=false会直接丢弃
        // 每个路由的路由处理操作（CLogRoute::processLogs()）都是直接进行路由介质操作，例如写文件、写数据库、发邮件等

        // 接下来要做什么？
        // 1.扩展CLogger错误类型
        // 2.扩展handle()方法
        // 3.知道在什么场景下使用main的log配置
    }

    public function actiondd()
    {
        // 使用场景收集

        // 加载系统组件、连接数据库、查询数据库、权限检查等，记录trace
        Yii::trace('Loading xxx', 'system.core');
        Yii::trace('Connect db', 'system.core.db');
        Yii::trace('Check permission', 'application.user.permission');

        // 依赖条件检测失败时，抛出异常，在捕获异常后记录日志
        // 注意：框架里数据库连接失败时区分YII_DEBUG而且增加调用了Yii::log()这样的处理是多余的，
        // 因为抛出异常后总是会被handle()捕获处理，而且它们会调用Yii::log()记录错误，增加调用会记录两次.
        // 另外，其它地方都没有这样的处理，说明通过抛出异常的方式捕获错误并记录日志，是一个常规简单的处理方式，
        // 因此可以做出这样的判断.
//        throw new CDbException('CDbConnection failed to open the DB connection.');
//        throw new EMongoException(Yii::t('yii', 'EMongoDB.connectionString cannot be empty.'));
//        throw new CDbException(Yii::t('yii','The EMongoDocument cannot be updated because it is new.'));
//        throw new CException(Yii::t('yii','CApcCache requires PHP apc extension to be loaded.'));
//        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
//        throw new CHttpException(403,'Denies the access of the user.');
//        throw new CDbException(Yii::t('yii','The relation "{relation}" in active record class "{class}" is specified with an invalid foreign key "{key}". There is no such column in the table "{table}".',
//					array('{class}'=>get_class($parent->model), '{relation}'=>$this->relation->name, '{key}'=>$fk, '{table}'=>$fke->_table->name)));
//        throw new CException(Yii::t('yii','Extension path "{path}" does not exist.',
//				array('{path}'=>$path)));
//        throw new CException(Yii::t('yii','The asset "{asset}" to be published does not exist.',
//			array('{asset}'=>$path)));
//        throw new CException(Yii::t('yii','Cannot add an item of type "{child}" to an item of type "{parent}".',
//				array('{child}'=>$types[$childType], '{parent}'=>$types[$parentType])));
//        throw new CException(Yii::t('yii','{controller} has an extra endWidget({id}) call in its view.',
//				array('{controller}'=>get_class($this),'{id}'=>$id)));
//        throw new CException(Yii::t('yii','{className} does not support get() functionality.',
//			array('{className}'=>get_class($this))));
//        throw new CException(Yii::t('yii','CCacheHttpSession.cacheID is invalid. Please make sure "{id}" refers to a valid cache application component.',
//				array('{id}'=>$this->cacheID)));
//        throw new CException(Yii::t('yii','GD with FreeType or ImageMagick PHP extensions are required.'));
//        throw new CException(Yii::t('yii','CCaptchaValidator.action "{id}" is invalid. Unable to find such an action in the current controller.',
//						array('{id}'=>$this->captchaAction)));
//        throw new CException(Yii::t('yii','Script HTML options are not allowed for "CClientScript::POS_LOAD" and "CClientScript::POS_READY".'));
//        throw new CException(get_class($this).'.codeModel property must be specified.');
//        throw new CException(Yii::t('yii','Invalid operator "{operator}".',array('{operator}'=>$this->operator)));
//        throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));
//        throw new CException(Yii::t('yii','The pattern for month must be "M", "MM", "MMM", "MMMM", "L", "LL", "LLL" or "LLLL".'));
//        if($itemName===$childName)
//			throw new CException(Yii::t('yii','Cannot add "{name}" as a child of itself.',
//					array('{name}'=>$itemName)));
//        throw new CException(Yii::t('yii','The $converter argument must be a valid callback or null.'));
//        public function getTemplatePath()
//        {
//            // 这里抛出http异常，虽然走的是抛出异常记录错误日志的方式，但在YII_DEBUG=false的时候，方便在页面上展示错误信息给用户
//            $templates=$this->getTemplates();
//            if(isset($templates[$this->template]))
//                return $templates[$this->template];
//            elseif(empty($templates))
//                throw new CHttpException(500,'No templates are available.');
//            else
//                throw new CHttpException(500,'Invalid template selection.');
//
//        }

        //
    }
}
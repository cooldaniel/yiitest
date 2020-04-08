<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Test',
	//'language'=>'zh_cn',
	
	// catch all request for maintaince. default is disabled.
	//'catchAllRequest'=>array('site/maintain'),

	// preloading 'log' component
	'preload'=>array('preLoadTest', 'log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.databuilder.*',
		'application.components.databuilder.dataschema.*',
		'application.helpers.*',
		'application.vendors.*',
        'application.vendors.phpexcel.PHPExcel',
        'application.traits.*',
        'application.models.mongodb.*',
        'ext.YiiMongoDbSuite.*',
        'ext.Mongo_db',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

		'admin'=>array(
			'class'=>'application.modules.admin.AdminModule',
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			//'urlSuffix'=>'shtml',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        'mongodb' => array(
            'class'            => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName'           => 'ueb_crm',
            'fsyncFlag'        => true,
            'safeFlag'         => true,
            'useCursor'        => false
        ),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		
		'db'=>array(
			//'connectionString' => 'mysql:host=192.168.3.54;dbname=yiitest',
            'connectionString' => 'mysql:host=localhost;dbname=yiitest',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
			'tablePrefix' => 'yii_',
			// 开启Yii系统内置的数据库性能分析开关
			// CDbConnection::getStats()记录了执行的SQL语句数量和总时间
			'enableProfiling' => true,
		),
        'db_laraveltest'=>array(
            // gii创建数据库连接的时候要指定class属性
            'class'=>'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=laraveltest',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
			'tablePrefix' => '',
			// 开启Yii系统内置的数据库性能分析开关
			// CDbConnection::getStats()记录了执行的SQL语句数量和总时间
			'enableProfiling' => true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
			//'errorAction'=>'site/customError',
			// 禁用该组件
			//'enabled'=>false,
			//'discardOutput'=>false,
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
                    // 总是默认打开
					'enabled'=>true,
                    // 调试模式记录更多调试信息，否则只记录重要错误
                    // 实际调试的时候，可以选择性手动切换需要关注的错误类型
                    'levels'=>YII_DEBUG ? 'error, warning, info, trace, profile' : 'error, warning',
					// 方便查看每次请求的上下文环境
//					'filter'=>'CLogFilter',
				),
				array(
					'class'=>'CWebLogRoute',
					// 调试模式而且是异步调用方式就打开
					'enabled'=>YII_DEBUG && !getIsAjaxRequest(),
					'enabled'=>false,
					'levels'=>'error, warning, trace, info, profile',
					// 方便查看每次请求的上下文环境
					'filter'=>'CLogFilter',
				),
				array(
					'class'=>'CProfileLogRoute',
					// 调试模式而且是异步调用方式就打开
                    'enabled'=>YII_DEBUG && !getIsAjaxRequest(),
					'enabled'=>false,
                    'report'=>'callstack',
					// filter选项对此route无效
					// 'filter'=>'CLogFilter',
				),
                array(
					'class'=>'CDbLogRoute',
					// 总是默认打开
					'enabled'=>true,
                    // 必须手动指定数据库连接ID，否则默认使用sqlite在runtime目录下创建数据库文件
                    'connectionID'=>'db',
                    // 表名字必须填写完整
                    'logTableName'=>'yiitest_log',
                    // 默认是自动创建表
                    'autoCreateLogTable'=>true,
                    'levels'=>'error, warning',
                    // filter选项对此route无效
                    // 'filter'=>'CLogFilter',
				),
			),
		),
//        'preLoadTest'=>array(
//            'class'=>'PreLoadTest',
//        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
	
);
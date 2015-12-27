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
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
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
			//'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yiitest',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
			// 开启Yii系统内置的数据库性能分析开关
			// CDbConnection::getStats()记录了执行的SQL语句数量和总时间
			'enableProfiling' => true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
			// 禁用该组件
			//'enabled'=>false,
			//'discardOutput'=>false,
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			//'enabled'=>false,
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					// 方便查看每次请求的上下文环境
					//'filter'=>'CLogFilter',
				),
				// uncomment the following to show log messages on web pages
				/*array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, error, warning, info',
					// 方便查看每次请求的上下文环境
					'filter'=>'CLogFilter',
				),
				array(
					'class'=>'CProfileLogRoute',
					// 输出结果展示方式
					//'report'=>'callstack',
					// filter选项对此route无效
					'filter'=>'CLogFilter',
				),*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
	
);
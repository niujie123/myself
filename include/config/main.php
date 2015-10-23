<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'萤火虫',
    'language' => 'zh_cn',
    'charset' => 'UTF-8',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'ext.yiimail.YiiMailMessage',
	),

	'modules'=>array(

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'showScriptName'=>false,    // 这一步是将代码里链接的index.php隐藏掉。
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<action:\w+>/<id:\d+>' 	=> 	'<controller>/<action>',
                '<controller:\w+>/p<page:\d+>' 			    => 	'<controller>',
                '<controller:\w+>/<action:\w+>/p<page:\d+>' => '<controller>/<action>',

                //产品列表
                '<controller:s>'							=> 	'product/index',
                '<controller:s>/<typeId:\d+>'				=> 	'product/index',
                '<controller:s>/<typeId:\d+>/<cate:\w+>'	=> 	'product/index',


                //其他
                '<controller:home>'							=>	'site/index',
                '<controller:index>'						=>	'site/index',
                '<controller:login>'						=>	'login/login',
                '<controller:register>'						=>	'login/register',
                '<controller:help>'							=>	'help/helpXintuo',
                '<controller:contactUs>'					=>	'contactUs/index',
                '<controller:404>'							=>	'site/404',
                '<controller:msg>'							=>	'site/msg',
                '<controller:app>'							=>	'site/app',
                '<controller:newUserGuide>'					=>	'site/newUserGuide',
                '<controller:frontReceive>'                 =>  'notify/frontReceive',
                '<controller:backReceive>'                  =>  'notify/backReceive',
                '<controller:downloadapp>'					=>	'mobile/downloadapp',

            ),
        ),
        'cache' => array(
            'class' => 'FMemCache',
            //'keyPrefix' => 'fireFly.com',
            'keyPrefix' => 'fireflymoney.com',
            'masterServers' => "127.0.0.1:11211",
            'slaveServers' => "127.0.0.1:11211",
        ),
        'db' => array(
            'class' => 'FDbConnection',
            'connectionString' => "mysql:host=localhost;dbname=firefly;port=3306",
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'Hello0617',
            'charset' => 'UTF8',
            'tablePrefix' => 'ff_',
            'enableParamLogging' => YII_DEBUG,
            //'schemaCacheID' => 'cache',
            'schemaCachingDuration' => YII_DEBUG ? 0 : 1800,
            'slaves' => array(
                array(
                    'connectionString' => "mysql:host=localhost;dbname=firefly;port=3306",
                    'emulatePrepare' => true,
                    'username' => 'root',
                    'password' => 'Hello0617',
                    'charset' => 'UTF8',
                    'tablePrefix' => 'ff_',
                    'enableParamLogging' => YII_DEBUG,
                    'schemaCacheID' => 'cache',
                    'schemaCachingDuration' => 0,
                )
            )
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'info,error,warning,trace',
                    'categories'=>'order.*',//日志分类，如：application.componets 不填写，表示全部类别
                    'logPath'=>FF_LOG_DIR,//日志存储目录
                    'logFile'=>'order.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'info,error,warning,trace',
                    'categories'=>'buy.*',//日志分类，如：application.componets 不填写，表示全部类别
                    'logPath'=>FF_LOG_DIR,//日志存储目录
                    'logFile'=>'buy.log',
                ),
                array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'trace',//提示的级别
                    'categories'=>'system.db.*',
                ),
            )
        ),
        'clientScript' => array(
            'class' => 'FClientScript',
        ),
        'mail' => array(
            'class' => 'ext.yiimail.YiiMail',
            'transportType' => 'php',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false,
            'transportType'=>'smtp',
            'transportOptions' => array(
                'host' => 'smtpcom.263xmail.com',
                'port' => '25',
                'username' => 'zhangchao@aladdin-holdings.com',
                'password' => '123.com'
            )
        ),
        'alipay' => array(
            'class' => 'ext.alipay.Alipay',
            'payment_type' => '1',
            'notify_url' => 'notify_url',
            'return_url' => 'return_url',
            'seller_email' => 'seller_email',
            'alipay_config' => array(
                'partner' => 'partner',
                'key' => 'key',
                'sign_type' => 'sign_type',
                'input_charset' => 'input_charset',
                'cacert' => 'cacert',
                'transport' => 'http'
            )
        ),
        'unionPay' => array(
            'class' => 'ext.unionPay.UnionPay',
        ),

        'clientScript' => array(
            'class' => 'CClientScript',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'xxx@xxx.com',
        'app_id' => 3,
        'app_secret' => 'k0jh4Fw0rz1JkIgRQ~xwabRo5c7PRGf2',
        'idCardApi_key'=>'01e0c1d6ebe68afe070f91c829443aaf',
    ),
);
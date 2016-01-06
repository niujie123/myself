<?php
/**
 * This is the configuration for web application dev
 *
 */
$_main = require dirname(__FILE__) . '/main.php';
unset($_main['components']['cache']);
unset($_main['components']['db']);
return CMap::mergeArray($_main, array(
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.yiidebugtb.*'
    ),

    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            'generatorPaths' => array(
                'application.gii'
            ),
            'ipFilters' => array('*.*.*.*'),
        )
    ),

    'components' => array(
        'cache' => array(
            'class' => 'FMemCache',
            'keyPrefix' => 'zc.fireFly.com',
            'masterServers' => "127.0.0.1:11211",
            'slaveServers' => "127.0.0.1:11211",
        ),
        'db' => array(
            'class' => 'FDbConnection',
            'connectionString' => "mysql:host=localhost;dbname=5azhaopin;port=3306",
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'UTF8',
            'tablePrefix' => '5a_',
            'enableParamLogging' => YII_DEBUG,
            //'schemaCacheID' => 'cache',
            'schemaCachingDuration' => FF_DEBUG ? 0 : 1800,
            'slaves' => array(
                array(
                    'connectionString' => "mysql:host=localhost;dbname=5azhaopin;port=3306",
                    'emulatePrepare' => true,
                    'username' => 'root',
                    'password' => '',
                    'charset' => 'UTF8',
                    'tablePrefix' => '5a_',
                    'enableParamLogging' => YII_DEBUG,
                    'schemaCacheID' => 'cache',
                    'schemaCachingDuration' => 0,
                )
            )
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

    'params' => array(
        'adminEmail' => 'xxx@xxx.com',
        'app_id' => 3,
        'app_secret' => 'k0jh4Fw0rz1JkIgRQ~xwabRo5c7PRGf2',
        'name'		=> 	'JIAJINGINFO',
        'crypt_key'	=>	'J2X8jExm1',
        'wapToPc'	=>	'wapToPc',
        'focus_appid'=>1021,
        'focus_key'=>'123456',
        'focus_url'=>'http://passportcs-test.apps.sohuno.com/p/user/nolog',
    ),

));

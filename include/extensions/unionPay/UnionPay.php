<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-4-28
 * Time: 上午10:33
 */
class UnionPay extends CApplicationComponent
{
    private static $registeredScripts = false;
    public $secureUtil;



    /**
     * Calls the {@link registerScripts()} method.
     */
    public function init() {
        $this->registerScripts();
        parent::init();
        $this->secureUtil = new SecureUtil();
    }
    public function pay($attr,$type="bank"){
        $log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
        $log->LogInfo ( "============处理前台请求开始===============" );
        // 初始化日志
        if ($type == "bank") {
            $merId = '898110260110001';
        } else {
            $merId = '898110260110002';
        }
        $params = array(
            'version' => '5.0.0',				//版本号
            'encoding' => 'utf-8',				//编码方式
            'certId' => $this->secureUtil->getSignCertId ($type),			//证书ID
            'txnType' => '01',				//交易类型
            'txnSubType' => '01',				//交易子类
            'bizType' => '000201',				//业务类型
            'frontUrl' =>  SDK_FRONT_NOTIFY_URL,  		//前台通知地址
            'backUrl' => SDK_BACK_NOTIFY_URL,		//后台通知地址
            'signMethod' => '01',		//签名方法
            'channelType' => '08',		//渠道类型，07-PC，08-手机
            'accessType' => '0',		//接入类型
            'merId' => $merId,		        //商户代码，请改自己的测试商户号
            'orderId' => $attr['order_id'],	//商户订单号
            'txnTime' => date('YmdHis'),	//订单发送时间
            'txnAmt' => $attr['order_fee']*100,		//交易金额，单位分
            'currencyCode' => '156',	//交易币种
            'defaultPayType' => '0001',	//默认支付方式
            //'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
            'reqReserved' =>' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        );

//        print_r($params);
//        exit;
        // 签名

        $this->secureUtil->sign ( $params ,$type);


        // 前台请求地址
        $front_uri = SDK_FRONT_TRANS_URL;
        $log->LogInfo ( "前台请求地址为>" . $front_uri );
        // 构造 自动提交的表单
        $html_form = create_html ( $params, $front_uri );

        $log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
        $log->LogInfo ( $html_form );
        $log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
        $log->LogInfo ( "============处理前台请求 结束===========" );
        echo $html_form;
    }
    public function searchOrder($attr,$type="bank"){
        $log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
        $log->LogInfo ( "============处理前台请求开始===============" );
        // 初始化日志
        if ($type == "bank") {
            $merId = '898110260110001';
        } else {
            $merId = '898110260110002';
        }
        $attr['txnTime'] = date("YmdHis",strtotime($attr['trade_time']));
        $params = array(
            'version' => '5.0.0',		//版本号
            'encoding' => 'utf-8',		//编码方式
            'certId' => $this->secureUtil->getSignCertId ($type),	//证书ID
            'signMethod' => '01',		//签名方法
            'txnType' => '00',		//交易类型
            'txnSubType' => '00',		//交易子类
            'bizType' => '000000',		//业务类型
            'accessType' => '0',		//接入类型
            'channelType' => '07',		//渠道类型
            'orderId' => $attr['trade_code'],	//请修改被查询的交易的订单号
            'merId' => $merId,	//商户代码，请修改为自己的商户号
            'txnTime' => $attr['txnTime'],	//请修改被查询的交易的订单发送时间				//业务类型
        );

//        print_r($params);
//        exit;
        // 签名

        $this->secureUtil->sign ( $params ,$type);


        // 前台请求地址
        $front_uri = SDK_SINGLE_QUERY_URL;
        $log->LogInfo ( "前台请求地址为>" . $front_uri );
        // 构造 自动提交的表单
        $html_form = create_html ( $params, $front_uri );
        $api_client  = new FApiClient();
        $res = $api_client->unionPaySend($front_uri,$params,"post");
        $log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
        $log->LogInfo ( $html_form );
        $log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
        $log->LogInfo ( "============处理前台请求 结束===========" );
        //echo $html_form;
        return $res;

    }
    /**
     * Registers swiftMailer autoloader and includes the required files
     */
    public function registerScripts() {
        if (self::$registeredScripts) return;
        self::$registeredScripts = true;
        require dirname(__FILE__).'/func/common.php';
        require dirname(__FILE__).'/func/SDKConfig.php';
        require dirname(__FILE__).'/func/secureUtil.php';
        //require dirname(__FILE__).'/func/log.class.php';

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-4-23
 * Time: 下午5:06
 */
class Alipay extends CApplicationComponent
{

    public $payment_type;

    public $notify_url ;

    public $return_url ;

    public $seller_email ;

    public $alipay_config ;

    private static $registeredScripts = false;




    /**
     * Calls the {@link registerScripts()} method.
     */
    public function init() {
        $this->registerScripts();
        parent::init();
    }
    public function submit(){
//        $alipay_config['partner']		= $this -> $partner;
//
//        $alipay_config['key']			= $this -> $key;
//
//        $alipay_config['sign_type']    = $this -> $sign_type;

        $this->alipay_config['input_charset']= strtolower('utf-8');

        $this->alipay_config['cacert']    = getcwd().'\\cacert.pem';

        $this->alipay_config['transport']    = 'http';

        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($this->alipay_config['partner']),
            "payment_type"	=> $this -> payment_type,
            "notify_url"	=> $this -> notify_url,
            "return_url"	=> $this -> return_url,
            "seller_email"	=> $this -> seller_email,
            "out_trade_no"	=> 'out_trade_no',
            "subject"	=> 'subject',
            "total_fee"	=> 'total_fee',
            "body"	=> 'body',
            "show_url"	=> 'show_url',
            "anti_phishing_key"	=> time(),
            "exter_invoke_ip"	=> $_SERVER['REMOTE_ADDR'],
            "_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
        );
        print_r($parameter);
        print_r($this->alipay_config);
    }

    /**
     * Registers swiftMailer autoloader and includes the required files
     */
    public function registerScripts() {
        if (self::$registeredScripts) return;
        self::$registeredScripts = true;
        require dirname(__FILE__).'/lib/alipay_submit.class.php';

    }
}
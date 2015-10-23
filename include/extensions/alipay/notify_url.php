<?php

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) 
{
	//验证成功

    if($_POST['trade_status'] == 'TRADE_FINISHED') 
    {
        log_result( "判断该笔订单是否在商户网站中已经做过处理" );//判断该笔订单是否在商户网站中已经做过处理
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS')
    {
		//判断该笔订单是否在商户网站中已经做过处理
        log_result( "判断该笔订单是否在商户网站中已经做过处理" );
    }

    log_result( "success" );			//请不要修改或删除
	
}
else 
{

    log_result( "field" );
}

function  log_result($word) {
    $fp = fopen("./alipay.txt","a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}
?>
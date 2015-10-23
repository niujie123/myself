<?php
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) 
{//验证成功
    print_r($_GET);
    echo '验证成功';
	echo json_encode(array('message'=>'验证成功'));
}
else 
{
	echo json_encode(array('message'=>'验证失败'));
}
?>
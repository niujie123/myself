<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-4-29
 * Time: 下午12:08
 * 银联支付公用方法
 */
class FUPayFn {
    /**
     * Author: gu_yongkang
     * data: 20110510
     * 密码转PIN
     * Enter description here ...
     * @param $spin
     */
    public static function  Pin2PinBlock( &$sPin )
    {
        //	$sPin = "123456";
        $iTemp = 1;
        $sPinLen = strlen($sPin);
        $sBuf = array();
        //密码域大于10位
        $sBuf[0]=intval($sPinLen, 10);

        if($sPinLen % 2 ==0)
        {
            for ($i=0; $i<$sPinLen;)
            {
                $tBuf = substr($sPin, $i, 2);
                $sBuf[$iTemp] = intval($tBuf, 16);
                unset($tBuf);
                if ($i == ($sPinLen - 2))
                {
                    if ($iTemp < 7)
                    {
                        $t = 0;
                        for ($t=($iTemp+1); $t<8; $t++)
                        {
                            $sBuf[$t] = 0xff;
                        }
                    }
                }
                $iTemp++;
                $i = $i + 2;	//linshi
            }
        }
        else
        {
            for ($i=0; $i<$sPinLen;)
            {
                if ($i ==($sPinLen-1))
                {
                    $mBuf = substr($sPin, $i, 1) . "f";
                    $sBuf[$iTemp] = intval($mBuf, 16);
                    unset($mBuf);
                    if (($iTemp)<7)
                    {
                        $t = 0;
                        for ($t=($iTemp+1); $t<8; $t++)
                        {
                            $sBuf[$t] = 0xff;
                        }
                    }
                }
                else
                {
                    $tBuf = substr($sPin, $i, 2);
                    $sBuf[$iTemp] = intval($tBuf, 16);
                    unset($tBuf);
                }
                $iTemp++;
                $i = $i + 2;
            }
        }
        return $sBuf;
    }
    /**
     * Author: gu_yongkang
     * data: 20110510
     * Enter description here ...
     * @param $sPan
     */
    public static function FormatPan(&$sPan)
    {
        $iPanLen = strlen($sPan);
        $iTemp = $iPanLen - 13;
        $sBuf = array();
        $sBuf[0] = 0x00;
        $sBuf[1] = 0x00;
        for ($i=2; $i<8; $i++)
        {
            $tBuf = substr($sPan, $iTemp, 2);
            $sBuf[$i] = intval($tBuf, 16);
            $iTemp = $iTemp + 2;
        }
        return $sBuf;
    }

    public static function Pin2PinBlockWithCardNO(&$sPin, &$sCardNO)
    {
        $sPinBuf = self :: Pin2PinBlock($sPin);
        $iCardLen = strlen($sCardNO);
//		$log->LogInfo("CardNO length : " . $iCardLen);
        if ($iCardLen <= 10)
        {
            return (1);
        }
        elseif ($iCardLen==11){
            $sCardNO = "00" . $sCardNO;
        }
        elseif ($iCardLen==12){
            $sCardNO = "0" . $sCardNO;
        }
        $sPanBuf = FormatPan($sCardNO);
        $sBuf = array();

        for ($i=0; $i<8; $i++)
        {
//			$sBuf[$i] = $sPinBuf[$i] ^ $sPanBuf[$i];	//十进制
//			$sBuf[$i] = vsprintf("%02X", ($sPinBuf[$i] ^ $sPanBuf[$i]));
            $sBuf[$i] = vsprintf("%c", ($sPinBuf[$i] ^ $sPanBuf[$i]));
        }
        unset($sPinBuf);
        unset($sPanBuf);
//		return $sBuf;
        $sOutput = implode("", $sBuf);	//数组转换为字符串
        return $sOutput;
    }

    public static function EncryptedPin($sPin, $sCardNo ,$sPubKeyURL)
    {
        global $log;
        $sPubKeyURL = trim(SDK_ENCRYPT_CERT_PATH," ");
        //	$log->LogInfo("DisSpaces : " . PubKeyURL);
        $fp = fopen($sPubKeyURL, "r");
        if ($fp != NULL)
        {
            $sCrt = fread($fp, 8192);
            //		$log->LogInfo("fread PubKeyURL : " . $sCrt);
            fclose($fp);
        }
        $sPubCrt = openssl_x509_read($sCrt);
        if ($sPubCrt === FALSE)
        {
            print("openssl_x509_read in false!");
            return (-1);
        }
        //	$log->LogInfo($sPubCrt);
        //	$sPubKeyId = openssl_x509_parse($sCrt);
        //	$log->LogInfo($sPubKeyId);
        $sPubKey = openssl_x509_parse($sPubCrt);
        //	$log->LogInfo($sPubKey);
        //	openssl_x509_free($sPubCrt);
        //	print_r(openssl_get_publickey($sCrt));

        $sInput = self ::Pin2PinBlockWithCardNO($sPin, $sCardNo);
        if ($sInput == 1)
        {
            print("Pin2PinBlockWithCardNO Error ! : " . $sInput);
            return (1);
        }
        $iRet = openssl_public_encrypt($sInput, $sOutData, $sCrt, OPENSSL_PKCS1_PADDING);
        if ($iRet === TRUE)
        {
            //		$log->LogInfo($sOutData);
            $sBase64EncodeOutData = base64_encode($sOutData);
            //print("PayerPin : " . $sBase64EncodeOutData);
            return $sBase64EncodeOutData;
        }
        else
        {
            print("openssl_public_encrypt Error !");
            return (-1);
        }
    }

    /**
     * 后台交易 HttpClient通信
     * @param unknown_type $params
     * @param unknown_type $url
     * @return mixed
     */
    public static function sendHttpRequest($params, $url) {
        header ( 'Content-type:text/html;charset=utf-8' );
        $opts = getRequestParamString ( $params );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);//不验证证书
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false);//不验证HOST
        curl_setopt ( $ch, CURLOPT_SSLVERSION, 3);
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
            'Content-type:application/x-www-form-urlencoded;charset=UTF-8'
        ) );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $opts );

        /**
         * 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
         */
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        // 运行cURL，请求网页
        $html = curl_exec ( $ch );
        // close cURL resource, and free up system resources
        curl_close ( $ch );
        return $html;
    }

    /**
     * 组装报文
     *
     * @param unknown_type $params
     * @return string
     */
    public static function getRequestParamString($params) {
        $params_str = '';
        foreach ( $params as $key => $value ) {
            $params_str .= ($key . '=' . (!isset ( $value ) ? '' : urlencode( $value )) . '&');
        }
        return substr ( $params_str, 0, strlen ( $params_str ) - 1 );
    }




}
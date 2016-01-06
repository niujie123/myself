<?php
/**
 * EJU API 客户端
 *
 * @category   API
 * @package    Api_Payment
 * @copyright
 * @license
 *
 */

class FApiClient
{
    private $_encrypt_methods = array('md5', 'sha1');
    private $_key;
    private $_data_type = 'json';
    private $_version = '1.0' ;

    public function __construct($key = '', $partner = 0, $version='')
    {
        $this->_key = Yii::app()->params['idCardApi_key'];
    }
    public function sendIdCardVerify($url, array $params, $request_method = 'get',array $header = array()) {

        $params['key'] = $this->_key;

        if ('get' == $request_method)
        {
            $result = $this->_curl_get($url, $params, $header,30);
        }
        else
        {
            $result = $this->_curl_post($url, $params, $header,30);
        }
        if (false !== $result )
        {
            //暂时支持JSON，或者原文，可扩展
            if ('json' == $this->_data_type)
            {
                $tmp = json_decode($result, true);

                $res = $this->inputFilter($tmp);

                return $res;
            }

        }

        return $result;
    }
    public function unionPaySend($url, array $params, $request_method = 'get',array $header = array()) {


        if ('get' == $request_method)
        {
            $result = $this->_curl_get($url, $params, $header,30);
        }
        else
        {
            $result = $this->_curl_post($url, $params, $header,30);
        }
        //echo $result;
        if (false !== $result )
        {
            $array =$this->_coverStringToArray($result);

            return $array;
        }

        return $result;
    }

    public function inputFilter($data) {

        if(is_string($data) && !empty($data)) {
            if(@json_decode($data)){
                return $data;
            }
            return htmlspecialchars($data);
        } elseif(is_array($data) && !empty($data)) {
            foreach ( $data as $key => $val ) {
                $data[$key] = $this->inputFilter($val);
            }
            return $data;
        } else {

            return $data;
        }
    }
    private function _coverStringToArray($str) {
        $result = array ();

        if (! empty ( $str )) {
            $temp = preg_split ( '/&/', $str );
            if (! empty ( $temp )) {
                foreach ( $temp as $key => $val ) {
                    $arr = preg_split ( '/=/', $val, 2 );
                    if (! empty ( $arr )) {
                        $k = $arr ['0'];
                        $v = $arr ['1'];
                        $result [$k] = $v;
                    }
                }
            }
        }
        return $result;
    }
    /**
     * 设置版本号
     *
     * @param string $version
     */
    public function set_version($version)
    {
        $this->_version = $version;
    }

    /**
     * 获取版本号
     *
     * @return string
     */
    public function get_version()
    {
        return $this->_version;
    }

    /**
     * 生成签名
     * @author zhangtao
     * @param array $params
     * @param string $encrypt_method
     * @param array $excepts
     * @return string
     */
    private function _sign(array $params, $encrypt_method = 'md5', $excepts = array())
    {
        if (!in_array($encrypt_method, $this->_encrypt_methods)) {
            //加密算法不存在，返回FALSE;
            return FALSE;
        }
        if($excepts) {
            foreach ($excepts as $key => $value) {
                unset($params[$value]);
            }
        }
        ksort($params);
        return $encrypt_method(http_build_query($params, '', '&').$this->_key);
    }

    /**
     * 提交POST请求，curl方法
     * @param string  $url       请求url地址
     * @param array   $data      POST数据
     * @param array   $header    头信息
     * @param int     $timeout   超时时间
     * @return array             请求结果,
     */
    private function _curl_post($url, $data = array(), $header = array(), $timeout = 30)
    {
        $data = empty($data['_no_http_query_']) ? http_build_query($data) : $data;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $info = curl_exec($ch);
        curl_close($ch);
        return $info;
    }

    /**
     * 提交GET请求，curl方法
     * @param string  $url       请求url地址
     * @param mixed   $data      GET数据,数组或类似id=1&k1=v1
     * @param array   $header    头信息
     * @param int     $timeout   超时时间
     * @return array             请求结果,
     */
    private function _curl_get($url, $data = array(), $header = array(), $timeout = 30)
    {
        $url =  $url.'?'.http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 0);
        set_time_limit(0);
        $info = curl_exec($ch);
        curl_close($ch);
        return $info;
    }

    /**
     * 获取客户端IP
     *
     * @return string
     */
    private function _get_client_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if (empty($ip)) $ip = '127.0.0.1';
        return $ip;
    }
}

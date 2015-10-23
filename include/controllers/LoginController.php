<?php
/**
 * 登录、退出
 *
 */
class LoginController extends FController
{
    private $access = array('login','register','getLogin');
    private $user_model;
    private $userInfo_model;

    public function __construct($id, $module = null) {

        parent::__construct($id, $module);
        $this->user_model = new User();
        $this->userInfo_model = new Userinfo();

    }

    protected function beforeAction($action) {

        parent::beforeAction($action);
        //若登录则无法访问
        if($this -> is_login() && in_array($action -> getId(), $this -> access)){

            $this->request->redirect(FF_DOMAIN);
        }

        return true;
    }
    public function actionLogin () {
        $returnUrl = FCookie::get("returnurl");
        if (!empty($returnUrl)) {
            //$returnUrl = rawurldecode($returnUrl);

            FCookie::del("returnurl");
        } else {
            $returnUrl = '';
        }
        $this->render('login',array('returnurl' => $returnUrl));
    }

    public function actionAgreement () {
        $this->render('agreement');
    }

    public function actionCallback ()
    {
        $ru = $this->request->getParam('referer');
        $arr_parse_url = parse_url($ru);
        $out=array();
        if(isset($arr_parse_url['query']))parse_str($arr_parse_url['query'],$out);
        //提取返回地址
        //if ($arr_parse_url['port']) {
        if (0) {
            $return_url = "{$arr_parse_url['scheme']}://{$arr_parse_url['host']}:{$arr_parse_url['port']}{$arr_parse_url['path']}";
        } else {
            $return_url = "{$arr_parse_url['scheme']}://{$arr_parse_url['host']}{$arr_parse_url['path']}";
        }
        //$return_url = "{$arr_parse_url['scheme']}://{$arr_parse_url['host']}{$arr_parse_url['path']}";

        unset($out['status']);
        !empty($out) && $return_url .= '?'.http_build_query($out);
        $url = empty($return_url) ? '/'  : $return_url;
        $this->request->redirect($url);

    }

    public function actionGetLogin(){
        $userName=$this->request->getParam('userName');
        $rememberme=$this->request->getParam('rememberme');
        $password=$this->request->getParam('password');
        $attr =array(
            'condition'=>"(phone_num=:phone_num and password=:password )or (email=:email and password=:password)",
            'params' => array(
                ':phone_num'=>$userName,
                ':email'=>$userName,
                ':password'=>md5($password),
            ),
        );

        $res = $this->user_model->find($attr);

        if ($res->id) {
            $response['status'] = 100000;
            $response['content'] = 'success';
            $this->saveCookie($res->id,$userName,$rememberme);
            Yii::app()->end(FHelper::json($response['content'],$response['status']));

        } else {
            $response['status'] = 100001;
            $response['content'] = '用户名或密码错误';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }

    }
    //验证短信发送
    public function actionSendMobileMess () {

        $sendMessage = new SendMessage();
        $response = array();

        $target=$this->request->getParam('target');
        $user_name=$this->request->getParam('user_name');
        $condition_user_name = array(
            'condition' => 'nick_name = :nick_name OR phone_num = :phone_num',
            'params' => array(
                ':nick_name' => $user_name,
                ':phone_num' => $user_name
            )
        );

        if(!empty($user_name)){
            $userList = $this->user_model->find($condition_user_name);
            $target = $userList->phone_num;
        }
        if(!$target){
            $response['content'] = '请输入目标手机号';
            $response['status'] = 100001;
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }

        if(empty($user_name)){
            if(!$this->verifyPhone($target)){
                $response['content'] = '该手机号已经被验证过来';
                $response['status'] = 100002;
                Yii::app()->end(FHelper::json($response['content'],$response['status']));
            }
        }

        $code = FHelper :: generate_code();
        $content = FConfig::item('siteMessage.register.first')
            .$code
            .FConfig::item('siteMessage.register.end');

        $user = FConfig::item('config.ws_mobile.userName');
        $pass = FConfig::item('config.ws_mobile.passWord');
        //查询发送条数
        $today = date('Y-m-d 0:0:0', time());
        $condition =
            array(
                'condition' => "mobile_no = '{$target}' and send_time >= '{$today}'",
            );
        $messageCount = $sendMessage->count($condition);
        if($messageCount < 5){
            Yii::import('ext.wsMobile.ws.*');
            require_once 'ws-demo.php';

            $engine = WS_SDK::getInstance ($user,$pass);
            $res = $engine->sendSmsAsNormal($target, $content, '', 0);


            if (intval($res) === 0) {
                //短息发送成功对短信进行加密
                $cryRes =Fn::crypt($code,FConfig::item('config.cookie.phone_code'));

                FCookie::set(FConfig::item('config.cookie.phone_key'),$cryRes);//放到cookie中

                $response['status'] = 100000;
                $response['content'] = $target; // 短信发送成功
                $telArr = array(
                    'mobile_no' => $target,
                    'mess_code' => $code,
                    'send_time' => FF_DATE_TIME,
                );
                $sendMessage->attributes = $telArr;
                $sendMessage->save();
            } else {
                $response['status'] = 100003;
                $response['content'] = '短信发送失败，请重试';
            }
        } else {
            $response['status'] = 100004;
            $response['content'] = '该手机号码今天发送验证码过多';
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }

    //登出
    public function actionLogout()
    {
        FCookie::set('auth', '' ,-3600);
        $this->request->redirect(FF_DOMAIN);
    }

    /**
     * 注册页
     */
    public function actionRegister(){

        $this->render('register');

    }

    /**
     * 等到验证码
     */
    public function actionGetCodeImg () {
        $an = new FCodeImge();
        $an->ext_num_type='';
        $an->ext_pixel = false; //干扰点
        $an->ext_line  = true; //干扰线
        $an->ext_rand_y= true; //y轴随机
        $an->green = 238;
        $an->create();

    }

    /**
     * 注册
     */
    public function actionGetRegister () {
        $response = array();
        $phone=trim($this->request->getParam('phone'));
        $email=trim($this->request->getParam('email'));
        $password=trim($this->request->getParam('password'));
        $checkCode=trim($this->request->getParam('checkCode'));
        $verifyMess=trim($this->request->getParam('verifyMess'));
        $verifyCode = FCookie::get(FConfig::item('config.cookie.phone_key'));
        $verifyCode = Fn::crypt($verifyCode,FConfig::item('config.cookie.phone_code'),'decode');

        if (!FHelper::FilterPhone($phone)) {
            $response['status'] = 100003;
            $response['content'] = '手机格式错误';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }

        if (!$this->verifyPhone($phone)) {
            $response['status'] = 100004;
            $response['content'] = '手机号已经注册过了';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }


        if (!FHelper::check_email($email)) {
            $response['status'] = 100003;
            $response['content'] = '邮箱格式错误';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }

        if (!$this->verifyEmail($email)) {
            $response['status'] = 100004;
            $response['content'] = '邮箱帐号已经注册过了';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }
        session_start();
        if ($checkCode != $_SESSION['verify_code']) {
            $response['status'] = 100004;
            $response['content'] = '校验码输入有误';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        }



        if ($verifyMess != $verifyCode) {
            $response['status'] = 100002;
            $response['content'] = '短信验证码验证失败';
        } else {

            $attr = array(
                'source_type' => 1,//网站注册
                'phone_num' => $phone,
                'email' => $email,
                'nick_name' => $email,
                'password' => md5($password),
                'register_ip' => ip2long(Fn::getIp()),
                'create_time' => FF_DATE_TIME,
                'update_time' => FF_DATE_TIME,
            );
            $this->user_model->attributes = $attr;
            if ($this->user_model->save() && $this->user_model->id) {

                $attr = array(
                    'user_id' => $this->user_model->id,
                );
                $this->userInfo_model->attributes = $attr;
                $this->userInfo_model->save();
                $response['status'] = 100000;
                $response['content'] = '注册成功';
                $attr['uid'] = $this->user_model->id;
                $this->user = $attr;

                $this->saveCookie($this->user_model->id,$this->user_model->nick_name,0);

                $_SESSION['auth_login'] = 'true';

                FCookie::del(FConfig::item('config.cookie.phone_key'));
                unset($_SESSION['verify_code']);
            } else {
                $response['status'] = 100002;
                $response['content'] = '注册失败';
            }

        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }

    public function actionVerifyPhoneAjax(){
        $phone=trim($this->request->getParam('phone'));
        if (!$this->verifyPhone($phone)) {
            Yii::app()->end('false');
        } else {
            Yii::app()->end('true');
        }
    }
    public function actionVerifyEmailAjax(){
        $email=trim($this->request->getParam('email'));
        if (!$this->verifyEmail($email)) {
            Yii::app()->end('false');
        } else {
            Yii::app()->end('true');
        }
    }
    private function verifyPhone ($phone) {
        $res_num = $this->user_model->count(
            array(
                'condition'=>"phone_num=:phone_num",
                'params' => array(':phone_num'=>$phone,),
            )
        );
        if ($res_num > 0) {
            return false;
        }
        return true;
    }
    private function verifyEmail ($email) {
        $res_num = $this->user_model->count(
            array(
                'condition'=>"email=:email",
                'params' => array(':email'=>$email,),
            )
        );
        if ($res_num > 0) {
            return false;
        }
        return true;
    }
    private function saveCookie ($uid,$email,$rememberme) {
        $salt = FF_SALT;
        //$timeout =  time()+60 * 60 * 24 * 7;
        $timeout =  time()+60 *15;
        $token = FHelper::auth_code("$uid\t$email\t$timeout", 'ENCODE', $salt);

        $attr =array(
            'token' =>  $token,
        );
        $this->user_model->updateByPk($uid,$attr);

        FCookie::set('auth', $token,60 *15);
        if ($rememberme) {
            FCookie::set('user_name', $email,60 * 60 * 24 * 7);
        } else {
            FCookie::set('user_name',$email,-1);
        }

    }

    public function actionGetPassword () {
        // 忘记密码
        $this->render('getPassword');
    }
    public function actionUpdatePwd () {
        $response = array();
        $user_phone = $this->request->getParam('user_phone');
        $new_pwd = trim($this->request->getParam('new_pwd'));
        $phone_code = trim($this->request->getParam('phone_code'));
        $verifyCode = FCookie::get(FConfig::item('config.cookie.phone_key'));
        $verifyCode = Fn::crypt($verifyCode,FConfig::item('config.cookie.phone_code'),'decode');

        if($phone_code != $verifyCode){
            $response['status'] = 100001;
            $response['content'] = '短信验证失败！';
        }else {
            $res = $this->user_model->updateAll(array('password'=>md5($new_pwd),),'phone_num=:phone',array(
                ':phone'=>$user_phone,
            ));
            if($res){
                $response['status'] = 100000;
                $response['content'] = '修改密码成功！';
            }else{
                $response['status'] = 100002;
                $response['content'] = '修改密码失败！';
            }
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }
}
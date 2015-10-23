<?php
class UserController extends FController
{
    private $product_model;
    private $productType_model;
    private $productPublish_model;
    private $userHeadInfo;
    private $user_model;
    private $userInfo_model;
    private $tradingRecord_model;
    private $userProductBuy_model;
    private $_api_url_idCard;
    private $withdrawCash_model;
    private $appoint_model;
    private $xintuoDetail_model;
    private $fundDetail_model;
    private $testTrade_model;

    public function __construct($id, $module = null) {

        parent::__construct($id, $module);
        $this->product_model = new Product();
        $this->productType_model = new ProductType();
        $this->productPublish_model = new ProductPublish();
        $this->user_model = new User();
        $this->userInfo_model = new Userinfo();
        $this->userProductBuy_model = new UserProductBuy();
        $this->tradingRecord_model = new TradingRecord();
        $this->withdrawCash_model = new WithdrawCash();
        $this->appoint_model = new Appoint();
        $this->xintuoDetail_model = new XintuoDetail();
        $this->fundDetail_model = new FundDetail();
        $this->testTrade_model = new TestTrade();
        $this->_api_url_idCard = "http://op.juhe.cn/idcard/query";

    }

    protected function beforeAction($action) {

        parent::beforeAction($action);

        //若登录则无法访问
        if(!$this -> is_login()){
            FCookie::set("returnurl",$this->returnurl);
            $this->request->redirect("/login");
        }
        return true;
    }
    public function actionIndex () {
        $data = array();
        //我的理财产品
        $user_id = $this->user['id'];
        $attr = array(
            'order' => 'create_time DESC',
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' =>$user_id,),
        );
        $userProBuyList = $this->userProductBuy_model->findAll($attr);
        $sumBuyVal = 0.00;
        foreach($userProBuyList as $userProVal){
            $buyPro = $userProVal->getAttributes();
            $buyPro['product'] = $userProVal->publish->product;
            $data['userProBuyList'] [] = $buyPro;
            $sumBuyVal+=$buyPro['buy_val'];
        }
        $data['buy_status_mess'] = FConfig::item('config.buy_status_mess');
        $res = $this->productPublish_model->findAll(array(
            'order' => 'create_time DESC',
            'condition' => 'publish_personal =:publish_personal and publish_status = :publish_status',
            'params' => array(":publish_personal"=>1,":publish_status"=>1,),
        ));

        foreach ($res as $val) {
            $publish = $val->getAttributes();
            $publish['product'] = $val->product->getAttributes();

            $condition_arr = array(
                'select' => 'sum(buy_val) as sum_buy_val',
                'condition' => 'p_id = :p_id',
                'params' => array(':p_id'=>$publish['id']),
            );
            $buy_res = $this->userProductBuy_model->find($condition_arr);
            $condition_test = array(
                'select' => 'sum(money) as sum_money',
                'condition' => 'product_id = :pub_id',
                'params' => array(':pub_id'=>$publish['id']),
            );
            $testMoney = $this->testTrade_model->find($condition_test);
            $publish['sum_buy_val'] = $buy_res->sum_buy_val+$testMoney->sum_money;
            $condition_count_user = array(
                'group' => 'user_id',
                'condition' => 'p_id = :p_id',
                'params' => array(':p_id'=>$publish['id']),
            );
            $user_res = $this->userProductBuy_model->count($condition_count_user);
            $publish['count_user'] = $user_res;
            $data['publish_list'][] = $publish;
        }
        $data['proTypes'] = $this->getProductType();
        $data['userHeadInfo'] = $this->userHeadInfo;
        $data['sumBuyVal'] = floatval($sumBuyVal);
        $data['guarantee_levels'] = FConfig::item('config.guarantee_levels');
        $this->render('index',$data);
    }

    public function actionUserInfo() {
        $data = array();
        $userHeadInfo = array();
        $data['user'] = $this->user;
        $data['userInfo'] = $this->userInfo;
        $userHeadInfo['email_check'] = $this->userInfo['email_check'];
        $userHeadInfo['bank_check'] = $this->userInfo['bank_check'];
        if ($this->user['phone_num']) {
            $userHeadInfo['phone_check'] = 1;
        }else {
            $userHeadInfo['phone_check'] = 0;
        }
        if ($this->userInfo['person_id']) {
            $userHeadInfo['person_id'] = 1;
        }else {
            $userHeadInfo['person_id'] = 0;
        }

        $userHeadInfo['level'] = $userHeadInfo['email_check']+$userHeadInfo['bank_check']+$userHeadInfo['person_id']+$userHeadInfo['phone_check'] ;
        $levels = FConfig::item("config.user_level");
        $userHeadInfo['level_name'] = $levels[$userHeadInfo['level']];

        $userHeadInfo['progress'] =intval($userHeadInfo['level']/4*100);
        $data['userHeadInfo'] = $userHeadInfo;
        $this->render('userInfo',$data);
    }

    public function actionInvest() {
        $tDate = $this->request->getParam('tDate');
        $tTime = FConfig::item('config.time_type.'.$tDate);

        $data = array();
        $user_id = $this->user['id'];
        $where = '1=1 and user_id=:user_id';
        if(!empty($tDate)){
            $where .= " and create_time >= :create_time ";
            $data['tDate'] = $tDate;
        }
        $condition_attr = array(
            'condition' =>$where,
            'order'=>'create_time DESC',
        );
        $condition_attr['params'][':user_id'] = $user_id;
        if(!empty($tDate)){
            $condition_attr['params'][':create_time'] = $tTime;
        }
        $userProductBuyList = $this->userProductBuy_model->findAll($condition_attr);
        $data['userProductBuyList'] = $userProductBuyList;
        foreach($userProductBuyList as $userProductBuy){
            $proPublish[$userProductBuy->id] = $this->productPublish_model->findByPk($userProductBuy->p_id);
        }
        $data['proPublish'] = $proPublish;
        $condition_arr_start = array(
            'condition' => 'user_id=:user_id and buy_status=:buy_status',
            'params' => array(':user_id' => $user_id,':buy_status'=>1)
        );
        $data['count_start'] = $this->userProductBuy_model-> count($condition_arr_start);
        $condition_arr_ing = array(
            'condition' => 'user_id=:user_id and buy_status=:buy_status',
            'params' => array(':user_id' => $user_id,':buy_status'=>2)
        );
        $data['count_ing'] = $this->userProductBuy_model-> count($condition_arr_ing);
        $condition_arr_end = array(
            'condition' => 'user_id=:user_id and buy_status=:buy_status',
            'params' => array(':user_id' => $user_id,':buy_status'=>3)
        );
        $data['count_end'] = $this->userProductBuy_model-> count($condition_arr_end);

        $this->render('invest',$data);
    }

    public function actionRecharge() {
        $data = array();
        $attr = array(
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' =>$this->user['id'],),
        );
        $userProBuyList = $this->userProductBuy_model->findAll($attr);
        $sumBuyVal = 0.00;
        foreach($userProBuyList as $userProVal){
            $buyPro = $userProVal->getAttributes();
            $sumBuyVal+=$buyPro['buy_val'];
        }
        $data['sumBuyVal'] = $sumBuyVal;
        $dType = $this->request->getParam('dType');
        $rType = $this->request->getParam('rType');
        $dTime = FConfig::item('config.time_type.'.$dType);
        if($rType == 3){

            //分页参数
            $page = ($this->request->getParam('page') > 0) ? (int) $this->request->getParam('page') : 1;
            $page_size = ($this->request->getParam('size') > 0) ? (int) $this->request->getParam('size') : FConfig::item('config.pageSize');
            $where = "1=1";
            $where .= " and user_id = {$this->user['id']}";

            if(!empty($dType)){
                $where .= " and create_time >= :create_time";
                $data['dType'] = $dType;
            }

            $condition_arr = array(
                'condition' =>$where,
                'order' => 'create_time DESC',
                'limit' => $page_size,
                'offset' => ($page - 1) * $page_size ,
            );
            $condition_arr['params'] = array();
            if(!empty($dType)){
                $condition_arr['params'][':create_time'] = $dTime;
            }
            $data['cashList'] = $this->withdrawCash_model->findAll($condition_arr);

            $data['count'] = $this->withdrawCash_model-> count($condition_arr);
            $pages = new FPagination($data['count']);
            $pages->setPageSize($page_size);
            $pages->setCurrent($page);
            $pages->makePages();

            $data['page'] = $pages;
        }

//分页参数
        $page = ($this->request->getParam('page') > 0) ? (int) $this->request->getParam('page') : 1;
        $page_size = ($this->request->getParam('size') > 0) ? (int) $this->request->getParam('size') : FConfig::item('config.pageSize');
        $where = "1=1";
        $where .= " and user_id = {$this->user['id']} and trade_status=1";
        if(!empty($rType)){
            $where .= " and trade_type = :trade_type";
            $data['rType'] = $rType;
        }

        if(!empty($dType)){
            $where .= " and trade_time >= :trade_time";
            $data['dType'] = $dType;
        }

        $condition_arr = array(
            'condition' =>$where,
            'order' => 'trade_time DESC',
            'limit' => $page_size,
            'offset' => ($page - 1) * $page_size ,
        );
        $condition_arr['params'] = array();
        if(!empty($dType)){
            $condition_arr['params'][':trade_time'] = $dTime;
        }
        $tType = FConfig::item("config.r_type.".$rType);
        if(!empty($rType)){
            $condition_arr['params'][':trade_type'] =FConfig::item("config.trade_type.".$tType);
        }

        $data['tradeList'] = $this->tradingRecord_model->findAll($condition_arr);

        $data['count'] = $this->tradingRecord_model-> count($condition_arr);
        $pages = new FPagination($data['count']);
        $pages->setPageSize($page_size);
        $pages->setCurrent($page);
        $pages->makePages();


        $data['tradeList'] = $this->tradingRecord_model->findAll($condition_arr);
        $data['page'] = $pages;
        $this->render('recharge',$data);
    }
    public function actionVerifyMail(){
        $email = $this->request->getParam("email");
        $user = $this->user_model->findByAttributes(array('email'=>$email));
        $nick_name = $user->nick_name;
        $subject = '萤火虫理财中心：邮箱绑定';


        $uid = $this->user['id'];
        $to_email = $this->user['email'];
        $timeout =  time()+60*60*24;

        $token = Fn::crypt("$uid,$to_email,$timeout",FF_SALT);
        $verifyUrl = FF_DOMAIN;
        $verifyUrl.= "/v/verifyEmail/?t=".urlencode($token);
        $body = FConfig::item('config.mail_content.head_a')
            .$nick_name
            .FConfig::item('config.mail_content.head_b')
            .FF_DATE_TIME
            .FConfig::item('config.mail_content.body')
            .'<a href='.$verifyUrl.'>'.$verifyUrl.'</a>'
            .FConfig::item('config.mail_content.foot');

        $res = FMail::send($email,$subject,$body);
        if($res){
            $response['status'] = 100000;
            $response['content'] = '发送邮件成功！';
        }else{
            $response['status'] = 100001;
            $response['content'] = '发送邮件失败！';
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }
    public function actionToRecharge () {
        $this->render('rechargeReal');
    }

    public function actionUpdatePwd(){

        $this->render('updatePwd');
    }

    public function actionVerifyPwdAjax(){
        $pwd=trim($this->request->getParam('pwd'));
        if ($this->verifyPwd($pwd)) {
            Yii::app()->end('true');
        } else {
            Yii::app()->end('false');
        }
    }
    private function verifyPwd ($pwd) {
        $res_num = $this->user_model->count(
            array(
                'condition'=>"password=:password and id=:id",
                'params' => array(
                    ':password'=>md5($pwd),
                    ':id' => $this->user['id'],
                ),
            )
        );
        if ($res_num > 0) {
            return true;
        }
        return false;
    }

    public function actionVerifyPwd(){
        $old_pwd = trim($this->request->getParam('old_pwd'));
        $new_pwd = trim($this->request->getParam('new_pwd'));
        $phone_code = $this->request->getParam('phone_code');
        $verifyCode = FCookie::get(FConfig::item('config.cookie.phone_key'));
        $verifyCode = Fn::crypt($verifyCode,FConfig::item('config.cookie.phone_code'),'decode');

        if ($phone_code != $verifyCode) {
            $response['status'] = 100002;
            $response['content'] = '短信验证码验证失败';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        } else {
            if ($this->user['password']==md5($old_pwd)) {
                $res = $this->user_model->updateByPk($this->user['id'], array('password' => md5($new_pwd)));
                if ($res) {
                    $response['status'] = 100000;
                    $response['content'] = '密码修改成功！';
                    Yii::app()->end(FHelper::json($response['content'],$response['status']));
                } else {
                    $response['status'] = 100007;
                    $response['content'] = '密码修改失败！';
                    Yii::app()->end(FHelper::json($response['content'],$response['status']));
                }
            }
        }
    }

    public function actionSendMobileMess () {
        $sendMessage = new SendMessage();
        $response = array();
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
                'condition' => "mobile_no = '{$this->user['phone_num']}' and send_time >= '{$today}'",
            );
        $messageCount = $sendMessage->count($condition);
        if($messageCount < 5){
            Yii::import('ext.wsMobile.ws.*');
            require_once 'ws-demo.php';

            $engine = WS_SDK::getInstance ($user,$pass);
            $res = $engine->sendSmsAsNormal($this->user['phone_num'], $content, '', 0);

            if (intval($res) === 0) {
                $cryRes =Fn::crypt($code,FConfig::item('config.cookie.phone_code'));
                FCookie::set(FConfig::item('config.cookie.phone_key'),$cryRes);

                $response['status'] = 100000;
                $response['content'] = '短信发送成功';
                $telArr = array(
                    'mobile_no' => $this->user['phone_num'],
                    'mess_code' => $code,
                    'send_time' => FF_DATE_TIME,
                );
                $sendMessage->attributes = $telArr;
                $sendMessage->save();
            } else {
                $response['status'] = 100001;
                $response['content'] = '短信发送失败，请重试';
            }
        } else {
            $response['status'] = 100002;
            $response['content'] = '该手机号码今天发送验证码过多';
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }
    public function actionVerifyPersonId() {
        $person_name = trim($this->request->getParam('real_name'));
        $id_num = trim($this->request->getParam('id_num'));
        $condition_arr = array(
            'realname'    =>	$person_name,
            'idcard'    => $id_num,
        );
        $res = $this -> _api_client -> sendIdCardVerify($this->_api_url_idCard,$condition_arr,"get");
        if($res['error_code'] == 0 && $res['result']['res']==1){
            $condition_userInfo = array(
                'real_name' => $person_name,
                'person_id' => $id_num
            );
            $res_updatePId = $this->userInfo_model->updateByPk($this->userInfo['id'],$condition_userInfo);
            if($res_updatePId){
                $response['status'] = 100000;
                $response['content'] = 'success';
            }else{
                $response['status'] = 100002;
                $response['content'] = 'error';
            }
        }else{
            $response['status'] = 100001;
            $response['content'] = 'error';
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }
    public function actionVerifyPIdPage(){
        $this->render('verifyPIdPage');
    }
    public function actionVerifyPIdRes(){
        $res = $this->request->getParam('result');
        if($res==100000){
            $data['class'] = "success-msg-icon";
            $data['mess'] = "身份证认证成功！";
        }else{
            $data['class'] = "error-msg-icon";
            $data['mess'] = "身份证认证失败！";
        }
        $this->render('verifyPIdRes',$data);
    }

    public function actionBankManage(){
        $data = array();
        if($this->userInfo['person_id'] && $this->userInfo['real_name']){
            $data['real_name'] = $this->userInfo['real_name'];
            $data['person_id'] = $this->userInfo['person_id'];
        }
        if($this->userInfo['bank_check']){

            $data['bank_id'] = FConfig::item('config.bank_id.'.$this->userInfo['bank_id'].'.1');
            $data['bank_num'] = $this->userInfo['bank_num'];
        }
        $data['bank_list'] = FConfig::item('config.bank_id');

        $this->render('bankManage',$data);
    }

    public function actionModifyBank(){
        $id = $this->userInfo['id'];
        $bank_num = trim($this->request->getParam('bank_num'));
        $bank_id = trim($this->request->getParam('bank_id'));
        $condition_bank = array(
            'bank_check' => 1,
            'bank_num' => $bank_num,
            'bank_id' => $bank_id
        );
        if($bank_num && $bank_id){
            $res_bank = $this->userInfo_model->updateByPk($id,$condition_bank);
            if($res_bank){
                $response['status'] = 100000;
                $response['content'] = 'success';
            }else{
                $response['status'] = 100002;
                $response['content'] = 'error';
            }

        }else{
            $response['status'] = 100001;
            $response['content'] = 'error';
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }

    public function actionUpdatePhone(){

        $this->render('updatePhone');
    }

    public function actionVerifyPhoneAjax(){
        $phone=trim($this->request->getParam('phone'));
        if ($this->verifyPhone($phone)) {
            Yii::app()->end('true');
        } else {
            Yii::app()->end('false');
        }
    }
    private function verifyPhone ($phone) {
        $res_num = $this->user_model->count(
            array(
                'condition'=>"phone_num=:phone_num and id=:id",
                'params' => array(
                    ':phone_num'=>$phone,
                    ':id' => $this->user['id'],
                ),
            )
        );
        if ($res_num > 0) {
            return true;
        }
        return false;
    }
    public function actionVerifyPhone(){
        $old_phone = trim($this->request->getParam('old_phone'));
        $new_phone = trim($this->request->getParam('new_phone'));
        $phone_code = trim($this->request->getParam('phone_code'));
        $verifyCode = FCookie::get(FConfig::item('config.cookie.phone_key'));
        $verifyCode = Fn::crypt($verifyCode,FConfig::item('config.cookie.phone_code'),'decode');

        if ($phone_code != $verifyCode) {
            $response['status'] = 100002;
            $response['content'] = '短信验证码验证失败';
            Yii::app()->end(FHelper::json($response['content'],$response['status']));
        } else {
            if($this->user['phone_num'] == $old_phone){
                $res = $this->user_model->updateByPk($this->user['id'], array('phone_num' => $new_phone));
                if ($res) {
                    $response['status'] = 100000;
                    $response['content'] = '手机号修改成功！';
                    Yii::app()->end(FHelper::json($response['content'],$response['status']));
                } else {
                    $response['status'] = 100007;
                    $response['content'] = '手机号修改失败！';
                    Yii::app()->end(FHelper::json($response['content'],$response['status']));
                }
            }
        }
    }

    public function actionSendMsgPhone () {
        $sendMessage = new SendMessage();
        $response = array();
        $code = FHelper :: generate_code();
        $content = FConfig::item('siteMessage.register.first')
            .$code
            .FConfig::item('siteMessage.register.end');

        $user = FConfig::item('config.ws_mobile.userName');
        $pass = FConfig::item('config.ws_mobile.passWord');

        $today = date('Y-m-d 0:0:0', time());
        $condition =
            array(
                'condition' => "mobile_no = '{$this->user['phone_num']}' and send_time >= '{$today}'",
            );
        $messageCount = $sendMessage->count($condition);
        if($messageCount < 5){
            Yii::import('ext.wsMobile.ws.*');
            require_once 'ws-demo.php';

            $engine = WS_SDK::getInstance ($user,$pass);
            $res = $engine->sendSmsAsNormal($this->user['phone_num'], $content, '', 0);
            if (intval($res) === 0) {

                $cryRes =Fn::crypt($code,FConfig::item('config.cookie.phone_code'));
                FCookie::set(FConfig::item('config.cookie.phone_key'),$cryRes);
                $response['status'] = 100000;
                $response['content'] = '短信发送成功';
                $telArr = array(
                    'mobile_no' => $this->user['phone_num'],
                    'mess_code' => $code,
                    'send_time' => FF_DATE_TIME,
                );
                $sendMessage->attributes = $telArr;
                $sendMessage->save();
            } else {
                $response['status'] = 100001;
                $response['content'] = '短信发送失败，请重试';
            }
        } else {
            $response['status'] = 100002;
            $response['content'] = '该手机号码今天发送验证码过多';
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }

    public function actionToCash(){
        $user_id = $this->request->getParam('user_id');
        $cash_money = $this->request->getParam('cash_money');
        $avail_cash = $this->request->getParam('avail_cash');
        $create_time = FF_DATE_TIME;
        $attr_cash = array(
            'user_id' => $user_id,
            'cash_money' => $cash_money,
            'avail_cash' => $avail_cash,
            'create_time' => $create_time
        );
        $this->withdrawCash_model->attributes = $attr_cash;

        $account_val = $this->userInfo['account_val'] - $cash_money;
        $condition_account_val = array(
            'account_val' => $account_val
        );
        $res_userInfo = $this->userInfo_model->updateByPk($this->userInfo['id'],$condition_account_val);
        $res = $this->withdrawCash_model->save();
        if($res && $res_userInfo){
            $response['status'] = 100000;
            $response['content'] = success;
        }else{
            $response['status'] = 100001;
            $response['content'] = error;
        }
        Yii::app()->end(FHelper::json($response['content'],$response['status']));
    }

    public function actionAppoint() {

        $data = array();
        $user_id = $this->user['id'];

        $condition_arr = array(
            'condition' => 'user_id =:user_id',
            'params' => array(
                ':user_id' => $user_id
            )
        );
        $appointList = $this->appoint_model->findAll($condition_arr);
        foreach ($appointList as $v) {
            $data['appointList'][] = $v->getAttributes();
        }
        $xintuoList = $this->xintuoDetail_model->findAll();
        foreach ($xintuoList as $v) {
            $data['xintuo'][$v->id] = $v->getAttributes();
        }
        $fundList = $this->fundDetail_model->findAll();
        foreach ($fundList as $v) {
            $data['fund'][$v->id] = $v->getAttributes();
        }
        $proTypes = $this->productType_model->findAll();
        foreach ($proTypes as $v) {
            $data['proType'][$v->type_val] = $v->getAttributes();
        }

        $this->render('appoint',$data);
    }
}
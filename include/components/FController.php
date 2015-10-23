<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FController extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    //public $layout='//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

    /**
     * User info
     *
     * @var JUser
     */
    public $user;

    public $userInfo;
    /**
     * @var CHttpRequest
     */
    public $request;

    /**
     * @var string;
     */
    public $pageTitle;
    /**
     * @var string
     */
    public $pagekeywords;
    /**
     * @var string;
     */
    public $pageDescription;

    /**
     * @var string;
     */
    protected $_controller;
    /**
     * @var string;
     */
    protected $_action;

    /**
     * @var string
     */
    public $returnurl;

    /**
     * @var string;
     */
    protected $_api_client;

    public function __construct($id, $module = null) {

        parent::__construct($id, $module);

        $this -> request      = Yii::app()->getRequest();
        $this -> _api_client  = new FApiClient();
    }
    /*
    *判断当前用户是否登录
    */
    public function is_login(){



        return isset($this->userInfo['id']) && $this->userInfo['id'] ? true : false ;
    }
    protected function beforeAction($action) {

        $this -> _controller    =   $action -> getController() ->getId();
        $this -> _action        =   $action ->getId();
        $this -> returnurl      =   Fn::url_login_current();
        $token = FCookie::get("auth");
        $now = time();
        list($uid,$email,$timeout) = explode("\t", FHelper::auth_code($token, 'DECODE', FF_SALT));
        if($uid) {
            $userInfo = $this->getUserinfo($uid);
            if ($userInfo['user']['id']) {
                if ($token == $userInfo['user']['token']) {
                    if($now < $timeout){
                        $this->userInfo = $userInfo['info'];
                        $this->user = $userInfo['user'];
                        if (($timeout-$now) < 60*2) {
                            $timeout =  time()+60 *15;
                            $token = FHelper::auth_code("$uid\t$email\t$timeout", 'ENCODE', FF_SALT);
                            FCookie::set('auth', $token,60 * 15);
                            $attr =array(
                                'token' =>  $token,
                            );
                            $user_model =new User();
                            $user_model->updateByPk($uid,$attr);
                        }
//                        $timeout =  time()+60 *15;
//                        $token = FHelper::auth_code("$uid\t$email\t$timeout", 'ENCODE', FF_SALT);
//                        FCookie::set('auth', $token);
                    }
                }
            }
        }
        return true;
    }
    protected function getUserinfo($uid) {
        $userModel = new User();
        $userInfoModel = new Userinfo();
        $attr = array(
            'condition'=>"id=:id",
            'params' => array(':id'=>$uid,),

        );
        $user = $userModel->find($attr);
        $attrInfo = array(
            'condition'=>"user_id=:id",
            'params' => array(':id'=>$uid,),

        );
        $userInfo = $userInfoModel->find($attrInfo);
        $account['user'] = $user->getAttributes();
        $account['info'] = $userInfo->getAttributes();
        return $account;
    }
    protected function getProductType(){
        //获取全部标签
        $mc_product_type = md5('mc_product_type_key');
        $proTypes = Yii::app() -> cache -> get($mc_product_type);
        if(!$proTypes){
            $proTypes = array();
            $productType_model = new ProductType();
            $condition_attr = array(
                'order'=>" type_sort ",
            );
            $res = $productType_model->findAll($condition_attr);
            foreach($res as $val){
                $proTypes[$val['id']] = $val->getAttributes();
            }
            Yii::app() -> cache -> set($mc_product_type,$proTypes,600);
        }
        uasort($proTypes, array($this, '_sortHandlers'));
        return $proTypes;
    }
    private function  _sortHandlers ($a, $b) {
        if ($a['type_sort'] > $b['type_sort'])
            return 1;
        else if ($a['type_sort'] == $b['type_sort'])
            return 0;
        else
            return -1;
    }
    protected function dealParam($isMobileRequest = null){
        //获取全部标签
        $mc_tag_tree1 = md5('mc_tag_tree_key1');
        $mc_tag_tree2 = md5('mc_tag_tree_key2');
        $mc_tag_tree3 = md5('mc_tag_tree_key3');

        $typeId = $this -> request -> getParam('typeId');
        if (empty($typeId)) {
            $productType = Yii::app()->db->createCommand('select * from ff_product_type order by type_sort limit 1')->queryAll();
            $typeId = $productType[0]['id'];

        }
        $proTypes = $this->getProductType();
        $type_val = $proTypes[$typeId]['type_val'];
        if ($type_val == 1) {
            $tree = Yii::app() -> cache -> get($mc_tag_tree1);
        } elseif ($type_val == 2) {
            $tree = Yii::app() -> cache -> get($mc_tag_tree2);
        } elseif ($type_val == 3) {
            $tree = Yii::app() -> cache -> get($mc_tag_tree3);
        }

        if (!$tree) {

            $tree = new FTree(Yii::app()->db->createCommand("select * from ff_tag where type_val = {$type_val} order by tag_sort")->queryAll());
            $key = "mc_tag_tree_key".$type_val;
            Yii::app() -> cache -> set(md5($key),$tree,600);
        }
        $param = array(
            'cate'  => trim($this -> request -> getParam('cate')),//spell参数
            //'cate'  => "a11a12b17",//spell参数
            'tags'  => $tree -> getArray(),//全部标签
            'seo_year'   => date("Y"), //年份
            'parameters'=>'', //参数串
            'basePath'=>'', //参数串名称
        );

        $param['typeId'] = $typeId;
        if ($isMobileRequest) {
            $_url_prefix    = '';//FF_DOMAIN . "/w/index/caseList/"
        } else {
            //生成标签展示URL
            $_url_prefix    = FF_DOMAIN . "/s/$typeId/";
        }
        //获取参数相关配置文件
        $p_config = FConfig::item("tags.param.$type_val");
        $rs = ($param['cate']) ? $this -> dealCate($param['cate']) : '';
        foreach ($p_config as $k => $v) {

            //设置参数
            $param[$v['short']] = isset($rs[$v['short']]) && in_array($rs[$v['short']] , array_keys($tree -> get_child($v['id']))) ? $rs[$v['short']] : 0;

            //SEO title，keyword，desc拼接
            $seo_show_tmp = $param[$v['short']] > 0 ? $param['tags'][$param[$v['short']]]['name'] : '';

            if($v['short']=='a'){$a=$seo_show_tmp; $a1=isset($rs['a'])?('a'.$rs['a']):'';}
            if($v['short']=='b'){$b=$seo_show_tmp; $b1=isset($rs['b'])?('b'.$rs['b']):'';}
            if($v['short']=='c'){$c=$seo_show_tmp; $c1=isset($rs['c'])?('c'.$rs['c']):'';}
            if($v['short']=='d'){$d=$seo_show_tmp; $d1=isset($rs['d'])?('d'.$rs['d']):'';}
            if($v['short']=='e'){$e=$seo_show_tmp; $e1=isset($rs['e'])?('e'.$rs['e']):'';}
            if($v['short']=='f'){$f=$seo_show_tmp; $f1=isset($rs['f'])?('f'.$rs['f']):'';}

        }
        //搜索参数拼接
        $param['parameters']=$a1.$b1.$c1.$d1.$e1.$f1;
        $param['pname']=$a.$b.$c.$d.$e.$f;
        foreach($param['tags'] as $k => &$v){
            $v['url'] = $_url_prefix;

            foreach ($p_config as $pc_k => $pc_v) {
                if($pc_v['id'] == $v['id']){
                    $v['url'] .= '';
                }elseif($pc_v['id'] == $v['parent_id']){

                    $v['url'] .= $pc_v['short'].$v['id'];

                }else{
                    //组合查询打开
                    if($param[$pc_v['short']] > 0)
                    {
                        $v['url'] .= $pc_v['short'].$param[$pc_v['short']];
                        $param['tags'][$param[$pc_v['short']]]['class'] = 'current';
                    } else {
                        //$param['tags'][$v['parent_id']]['class'] = 'current';
                        $param['tags'][$pc_v['id']] ['class'] = 'current';
                    }
                }
            }

            if (substr($v['url'],strlen($v['url'])-1) !== '/'){
                $v['url'] .= '/';
            }
        }
        $param['basePath'] =  FF_DOMAIN . "/s/";
        return $param;
    }
    //解析/a2b2c4d5/格式url
    public function dealCate($uri){
        //url解析
        //$uri = str_replace("all", "", $uri);
        $rs = array();
        preg_match_all('|([a-zA-Z])(\d+)|i', $uri, $tmp);

        if(isset($tmp[1]) && $tmp[1]){

            foreach ($tmp[1] as $key => $value) {

                $rs[$value] = $tmp[2][$key];
            }
        }
        return $rs;
    }
}
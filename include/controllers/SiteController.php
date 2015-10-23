<?php

class SiteController extends FController
{
    private $productPublish_model;
    private $product_model;
    private $productType_model;
    private $userProductBuy_model;
    private $xintuoDetail_model;
    private $fundDetail_model;
    private $testTrade_model;

    public function __construct($id, $module = null) {

        parent::__construct($id, $module);
        $this->productPublish_model = new ProductPublish();
        $this->product_model = new Product();
        $this->productType_model = new ProductType();
        $this->userProductBuy_model = new UserProductBuy();
        $this->xintuoDetail_model = new XintuoDetail();
        $this->fundDetail_model = new FundDetail();
        $this->testTrade_model = new TestTrade();
    }
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
                'maxLength'=>'4',       // 最多生成几个字符
                'minLength'=>'2',       // 最少生成几个字符
                'height'=>'40'
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $data = array();
        $data['proType']=$this->getProductType();
        $where = "1=1";
        $where .= " AND publish_index=1 and publish_status=1";
        $res = $this->productPublish_model->findAll($where);

        if($res){
            foreach ($res as $value) {
                $publish = $value->getAttributes();
                $publish['product'] = $value->product->getAttributes();

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
                $publish['sum_buy_val'] = $buy_res->sum_buy_val + $testMoney->sum_money;

                $condition_count_user = array(
                    'group' => 'user_id',
                    'condition' => 'p_id = :p_id',
                    'params' => array(':p_id'=>$publish['id']),
                );
                $user_res = $this->userProductBuy_model->count($condition_count_user);
                $testUser = $this->testTrade_model->count('product_id='.$publish['id']);
                $publish['count_user'] = $user_res+$testUser;
                $pro_type = $value->product->product_type;
                if($pro_type && $pro_type->type_val == 1){
                    $data['proIndexList'][]=$publish;
                }

            }

        }
        foreach($data['proType'] as $val){
            $condition = array(
                'order' => 'id DESC',
//                'limit' => 2,
                'condition' => 'product_type_id = :product_type_id',
                'params' => array(':product_type_id'=>$val['id']),
            );
            if($val['type_val'] == 2){
                $res_xintuo = $this->xintuoDetail_model->findAll($condition);
                foreach($res_xintuo as $v_xintuo){
                    $data['proIndexXintuoList'][$val['type_val']][$val['id']][] = $v_xintuo;
                }
            }
            if($val['type_val'] == 3){
                $res_fund = $this->fundDetail_model->findAll($condition);
                foreach($res_fund as $v_fund){
                    $data['proIndexFundList'][$val['type_val']][] = $v_fund;
                }
            }

        }
        $data['guarantee_levels'] = FConfig::item('config.guarantee_levels');

        $this->render('index',$data);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this -> pageTitle 			= '非常抱歉！您所访问的页面不存在';

        //$this -> pagekeywords 		= '非常抱歉！您所访问的页面不存在-萤火虫网';

        //$this -> pageDescription 	= '非常抱歉！您所访问的页面不存在，请查找其他相关内容，更多精彩信息，尽在萤火虫网。';
        $this -> action = 'error';

        if(isset($_GET['test']))
        {
            if($error=Yii::app()->errorHandler->error)
            {
                print_r($error);exit;
            }
        }
        $this->render('404');
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;

		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->render('login');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    /**
     * Displays the know_us
     */
    public function actionKnowYhc()
    {
        $this->render('knowyhc');
    }
    /**
     * Displays the new user guide
     */
    public function actionNewUserGuide()
    {
        $this->render('newUserGuide');
    }
}
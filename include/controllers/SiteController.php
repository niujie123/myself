<?php

class SiteController extends FController
{
//    private $user_model;
//    private $position_model;

    public function __construct($id, $module = null) {

        parent::__construct($id, $module);
//        $this->user_model = new User();
//        $this->position_model = new Position();
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
//        echo strtotime('2015-09-21 00:00:00');
//        exit;
        $user = "zhaopin5a"; //账号
        $password = "aladdin5aWcome";//密码
        $host = '114.112.96.146';

//        $user = "root"; //账号
//        $password = "Hello@123456";//密码
//        $host = '10.0.0.142';

//        $user = "root"; //账号
//        $password = "";//密码
//        $host = '127.0.0.1';

        $con = mysql_connect($host, $user, $password);
        if (!$con) {

            die("连接失败" . mysql_error());

        }

        $db = mysql_select_db('5azhaopin', $con);
        if (!$db) {

            die("连接失败" . mysql_error());

        }

        mysql_query("set names 'utf8'");
        $sql = "select id,sevenreadrate,pubtime from 5a_position WHERE pubtime<1442764800 AND sevenreadrate>=0.8";

//        $endTime = strtotime('2015-09-21 00:00:00');
//        $sql = "select id,sevenreadrate from 5a_position WHERE pubtime<".$endTime;
        $result = mysql_query($sql);
//var_dump($result);exit;
        if (!$result) {
            echo "mysql error" . mysql_error();
            exit;
        }
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
//            print_r($row);
            $rand = rand(1,79) * 0.01;
            $sql_update = "update 5a_position set sevenreadrate=".$rand." where id=".$row['id'];
            $updateRes = mysql_query($sql_update);
            if ($updateRes) {
                echo $updateRes.'--';
            }
            $i += 1;
            echo $i.'+';
            if($i%1000==0){
                sleep(1);
            }
        }

        echo $i;exit;
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
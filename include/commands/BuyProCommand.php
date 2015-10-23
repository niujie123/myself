<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-5-6
 * Time: 下午3:49
 */
class BuyProCommand  extends CConsoleCommand
{
    private $product_model;
    private $productType_model ;
    private $productPublish_model;
    private $userProductBuy_model;
    private $buyLogs_model;
    private $tradingRecord_model;
    private $userInfo_model;
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        $this->product_model = new Product();
        $this->productType_model = new ProductType();
        $this->productPublish_model = new ProductPublish();
        $this->userProductBuy_model = new UserProductBuy();
        $this->buyLogs_model = new BuyLogs();
        $this->tradingRecord_model = new TradingRecord();
        $this->userInfo_model = new Userinfo();
    }
    public function actionCheckBuyStatus() {
        // 将已购买1的到期后改为持有中2
        $condition_arr = array(
            'condition' =>"buy_status = :buy_status",
            'params' =>array(":buy_status"=>FConfig::item("config.buy_status.ygm")),
        );
        $res = $this->userProductBuy_model->findAll($condition_arr);
        foreach ($res as $val) {
            $publish = $val->publish;
            $product = $publish->product;
            //创建时间y-m-d + N
            $buy_time = strtotime($val->create_time);
            if($product->invest_start_type == 1){
                if($product->invest_date_type == 1){
                    $start_timestamp = strtotime("+$product->invest_days day",$buy_time);
                    $end_time = date('Y-m-d',strtotime("+$product->earn_days days",$start_timestamp));
                    $start_time = date('Y-m-d',$start_timestamp);
                }elseif($product->invest_date_type == 2){
                    $invest_days = $product->invest_days;
                    $i = 0;
                    $start_timestamp = strtotime("+1 day", $buy_time);
                    for($j=0;$j<15;$j++) {
                        $is = FHelper::isHoliday($start_timestamp);
                        if ($is) {
                            $start_timestamp = strtotime("+1 day", $start_timestamp);
                        } else {
                            $i++;
                            $start_timestamp = strtotime("+1 day", $start_timestamp);
                        }
                        if($i == $invest_days){
                            $start_timestamp = strtotime("-1 day",$start_timestamp);
                            break;
                        }
                    }
                    $end_time = date('Y-m-d',strtotime("+$product->earn_days days",$start_timestamp));
                    $start_time = date('Y-m-d',$start_timestamp);
                }
            }else{
                $start_time = $product->invest_start_date;
                $end_time = $product->invest_end_date;
            }
            if($start_time <= date('Y-m-d')){
                $result = $this->userProductBuy_model->updateByPk($val->id,array('buy_status'=>2));
                Yii::log("成功：用户ID：$val->user_id:产品ID：$product->id:发布ID：$publish->id:购买时间：$val->create_time:起息日：$start_time", CLogger::LEVEL_INFO, 'buy.actionCheckBuyStatus');
            }else{
                $result = 2;
                Yii::log("起息开始未到期：用户ID：$val->user_id:产品ID：$product->id:发布ID：$publish->id:购买时间：$val->create_time:起息日：$start_time", CLogger::LEVEL_INFO, 'buy.actionCheckBuyStatus');
            }
            $now_time = date('Y-m-d H:i:s');
            $condition_arr = array(
                'user_id' => $val->user_id,
                'product_id' => $product->id,
                'p_id' => $publish->id,
                'user_buy_time' => $val->create_time,
                'invest_start_time' => $start_time,
                'invest_end_time' => $end_time,
                'op_time' => $now_time,
                'buy_log_status' => $result,
            );
            $buyLogs = new BuyLogs();
            $buyLogs->attributes = $condition_arr;
            $buyLogs->save();
        }
    }
    public function actionCheckBuyEndDate() {
	        //所要执行的任务，如数据符合某条件更新，删除，修改
//        echo "查询产品用户购买产品结束日期\n";

        // 持有中2的到期后改为已结束3
        $condition_syz = array(
            'condition' =>"buy_status = :buy_status",
            'params' =>array(":buy_status"=>FConfig::item("config.buy_status.syz")),
        );
        $res_cyz = $this->userProductBuy_model->findAll($condition_syz);
        foreach ($res_cyz as $val_cyz) {
            $publish = $val_cyz->publish;
            $product = $publish->product;
            //创建时间y-m-d + N
            $buy_time = strtotime($val_cyz->create_time);
            if($product->invest_start_type==1){
                if($product->invest_date_type==1){
                    $start_timestamp = strtotime("+$product->invest_days day",$buy_time);
                    $end_time = date('Y-m-d',strtotime("+$product->earn_days days",$start_timestamp));
                    $start_time = date('Y-m-d',$start_timestamp);
                }elseif($product->invest_date_type == 2){
                    $invest_days = $product->invest_days;
                    $i = 0;
                    $start_timestamp = strtotime("+1 day", $buy_time);
                    for($j=0;$j<15;$j++) {
                        $is = FHelper::isHoliday($start_timestamp);
                        if ($is) {
                            $start_timestamp = strtotime("+1 day", $start_timestamp);
                        } else {
                            $i++;
                            $start_timestamp = strtotime("+1 day", $start_timestamp);

                        }
                        if($i == $invest_days){
                            $start_timestamp = strtotime("-1 day",$start_timestamp);
                            break;
                        }
                    }
                    $end_time = date('Y-m-d',strtotime("+$product->earn_days days",$start_timestamp));
                    $start_time = date('Y-m-d',$start_timestamp);
                }
            }else{
                $start_time = $product->invest_start_date;
                $end_time = $product->invest_end_date;
            }
            if($end_time <= date('Y-m-d')){
                $transaction = Yii::app()->db->beginTransaction();

                $earn_val = sprintf("%.2f", floatval($val_cyz->buy_val)*floatval($product->yield_rate_year)*$product->earn_days/(360*100));
                $result_cyz = $this->userProductBuy_model->updateByPk($val_cyz->id,array('buy_status'=>3,'earn_val'=>$earn_val));
                Yii::log("已结束：用户ID：$val_cyz->user_id:产品ID：$product->id:发布ID：$publish->id:购买时间：$val_cyz->create_time:结束日：$end_time", CLogger::LEVEL_INFO, 'buy.actionCheckBuyStatus');

                if ($result_cyz) {

                    $userInfoRes = $this->userInfo_model->find('user_id=:user_id',array(':user_id'=>$val_cyz->user_id));
                    if ($userInfoRes) {
                        $sumVal = floatval($userInfoRes->account_val)+floatval($val_cyz->buy_val)+floatval($earn_val);
                        $updateAttr = array(
                            "account_val"=>$sumVal,
                        );
                        $result = $this->userInfo_model->updateByPk($userInfoRes->id,$updateAttr);
                        if (!$result) {
                            Yii::log("充值失败", CLogger::LEVEL_ERROR, 'buy.actionCheckBuyStatus');
                            $transaction->rollback();

                        } else {
                            $transaction->commit();
                        }
                    }

                } else {
                    $transaction->rollback();
                    Yii::log("修改交易记录失败", CLogger::LEVEL_ERROR, 'order.frontReceive');

                }

            }else{
                $result_cyz = 3;
                Yii::log("起息结束未到期：用户ID：$val_cyz->user_id:产品ID：$product->id:发布ID：$publish->id:购买时间：$val_cyz->create_time:结束日：$end_time", CLogger::LEVEL_INFO, 'buy.actionCheckBuyStatus');
            }
            $now_time = date('Y-m-d H:i:s');
            $condition_arr = array(
                'user_id' => $val_cyz->user_id,
                'product_id' => $product->id,
                'p_id' => $publish->id,
                'user_buy_time' => $val_cyz->create_time,
                'invest_start_time' => $start_time,
                'invest_end_time' => $end_time,
                'op_time' => $now_time,
                'buy_log_status' => $result_cyz,
            );
            $buyLogs = new BuyLogs();
            $buyLogs->attributes = $condition_arr;
            $buyLogs->save();
        }
    }
    public function actionCheckUnion() {

        $condition_trade = array(       // 查找所有大于昨天凌晨的时间的交易test
            'condition' => 'trade_time>=:trade_time',
            'params' => array(
                ':trade_time' => date('Y-m-d',strtotime('-1 day')),
            )
        );
        $res_trade_arr = $this->tradingRecord_model->findAll($condition_trade);
        foreach($res_trade_arr as $k=>$res_trade){
            $trade_record = $res_trade->getAttributes();
            $res_search = FUnionPay::search($trade_record,FConfig::item('config.payType.'.$res_trade['pay_type']));
            if($res_search['origRespCode'] === '00'){
                $is_equal = $res_trade['trade_status']==1?1:0;
            }else{
                $is_equal = $res_trade['trade_status']==0?1:0;
            }
            $condition_attr_union = array(
                'trade_code' => $res_search['orderId'],
                'trade_status' => $res_trade['trade_status'],
                'trade_fee' => $res_search['trade_fee'],
                'origRespCode' => $res_search['origRespCode'],
                'origRespMsg' => $res_search['origRespMsg'],
                'check_time' => date('Y-m-d H:i:s'),
                'respCode' => $res_search['respCode'],
                'respMsg' => $res_search['respMsg'],
                'txnAmt' => $res_search['txnAmt'],
                'settleAmt' => $res_search['settleAmt'],
                'is_equal' => $is_equal,
            );
            $unionCheck = new UnionCheck();
            $unionCheck->attributes = $condition_attr_union;
            $unionCheck->save();
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-4-28
 * Time: 上午10:41
 */
class FUnionPay
{


    public  static function submit($subAttr,$payType = "bank")
    {
        Yii::app()->unionPay->pay($subAttr,$payType);
    }
    public  static function search($subAttr,$payType = "bank")
    {
        return Yii::app()->unionPay->searchOrder($subAttr,$payType);
    }

}
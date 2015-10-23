<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-4-23
 * Time: 下午5:49
 */
class FAlipay
{


    public static function submit()
    {
        Yii::app()->alipay->submit();
    }
}
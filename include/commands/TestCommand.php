<?php
/**
 * Created by PhpStorm.
 * User: zhangchao8189888
 * Date: 15-5-6
 * Time: 下午2:30
 */
class TestCommand  extends CConsoleCommand
{

    public function run($args)
    {
        echo '测试command';
    }
}
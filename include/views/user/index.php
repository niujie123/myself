<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-账户总览 -->
<div id="pg-user">
<div class="g-in f-cb">
    <?php $this->renderPartial('user_menu'); ?>
<div class="g-mn2 account-summary">
    <div class="simple-summary">
        <ul class="f-cb">
            <li>
                <div class="item asset">
                    <?php
                        $accountAttr = explode(".",$this->userInfo['account_val']);

                    ?>
                    <p class="f-color-red"><span class="big"><?php echo is_numeric($accountAttr[0])?$accountAttr[0]:0; ?></span>.<?php echo is_numeric($accountAttr[1])?$accountAttr[1]:'00'; ?>元</p>
                    <p>总资产</p>
                </div>
            </li>
            <li>
                <div class="item profit">
                    <p class="f-color-red"><span class="big">0</span>.00元</p>
                    <p>累计收益</p>
                </div>
            </li>
            <li class="last">
                <div class="item balance">
                    <?php $have_val = floatval($this->userInfo['account_val']) -floatval($sumBuyVal);
                    $have_valAttr = explode(".",$have_val);
                    ?>
                    <p class="f-color-red"><span class="big"><?php echo is_numeric($have_valAttr[0])?$have_valAttr[0]:0; ?></span>.<?php echo is_numeric($have_valAttr[1])?$have_valAttr[1]:'00'; ?>元</p>
                    <p>可用余额</p>
                </div>
                <p class="recharge-btn"><a class="u-btn u-btn-c1 u-btn-w72 u-btn-h27" href="<?php echo FF_DOMAIN."/u/toRecharge";?>">充值</a> </p>
            </li>
        </ul>
    </div>

    <div class="my-products">
        <div class="title">我的理财产品</div>
        <table class="f-w-auto">
            <tr>
                <th>理财产品</th>
                <th>交易金额</th>
                <th>已赚金额</th>
                <th>加权平均收益率</th>
                <th>交易时间</th>
                <th>交易状态</th>
<!--                <th></th>-->
            </tr>
            <?php if(is_array($userProBuyList)){
                foreach ($userProBuyList as $v) {?>
                <tr>
                <td><?php echo $v['product']->product_name;?></td>
                <td><?php echo $v['buy_val'];?>元</td>
                <td><?php echo $v['earn_val'];?>元</td>
                <td><?php echo $v['product']->yield_rate_year;?>%</td>
                <td><?php echo $v['create_time'];?></td>
                <td><?php echo $buy_status_mess[$v['buy_status']];?></td>
<!--                <td><a href="#">查看></a> </td>-->
                </tr>
            <?php }}?>
        </table>
    </div>

    <!-- 产品列表 -->
    <div class="product-list">
        <div class="title">理财推荐</div>
        <div class="product-list-content">
            <ul>
                <?php if(count($publish_list) > 0) {$i = 0;foreach($publish_list as $v){
                $class = '';
                if (($i%2)== 0) {$class = "two";}
                    $i++;
                ?>
                <li class="f-cb <?php echo $class;?>">
                    <div class="f-fl">
                        <div class="info f-fl">
                            <div><!--<span class="count-profits f-fr">计算收益</span>--><h3 class="f-h3"><a href="#"><?php echo $v['product']['product_name'];?></a></h3></div>
                            <div class="desc"><?php echo Fn::wsubstr($proTypes[$v['product']['product_type_id']]['description'],0,65);?></div>
                            <div class="info-bottom">
                                <div class="item red">
                                    <div class="f-fl">
                                        <p>预计年化</p>
                                        <p>收益率</p>
                                    </div>
                                    <div>
                                        <span class="rate"><?php echo $v['product']['yield_rate_year'];?>%</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <p>投资期限</p>
                                    <p class="red"><?php echo $v['product']['earn_days_sign'];?></p>
                                </div>
                                <div class="item last">
                                    <p>起投金额</p>
                                    <p class="red"><?php echo $v['product']['fund_min_val'];?>元</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-investment f-fr">
                        <div class="investment-money"><span class="t t1">已投金额</span><span class="c"><?php if($v['sum_buy_val']){echo $v['sum_buy_val'];}else{echo '0.00';}?>元</span></div>
                        <div class="join-num"><span class="t t2">加入人数</span><span class="c"><?php echo $v['count_user'];?>人</span></div>
                        <div class="investment-btn"><a href="<?php echo FF_DOMAIN.'/d/'.$v['id'];?>" class="u-btn u-btn-sm114 u-btn-c1">立即投资</a> </div>
                    </div>
                </li>
            <?php }}?>

            </ul>
        </div>
    </div>
    <!-- end 产品列表 -->
</div>
</div>
</div>
<!-- end 用户中心-账户总览 -->
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
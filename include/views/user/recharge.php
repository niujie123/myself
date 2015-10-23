<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/index/index.css" />
<!-- 用户中心-充值提现 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 充值提现 -->
        <div class="g-mn2 recharge f-w769">
            <div class="recharge-box">
                <div class="title f-bbdc">充值提现</div>
                <div class="content">
                    <div class="summary-section f-cb">
                        <div class="tip-wrapper f-fl">
                            <div class="header-label">温馨提示</div>
                            <div>
                                <ul class="my-account-tip">
                                    <li><p>1.在你申请提现前，请先在页面下方或"基本信息"账户信息页面绑定银行卡</p></li>
                                    <li><p>2.收到你的提现请求后，萤火虫理财将在1个工作日（双休日或法定节假日顺延）处理你的提现申请，请你注意查收</p></li>
                                    <li><p>3.为保障你的账户资金安全，申请提现时，你选择的银行卡开户名必须与你萤火虫理财账户实名认证一致，否则提现申请将不予受理。</p></li>
                                </ul>
                            </div>
                        </div>
                        <div class="status-wrapper">
                            <div class="textTop">
                                <div><span class="f-fr red"><?php echo floatval($this->userInfo['account_val']) -floatval($sumBuyVal);?>元</span>可用余额</div>
                                <div><span class="f-fr red"><?php echo floatval($this->userInfo['account_val']) -floatval($sumBuyVal);?>元</span>可提现金额</div>
                            </div>
                            <div class="buttonBottom">
                                <a href="#" id="cash" class="u-btn u-btn-c1 f-pdlr18"><em class="tixian-icon"></em>提现</a>
                                <a href="<?php echo FF_DOMAIN."/u/toRecharge";?>" class="u-btn u-btn-c1 f-pdlr18"><em class="chongzhi-icon"></em>充值</a>
                            </div>
                        </div>
                    </div>

                    <div class="summary-filter">
                        <div class="f-cb f-mgb10">
                            <span class="f-fl">交易时间</span>
                            <a href="<?php if(empty($rType)){$rType=0;} echo FF_DOMAIN.'/r/d0/r'.$rType;?>"<?php if(empty($dType)||$dType=='0'){echo 'class="active"';}?>>所有</a>
                            <a href="<?php echo FF_DOMAIN.'/r/d1/r'.$rType;?>"<?php if($dType=='1'){echo 'class="active"';}?>>今天</a>
                            <a href="<?php echo FF_DOMAIN.'/r/d2/r'.$rType;?>"<?php if($dType=='2'){echo 'class="active"';}?>>最近一周</a>
                            <a href="<?php echo FF_DOMAIN.'/r/d3/r'.$rType;?>"<?php if($dType=='3'){echo 'class="active"';}?>>一个月</a>
                            <a href="<?php echo FF_DOMAIN.'/r/d4/r'.$rType;?>"<?php if($dType=='4'){echo 'class="active"';}?>>三个月</a>
                            <a href="<?php echo FF_DOMAIN.'/r/d5/r'.$rType;?>"<?php if($dType=='5'){echo 'class="active"';}?>>六个月</a>
                        </div>
                        <div class="f-cb">
                            <span class="f-fl">交易类型</span>
<!--                            <a href="--><?php //if(empty($dType)){$dType=0;} echo FF_DOMAIN.'/r/d'.$dType.'/r0';?><!--"--><?php //if($rType=='0'||empty($rType)){echo 'class="active"';}?><!--全部</a>-->
                            <a href="<?php if(empty($dType)){$dType=0;} echo FF_DOMAIN.'/r/d'.$dType.'/r1';?>"<?php if($rType=='1' || empty($rType)){echo 'class="active"';}?>">充值</a>
                            <a href="<?php  if(empty($dType)){$dType=0;} echo FF_DOMAIN.'/r/d'.$dType.'/r3';?>"<?php if($rType=='3'){echo 'class="active"';}?>">提现</a>
                        </div>
                    </div>

                    <div class="transaction-list">
                        <table class="f-w-auto">
                            <?php
                            if($rType==3){?>
                            <tr>
                                <th>交易类型<em class="arrow-icon"></em></th>
                                <th>账户余额<em class="arrow-icon"></em></th>
                                <th>交易金额<em class="arrow-icon"></em></th>
                                <th>交易状态<em class="arrow-icon"></em></th>
                                <th>交易时间<em class="arrow-icon"></em></th>
                            </tr>
                            <?php foreach($cashList as $cash_val){?>
                                <tr>
                                    <td>提现</td>
                                    <td><?php echo $cash_val->avail_cash;?></td>
                                    <td><?php echo $cash_val->cash_money;?></td>
                                    <td><?php echo FConfig::item('config.cash_status.'.$cash_val->cash_status);?></td>
                                    <td><?php echo $cash_val->create_time;?></td>
                                </tr>

                            <?php }}else{?>
                            <tr>
                                <th>交易流水号<em class="arrow-icon"></em></th>
                                <th>交易类型<em class="arrow-icon"></em></th>
                                <th>账户余额<em class="arrow-icon"></em></th>
                                <th>交易金额<em class="arrow-icon"></em></th>
                                <th>交易状态<em class="arrow-icon"></em></th>
                                <th>交易时间<em class="arrow-icon"></em></th>
                            </tr>
                            <?php
                            $trade_mess = FConfig::item("config.trade_type_mess");
                            if(is_array($tradeList)){
                                foreach($tradeList as $val){
                                    $trade = $val ->getAttributes();
                                    $tradeStatus = $trade['trade_status'] ? "成功":"未完成";
                                    $u_account_val = floatval($trade['user_account_val'] + $trade['trade_fee']);
                                    echo "<tr>
                                <td>{$trade['trade_code']}</td>
                                <td>{$trade_mess[$trade['trade_type']]}</td>
                                <td>{$u_account_val}</td>
                                <td>{$trade['trade_fee']}</td>
                                <td>$tradeStatus</td>
                                <td>{$trade['trade_time']}</td>
                                </tr>";
                                }
                            }}
                            ?>

                        </table>

                        <?php if(is_array($tradeList)){$this->renderPartial('//page/index',array('page'=>$page));} ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end充值提现 -->
    </div>
</div>
<!-- end 用户中心-充值提现 -->
<input type="hidden" id="user_id" value="<?php echo $this->user['id'];?>" />
<input type="hidden" id="avail_cash" value="<?php echo floatval($this->userInfo['account_val']) -floatval($sumBuyVal);?>" />
<script>
    <?php if ($this->userInfo){?>

    FIREFLY.USER = <?php echo json_encode($this->userInfo) ?>;
    <?php }?>
    FIREFLY.defaultIndex = 0;
    <?php if($this->request->getParam('page')){?>
    FIREFLY.defaultIndex = 1;
    <?php }?>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
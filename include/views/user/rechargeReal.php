<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>
<!-- 充值详情页 -->
<div class="g-mn2 recharge f-w769">
    <div class="recharge-box">
        <div class="title f-bbdc">充值</div>
        <div class="content">
            <div class="recharge-way">
                <p class="tit"><span class="red">*</span>充值方式</p>
                <div class="options">
                    <ul id="menu-tab" class="menu f-cb f-graybgf6">
                        <li class="current">网银充值</li>
                        <li>银联在线</li>
                    </ul>
                    <div id="content-con" class="content-main">
                        <div class="content">
                            <!--<ul class="choose-bank f-cb">
                                <li>
                                    <span class="sel-redio checked"><input type="radio" class="radio" name="bank" checked="checked"></span>
                                    <span class="bank-icon"><img src="<?php /*echo FF_DOMAIN; */?>/upload/images/yinlian.png"></span>
                                </li>
                            </ul>-->
                            <div class="m-form2">
                                <form id="rechargeBankForm" target="_blank" method="post" action="<?php echo FF_DOMAIN;?>/m/recharge">
                                    <div class="form-item">
                                        <label class="lab">账户余额</label>
                                        <div class="ipt">
                                            <span class="red">&yen;0.00</span>元
                                        </div>
                                    </div>
                                    <div class="form-item">
                                        <label class="lab"><span class="red">*</span>充值金额</label>
                                        <div class="ipt">
                                            <input type="text" class="money" name="money" id="bank_money" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "/>
                                            <!--<1input type="text" class="money" name="money" id="bank_money" />-->
                                            <em class="yuan"></em>
                                            <input type="hidden" name="payType" id="payType" value="bank"/>
                                            <div class="vd-error">
                                                <em class="vd-arrow"></em>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-item">
                                        <label class="lab"></label>
                                        <div class="ipt">
                                            <a href="javascript:void(0)" id="recharge_bank_btn" class="u-btn u-btn-c1 f-pdlr18"><em class="chongzhi-icon"></em>充值</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="content">
                            <ul class="choose-bank f-cb">
                                <li>
                                    <span class="sel-redio checked"><input type="radio" class="radio" name="bank" checked="checked"></span>
                                    <span class="bank-icon"><img src="<?php echo FF_DOMAIN; ?>/upload/images/yinlian.png"></span>
                                </li>
                            </ul>
                            <div class="m-form2">
                                <form id="rechargeForm" target="_blank" method="post" action="<?php echo FF_DOMAIN;?>/m/recharge">
                                    <div class="form-item">
                                        <label class="lab">账户余额</label>
                                        <div class="ipt">
                                            <span class="red">&yen;0.00</span>元
                                        </div>
                                    </div>
                                    <div class="form-item">
                                        <label class="lab"><span class="red">*</span>充值金额</label>
                                        <div class="ipt">
                                            <input type="text" class="money" name="money" id="money" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "/>
                                            <em class="yuan"></em>
                                            <input type="hidden" name="payType" id="payType" value="unionPay"/>
                                            <div class="vd-error">
                                                <em class="vd-arrow"></em>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="form-item">
                                        <label class="lab">充值费用</label>
                                        <div class="ipt">
                                            <span class="red">&yen;0.00</span>元
                                            <p class="coupon"><input type="checkbox" name="" />使用最近到期的一张充值免费券（共1张）</p>
                                        </div>
                                    </div>-->
                                    <!--<div class="form-item">
                                        <label class="lab">实际金额</label>
                                        <div class="ipt">
                                            <span class="red">&yen;0.00</span>元
                                        </div>
                                    </div>-->
                                    <div class="form-item">
                                        <label class="lab"></label>
                                        <div class="ipt">
                                            <a href="javascript:void(0)" id="recharge_btn" class="u-btn u-btn-c1 f-pdlr18"><em class="chongzhi-icon"></em>充值</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- end充值详情页 -->
</div>
</div>
<!-- end 用户中心-充值详情页 -->
</div>
</div>
<!-- end 用户中心-投资记录 -->
<!-- 充值弹出框 -->
<div id="recharge-layer" style="display: none">
    <div class="recharge-layer">
        <p>付款完成前请不要关闭此窗口，完成付款后请根据<br>
            您的情况点击下面的按钮</p>
        <div class="btn">
            <a href="<?php echo FF_DOMAIN."/u/recharge";?>" class="u-btn u-btn-c1 u-btn-w150 u-btn-h40">已完成付款</a>
            <a href="<?php echo FF_DOMAIN."/help/helpPay";?>" class="u-btngray u-btn-c2 u-btn-w150 u-btn-h40">充值遇到问题</a>
        </div>
    </div>
</div>
<!-- /充值弹出框 -->
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
    require([GLOBAL_CF.BASE_URL+'/app/rechargeReal.js']);
</script>
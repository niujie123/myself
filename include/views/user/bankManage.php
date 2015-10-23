<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/bankselect.css" />
<!-- 用户中心-投资记录 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 银行卡管理 -->
        <div class="g-mn2 bank-card f-w769">
            <div class="bank-card-box">
                <div class="title f-bbdc">银行卡管理</div>
                <div class="leftcontent">
                    <div class="list f-mgb15">
                        <ul class="menu f-graybgf6">银行卡列表</ul>

                            <?php if(empty($bank_id) && empty($bank_num)){?>
                                <div class="erro"><img src="<?php echo FF_STATIC_BASE_URL; ?>/images/bankcard/bankcard-list-erro.png" />您还未添加银行卡,请添加银行卡</div>

                            <?php }else{?>
                        <div class="card-tab">
                            <table class="per-card-tab">
                                <tr>
                                    <th width="30%">用户名</th>
                                    <th width="30%">开户行</th>
                                    <th width="30%">银行卡帐号</th>
                                </tr>
                                <tr>
                                    <td><?php echo $real_name;?></td>
                                    <td><?php echo $bank_id;?></td>
                                    <td><?php echo $bank_num;?></td>
                                </tr>
                            </table>
                        </div>
                            <?php }?>
                    </div>
                    <div class="list">
                        <ul class="menu f-graybgf6">添加银行卡</ul>
                        <div class="add">
                            <div class="m-form2">
                                <form id="bank-form">
                                    <?php
                                    $disable = '';
                                    $placeHolder = '';
                                    if(!empty($real_name) && !empty($person_id)){

                                    ?>
                                    <div class="form-item">
                                        <div class="lab"><i class="orange">*</i> 开户姓名：</div>
                                        <div class="card-name"><span class="name"><?php echo $real_name;?><i class="gray">&nbsp;&nbsp;&nbsp;请添加相同开户名的银行卡</i></span></div>
                                    </div>
                                    <div class="form-item">
                                        <div class="lab"><i class="orange">*</i> 开户证件号：</div>
                                        <div class="card-name"><span class="name"><?php echo $person_id;?></span></div>
                                    </div>
                                    <?php
                                    }else{
                                        $disable = "disabled='disabled'";
                                        $placeHolder = 'placeholder="请先验证银行卡" ';
                                     ?>
                                    <div class="form-item">
                                        <div class="lab"><i class="orange">*</i> 开户姓名：</div>
                                        <div class="card-name"><span class="name">未绑定</span></div>
                                    </div>
                                    <div class="form-item">
                                        <div class="lab"><i class="orange">*</i> 开户证件号：</div>
                                        <div class="card-name"><span class="name">未绑定</span>
                                            <a href="<?php echo FF_DOMAIN;?>/user/verifyPIdPage" class="u-btn u-btn-h30 u-btn-c1 u-btn-ml50 u-btn-p8">立即绑定</a>
                                        </div>
                                    </div>
                                    <?php }?>

                                    <div class="form-item">
                                        <div class="lab"><span><i class="orange">*</i> 开户行：</span></div>
                                        <div class="card-name">
                                             <span class="name">
                                             <i id="icon_select_bank" class="china">&nbsp;</i>
                                             <input type="button" value="请选择银行" class="chose-bank" id="withdrawals" />
                                             </span>
                                        </div>
                                    </div>
                                    <div class="form-item">
                                        <label class="lab"><i class="orange">*</i> 银行卡号：</label>
                                        <div class="ipt">
                                            <span class="name">
                                            <input type="text" class="u-ipt2 u-ipt2-w230" name="bankId" id="bankId" <?php echo $disable; echo $placeHolder;?> />
                                            <div class="vd-error">
                                                <em class="vd-arrow"></em>
                                            </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-item">
                                        <label class="lab"><i class="orange">*</i> 确认卡号：</label>
                                        <div class="ipt">
                                            <span class="name">
                                            <input type="text" class="u-ipt2 u-ipt2-w230" name="confimBank"  <?php echo $disable;?> />
                                            <div class="vd-error">
                                                <em class="vd-arrow"></em>
                                            </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-item">
                                        <label class="lab"></label>
                                        <div class="ipt">
                                            <span class="name">
                                                <input type="button" class="bank_button u-btn u-btn-h35 u-btn-c1 u-btn-p22" value="确认"><span>（只能绑定一个银行卡！）</span>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rightcontent">
                    <div class="list f-mgb17">
                        <p><img src="<?php echo FF_STATIC_BASE_URL; ?>/images/bankcard/bankcard-Q.png"/>认证银行卡是否必须？</p>
                        <p><img src="<?php echo FF_STATIC_BASE_URL; ?>/images/bankcard/bankcard-A.png"/>不是必须，但建议您投资之前先进性认证。</p>
                        <p><img src="<?php echo FF_STATIC_BASE_URL; ?>/images/bankcard/bankcard-Q.png"/>认证银行卡有何作用？</p>
                        <p><img src="<?php echo FF_STATIC_BASE_URL; ?>/images/bankcard/bankcard-A.png"/>确保准确无误的将账户资金提现到您认证的银行卡。</p>
                    </div>
                    <div class="tips f-mgb17">
                        <ul class="f-graybgf6 tips-top">温馨提示</ul>
                        <div class="tips-bottom">
                            <p>1、请务必添加借记卡，不支持提现至信用卡账户。</p>
                            <p>2、请仔细填写并核对您的银行卡信息，如果您填写的支行名称不正确，可能将影响提现到账速度，或无法成功提现。</p>
                            <p>3、如果您不确定开户行支行名称，可打电话到所在地银行的营业网点询问或上网查询。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end基本信息 -->

        <!-- 选择银行弹出层 -->
        <div id="bank-out">
            <div id="withdrawals-layer" class="dialog" style="width:740px;border:#c9c9c9 1px solid;">
                <div class="titlebar"><a class="close" href="javascript:void(0);">关闭</a><h1>选择银行</h1></div>
                <div class="withdrawals-box">
                    <div class="banklist">
                        <ul class="select-banklist clearfix choose-bank">
                            <?php foreach ($bank_list as $k=>$v) {?>
                            <li>
                                <input type="radio" value="<?php echo $k;?>" name="bank" id="<?php echo $v['2'];?>" class="sel-redio">
                                <label title="<?php echo $v['1'];?>" for="<?php echo $v['2'];?>" class="<?php echo $v['2'];?>"></label>
                            </li>
                            <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /选择银行弹出层 -->
    </div>
</div>
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
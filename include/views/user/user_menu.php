<?php

    $greetings = "";
    if(0<date('G') && date('G')<12){
        $greetings = "上午好，";
    } elseif(12 <= date('G') && date('G')<18) {
        $greetings = "下午好，";
    } elseif (18 <= date('G') && date('G')<24){
        $greetings = "晚上好，";
    }
    $userHeadInfo['greetings'] = $greetings.Fn::wsubstr($this->user['nick_name'],0,10);
    $userHeadInfo['email_check'] = $this->userInfo['email_check'];
    $userHeadInfo['person_id'] = $this->userInfo['person_id'];
    if ($this->user['phone_num']) {
        $userHeadInfo['phone_check'] = 1;
    }else {
        $userHeadInfo['phone_check'] = 0;
    }

    $userHeadInfo['level'] = $userHeadInfo['email_check']+$userHeadInfo['person_id']+$userHeadInfo['phone_check'] ;
    $levels = FConfig::item("config.user_level");
    $userHeadInfo['level_name'] = $levels[$userHeadInfo['level']];
?>
<div class="g-sd2 sidebar">
    <!-- 个人信息 -->
    <div class="profile">
        <div class="pf-hd">
            <img src="<?php  echo FF_DOMAIN; ?>/upload/images/user_head.png" width="95" height="95" />
        </div>
        <div class="pf-name"><?php echo $userHeadInfo['greetings'];?></div>
        <div class="pf-identification f-cb">
            <span class="f-fl">认证</span>
            <a id="icon-email" class="verify-icon <?php if($userHeadInfo['email_check']) {echo 'active';}?>" title="邮箱认证"><span class="icon-email"></span></a>
            <a id="icon-profile" class="verify-icon <?php if($userHeadInfo['person_id']) {echo 'active';}?>"  title="身份证认证"><span class="icon-profile"></span></a>
            <a id="icon-mobile" class="verify-icon last <?php if($userHeadInfo['phone_check']) {echo 'active';}?>"  title="手机认证"><span class="icon-mobile"></span></a>
        </div>
        <div class="pf-level f-cb">
            <span class="f-fl">安全级别</span>&nbsp;&nbsp;
            <span><?php echo $userHeadInfo['level_name'];?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo FF_DOMAIN; ?>/u/userInfo">管理</a>
        </div>
    </div>
    <!-- end个人信息 -->

    <div class="user-menu">
        <dl>
            <dt>我的账户</dt>
            <dd>
                <div><a class="menu-icon <?php if($this->_action == 'index') echo 'active';?> icon-account" href="<?php echo FF_DOMAIN; ?>/u/">账户总览</a></div>
                <div><a class="menu-icon <?php if($this->_action == 'userInfo') echo 'active';?> icon-basicinfo" href="<?php echo FF_DOMAIN; ?>/u/userInfo">基本信息</a></div>
                <div><a class="menu-icon <?php if($this->_action == 'bankManage') echo 'active';?> icon-card" href="<?php echo FF_DOMAIN; ?>/u/bankManage">银行卡管理</a></div>
            </dd>
        </dl>
        <dl>
            <dt>我的投资</dt>
            <dd>
                <div><a class="menu-icon <?php if($this->_action == 'invest') echo 'active';?> icon-Investment" href="<?php echo FF_DOMAIN; ?>/u/invest">投资记录</a></div>
                <div><a class="menu-icon <?php if($this->_action == 'appoint') echo 'active';?> icon-yuyuejilu" href="<?php echo FF_DOMAIN; ?>/u/appoint">预约记录</a></div>
            </dd>
        </dl>
        <dl>
            <dt>账户管理</dt>
            <dd>
                <div><a class="menu-icon <?php if($this->_action == 'recharge') echo 'active';?> icon-recharge" href="<?php echo FF_DOMAIN; ?>/u/recharge">充值提现</a></div>
            </dd>
        </dl>
        <!--<dl>
            <dt>咨询中心</dt>
            <dd>
                <div><a class="menu-icon <?php /*if($this->_action == 'information') echo 'active';*/?> icon-notice" href="#">公告</a></div>
            </dd>
        </dl>-->
    </div>

</div>
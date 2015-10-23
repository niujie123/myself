<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-投资记录 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 基本信息 -->
        <div class="g-mn2 basic-info f-w769">
            <div class="basic-info-box">
                <div class="title f-bbdc">基本信息</div>
                <div class="basic-profile f-cb f-bbdc">
                    <div class="pf-head f-fl"><img src="<?php echo FF_DOMAIN; ?>/upload/images/user_head2.png" width="95" height="95" /></div>
                    <div class="pf-content f-fl f-cb">
                        <div class="pf-name f-mgb10"><?php echo $user['nick_name'];?></div>
                        <div class="f-mgb10 f-cb">
                            <span class="f-fl">资料完整度</span>
                            <span class="f-fl basic-progress-bg">
                                <b style="width: <?php echo $userHeadInfo['progress'];?>%" class="basic-percent"></b>
                            </span>
                            <span class="f-fl basic-progress-value"><?php
                                $levels = FConfig::item("config.user_level");
                                echo $userHeadInfo['level_name'];?></span>
                        </div>
                        <div>
                         <!--   --><?php
/*                            $userHeadInfo['email_check'] = $this->userInfo['email_check'];
                            $userHeadInfo['person_id'] = $this->userInfo['person_id'];
                            if ($this->user['phone_num']) {
                                $userHeadInfo['phone_check'] = 1;
                            }else {
                                $userHeadInfo['phone_check'] = 0;
                            }
                            $userHeadInfo['level'] = $userHeadInfo['email_check']+$userHeadInfo['person_id']+$userHeadInfo['phone_check'] ;

                            $userHeadInfo['level_name'] = $levels[$userHeadInfo['level']];
                            */?>
                            <span class="f-fl">认证</span>
                            <a id="icon-email" class="verify-icon <?php if($userHeadInfo['email_check']) {echo 'active';}?>" title="邮箱认证"><span class="icon-email"></span></a>
                            <a id="icon-profile" class="verify-icon <?php if($userHeadInfo['person_id']) {echo 'active';}?>"  title="身份证认证"><span class="icon-profile"></span></a>
                            <a id="icon-mobile" class="verify-icon last <?php if($userHeadInfo['phone_check']) {echo 'active';}?>"  title="手机认证"><span class="icon-mobile"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="personal-info">
                <div class="title f-bbdc">个人信息</div>
                <div class="info-content">
                    <div class="info-row">
                        <div class="row f-cb">
                            <div class="f-fl info-name">用户名</div>
                            <div class="f-fl info-value"><?php echo $user['nick_name'];?></div>
<!--                            <div class="f-fl info-btn"><a class="u-btn u-btn-c1 u-btn-w103 u-btn-h24 u-btn-style2">修改</a> </div>-->
                        </div>
                    </div>
                    <div class="info-row f-bbdc">
                        <div class="row f-cb">
                            <div class="f-fl info-name">登录密码</div>
                            <div class="f-fl info-value">********</div>
                            <div class="f-fl info-btn"><a href="<?php echo FF_DOMAIN;?>/user/updatePwd" class="u-btn u-btn-c1 u-btn-w103 u-btn-h24 u-btn-style2">修改</a> </div>
                        </div>
                    </div>
                    <?php if(!empty($userInfo['person_id'])){?>
                    <div class="info-row">
                        <div class="row f-cb">
                            <div class="f-fl info-name">真实姓名</div>
                            <div class="f-fl info-value"><?php echo $userInfo['real_name'];?></div>
                        </div>
                    </div>
                    <div class="info-row f-bbdc">
                        <div class="row f-cb">
                            <div class="f-fl info-name">身份证号</div>
                            <div class="f-fl info-value"><?php echo substr_replace($this->userInfo['person_id'],'**********','4','-4');?></div>
                        </div>
                    </div>
                    <?php }else{?>
                        <div class="info-row">
                            <div class="row f-cb">
                                <div class="f-fl info-name">真实姓名</div>
                                <div class="f-fl info-value">未验证</div>
                                <div class="f-fl info-btn"><a href="<?php echo FF_DOMAIN;?>/user/verifyPIdPage" class="u-btn u-btn-c1 u-btn-w103 u-btn-h24 u-btn-c1">立即验证</a> </div>
                            </div>
                        </div>
                        <div class="info-row f-bbdc">
                            <div class="row f-cb">
                                <div class="f-fl info-name">身份证号</div>
                                <div class="f-fl info-value">未验证</div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="info-row">
                        <div class="row f-cb">
                            <div class="f-fl info-name">绑定邮箱</div>
                            <div id="bind_mail" class="f-fl info-value"><?php echo $user['email'];?></div>
                            <?php if($userInfo['email_check'] == 0){?>
                            <div class="f-fl info-btn"><input type="button" class="send_mail u-btn u-btn-c1 u-btn-w103 u-btn-h24 u-btn-c1" value="登录邮箱绑定" /></div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="row f-cb">
                            <div class="f-fl info-name">绑定手机</div>
                            <div class="f-fl info-value"><?php echo substr_replace($this->user['phone_num'],'****','3','4');?></div>
                            <div class="f-fl info-btn"><a href="<?php echo FF_DOMAIN;?>/user/updatePhone" class="u-btn u-btn-c1 u-btn-w103 u-btn-h24 u-btn-style2">修改</a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end基本信息 -->
    </div>
</div>
<!-- end 用户中心-投资记录 -->
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
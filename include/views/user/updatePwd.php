<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-账户总览 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>
        <!-- 修改密码 -->
        <div class="g-mn2 update-pwd f-w769">
            <div class="pwd-box">
                <div class="title f-bbdc">修改密码</div>
                <div class="content">
                    <div class="m-form2">
                        <form id="updatePwd-form">
                            <div class="form-item">
                                <label class="lab">当前登录密码：</label>
                                <div class="ipt">
                                    <input type="password" class="u-ipt2" id="old-pwd" name="old_pwd"/>
<!--                                    <input type="hidden" id="user_id" name="user_id"/>-->
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">新登录密码：</label>
                                <div class="ipt">
                                    <input type="password" id="new-pwd" class="u-ipt2" name="new_pwd"/>
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">确认新登录密码：</label>
                                <div class="ipt">
                                    <input type="password" id="confirm_pwd" class="u-ipt2" name="confirm_pwd"/>
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">手机校验码：</label>
                                <div class="ipt">
                                    <input type="text" id="phone_code" class="u-ipt2 u-ipt-w210" name="phone_code" />
                                    <input type="button" class="sendMsg obtain-code" value="点此免费获取" />
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab"></label>
                                <div class="ipt">
                                    <input type="button" class="btn_update_pwd u-btn u-btn-c1 u-btn-w103" value="提&nbsp;&nbsp;交">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end修改密码 -->
    </div>
</div>
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
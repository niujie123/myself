<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-账户总览 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <!-- 修改密码 -->
        <div class="g-mn2 update-pwd f-w769">
            <div class="pwd-box">
                <div class="title f-bbdc">忘记密码</div>
                <div class="content">
                    <div class="m-form2">
                        <form id="getPwd-form">
                            <div class="form-item">
                                <label class="lab">用户名：</label>
                                <div class="ipt">
                                    <input type="text" class="u-ipt2" id="user_name" name="user_name" />
                                    <input type="hidden" id="user_phone" />
<!--                                    <input type="hidden" id="user_id" name="user_id"/>-->
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">新登录密码：</label>
                                <div class="ipt">
                                    <input type="password" id="new_pwd" class="u-ipt2" name="new_pwd"/>
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>（必须是数字和字母的组合）
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
                                    <input type="button" class="btn_get_password u-btn u-btn-c1 u-btn-w103" value="提&nbsp;&nbsp;交">
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
    require([GLOBAL_CF.BASE_URL+'/app/login.js']);
</script>
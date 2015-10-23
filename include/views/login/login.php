<!-- 登录页面 -->
<div id="pg-login" class="f-bg-gray f-pdb35">
    <div class="login-form m-form f-fr">
        <h3 class="login-form-title">欢迎回来</h3>
        <form id="login-form">
            <div class="err-alert" style="display: none">

            </div>
            <div class="form-item">
                <em class="icon login-email-icon"></em>
                <div class="ipt">
                    <input type="text"
                           value="<?php
                    $userName = FCookie::get('user_name');
                           if ($userName) {
                               echo $userName;
                           }
                    ?>"
                           class="u-ipt u-ipt-pl30" id="userName" placeholder="电子邮箱或手机号码" />
                </div>
            </div>
            <div class="form-item">
                <em class="icon password-icon"></em>
                <div class="ipt">
                    <input type="password" class="u-ipt u-ipt-pl30" id="password" autocomplete="off" placeholder="请输入登录密码" value=""/>
                </div>
            </div>
            <div class="f-mgb05">
                <input type="hidden" id="ru" value="<?php echo $returnurl?>">
                <input type="button" id="login-btn" class="login_btn u-btn u-btn-auto u-btn-h42 u-btn-c1" value="立即登录" />
            </div>
            <div class="form-item">
                <span class="sel-checkbox" style="background-position: 0 -248px">
                    <input type="checkbox" checked="checked" id="rememberme" name="rememberme">
                </span>
                <label for="rememberme">记住用户名</label>
                <a class="forget-pwd f-fr f-color-orange" href="<?php echo FF_DOMAIN;?>/login/getPassword">忘记密码?</a>
            </div>
            <div class="form-item">
                没有账号？<a class="f-color-orange" href="<?php echo FF_DOMAIN; ?>/register">立即注册</a>
            </div>
        </form>
    </div>
</div>
<!-- end 登录页面 -->
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/index/index.css" />
<script>
    require([GLOBAL_CF.BASE_URL+'/app/login.js']);
</script>
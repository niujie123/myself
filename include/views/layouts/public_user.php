<?php if($this->user) {?>
    <div class="header-top">
        <div class="g-in f-cb">
            <div class="f-fl"></div>
            <div class="nav-login f-fr">
                您好，<a href="<?php echo FF_DOMAIN; ?>/u" class="user"><?php echo substr_replace($this->user['nick_name'],'*******','3','-7'); ?></a><a href="<?php echo FF_DOMAIN.'/login/logout';?>">[退出登录]</a>
            </div>
        </div>
    </div>
<?php }else { ?>
    <div class="header-top">
        <div class="g-in f-cb">
            <div class="f-fl"></div>
            <div class="nav-login f-fr">
                <a class="login-link" href="<?php echo FF_DOMAIN; ?>/login">登录</a><a class="reg-link" href="<?php echo FF_DOMAIN; ?>/register">注册</a>
            </div>
        </div>
    </div>
<?php }?>

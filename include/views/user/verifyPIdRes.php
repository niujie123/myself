<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-投资记录 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 身份验证 -->
        <div class="g-mn2 id-valid f-w769">
            <div class="id-box">
                <div class="title f-bbdc">身份证认证</div>
                <div class="content">
                    <div class="step1">
                        <div class="valid-success">
                            <div class="success-msg">
                                <p><em class="<?php echo $class;?>"></em><?php echo $mess;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end身份验证 -->

    </div>
</div>
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
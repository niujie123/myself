<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-账户总览 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>
        <!-- 修改密码 -->
        <div class="g-mn2 update-pwd f-w769">
            <div class="pwd-box">
                <div class="title f-bbdc">修改手机号</div>
                <div class="content">
                    <div class="m-form2">
                        <form id="updatePhone-form">
                            <div class="form-item">
                                <label class="lab">当前手机号：</label>
                                <div class="ipt">
                                    <input type="text" class="u-ipt2" id="old-phone" name="old_phone"/>
                                    <div class="vd-error" id="_phone">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">新手机号：</label>
                                <div class="ipt">
                                    <input type="text" id="new-phone" class="u-ipt2" name="new_phone"/>
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">确认新手机号：</label>
                                <div class="ipt">
                                    <input type="text" id="confirm-phone" class="u-ipt2" name="confirm_phone"/>
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab">手机校验码：</label>
                                <div class="ipt">
                                    <input type="text" id="phone_code" class="u-ipt2 u-ipt-w210" name="phone_code" />
                                    <input type="button" class="sendMsgPhone obtain-code" value="点此免费获取" />
                                    <div class="vd-error">
                                        <em class="vd-arrow"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="lab"></label>
                                <div class="ipt">
                                    <input type="button" class="btn_update_phone u-btn u-btn-c1 u-btn-w103" value="提&nbsp;&nbsp;交">
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
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
                        <div><img src="<?php echo FF_DOMAIN; ?>/upload/images/id_valid_step1.png" /></div>
                        <div class="m-form2">
                            <form id="withdrawals-form">
                                <div class="form-item">
                                    <label class="lab">真实姓名：</label>
                                    <div class="ipt">
                                        <input type="text" id="person_name" class="u-ipt2" name="real_name"/>
                                        <div class="vd-error">
                                            <em class="vd-arrow"></em>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-item">
                                    <label class="lab">身份证号：</label>
                                    <div class="ipt">
                                        <input type="text" id="person_num" class="u-ipt2" name="id_num"/>
                                        <div class="vd-error">
                                            <em class="vd-arrow"></em>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-item">
                                    <label class="lab"></label>
                                    <div class="ipt">
                                        <input type="button" id="id-nextBtn" class="u-btn u-btn-c1 u-btn-w80" value="下一步">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end身份验证 -->

        <!-- 身份信息认证弹出框 -->
        <div id="id-layer" style="display: none">
            <div class="id-layer">
                <p>身份证信息验证中...</p>
            </div>
        </div>
        <!-- /身份信息认证弹出框 -->

    </div>
</div>
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
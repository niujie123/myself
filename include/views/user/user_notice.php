<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-投资记录 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 系统公告 -->
        <div class="g-mn2 notice f-w769">
            <div class="notice-box">
                <div class="title f-bbdc">通知</div>
                <div class="content">
                    <ul class="notice-list">
                        <li class="f-cb">
                            <div class="img"><img src="images/notice_img.jpg" width="99" height="113"></div>
                            <div class="info">
                                <div class="tit">材料通过</div>
                                <div class="time">2015-01-12  11:12:12</div>
                                <div class="detial">尊敬的用户zhangchao839398:您好，您于2015年03月22日在萤火虫理财的身份证绑定信息已经成功 通过审核... </div>
                                <a class="open">展开<em></em></a>
                            </div>
                        </li>
                    </ul>
                    <div class="pagination">
                        <a href="#">上一页</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <span class="current">4</span>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">...</a>
                        <a href="#">下一页</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end系统公告 -->
    </div>
</div>
<!-- end 用户中心-投资记录 -->
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
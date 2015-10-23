<!-- 头部 -->
<div id="header" class="header f-cb">
    <?php $this->renderPartial('//layouts/public_user'); ?>
    <div class="header-main">
        <div class="g-in f-cb">
            <div class="header-logo f-fl">
                <a href="<?php echo FF_DOMAIN; ?>/index"><img src="<?php echo FF_DOMAIN; ?>/upload/images/logo.png" width="315" height="75" alt="萤火虫理财" /></a>
            </div>
            <div class="header-nav f-fr">
                <ul class="f-cb">
                    <li <?php if(Yii::app()->controller->id == 'site'){echo 'class="current"';}?>><a href="<?php echo FF_DOMAIN;?>/index">首页</a></li>
                    <li <?php if(Yii::app()->controller->id == 'product'){echo 'class="current"';}?>><a href="<?php echo FF_DOMAIN.'/s';?>">我要理财</a></li>
                    <li <?php if(Yii::app()->controller->id == 'help'){echo 'class="current"';}?>><a href="<?php echo FF_DOMAIN;?>/help">帮助中心</a></li>
                    <li <?php if(Yii::app()->controller->id == 'contactUs'){echo 'class="current"';}?>><a class="last" href="<?php echo FF_DOMAIN;?>/contactUs">联系我们</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end头部 -->

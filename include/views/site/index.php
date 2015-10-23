<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/index/index.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/flexslider.css" />
<!-- banner -->
<div id="banner">
    <!--flash start-->
    <div id="flash" class="flexslider" >
        <ul class="slides" >
            <li style="background:url(<?php echo FF_DOMAIN; ?>/upload/images/banner_silder/silder01.jpg) 50% 0 no-repeat;"></li>
            <li style="background:url(<?php echo FF_DOMAIN; ?>/upload/images/banner_silder/silder02.png) 50% 0 no-repeat;"></li>
        </ul>
    </div>
    <!--flash end-->
</div>
<!-- end banner -->
<!-- 登陆注册状态 -->
<div class="pg-box">
    <div class="g-in f-pr">

        <?php if( $this->user) {?>
        <!-- 登陆 -->
        <div class="login" style="display: block">
            <div class="welcome">欢迎您，<br /><?php echo substr_replace($this->user['nick_name'],'*******','3','-7');?></div>
            <div class="btn"><a href="<?php echo FF_DOMAIN; ?>/u" class="u-btn u-btn-c1 u-btn-h30 u-btn-w132">我的账户</a> </div>
            <div class="tel">客服电话：400-018-5255</div>
        </div>
        <!-- end 登陆 -->
        <!-- 遮罩 -->
            <div class="mask login-mask"></div>
            <!-- end 遮罩 -->
        <?php }else {?>
            <!-- 注册 -->
            <div class="register" >
                <div class="title">萤火虫理财欢迎您！</div>
                <div class="content">
                    <p class="p1"><span>专业投资建议</span></p>
                    <p class="p1"><span>一站式综合理财平台</span></p>
                </div>
                <div class="reg-btn">
                    <a href="<?php echo FF_DOMAIN; ?>/register" class="u-btn u-btn-auto u-btn-c1">立即注册</a>
                    <p class="login-link"><a href="<?php echo FF_DOMAIN; ?>/login">已有账号？立即登录</a> </p>
                </div>
            </div>
            <!-- end 注册 -->
            <!-- 遮罩 -->
            <div class="mask"></div>
            <!-- end 遮罩 -->
        <?php }?>

    </div>
</div>
<!-- end 登陆注册状态 -->
<!-- 首页内容 -->
<div id="pg-index">

    <!-- 媒体 -->
    <div class="g-in">
        <div class="media">
            <div class="media-guide f-fl">
                <div class="item">
                    <a href="<?php echo FF_DOMAIN;?>/site/knowYhc"><i class="media-icon icon1"></i><p>了解萤火虫</p></a>
                </div>
                <div class="item">
                    <a href="<?php echo FF_DOMAIN;?>/site/newUserGuide"><i class="media-icon icon2"></i><p>新手指引</p></a>
                </div>
            </div>
            <div class="media-news f-fl">
                <div class="tit">
<!--                    <a href="#" class="more f-fr">更多>></a>-->
                    <i class="icon"></i>媒体报道
                </div>
                <ul class="list">
                    <li>
                        <a href="<?php echo FF_DOMAIN."/news/index1";?>"><span class="media-logo">新京报：互联网，为颠覆而生</span>互联网发展史已经证明...</a>
                    </li>
                    <li>
                        <a href="<?php echo FF_DOMAIN."/news/index2";?>"><span class="media-logo">互联网金融探索自律式发展 </span>由中国政法大学金融创新...</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /媒体 -->

    <!-- 内容介绍 -->
    <!--<div class="intro-box">
        <div class="g-in">
            <ul class="intro f-cb">
                <li>
                    <span class="intro-fig intro-fig-1"></span>
                    <h3 class="intro-title">安全</h3>
                    <p class="intro-desc">运用技术分散投资<br/>帮助投资人进入本金保障计划</p>
                </li>
                <li>
                    <span class="intro-fig intro-fig-2"></span>
                    <h3 class="intro-title">收益</h3>
                    <p class="intro-desc">我们不介入交易<br/>借款人的利息100%给到投资人</p>
                </li>
                <li>
                    <span class="intro-fig intro-fig-3"></span>
                    <h3 class="intro-title">保障</h3>
                    <p class="intro-desc">不接触资金不赚利差<br/>最大地保障了平台安全</p>
                </li>
            </ul>
        </div>
    </div>-->
    <!-- end 内容介绍 -->
    <!-- 广告 -->
    <div class="g-in">
        <div class="ad">
            <ul class="f-cb">
                <li style="width: 470px; height: 180px;overflow: hidden;"><a href="<?php echo FF_DOMAIN;?>/d/8"><img src="<?php echo FF_STATIC_BASE_URL?>/images/ad_img8.png" /></a></li>
                <li style="width: 470px; height: 180px;overflow: hidden;" class="last"><a href="<?php echo FF_DOMAIN;?>/d/7"><img src="<?php echo FF_STATIC_BASE_URL?>/images/ad_img7.png" /></a></li>
            </ul>
        </div>
    </div>
    <!-- end 广告 -->
    <!-- 产品列表 -->
    <div class="g-in">
        <div class="product-list">
            <div class="product-list-title">
                <a class="f-fr more" href="<?php echo FF_DOMAIN.'/s/1/all';?>">更多>></a>
                <h3 class="f-h3"><i class="icon"></i>萤火虫专区</h3>
            </div>
            <div class="product-list-content">
                <ul>
                    <?php if (!is_array($proIndexList) || count($proIndexList) < 1) {
                        $productList = array();
                        ?>
                        <!-- 无搜索结果 -->
                        <div class="no-result">
                            没有你想找到的哟~
                        </div>
                        <!-- end 无搜索结果 -->
                    <?php }else {foreach($proIndexList as $v){?>
                            <li class="f-cb">
                                <div class="f-fl">
                                    <div class="img f-fl"><a href="<?php echo FF_DOMAIN."/d/".$v['id'];?>"> <img src="<?php echo FF_DOMAIN.$v['product']['product_icon']; ?>" width="68" height="68"></a></div>
                                    <div class="info f-fl">
                                        <div>
                                            <!--<span class="count-profits f-fr">计算收益</span>-->
                                            <h3 class="f-h3"><a href="<?php echo FF_DOMAIN."/d/".$v['id'];?>" class="link_name"> <?php echo $v['product']['product_name'];?></a></h3></div>
                                        <div class="desc"><?php echo Fn::wsubstr($proType[$v['product']['product_type_id']]['description'],0,90);?></div>
                                        <div class="info-bottom f-cb">
                                            <div class="item-yields">
                                                <div class="f-fl">
                                                    <p>预计年化</p>
                                                    <p>收益率</p>
                                                </div>
                                                <div>
                                                    <span class="rate"><?php echo $v['product']['yield_rate_year'];?>%</span>
                                                </div>
                                            </div>
                                            <div class="item-term">
                                                <p>投资期限</p>
                                                <p class="red"><?php echo $v['product']['earn_days_sign'];?></p>
                                            </div>
                                            <div class="item">
                                                <p>起投金额</p>
                                                <p class="red"><?php echo $v['product']['fund_min_val'];?>元</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-investment f-fr">
                                    <div class="investment-money"><span class="t t1">已投金额</span><span class="red"><?php if($v['sum_buy_val']){echo $v['sum_buy_val'];}else{echo '0.00';}?>元</span></div>
                                    <div class="join-num"><span class="t t2">加入人数</span><span class="red"><?php echo $v['count_user'];?>人</span></div>
                                    <div class="investment-btn"><a href="<?php echo FF_DOMAIN.'/d/'.$v['id'];?>" class="u-btn u-btn-sm114 u-btn-c1">立即投资</a> </div>
                                </div>
                            </li>
                            <?php }}?>
                </ul>
            </div>
        </div>
        <?php if (!is_array($proIndexXintuoList) || count($proIndexXintuoList) < 1) {
            $proIndexXintuoList = array();
            ?>
            <!-- 无搜索结果 -->

            <!-- end 无搜索结果 -->
        <?php } foreach($proIndexXintuoList as $type_val => $value){
            if($type_val == 2){
                foreach($value as $type_id=>$per_type){
                    $class_icon = '';
                    $class_u_btn = '';
                    $class_u_btn_c = '';
                    $class_icon = FConfig::item('config.proType_color.'.$proType[$value[$type_id][0]->product_type_id]['ad_color'].'.icon');
                    $class_u_btn = FConfig::item('config.proType_color.'.$proType[$value[$type_id][0]->product_type_id]['ad_color'].'.u-btn');
                    $class_u_btn_c = FConfig::item('config.proType_color.'.$proType[$value[$type_id][0]->product_type_id]['ad_color'].'.u-btn-c');
        ?>
        <div class="product-list f-mt20">
            <div class="product-list-title">
                <a class="f-fr more" href="<?php echo FF_DOMAIN.'/s/'.$value[$type_id][0]->product_type_id.'/all';?>">更多>></a>
                <h3 class="f-h3"><i class="<?php echo $class_icon;?>"></i><?php echo $proType[$value[$type_id][0]->product_type_id]['type_name'];?></h3>
            </div>
            <div class="product-list-content">
                <ul>
                    <?php foreach($per_type as $v){ ?>
                    <li class="f-cb">
                        <div class="f-fl">
                            <div class="img f-fl"><a href="<?php echo FF_DOMAIN."/x/".$v->id;?>"><img src="<?php echo FF_DOMAIN.$v->xintuo_icon;?>" width="68" height="68"></a></div>
                            <div class="info f-fl">
                                <div>
<!--                                    <span class="count-profits f-fr">计算收益</span>-->
                                    <h3 class="f-h3"><a href="<?php echo FF_DOMAIN."/x/".$v->id;?>" class="link_name"> <?php echo $v->xintuo_name;?></a></h3>
                                </div>
<!--                                <div class="desc">--><?php //echo Fn::wsubstr($v->xintuo_annual_yield,0,70);?><!--</div>-->
                                <div class="info-bottom f-cb">
                                    <div class="item-yields">
                                        <div class="f-fl">
                                            <p>预计年化</p>
                                            <p>收益率</p>
                                        </div>
                                        <div>
                                            <span class="rate"><?php echo $v->xintuo_annual_yield_min.'-'.$v->xintuo_annual_yield_max;?>%</span>
                                        </div>
                                    </div>
                                    <div class="item-term">
                                        <p>类型</p>
                                        <p class="red"><?php echo $v->xintuo_type;?></p>
                                    </div>
                                    <div class="item">
                                        <p>起投金额</p>
                                        <p class="red"><?php echo $v->xintuo_min_val.FConfig::item('config.money_unit.'.$v->money_unit);?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-investment f-fr">
                            <div class="investment-btn"><a href="<?php echo FF_DOMAIN.'/x/'.$v->id;?>" class="u-btn-sm114 u-btn-mt50 <?php echo $class_u_btn.' '.$class_u_btn_c;?>">了解详情</a> </div>
                        </div>
                    </li>
                    <?php }?>

                </ul>
            </div>
        </div>
        <?php }}} if (!is_array($proIndexFundList) || count($proIndexFundList) < 1) {
            $proIndexXintuoList = array();
            ?>
            <!-- 无搜索结果 -->

            <!-- end 无搜索结果 -->
        <?php } foreach($proIndexFundList as $type_val => $value){ if($type_val == 3){?>
            <div class="product-list f-mt20">
                <div class="product-list-title">
                    <a class="f-fr more" href="<?php echo FF_DOMAIN.'/s/3/all';?>">更多>></a>
                    <h3 class="f-h3"><i class="icon4"></i><?php echo $proType[$value[0]->product_type_id]['type_name'];?></h3>
                </div>
                <div class="product-list-content">
                    <ul>
                        <?php foreach($value as $v){?>
                            <li class="f-cb">
                                <div class="f-fl">
                                    <div class="img f-fl"><a href="<?php echo FF_DOMAIN."/f/".$v->id;?>"><img src="<?php echo FF_DOMAIN.$v->fund_icon;?>" width="68" height="68"></a></div>
                                    <div class="info f-fl">
                                        <div>
<!--                                            <span class="count-profits f-fr">计算收益</span>-->
                                            <h3 class="f-h3"><a href="<?php echo FF_DOMAIN."/f/".$v->id;?>" class="link_name"> <?php echo $v->fund_name;?></a></h3>
                                        </div>
                                        <!--                                <div class="desc">--><?php //echo Fn::wsubstr($proType[$v['product']['product_type_id']]['description'],0,70);?><!--</div>-->
                                        <div class="info-bottom f-cb">
                                            <div class="item-yields">
                                                <div class="f-fl">
                                                    <p>基金</p>
                                                    <p>管理人</p>
                                                </div>
                                                <div>
                                                    <span class="rate"><?php echo $v->fund_manager;?></span>
                                                </div>
                                            </div>
                                            <div class="item-term">
                                                <p>类型</p>
                                                <p class="red"><?php echo $v->fund_type;?></p>
                                            </div>
                                            <div class="item">
                                                <p>投资门槛</p>
                                                <p class="red"><?php echo $v->min_val.FConfig::item('config.money_unit.'.$v->money_unit);?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-investment f-fr">
                                    <div class="investment-btn"><a href="<?php echo FF_DOMAIN.'/f/'.$v->id;?>" class="u-btn4 u-btn-sm114 u-btn-c4 u-btn-mt50">了解详情</a> </div>
                                </div>
                            </li>
                        <?php }?>

                    </ul>
                </div>
            </div>
        <?php }}?>
    </div>
    <!-- end 产品列表 -->

    <!-- 产品类型 -->
    <!--<div class="product-type">
        <div class="g-in">
            <div class="product-type-title f-cb">
                <a class="more f-fr" href="<?php /*echo FF_DOMAIN."/s";*/?>">查看更多>></a>
                <h3 class="f-h3">产品类型介绍</h3>
            </div>
            <div class="product-type-content">
                <ul>
                    <?php /*$i = 1;foreach($proType as $v){*/?>
                    <li class=" <?php /*if ($i == count($proType)) { echo "last";} else {echo "time";} $i++;*/?>">
                        <h3><?php /*echo $v['type_name'];*/?></h3>
                        <p class="time"><?php /*echo Fn::wsubstr($v['description'],0,70);*/?></p>
                        <p><a href="<?php /*echo FF_DOMAIN.'/s/'.$v['id'].'/all';*/?>" class="u-btn u-btn-auto u-btn-c1">立即投资</a></p>
                    </li>
                    <?php /*}*/?>
                </ul>
            </div>
        </div>
    </div>-->
    <!-- end 产品类型 -->


    <!-- 合作伙伴 -->
    <div class="g-in">
        <div class="partner f-mt20">
            <div class="title"><i class="icon"></i>合作伙伴</div>
            <div class="partner-con">
                <ul class="f-cb">
                    <li><a href="http://www.idgvc.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_IDG.jpg"></a></li>
                    <li><a href="http://www.fortunevc.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_dachen.jpg"></a></li>
                    <li><a href="http://trust.ecitic.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_zhongxin.jpg"></a></li>
                    <li><a href="http://www.bjitic.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_beiguo.jpg"></a></li>
                    <li><a href="http://www.chinaamc.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_huaxia.jpg"></a></li>
                    <li><a href="http://www.hsbc.com.cn/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_huifeng.jpg"></a></li>
                </ul>
                <ul class="f-cb">
                    <li><a href="http://bank.ecitic.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_zhongxinbank.jpg"></a></li>
                    <li><a href="http://www.cmbc.com.cn/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_minsheng.jpg"></a></li>
                    <li><a href="http://ebank.spdb.com.cn/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_pufa.jpg"></a></li>
                    <li><a href="http://www.cindasc.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_xinda.jpg"></a></li>
                    <li><a href="http://www.cs.ecitic.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_zongxin.jpg"></a></li>
                    <li><a href="http://www.ccb.com/"><img src="<?php echo FF_STATIC_BASE_URL?>/images/partner/parter_jianhang.jpg"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end 合作伙伴 -->

</div>
<!-- end首页内容 -->
<style type="text/css">
.link_name:hover{
    color: #000000;
    text-decoration: underline;
}
</style>

<script>
    require([GLOBAL_CF.BASE_URL+'/app/index.js']);
</script>
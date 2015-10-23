<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-投资记录 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 投资记录 -->
        <div class="g-mn2 investment-records f-w769">
            <div class="ir-box">
                <div class="title f-bbdc">投资记录</div>
                <div class="content">
                    <div class="screening f-cb">
                        <span class="f-fl">按时间筛选：</span>
                        <a href="<?php if(empty($tDate)){$tDate=0;} echo FF_DOMAIN.'/i/d0';?>"<?php if($tDate=='0'||empty($tDate)){echo 'class="active"';}?>>所有</a>
                        <a href="<?php echo FF_DOMAIN.'/i/d1';?>"<?php if($tDate=='1'){echo 'class="active"';}?>>今天</a>
                        <a href="<?php echo FF_DOMAIN.'/i/d2';?>"<?php if($tDate=='2'){echo 'class="active"';}?>>最近一周</a>
                        <a href="<?php echo FF_DOMAIN.'/i/d3';?>"<?php if($tDate=='3'){echo 'class="active"';}?>>一个月</a>
                        <a href="<?php echo FF_DOMAIN.'/i/d4';?>"<?php if($tDate=='4'){echo 'class="active"';}?>>三个月</a>
                        <a href="<?php echo FF_DOMAIN.'/i/d5';?>"<?php if($tDate=='5'){echo 'class="active"';}?>>六个月</a>
                    </div>
                    <div class="status f-cb">
                        <span class="f-fl">已购买：<em><?php echo $count_start;?></em>笔</span>
                        <span class="f-fl">持有中：<em><?php echo $count_ing;?></em>笔</span>
                        <span class="f-fl">已结束：<em><?php echo $count_end;?></em>笔</span>
                    </div>

                    <div class="records-list">
                        <table class="f-w-auto">
                            <tr>
                                <th>交易编码</th>
                                <th>操作</th>
                                <th>总交易金额（元）</th>
                                <th>手续费</th>
                                <th>实际转入金额</th>
                                <th>累计收益（元）</th>
                                <th>状态</th>
                                <th>交易详情</th>
                            </tr>
                            <?php foreach($userProductBuyList as $k=>$v){?>
                            <tr>
                                <td>
                                    <p><?php echo $proPublish[$v->id]['product']->product_name;?></p>
                                    <p><?php echo $v->buy_code;?></p>
                                    <p><?php echo $v->create_time;?></p>
                                </td>
                                <td>转入</td>
                                <td><?php echo $v->buy_val;?></td>
                                <td>0.00</td>
                                <td><?php echo $v->buy_val-0;?></td>
                                <td>0.00</td>
                                <td><?php echo FConfig::item('config.buy_status_mess.'.$v->buy_status);?></td>
                                <td><a href="#">查看</a> </td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- end投资记录 -->
    </div>
</div>
<!-- end 用户中心-投资记录 -->
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
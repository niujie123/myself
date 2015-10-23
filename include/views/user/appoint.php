<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/user/user.css" />
<link type="text/css" rel="stylesheet" href="<?php echo FF_DOMAIN; ?>/upload/css/lib/tip-twitter.css" />
<!-- 用户中心-预约记录 -->
<div id="pg-user">
    <div class="g-in f-cb">
        <?php $this->renderPartial('user_menu'); ?>

        <!-- 预约记录 -->
        <div class="g-mn2 investment-records f-w769">
            <div class="ir-box">
                <div class="title f-bbdc">预约记录</div>
                <div class="content">
<!--                    <div class="screening f-cb">-->
<!--                        <span class="f-fl">按时间筛选：</span>-->
<!--                        <a href="--><?php //if(empty($tDate)){$tDate=0;} echo FF_DOMAIN.'/i/d0';?><!--"--><?php //if($tDate=='0'||empty($tDate)){echo 'class="active"';}?><!--所有</a>-->
<!--                        <a href="--><?php //echo FF_DOMAIN.'/i/d1';?><!--"--><?php //if($tDate=='1'){echo 'class="active"';}?><!--今天</a>-->
<!--                        <a href="--><?php //echo FF_DOMAIN.'/i/d2';?><!--"--><?php //if($tDate=='2'){echo 'class="active"';}?><!--最近一周</a>-->
<!--                        <a href="--><?php //echo FF_DOMAIN.'/i/d3';?><!--"--><?php //if($tDate=='3'){echo 'class="active"';}?><!--一个月</a>-->
<!--                        <a href="--><?php //echo FF_DOMAIN.'/i/d4';?><!--"--><?php //if($tDate=='4'){echo 'class="active"';}?><!--三个月</a>-->
<!--                        <a href="--><?php //echo FF_DOMAIN.'/i/d5';?><!--"--><?php //if($tDate=='5'){echo 'class="active"';}?><!--六个月</a>-->
<!--                    </div>-->
<!--                    <div class="status f-cb">-->
<!--                        <span class="f-fl">已购买：<em>--><?php //echo $count_start;?><!--</em>笔</span>-->
<!--                        <span class="f-fl">持有中：<em>--><?php //echo $count_ing;?><!--</em>笔</span>-->
<!--                        <span class="f-fl">已结束：<em>--><?php //echo $count_end;?><!--</em>笔</span>-->
<!--                    </div>-->

                    <div class="records-list">
                        <table class="f-w-auto">
                            <tr>
                                <th width="10%">预约编码</th>
                                <th width="10%">预约姓名</th>
                                <th>预约邮箱</th>
                                <th>预约电话</th>
                                <th>产品名称</th>
                                <th width="10%">产品类型</th>
                                <th width="10%">预约状态</th>
                                <th>预约时间</th>
                            </tr>
                            <?php if (empty($appointList) && count($appointList)<1) {
                                $appointList = array();
                            ?>
                                <tr><td colspan="8">没有你想找到的哟~</td> </tr>
                            <?php  } else { foreach ($appointList as $v) { ?>
                            <tr>
                                <td><?php echo $v['id'];?></td>
                                <td><?php echo $v['appoint_name'];?></td>
                                <td><?php echo $v['appoint_mail'];?></td>
                                <td><?php echo $v['appoint_phone'];?></td>
                                <td><?php
                                    if($v['product_type_val']==2){
                                        echo $xintuo[$v['product_id']]['xintuo_name'];
                                    }elseif($v['product_type_val']==3){
                                        echo $fund[$v['product_id']]['fund_name'];
                                    }
                                    ?></td>
                                <td><?php echo $proType[$v['product_type_val']]['type_name'];?></td>
                                <td><?php echo FConfig::item('config.appoint_status.'.$v['appoint_status']);?></td>
                                <td><?php echo date('Y-m-d',strtotime($v['create_time']));?></td>
                            </tr>
                            <?php }}?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- end预约记录 -->
    </div>
</div>
<!-- end 用户中心-预约记录 -->
<script>
    require([GLOBAL_CF.BASE_URL+'/app/user.js']);
</script>
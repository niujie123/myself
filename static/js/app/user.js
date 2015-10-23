/**
 * 用户中心
 * Created by Administrator on 15-4-22.
 */
define(['jquery','poshytip','validate','common','layer','tabso_yeso'], function ($,poshytip,validate,common,layer,tabso_yeso) {
    $(document).ready(function () {

        //邮箱认证提示
        $('#icon-email').poshytip({
            className: 'tip-twitter',
            showTimeout: 1,
            alignTo: 'target',
            alignX: 'center',
            offsetY: 5,
            allowTipHover: false,
            fade: false,
            slide: false
        });

        //身份证认证提示
        $('#icon-profile').poshytip({
            className: 'tip-twitter',
            showTimeout: 1,
            alignTo: 'target',
            alignX: 'center',
            offsetY: 5,
            allowTipHover: false,
            fade: false,
            slide: false
        });

        //手机号认证提示
        $('#icon-mobile').poshytip({
            className: 'tip-twitter',
            showTimeout: 1,
            alignTo: 'target',
            alignX: 'center',
            offsetY: 5,
            allowTipHover: false,
            fade: false,
            slide: false
        });

        //提现弹出框
        $("#withdrawals").click(function () {
            //获取显示器窗口的宽度与高度
            var _width = $(window).width();
            var _height = $(document).height();

            //弹出框据页面顶部与左边距离
            var _top = $(document).scrollTop()+($(window).height()-$("#withdrawals-layer").height())/2;
            var _left = (_width-$("#withdrawals-layer").width())/2

            $("#mask").css({
                width:_width,
                height:_height
            });

            $("#withdrawals-layer").css({
                top:_top,
                left:_left
            });

            $("#mask").show();
            $("#withdrawals-layer").show();
        })

        /* 提现弹出框关闭 */
        $("#withdrawals-layer .close").click(function () {
            $("#mask").hide();
            $("#withdrawals-layer").hide();
        })
        $(".select-banklist li").click(function () {
            $("#mask").hide();
            $("#withdrawals-layer").hide();
        })

        /* 充值详情tab方式切换 */
        $("#menu-tab").tabso({
            cntSelect:"#content-con",
            tabEvent:"click",
            tabStyle:"normal"
        });

        /* 银联支付选择 */
        $(".sel-redio").click(function () {
            var bool = $(this).find("input").prop("checked");

            //判断当前点击是否是选中状态
            if(!bool){
                $(this).parents(".choose-bank").find("input").prop("checked",false);
                $(this).parents(".choose-bank").find(".sel-redio").removeClass("checked");
                $(this).addClass("checked");
                $(this).find("input").prop("checked",true);
            }
        })

        /* 点击充值后 */
        $("#rechare-btn").click(function () {
            var html = $("#recharge-layer").html();
            layer.open({
                type: 1,
                shift:-1,
                title: "请您在新打开的页面上完成付款",
                area: ['470px', '260px'],
                move:false,
                content: html
            });
        })
        /* 点击立即预约后 */
        $("#order_rightnow").click(function () {
            var html = $("#rightnow-layer").html();
            layer.open({
                type: 1,
                shift:-1,
                title: "请您在新打开的页面上完成付款",
                area: ['470px', '260px'],
                move:false,
                content: html
            });
        })

        /* 身份证认证下一步 */
        $("#id-nextBtn").click(function () {
            if($("#withdrawals-form").valid()){
                var html = $("#id-layer").html();
                layer.open({
                    type: 1,
                    shift:-1,
                    title: "验证身份信息",
                    area: ['470px', '170px'],
                    move:false,
                    content: html
                });
            }
        })

        /* 修改密码表单验证 */
        var aa = $("#updatePwd-form").validate({
            rules: {
                old_pwd: {
                    required:true
                },
                new_pwd: {
                    required: true,
                    rangelength: [8, 40],
                    chrnum: true
                },
                confirm_pwd: {
                    required:true,
                    equalTo:"#new-pwd"
                },
                phone_code: {
                    required:true
                }
            },
            messages: {
                old_pwd: {
                    required:"请输入旧密码"
                },
                new_pwd: {
                    required: "请输入新密码",
                    rangelength: "请输入8个以上字符",
                    chrnum:"只能输入数字和字母"
                },
                confirm_pwd: {
                    required:"请输入确认密码",
                    equalTo:"两次密码输入不一致"
                },
                phone_code: {
                    required:"请输入手机验证码"
                }
            },
            errorElement:"div",
            errorPlacement: function(error, element){
                error.appendTo(element.parent().find(".vd-error"));
                element.parent().find(".vd-error").show();
            },
            success: function(element) {
                element.parent(".vd-error").addClass("vd-success");
            }
        });

        /* 邮箱验证表单 */
        var bb = $("#email-form").validate({
            rules: {
                email: {
                    required:true,
                    email:true
                }
            },
            messages: {
                email: {
                    required:"请输入电子邮箱",
                    email:"电子邮箱地址有误"
                }
            },
            errorElement:"div",
            errorPlacement: function(error, element){
                error.appendTo(element.parent().find(".vd-error"));
                element.parent().find(".vd-error").show();
            },
            success: function(element) {
                element.parent(".vd-error").addClass("vd-success");
            }
        });

        /* 提现实名认证 验证表单 */
        var cc = $("#withdrawals-form").validate({
            rules: {
                real_name: {
                    required:true
                },
                id_num: {
                    required:true,
                    isIdCardNo:true
                }
            },
            messages: {
                real_name: {
                    required:"真实姓名不能为空"
                },
                id_num: {
                    required:"身份证号码不能为空",
                    isIdCardNo:"身份证号输入有误"
                }
            },
            errorElement:"div",
            errorPlacement: function(error, element){
                error.appendTo(element.parent().find(".vd-error"));
                element.parent().find(".vd-error").show();
            },
            success: function(element) {
                element.parent(".vd-error").addClass("vd-success");
            }
        });
        /* 银行卡列表管理 选择银行 */
        $(function(){
            $(".select-banklist li").click(function(){
                var bank_ipt = $(this).children("input");
                $("#bank_code").val(bank_ipt.val());
                $("#icon_select_bank").attr("class",bank_ipt.prop("id")).show();
            }).eq(0).find("input").trigger("click");
        });
        /* 用户帮助 展开答案 */
        /*$(function(){
            $(".closebtn").click(function(){
                $("li").next(".openli").toggle();
                var classes =  $(".closebtn").attr("class");
                var toggleClass = '';
                if (classes == 'closebtn') {
                    toggleClass = 'openbtn';
                } else {
                    toggleClass =  'closebtn';
                }
                $(".closebtn").removeClass(classes).addClass(toggleClass);
            });
        });*/
        $(function(){
            $(".closebtn").click(function(){
                $(this).parent("li").next("li").toggle(200);
                $(this).toggleClass("closebtnbac02");
            });
        });
        /* 银行卡列表管理 验证表单 */
        var dd = $("#bank-form").validate({
            rules: {
                bankId: {
                    required:true,
                    creditcard:true
                },
                confimBank: {
                    required:true,
                    creditcard:true,
                    equalTo:"#bankId"
                }
            },
            messages: {
                bankId: {
                    required:"请输入银行卡号",
                    creditcard:"银行卡号格式错误"
                },
                confimBank: {
                    required:"请输入确认银行卡号",
                    creditcard:"确认银行卡号格式错误",
                    equalTo:"确认卡号输入错误"
                }
            },
            errorElement:"div",
            errorPlacement: function(error, element){
                error.appendTo(element.parent().find(".vd-error"));
                element.parent().find(".vd-error").show();
            },
            success: function(element) {
                element.parent(".vd-error").addClass("vd-success");
            }
        });
    })

})
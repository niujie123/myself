/**
 * 产品业务
 * Created by Administrator on 15-4-14.
 */
define(['jquery','flexslider','common','tabso_yeso','layer'], function ($,flexslider,common,tabso_yeso,layer) {
    $(document).ready(function () {

        //产品页面焦点图代码
        $('.flexslider').flexslider({
            slideshow: true,
            animationSpeed: 600,
            directionNav:false
        });

        //产品类型切换
        $(".product-type ul>li").click(function () {
            $(".product-type a").removeClass("current");
            $(this).find("a").addClass("current");
        });

        //产品详情页TAB切换
        $("#menu-tab").tabso({
            cntSelect:"#content-con",
            tabEvent:"click",
            tabStyle:"normal"
        });

        //立即购买提示框
        $("#im-buy").click(function () {
            var html = $("#money-dialog").html();
            layer.open({
                type: 1,
                shift:-1,
                title: "提示信息",
                area: ['470px', '205px'],
                move:false,
                content: html
            });
        })

        $("#order-right").click(function () {
            var html = $("#order-rightnow").html();
            layer.open({
                type: 1,
                shift:-1,
                title: "想了解该产品的详细信息或者预约产品，您可以",
                area: ['480px', '413px'],
                move:false,
                content: html
            });
        })

    })
})

/**
 * 首页业务逻辑代码
 * Created by Administrator on 15-4-2.
 */

define(['jquery','flexslider','common'], function ($,flexslider,common) {
    $(document).ready(function () {

        //首页焦点图代码
        $('.flexslider').flexslider({
            slideshow: true,
            animationSpeed: 600,
            directionNav:false
        });

        //设置首页注册与遮罩层left值
        $("#banner .mask").css("right",common.getWindowsHalfWidth(960) + "px");
        $("#banner .register").css("right",common.getWindowsHalfWidth(960) + "px");


    })
})
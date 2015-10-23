/**
 * Created by Administrator on 15-3-31.
 */

define(['jquery'], function ($) {
    return {
        method1: function() {
            console.log("生活总是美好的！");
        },

        //获得浏览器宽度减去实际宽度的一半值 应用在首页遮罩层部分
        getWindowsHalfWidth: function(w) {
            var w = w || 0;
            return (parseInt($(document).width()) - w) / 2;
        },


    };
});

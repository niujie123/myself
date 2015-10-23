/**
 * Created by zhangchao8189888 on 15-4-11.
 */

define(['jquery'], function ($) {
    return {
        chgUrl: function(url){
            var timestamp = (new Date()).valueOf();
            url = url.substring(0,17);
            if((url.indexOf("&")>=0)){
                url = url + "×tamp=" + timestamp;
            }else{
                url = url + "?timestamp=" + timestamp;
            }
            return url;
        },

        //应用在首页遮罩层部分
        changeImg: function(em){
        var imgSrc = $(em);
        var src = imgSrc.attr("src");
        imgSrc.attr("src",this.chgUrl(src));
    }

};
});
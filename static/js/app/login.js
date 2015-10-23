/**
 * 登录业务逻辑代码
 * Created by Administrator on 15-4-8.
 */

define(['jquery','common'], function ($,common) {
    $(document).ready(function () {
        //模拟checkbox选择框效果
        $(".sel-checkbox").click(function () {
            if($("#rememberme").prop("checked")){
                $("#rememberme").prop("checked",false);
                $(this).css("background-position","0 -284px");
            }else{
                $("#rememberme").prop("checked",true);
                $(this).css("background-position","0 -248px");
            }
        })

        //登录按Enter提交
        $(document).bind("keypress",function(event){
            if(event.keyCode == "13")
            {
                $("#login-form").submit();
            }
        });
    })
})
/**
 * 注册业务逻辑代码
 * Created by Administrator on 15-4-9.
 */

define(['jquery','validate','validate_method'], function ($,validate,validate_method) {
    $(document).ready(function () {
        //注册表单验证
        var aa = $("#register-form").validate({
            rules: {
                email: {
                    required:true,
                    email:true
                },
                phone: {
                    required:true,
                    mobile:true
                },
                code: {
                    required:true
                },
                phone_code: {
                    required:true
                },
                password: {
                    required: true,
                    rangelength: [8, 40],
                    chrnum: true
                }
            },
            messages: {
                email: {
                    required:"请输入电子邮箱",
                    email:"电子邮箱地址有误"
                },
                phone: {
                    required:"请输入手机号",
                    mobile:"手机号输入有误"
                },
                code: {
                    required:"请输入效验码"
                },
                phone_code: {
                    required:"请输入手机验证码"
                },
                password: {
                    required: "请输入密码",
                    rangelength: "请输入8个以上字符",
                    chrnum:"只能输入数字和字母"
                }
            },
            errorElement:"div",
            errorPlacement: function(error, element){
                error.appendTo(element.parent().find(".vd-error"));
                element.parent().find(".vd-error").show();
                console.log(element);
            },
            success: function(element) {
                element.parent(".vd-error").hide();
                element.remove();
            }
        });

        $(".sendbtn").click(function () {
            console.log(aa.element("#phone"));
        });

        var doc=document,
            inputs=doc.getElementsByTagName('input'),
            supportPlaceholder='placeholder'in doc.createElement('input'),

            placeholder=function(input){
                var text=input.getAttribute('placeholder'),
                    defaultValue=input.defaultValue;
                if(defaultValue==''){
                    input.value=text
                }
                input.onfocus=function(){
                    if(input.value===text)
                    {
                        this.value=''
                    }
                };
                input.onblur=function(){
                    if(input.value===''){
                        this.value=text
                    }
                }
            };

        if(!supportPlaceholder){
            for(var i=0,len=inputs.length;i<len;i++){
                var input=inputs[i],
                    text=input.getAttribute('placeholder');
                if(input.type==='text'&&text){
                    placeholder(input)
                }
            }
        }
    })
})
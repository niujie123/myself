// JavaScript Document

// 字母和数字的验证
jQuery.validator.addMethod("chrnum", function(value, element) {
    var chrnum = /^([a-zA-Z0-9]+)$/;
    return this.optional(element) || (chrnum.test(value));
}, "只能输入数字和字母(字符A-Z, a-z, 0-9)");

// 手机号码验证
jQuery.validator.addMethod("mobile", function(value, element) {
    var length = value.length;
    var mobile =  /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/
    return this.optional(element) || (length == 11 && mobile.test(value));
}, "手机号码格式错误");  

// 电话号码验证1
jQuery.validator.addMethod("teltest", function(value, element) {
	var zip = $('#telZipcode').val();
	if(/^\d{4,10}$/.test(value) && /^\d{3,4}$/.test(zip) || value=="" && zip==""){
        return true;
    }
    return false;
}, "请正确填写您的电话号码");

// 汉字  
 jQuery.validator.addMethod("chcharacter", function(value, element) {  
   var tel = /^[\u4e00-\u9fa5]+$/;  
   return this.optional(element) || (tel.test(value));  
 }, "请输入汉字"); 

 //QQ
jQuery.validator.addMethod("qq", function(value, element) {
    var tel = /^\d{4,20}$/;
    return this.optional(element) || (tel.test(value));
}, "qq号码格式错误");




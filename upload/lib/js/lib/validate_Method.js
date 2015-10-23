// JavaScript Document

// 字母和数字的验证

$.validator.addMethod('bankNum',function(value,element,params){
    var bank_num = value;
    var bank_id_validate = /^\d{19}$/g;
    if(!bank_id_validate.test(bank_num)){
        return false;
    }
    return true;
},'银行卡格式不对');



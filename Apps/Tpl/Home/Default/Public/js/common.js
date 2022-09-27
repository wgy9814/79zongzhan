/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// by HHK 2016-03-25
$(function(){
    // 阻止电话和qq被百度抓取
    var telphone = "400-6387-883";
    var domTelphoneID = ".website_telphone";
    $(domTelphoneID).html("");
    $(domTelphoneID).html(telphone);
    
    // 阻止所有qq被百度抓取
    var QQ = "2885063857";
    var domQQID = ".website_QQ";
    $(domQQID).html("");
    $(domQQID).html(QQ);
    $("#onlinec").validate({
        rules: {
            // zhiye: {
            //     required : true,
            // },
            telephone: {
                required : true,
                mobile:true
            },
            // username: {
            //     required : true,
            // },
            // email : {
            //     required : true,
            //     email    : true,
            // },
            content: {
                required : true,
            },

        },
        messages: {
            // zhiye: {
            //     required : '请输入职业',
            // },
            telephone: {
                required : '请输入正确的手机号',
                mobile : '请输入正确的手机号',
            },
            // username: {
            //     required : '请输入姓名',
            // },
            // email : {
            //     required : '请输入正确的邮箱地址',
            //     email    : '请输入正确的邮箱地址',
            // },
            content: {
                required : '请输入留言',
            },

        }
    });
})
$('#jg_form .duanx').click(function(){
    var m=$(this).parents('form').find('input[name=telephone]').val();
    var verify=$(this).parents('form').find('input[name=verify]').val();
    var formhash=$(this).parents('form').find('input[name=formhash]').val();
    var form_submit=$(this).parents('form').find('input[name=form_submit]').val();

    if(m==''){
        alert('请输入您的手机号码');
        return false;
    }
    if(!checkPhone(m)){
        return false;
    }
    if(!checkVerify(verify)){
        return false;
    }

    countdown(this,'#jg_form');
    $.ajax({
        type:"post",
        url:"/User/Post/send_SMS",
        dataType:"json",
        data:{
            'mobile':m,
            'ajax':1,
            'site':5,
            'verify':verify,
            'formhash':formhash,
            'form_submit':form_submit,
        },
        error:function(msg){
            alert('发送失败！请重新发送')
        },
        success:function(msg){
            if(msg.data == 1){
                alert('发送成功！请注意查收')
            }else{
                alert('发送失败！请重新发送')
            }
        }
    });

})
$('#onlinec .duanx').click(function(){
    var m=$(this).parents('form').find('input[name=telephone]').val();
    var verify=$(this).parents('form').find('input[name=verify]').val();
    var formhash=$(this).parents('form').find('input[name=formhash]').val();
    var form_submit=$(this).parents('form').find('input[name=form_submit]').val();
    if(m==''){
        alert('请输入您的手机号码');
        return false;
    }
    if(!checkPhone(m)){
        return false;
    }
    if(!checkVerify(verify)){
        return false;
    }

    countdown(this,'#onlinec');
    $.ajax({
        type:"post",
        url:"/User/Post/send_SMS",
        dataType:"json",
        data:{
            'mobile':m,
            'ajax':1,
            'site':6,
            'verify':verify,
            'formhash':formhash,
            'form_submit':form_submit,
        },
        error:function(msg){
            alert('发送失败！请重新发送')
        },
        success:function(msg){
            if(msg.data == 1){
                alert('发送成功！请注意查收')
            }else{
                alert(msg.info)
            }
        }
    });

})
function countdown(e,dom) {
    // console.log(e)
    // console.log(dom)
    var b=60;
    $(e).hide(0);
    $(e).next().show(0);
    $(dom+' .dengd').html('60 秒重新发送');


    a=setInterval(function(){
        b-=1;
        // console.log(b)
        if(b<0){
            b=0;
            clearInterval(a);
            $(dom+' .dengd').hide(0);
            $(dom+' .duanx').show(0);
            $(dom+' .duanx').html('重新发送');
        }
        $(dom+' .dengd').html(''+b+' 秒重新发送');

    },1000)
}
function checkPhone(mobile){
    if(!(/^1(3|4|5|6|7|8|9)\d{9}$/.test(mobile))){
        alert("手机号码有误，请重填");
        return false;
    }
    return true;
}
function checkVerify(verify){
    var res = false
    if(verify==''){
        alert('请输入图形验证码');
        return false;
    }
    $.ajax({
        type:"post",
        async:false,
        url:"/Home/Ajax/cord",
        dataType:"json",
        data:{'verifyCode':verify},
        success:function(msg){
            if(msg==0){
                res =  true;
            }else{
                alert('图形验证码错误')
                res = false
            }
        }
    });
    return res;

}

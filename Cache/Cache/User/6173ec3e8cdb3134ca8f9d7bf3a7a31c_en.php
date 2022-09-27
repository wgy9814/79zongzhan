<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head lang="en"><meta name="description" content=""><meta name="keywords" content=""><meta charset="utf-8"><meta name="renderer" content="webkit"><!--360 极速模式--><link rel="shortcut icon" href="/Apps/Tpl/Home/Default/Public/images/favicon.ico" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><title>用户登录-79招生网</title><link href="../Public/css/common_header_footer.css" rel="stylesheet" type="text/css" /><link href="../Public/css/common_base.css" rel="stylesheet" type="text/css" /><link href="../Public/css/member.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="/Apps/Tpl/Home/Default/Public/js/jquery.min.js"></script></head><body><div class="header"><!--logo搜索--><div class="top_nav"><div class="w1200 auto clearfix"><div class="top_logo"><a class="l" href="/"><img src="<?php echo ($logo); ?>" /></a><div class="top_qie">
					用户登录
				</div></div><!--top--><div class="head_r fr"><a href="/">分站首页</a><a href="/User/Login">登录</a><a href="/User/Register/">注册</a></div></div></div><!--logo搜索end--><div class="clear"></div><!--导航--></div><!--导航end--><script type="text/javascript">
var APP	 =	 '__APP__';
var ROOT =	 '__ROOT__';
var PUBLIC = '__PUBLIC__';
</script><div id="member"><div class="main" id="denglu"><div class="denglu_con ovef"><div id="change"><div id="change_d1" class="on">账号密码登录</div><div id="change_d2">短信快捷登录</div></div><div class="qie_con"><form method="post" onsubmit="return formSub()" action="<?php echo URL('User-Login/dologin');?>" id="login" ><ul><li class="clearfix li1"><input placeholder="用户名 / 电子邮箱" type="text" id="username" name="username" class="input-text"/></li><li class="clear"><li class="clearfix li2"><input laceholder="请输入密码" type="password" id="password" name="password" class="input-text"/></li></li><li class="clearfix li4"><input type="submit" class="button" value="立即登录" /><a href="/User/Register/" class="re" style="color: #00b083;">快速注册</a> | <a class="re2" href="/User/Login/getpass" style="color: #0000ee;">找回密码</a></li></ul></form><form method="post" action="<?php echo URL('User-Login/dologin2');?>" id="login2" style="display: none;"><ul><li class="clearfix li1"><input placeholder="请输入您的手机号" type="text" id="phone" name="phone" class="input-text"/></li><div class="clear ovef"><li class=" li2"><input placeholder="请输入验证码" type="text" id="verifyCode" name="verifyCode" class="input-text" maxlength="4"/></li><li class=" li3 clearfix"><img SRC="<?php echo U('Home/Index/verify');?>" BORDER="0" ALT="<?php echo L('reverify');?>" id="verifyImage" onClick="resetVerifyCode()" style="cursor:pointer" align="absmiddle"><span class="" onClick="resetVerifyCode()">换一张</span></li></div><li class="li6 clearfix"><div><input placeholder="请输入确认码" type="text" id="verify" name="verify" class="input-text" maxlength="6"/></div><button type="button">获取手机确认码</button><a href="javascript:;">60秒重新获取</a></li><li class="li5 clearfix">
							验证即登录，未注册将自动创建列表网账号
						</li><li class="clearfix li4"><input type='hidden' name='formhash' value='<?php echo ($formhash); ?>' /><input type="hidden" name="form_submit" value="ok" /><input type="submit" class="button" value="立即登录" /></li></ul></form></div><div class="third ovef"><span class="c3">使用合作网站账号登录：</span><a href="/"><img src="../Public/images/d_weibo.jpg"/></a><a href="/"><img src="../Public/images/d_qq.jpg"/></a></div></div></div><script type="text/javascript" src="../Public/js/jquery.validate.min.js"></script><script type="text/javascript" src="../Public/js/messages_zh.js"></script><script type="text/javascript">
if(getCookieValue("username")){
	$("#username").val(getCookieValue("username"));
	$("#possword").val(getCookieValue("possword"));
}
function formSub(){
	if($('#check_box').attr('checked')){
		var username = $("#username").val();
		var possword = $("#possword").val();
		setCookie("username",username);
		setCookie("possword",possword);
		return true;
	}else{
		deleteCookie("username");
		deleteCookie("possword");
		return ture
	}
	return false;
}

function deleteCookie(name,path){
  var name = escape(name);
  var expires = new Date(0);
   path = path == "" ? "" : ";path=" + path;
   document.cookie = name + "="+ ";expires=" + expires.toUTCString() + path;
}

function setCookie(name,value,hours,path){
  var name = escape(name);
  var value = escape(value);
  var expires = new Date();
   expires.setTime(expires.getTime() + hours*3600000);
   path = path == "" ? "" : ";path=" + path;
   _expires = (typeof hours) == "string" ? "" : ";expires=" + expires.toUTCString();
   document.cookie = name + "=" + value + _expires + path;
}
//获取cookie值
function getCookieValue(name){
  var name = escape(name);
  //读cookie属性，这将返回文档的所有cookie
  var allcookies = document.cookie;    
  //查找名为name的cookie的开始位置
   name += "=";
  var pos = allcookies.indexOf(name);  
  //如果找到了具有该名字的cookie，那么提取并使用它的值
  if (pos != -1){                       //如果pos值为-1则说明搜索"version="失败
    var start = pos + name.length;         //cookie值开始的位置
    var end = allcookies.indexOf(";",start);    //从cookie值开始的位置起搜索第一个";"的位置,即cookie值结尾的位置
    if (end == -1) end = allcookies.length;    //如果end值为-1说明cookie列表里只有一个cookie
    var value = allcookies.substring(start,end); //提取cookie的值
    return (value);              //对它解码   
     }  
  else return "";                //搜索失败，返回空字符串
}

//切换表单
$('#change div').click(function(){
	var index=$(this).index();
	$(this).addClass('on').siblings().removeClass('on')
	$('.qie_con form').eq(index).show(0).siblings().hide(0);
})

	//更换验证码
function resetVerifyCode(){
	var timenow = new Date().getTime();
	var src = './index.php?g=Home&m=Index&a=verify#'+timenow;
	$('#verifyImage').attr('src',src);
}
//表单认证
$("#login").validate({
	    rules: {
	      	username:'required',
	       	password: {
				required: true,
			    minlength: 5,
			    maxlength: 16,
			},
	    },
	    messages: {
	      	username:"用户名错误",
			password: {
				required: '请输入密码',
			    minlength:'密码错误',
			    maxlength:'密码错误',
			},
	    }
	});	
	$('#login2 li.li6 button').click(function(){
		var a,b;
		b=60;
		var tel = $('#login2 #phone').val();
		if(tel==''){
			alert('请输入您的手机号码')
			return false;
		}
		$(this).hide(0);
		$(this).next().css('display','inline-block');
		a=setInterval(function(){
			b--;
			$('#login2 li.li6 a').html(b+'秒重新获取');
			if(b==0){
				$('#login2 li.li6 button').show(0);
				$('#login2 li.li6 a').hide(0);
				$('#login2 li.li6 button').html('重新发送');
				clearInterval(a);
			}
		},1000)
        var formhash=$(this).parents('form').find('input[name=formhash]').val();
        var form_submit=$(this).parents('form').find('input[name=form_submit]').val();
		$.ajax({
            type:"post",
            url:"/User/Login/login_SMS",
            async:true,
            data:{
                'phone':tel,
                'formhash':formhash,
                'form_submit':form_submit,
			},
            dataType:'json',
            success:function(msg){
            	
            	if(msg=='ok'){
            		alert('发送成功，请注意查收！')
            	}else{
            		alert('网络错误...')
            	}
            }
         })       
	})

</script></div><!--底部--><div class="footer mt20 clear"><div class="site_map"><div class="site_map_con site_map_con w1100 auto"><ul class="inline_box"><li class="inline_any" style="background:#fff;padding:8px;width: 112px;text-align: center;margin-right: 111px;"><?php $r = M('Block')->where(" 1  and lang=2 and pos='weima' ")->find(); if ($r):?><p><img src="<?php echo ($r["image1"]); ?>" /></p><?php endif;?><p class="" style="color:#666;">让学习变得更容易</p></li><?php $k=0;foreach($Categorys as $key=>$r):if(1=="" && $r['isfootermenu']==0){ continue; }if( $r['ismenu']==1 && intval(39)==$r["parentid"] ) :++$k;?><li class="inline_any"><h3 class="site_map_title"><?php echo ($r["catname"]); ?></h3><?php if($r[child]) : $kd=0;foreach($Categorys as $key=>$rd):if(1=="" && $rd['isfootermenu']==0){ continue; }if( $rd['ismenu']==1 && intval($r[id])==$rd["parentid"] ) :++$kd;?><p><a rel="nofollow" target="_bank" href="<?php echo ($rd["url"]); ?>"><?php echo ($rd["catname"]); ?></a></p><?php endif; endforeach; endif;?></li><?php endif; endforeach;?></ul></div></div><div class=" clear"></div><div class="lxwm tc mt10 w1100 auto"><ul><li style="font-size:14px;"><p><span style="color:#FFFFFF;font-size:14px;text-align:center;white-space:normal;background-color:#40B477;font-family:微软雅黑;">79招生网 版权所有 </span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">备案/许可证编号为：<a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank">粤ICP备</a></span><a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank"><span t="7" data="17158495" white-space:normal;background-color:#ffffff;border-bottom:1px="" dashed="" #cccccc;z-index:1;position:static;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">17158495</span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">号</span></a></p><p>	Copyright &copy; 2017 All rights reserved by 79招生网
</p> | Designed bymqu.cn</li></ul></div></div><!--底部 end--></body></html>
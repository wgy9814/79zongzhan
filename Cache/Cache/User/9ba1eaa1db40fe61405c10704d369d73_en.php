<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head lang="en"><meta name="description" content=" "><meta name="keywords" content=" "><meta charset="utf-8"><meta name="renderer" content="webkit"><!--360 极速模式--><link rel="shortcut icon" href="/Apps/Tpl/Home/Default/Public/images/favicon.ico" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><title>找回密码</title><link href="../Public/css/common_header_footer.css" rel="stylesheet" type="text/css" /><link href="../Public/css/common_base.css" rel="stylesheet" type="text/css" /><link href="../Public/css/member.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="/Apps/Tpl/Home/Default/Public/js/jquery.min.js"></script></head><body><div class="header" style="height: 100px;"><!--logo搜索--><div class="top_nav"><div class="w1200 auto clearfix"><div class="top_logo"><a class="l" href="/"><img src="<?php echo ($logo); ?>" /></a><div class="top_qie">
					找回密码
				</div></div><!--top--><div class="head_r fr"><a href="/">分站首页</a><a href="/User/Login">登录</a><a href="/User/Register/">注册</a></div></div></div><!--logo搜索end--><div class="clear"></div><!--导航--></div><!--导航end--><div class="getpass_top"><div class="w1200 auto clearfix f24 c3">
		找回密码
	</div></div><div id="getpass"><div class="w1200 auto clearfix"><form class="" id="getpass_form1" style="display: none;" method="post" action="" onsubmit="return getpassone();"><div class="top"></div><ul><li><input class="f_input" id="yanzheng" type="text" name="user" placeholder="请输入邮箱/手机"/></li><li class="li2"><input placeholder="请输入验证码" type="text" id="verify1" name="verify1" class="cord f_input" maxlength="4" required=""/><img SRC="<?php echo U('Home/Index/verify');?>" BORDER="0" ALT="<?php echo L('reverify');?>" id="verifyImage1" onClick="resetVerifyCode()" style="cursor:pointer" align="absmiddle"><span class="" onClick="resetVerifyCode()">换一张</span></li><li><button type="submit" class="btm f16">下一步</button></li></ul></form><form class="" id="getpass_form2" style="display: none;" method="post" action=""><div class="top" style="background-position-y:-34px;"></div><ul><li><p class="f12">为了你的账号安全，请完成身份验证</p></li><li class="li3"><h3 class="f14">手机验证</h3><p class="mobie">手机号：   156000000000</p></li><li class="li2"><h3>确认码：</h3><div class="ovef"><input placeholder="请输入验证码" type="text" name="cord" class="cord f_input"  required="" style="width: 228px;"/><a class="Sent" href="javascript:;">已发送 ( 60 ) </a><a class="resend" href="javascript:;" style="display: none;">重新发送</a></div></li><li class="li4"><button type="submit" class="btm f16">下一步</button></li><li class="li5"><p>如果无法通过验证，请联系79招生网客服电话：<span class="fw red">400-678-6632</span>(请于工作日的9:00-18:00进申诉)。</p></li></ul></form><form action="" id="getpass_form3" method="post" style="display: none;" ><div class="top" style="background-position-y:-68px;"></div><ul><li class="li1"><p class="" style="color: #999999;">您正在找回的账号是：<span>abcd123456</span></p></li><li class="li1"><p class="" style="color: #999999;">您的新密码已通过短信发到您的手机，请注意查收并及时登录系统修改密码</p></li><li class="li2"><div class="ovef"><span class="c3">新密码</span><input placeholder="输入新的密码" type="text" id="password" name="password" class="cord f_input"  required="" style="width: 228px;"/></div></li><li class="li2"><div class="ovef"><span class="c3">确认新密码</span><input placeholder="请再次确认密码" type="text" name="repassword" class="cord f_input"  required="" style="width: 228px;"/></div></li><li class="li4"><button type="submit" class="btm f16">确定</button></li></ul></form><form action="" id="getpass_form" method="post" style="" onsubmit="return false;"><ul><li><div id="err" style="color: red;width: 350px; text-align: center; display: none;"></div></li><li><input class="f_input" type="text" id="username" name="username" placeholder="请输入用户名" required="required" /></li><li><input class="f_input" type="text" id="mobile" name="mobile" placeholder="请输入帐号绑定的手机号码" required="required" /></li><li class="li2"><input type="text" id="verify" name="verify" class="cord f_input" maxlength="4" required="required" /><img src="<?php echo U('Home/Index/verify');?>" border="0" alt="<?php echo L('验证码');?>" id="verifyImage" onClick="this.src='/index.php?g=Home&m=Index&a=verify#'+new Date().getTime()" style="cursor: pointer;" align="absmiddle"><span onClick="resetVerifyCode();">换一张</span></li><li><input type='hidden' name='formhash' value='<?php echo ($formhash); ?>' /><input type="hidden" name="form_submit" value="ok" /><button type="submit" class="btm f16" id="getpass_btn">提交</button></li></ul></form><form id="result_form" onsubmit="return false;" style="display: none;"><ul><li class="li1"><p class="" style="color: #999999;">您正在找回的账号是：<span id="s_username">abcd123456</span></p></li><li class="li1"><p class="" style="color: #999999;">您的新密码已通过短信发到您的手机，请注意查收并及时登录系统修改密码</p></li></ul></form></div></div><!--底部--><div class="footer mt20 clear"><div class="site_map"><div class="site_map_con site_map_con w1100 auto"><ul class="inline_box"><li class="inline_any" style="background:#fff;padding:8px;width: 112px;text-align: center;margin-right: 111px;"><?php $r = M('Block')->where(" 1  and lang=2 and pos='weima' ")->find(); if ($r):?><p><img src="<?php echo ($r["image1"]); ?>" /></p><?php endif;?><p class="" style="color:#666;">让学习变得更容易</p></li><?php $k=0;foreach($Categorys as $key=>$r):if(1=="" && $r['isfootermenu']==0){ continue; }if( $r['ismenu']==1 && intval(39)==$r["parentid"] ) :++$k;?><li class="inline_any"><h3 class="site_map_title"><?php echo ($r["catname"]); ?></h3><?php if($r[child]) : $kd=0;foreach($Categorys as $key=>$rd):if(1=="" && $rd['isfootermenu']==0){ continue; }if( $rd['ismenu']==1 && intval($r[id])==$rd["parentid"] ) :++$kd;?><p><a rel="nofollow" target="_bank" href="<?php echo ($rd["url"]); ?>"><?php echo ($rd["catname"]); ?></a></p><?php endif; endforeach; endif;?></li><?php endif; endforeach;?></ul></div></div><div class=" clear"></div><div class="lxwm tc mt10 w1100 auto"><ul><li style="font-size:14px;"><p><span style="color:#FFFFFF;font-size:14px;text-align:center;white-space:normal;background-color:#40B477;font-family:微软雅黑;">79招生网 版权所有 </span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">备案/许可证编号为：<a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank">粤ICP备</a></span><a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank"><span t="7" data="17158495" white-space:normal;background-color:#ffffff;border-bottom:1px="" dashed="" #cccccc;z-index:1;position:static;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">17158495</span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">号</span></a></p><p>	Copyright &copy; 2017 All rights reserved by 79招生网
</p> | Designed bymqu.cn</li></ul></div></div><script type="text/javascript" src="../Public/js/jquery.validate.min.js"></script><script type="text/javascript" src="../Public/js/messages_zh.js"></script><script>
(function(){
	$('#getpass_btn').click(function(){
		if(check())
		{
			var username = $('#username').val();
			var mobile = $('#mobile').val();
			var verifyCode = $('#verify').val();
            var formhash=$(this).parents('form').find('input[name=formhash]').val();
            var form_submit=$(this).parents('form').find('input[name=form_submit]').val();
			$.ajax({
				type : 'POST',
				url  : '/User/Post/getPass',
				data : {
				    username,
					mobile,
					verifyCode,
                    formhash,
                    form_submit,
				},
				dataType : 'json',
				success  : function(data) {
					if(data.errno == 0)
					{
						$('#getpass_form').hide(0);
						$('#result_form').show(0);
						$('#err').hide(0);
					}else if(data.errno == 1) {
						$('#err').text('系统繁忙，请稍后再操作！');
						$('#err').show(0);
					}else if(data.errno == 2) {
						$('#err').text('短信发送失败，请联系系统管理员');
						$('#err').show(0);
					}else if(data.errno == 3) {
						$('#err').text('用户名或手机号码错误');
						$('#err').show(0);
					}else if(data.errno == 4) {
						$('#err').text('验证码不正确');
						$('#err').show(0);
                    }else if(data.errno == 5) {
                        $('#err').text('今天你已经获取多次验证码，发送失败');
                        $('#err').show(0);
                    }
				}
			});
		}
	});
	
	function check() {
		var username = $('#username').val();
		var mobile = $('#mobile').val();
		var verifyCode = $('#verify').val();
		if('' == username)
		{
			$('#err').text('用户名不能为空!');
			$('#err').show(0);
			return false;
		}else {
			$('#s_username').text(username);
			$('#err').show(0);
		}
		if('' == mobile)
		{
			$('#err').text('手机号码不能为空！');
			$('#err').show(0);
			return false;
		}
		if(!/^(1)[0-9]{10}$/.test(mobile))
		{
			$('#err').text('请输入正确的手机号码！');
			$('#err').show(0);
			return false;
		}
		if(4 != verifyCode.length)
		{
			$('#err').text('请输入正确的验证码！');
			$('#err').show(0);
			return false;
		}

		$('#err').hide(0);
		return true;
	}
})();
//更换验证码
function resetVerifyCode(){
	var timenow = new Date().getTime();console.log('serser');
	var src = '/index.php?g=Home&m=Index&a=verify#'+timenow;
	$('#verifyImage').attr('src',src);
}

	var state=0;
	var html = '';
	var a,b,c,InputValue
	function getpassone(){
		//电话验证
		InputValue=$('#yanzheng').val();
		var verify=$('#verify').val();
		
		//state=1是手机号，2是邮箱
		if (!(/^0?(13|14|15|18)[0-9]{9}$/.test(InputValue))) {
			if(!(/^w[-w.+]*@([A-Za-z0-9][-A-Za-z0-9]+.)+[A-Za-z]{2,14}$/.test(InputValue))){
				alert('请输入正确的手机号码或邮箱');
			}else{
				state=2;
			}
		}else{
			state=1;
		}
		$.ajax({
		 	type:"post",
		 	url:"<?php echo URL('Home-Ajax/cord');?>",
		 	dataType:"json",
		 	data:{'verifyCode':verify},
		 	success:function(msg){
		 		if(msg==0){
		 			show();
		 		}else{
		 			alert('验证码错误')
		 		}
		 	}
		});

		return false
	}
	function show(){
		//电话验证
		$('#getpass_form1').hide(0);
		$('#getpass_form2').show(0);
		if(state==1){
			html='<h3>手机验证</h3><p class="mobie">手机号：   '+InputValue+'</p>'
		}else{
			html='<h3>邮箱验证</h3><p class="mobie">邮箱：   '+InputValue+'</p>'
		}
		$('#getpass_form2 .li3').html(html);
		b=60;
		a=setInterval(function(){
			b--;
			
			if(b==0){
				clearInterval(a);
				$('.Sent').hide(0);
				$('.resend').show();
			}
			$('.Sent').html('已发送 ( '+b+' ) ');
			
		},1000)
		
	}
	$("#getpass_form3").validate({
	    rules: {
	       	password: {
				required: true,
			    minlength: 5,
			    maxlength: 16,
			},
			repassword: {
				required: true,
			    equalTo: "#password"
			},
	    },
	    messages: {
			password: {
				required: '请输入密码',
			    minlength:'密码不能少于5位',
			    maxlength:'密码不能大于16位',
			},
			repassword: {
				required: '请再次输入密码',
				equalTo: "两次密码不一致"
			},
	    }
	});
</script><!--底部 end--></body></html>
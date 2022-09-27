<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head><meta charset="<?php echo C('DEFAULT_CHARSET');?>" /><title>英虎企业建站系统</title><link rel="stylesheet" type="text/css" href="./Public/Css/login_yh.css" /><meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" /><title><?php echo L('system_name');?></title><script src="./Public/Js/jquery.min.js" type="text/javascript" charset="utf-8"></script><script src="./Public/Js/jquery.validate.js" type="text/javascript" charset="utf-8"></script><script src="./Public/Js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script><script src="./Public/Js/jquery.form.js" type="text/javascript" charset="utf-8"></script><script src="./Public/Js/my.js" type="text/javascript" charset="utf-8"></script></head><body onLoad="reload()" id="loginbg"><div class="wrapper"><div class="yh-login-wrap"><div class="login-header"><img class="logo" src="./Public/Images/admin_logo.png" /><span class="right">
						网站后台管理系统
					</span></div><form class="form-horizontal" role="form" method='post' name="login" id="form1" action="<?php echo U('Login/doLogin');?>"><div class="form-group"><div class="col-sm-12"><div class="input-box"><span class="pic"><img src="./Public/Images/username.png"/></span><input type="text" id="username" name="username" placeholder="请输入用户名登录" /></div></div></div><div class="form-group"><div class="col-sm-12"><div class="input-box"><span class="pic"><img src="./Public/Images/password.png"/></span><input type="password" name="password" placeholder="请输入登录密码" /></div></div></div><?php if($admin_verify) : ?><div class="form-group"><div class="col-sm-12"><div class="input-box" style="width: 60%;"><span class="pic"><img src="./Public/Images/number.png"/></span><input type="text" maxlength="4" name="verifyCode" class="input-text" class="inputbox" id="verifyCode" placeholder="请输入验证码" /></div><div class="verification-code"><img id="verifyImage" class="checkcode" style="height: 100%; width: 100%;" src="<?php echo U('Home/Index/verify');?>" onclick="javascript:resetVerifyCode();" class="checkcode" title="<?php echo L('resetVerifyCode');?>" /></div></div><div class="col-sm-12"><a href="javascript:resetVerifyCode();" class="help-inline">看不清？换一张</a></div></div><?php endif;?><div class="form-group"><div class="col-sm-12"><div class="checkbox"><label for="remember"><span class="fx"><span></span></span>
									记住用户名
							</label><input type="checkbox" name="" id="remember" value="" /></div></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-10"><input type="hidden" name="ajax" value="1"><span class="msg"><span id="result" class="result none"></span></span><button type="submit" class="button btn btn-default">登&nbsp;录</button></div></div></form></div><div class="login-copyright"><p>Copyright © <span class="year"></span> All rights reserved by 79招生网 | Designed bymqu.cn</p></div></div><script type="text/javascript">
     copyright=new Date();//取得当前的日期
    update=copyright.getFullYear();//取得当前的年份
    $(".year").html(update);//设置年份
        jQuery(document).ready(function($) {
            $('#form1').ajaxForm({
                beforeSend: function() {
                    $('#result').html('<img src="./Public/Images/msg_loading.gif">').show();;
                },
                success: complete, // post-submit callback
                dataType: 'json'
            });

            if ($.cookie('remembername')) {
                $('#username').val($.cookie('remembername'));
                $("#remember").attr('checked', 'checked');
            }

            if ($("#remember").is(':checked')) {
                $('.fx').addClass('remember');
            }
            $('.form-group .checkbox label').click(function() {
                if ($("#remember").is(':checked')) {
                    $('.fx').removeClass('remember');
                    setRememberMe();
                } else {
                    $('.fx').addClass('remember');
                }
            });
        });

        function complete(data) {
            if (data.status == 1) {
                $('#result').html(data.info).show();
                setRememberMe(true);
                //art.dialog.tips('<?php echo L("logined_ok");?>',2);
                setTimeout(function() {
                    window.location.href = '<?php echo U("Index/index");?>';
                }, 1000);
            } else {
			resetVerifyCode();
                $('#result').html(data.info).show();
            }
        }

        function reload() {
            document.login.username.focus();
            if (self != top) {
                window.top.location.href = '<?php echo U("Login/index");?>';
            }
            resetVerifyCode();
        }

        function setRememberMe(isRem) {
            if (isRem) {
                $.cookie('rememberme', 1, {
                    expires: 3600 * 24 * 30
                });
                $.cookie('remembername', $.trim($('#username').val()), {
                    expires: 3600 * 24 * 30
                });
            } else {
                $.cookie('rememberme', null, {
                    expires: 0
                });
                $.cookie('remembername', null, {
                    expires: 0
                });
            }
        }
    </script></body></html>
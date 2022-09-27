var a,b,c;
	$('#tab1 .duanx').click(function(){
		var m=$(this).parents('form').find('input[name=mobile]').val();
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
        var that = this
        $.ajax({
            type:"post",
            url:"/User/Register/registered_SMS",
            dataType:"json",
            data:{
            	'mobile':m,
				'verify':verify,
                'formhash':formhash,
                'form_submit':form_submit,
			},
            error:function(msg){
                alert('发送失败！请重新发送')
            },
            success:function(msg){
                if(msg.data == 1){
                    countdown(that,'#tab1');
                    alert('发送成功！请注意查收')
                }else{
                    alert(msg.info)
                }
            }
        });

	})
	$('#tab2 .duanx').click(function(){
		var m=$(this).parents('form').find('input[name=mobile]').val();
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
        var that = this
        $.ajax({
            type:"post",
            url:"/User/Register/registered_SMS",
            dataType:"json",
            data:{
                'mobile':m,
                'verify':verify,
                'formhash':formhash,
                'form_submit':form_submit,
            },
            error:function(msg){
                alert('发送失败！请重新发送')
            },
            success:function(msg){
                if(msg.data == 1){
                    countdown(that,'#tab2');
                    alert('发送成功！请注意查收')
                }else{
                    alert(msg.info)
                }
            }
        });
	})
	// $('.duanx').click(function(){
	// 	var m=$(this).parents('form').find('input[name=mobile]').val();
	// 	$.ajax({
	// 		type:"post",
	// 	 	url:"/User/Register/registered_SMS",
	// 	 	dataType:"json",
	// 	 	data:{'mobile':m},
	// 	 	error:function(msg){
	// 	 		alert('发送失败！请重新发送')
	// 	 	},
	// 	 	success:function(msg){
	// 	 		alert('发送成功！请注意查收')
	// 	 	}
	// 	});
	// })
	function resetVerifyCode() {
		var timenow = new Date().getTime();
		document.getElementById('verifyImage').src = './index.php?g=Home&m=Index&a=verify#' + timenow;
	}
	function resetVerifyCode2() {
		var timenow = new Date().getTime();
		document.getElementById('verifyImage2').src = './index.php?g=Home&m=Index&a=verify#' + timenow;
	}
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
	// 验证用户名是否存在问题
	// $('input[name=username]').blur(function(){
	// 	console.log($(this).val());
	// 	$.ajax({
	// 		type:"get",
	// 		url:"/User/Register/checkusername",
	// 		dataType:"json",
	// 		data:{'username':$(this).val()},
	// 		success:function(msg){
	// 			console.log(msg);
	// 			var tabIndex = 1;
	// 			console.log($('#user').val());
	// 			if($('#user').val() == '0'){
	// 				tabIndex = 2;
	// 			}
	// 			if(msg == false){
	// 				$("#tab"+tabIndex+ ' button[type=submit]').attr('disabled','disabled');
    //
    //
	// 				if($("#tab"+tabIndex+ ' #username-error').length <= 0){
	// 					$("#tab"+tabIndex+ ' input[name=username]').parent().append('<label id="username-error" class="error" for="username">用户名已被注册</label>');
	// 				}else{
	// 					$("#tab"+tabIndex+ ' #username-error').show();
	// 					$("#tab"+tabIndex+ ' #username-error').html('用户名已被注册');
	// 				}
	// 			}else{
	// 				$("#tab"+tabIndex+ ' #username-error').hide();
	// 				$("#tab"+tabIndex+ ' button[type=submit]').attr('disabled',false);
	// 			}
	// 		}
	// 	});
	// });
		


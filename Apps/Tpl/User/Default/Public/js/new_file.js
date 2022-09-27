//注册页切换
	$('#myTab>li').click(function(){
		var index = $(this).index()
		$(this).addClass('active').siblings().removeClass('active');
		$('.tab-content form').eq(index).show(0).siblings().hide(0);
		if (0 == index)
		{
			$('#user').val(1);
		}else {
			$('#user').val(0);
		}
	});
	$.validator.addMethod("isMobile", function(value, element) {
		var length = value.length;
		var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
		return this.optional(element) || (length == 11 && mobile.test(value));
	}, "请输入正确的手机号码");
	//注册页认证
	$("#tab1").validate({
	    rules: {
            username:{
                required : true,
                remote:{
                    url : "/User/Register/checkusername",
                    type: 'get',
                    data:{
                        username : function(){
                            return $('#username').val();
                        }
                    }
                }
            },
            mobile:{
                required : true,
                isMobile:true,
                remote:{
                    url : "/User/Register/check_mobile_only",
                    type: 'post',
                    data:{
                        mobile : function(){
                            return $('#mobile').val();
                        }
                    }
                }
            },
            email:{
                required : true,
                email:true,
                remote:{
                    url : "/User/Register/check_email_only",
                    type: 'post',
                    data:{
                        email : function(){
                            return $('#email').val();
                        }
                    }
                }
            },
	      	cord:'required',
            title:{
                required : true,
                remote:{
                    url : "/User/Register/check_title_only",
                    type: 'post',
                    data:{
                        title : function(){
                            return $('#title').val();
                        }
                    }
                }
            },
	      	industry:'required',
	      	areas:'required',
	      	description:'required',
	      	linkman:'required',
	      	// Mobile:'required',
	      	address:'required',
	       	password: {
				required: true,
			    minlength: 5,
			    maxlength: 16,
			},
			repassword: {
				required: true,
			    equalTo: "#password"
			},
            agreement:'required',
	    },
	    messages: {
            username:{
                required : '请输入用户名',
                remote   : '用户名已被注册',
            },
            mobile:{
                required : '输入手机号码',
                remote   : '此手机已注册，请用其他手机注册',
            },
            email:{
                required : '请输入电子邮箱',
                email : '请输入正确的电子邮箱',
                remote   : '此邮箱已注册，请用其他邮箱注册',
            },
	      	cord:'请输入验证码',
            title:{
                required : '请输入机构名',
                remote   : '此机构已注册，如果是同名分支机构请用地区在机构名称后面备注，例如：优路教育（上海）',
            },
	      	industry:'请输入您的行业',
	      	areas:'请输入授课地区',
	      	description:'请输入机构简介',
	      	linkman:'请输入联系人',
	      	// Mobile:'请输入正确的手机号码',
	      	address:'请输入地址',
			password: {
				required: '请输入密码',
			    minlength:'密码不能少于5位',
			    maxlength:'密码不能大于16位',
			},
			repassword: {
				required: '请再次输入密码',
				equalTo: "两次密码不一致"
			},
            agreement:'勾选已阅读，理解并接受《用户协议》才可注册',
        }
	});
	$("#tab2").validate({
	    rules: {
            username:{
                required : true,
                remote:{
                    url : "/User/Register/checkusername",
                    type: 'get',
                    data:{
                        username2 : function(){
                            return $('#username2').val();
                        }
                    }
                }
            },
	      	cord:'required',
            mobile:{
                required : true,
                isMobile:true,
            },
	       	password: {
				required: true,
			    minlength: 5,
			    maxlength: 16,
			},
			repassword: {
				required: true,
			    equalTo: "#password2"
			},
            agreement:'required',
        },
	    messages: {
            username:{
                required : '请输入用户名',
                remote   : '用户名已被注册',
            },
	      	cord:'请输入验证码',
            mobile:{
                required : '请输入正确的手机号码',
            },
			password: {
				required: '请输入密码',
			    minlength:'密码不能少于5位',
			    maxlength:'密码不能大于16位',
			},
			repassword: {
				required: '请再次输入密码',
				equalTo: "两次密码不一致"
			},
            agreement:'勾选已阅读，理解并接受《用户协议》才可注册',
        }
	});
	
	
	
$(function(){
		//注册页上传图片
    $(".file,.wechat_file").change(function(){
    	// console.log($(this).attr('id'))
		var id = $(this).attr('id')
        var fileImg = $("."+id+"Img");
        var explorer = navigator.userAgent;
        var imgSrc = $(this)[0].value;
        if (explorer.indexOf('MSIE') >= 0) {
            if (!/\.(jpg|jpeg|png|JPG|PNG|JPEG)$/.test(imgSrc)) {
                imgSrc = "";
                fileImg.attr("src","../Public/images/sc.jpg");
                alert('只允许上传jpg,jpeg,png,JPG,PNG,JPEG')
                return false;
            }else{
                fileImg.attr("src",imgSrc);
            }
        }else{
            if (!/\.(jpg|jpeg|png|JPG|PNG|JPEG)$/.test(imgSrc)) {
                imgSrc = "";
                fileImg.attr("src","../Public/images/sc.jpg");
                alert('只允许上传jpg,jpeg,png,JPG,PNG,JPEG')
                return false;
            }else{
                var file = $(this)[0].files[0];
                var url = URL.createObjectURL(file);
                fileImg.attr("src",url);
            }
        }
		if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/8./i)=="8."){ 
		alert("IE浏览器暂不支持预览图片"); 
		}
    });
    //我的消息点击张开内容
    

})
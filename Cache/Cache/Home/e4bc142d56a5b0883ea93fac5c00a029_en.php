<?php if (!defined('THINK_PATH')) exit(); if(!$empty) : ?><!DOCTYPE html><html><head lang="en"><?php if('Kecheng'==$module) : if('list_sid'==$template) : $schoolInfo=M('school')->where("id=$_GET[p]")->find(); if($schoolInfo) : if(!empty($schoolInfo['seo_d'])) : ?><meta name="description" content="<?php echo trim($schoolInfo['seo_d']); ?>"><?php else : if($seo_description) : ?><!-- tdk最新课程页面规则--><meta name="description" content="<?php echo ($seo_description); ?>"><?php else :?><meta name="description" content="<?php echo trim(trim(isset($schoolid)?$schoolid['title']:'').'怎么样,'.trim(isset($schoolid)?$schoolid['title']:'').'课程列表', ' ,，tnr x0B'); ?>"><?php endif; endif; if(!empty($schoolInfo['seo_k'])) : ?><meta name="keywords" content="<?php echo trim($schoolInfo['seo_k'],' ,，tnr x0B'); ?>"><?php else : if($seo_keywords) : ?><!-- tdk最新课程页面规则--><meta name="keywords" content="<?php echo ($seo_keywords); ?>"><?php else :?><meta name="keywords" content="<?php echo trim(trim(isset($schoolid)?$schoolid['title']:'').'课程,'.trim(isset($schoolid)?$schoolid['title']:'').'课程价格'); ?>"><?php endif; endif; else :?><meta name="description" content="<?php echo trim(trim(isset($schoolid)?$schoolid['title']:'').'怎么样,'.trim(isset($schoolid)?$schoolid['title']:'').'课程列表', ' ,，tnr x0B'); ?>"><meta name="keywords" content="<?php echo trim(trim(isset($schoolid)?$schoolid['title']:'').'课程,'.trim(isset($schoolid)?$schoolid['title']:'').'课程价格'); ?>"><?php endif; elseif('show'==$action_name): if($school_id) $schoolInfo=M('school')->where("id=$school_id")->find(); if(!empty($keywords)) : ?><meta name="keywords" content="<?php echo ($keywords); ?>"><?php else :?><meta name="keywords" content="<?php echo ($seo_keywords); ?>"><?php endif; if(!empty($description)) : ?><meta name="description" content="<?php echo ($description); ?>"><?php else :?><meta name="description" content="<?php echo trim($areaName.trim(isset($schoolid)?$schoolid['title']:'').trim($seo_description), ' ,，tnr x0B'); ?>"><?php endif; else :?><!-- tdk行业页面规则--><meta name="description" content="<?php echo ($seo_description); ?>"><meta name="keywords" content="<?php echo ($seo_keywords); ?>"><?php endif; elseif('School'==$module && 'list'==$template): $schoolInfo=M('school')->where("id=$_GET[p]")->find(); if($schoolInfo) : if(!empty($schoolInfo['seo_index_d'])) : ?><meta name="description" content="<?php echo trim($schoolInfo['seo_index_d'],' ,，tnr x0B'); ?>"><?php else :?><meta name="description" content="<?php echo ($seo_description); ?>"><?php endif; if(!empty($schoolInfo['seo_index_k'])) : ?><meta name="keywords" content="<?php echo trim($schoolInfo['seo_index_k'],' ,，tnr x0B'); ?>"><?php else :?><meta name="keywords" content="<?php echo ($seo_keywords); ?>"><?php endif; else :?><meta name="description" content="<?php echo trim(isset($schoolid)?$schoolid['title']:'').$seo_description;?>"><meta name="keywords" content="<?php echo trim(isset($schoolid)?$schoolid['title']:'').$seo_keywords;?>"><?php endif; else : $areaName = ''; ?><meta name="description" content="<?php echo trim(isset($schoolid)?$schoolid['title']:'').$seo_description;?>"><meta name="keywords" content="<?php echo trim(isset($schoolid)?$schoolid['title']:'').$seo_keywords;?>"><?php endif;?><meta charset="utf-8"><meta name="renderer" content="webkit"><!--360 极速模式--><link rel="shortcut icon" href="/Apps/Tpl/Home/Default/Public/images/favicon.ico" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><?php echo ($t_gas ? $t_gas : ''); ?><title><?php if ('Kecheng'==$module && 'list_sid'==$template && $schoolInfo) { if(!empty($schoolInfo['seo_t'])) { echo trim($schoolInfo['seo_t']," ,，tnr x0B"); }elseif(!empty($schoolInfo['title'])){ if(!empty($seo_title)){ echo $seo_title; }else{ $stitle = trim($schoolInfo['title']); $title = $stitle.'课程_'.$stitle.'培训班/辅导班'.'_'.$site_name; echo $title; } }else { echo trim($areaName.trim(isset($schoolid)?$schoolid['title']:'').$seo_title," ,，tnr x0B"); } }elseif ('School'==$module && 'list'==$template && $schoolInfo){ if(!empty($schoolInfo['seo_index_t'])) { echo trim($schoolInfo['seo_index_t']," ,，tnr x0B"); }else { if(!empty($seo_title)){ echo $seo_title; }else{ echo trim($areaName.trim(isset($schoolid)?$schoolid['title']:'').'_'.$schoolid['address'].'培训培训机构'," ,，tnr x0B"); } } }elseif ('Kecheng'==$module && 'show'==$action_name ){ if(!empty($seo_index_t)) { echo trim($seo_index_t," ,，tnr x0B"); }else { echo $seo_title; } }else { echo $seo_title; } ?></title><link href="/Apps/Tpl/Home/Default/Public/css/index.css?<?php echo ($now_time); ?>" rel="stylesheet" type="text/css" /><link href="/Apps/Tpl/Home/Default/Public/css/common_header_footer.css?<?php echo ($now_time); ?>" rel="stylesheet" type="text/css" /><link href="/Apps/Tpl/Home/Default/Public/css/common_base.css?<?php echo ($now_time); ?>" rel="stylesheet" type="text/css" /><link href="/Apps/Tpl/Home/Default/Public/css/set2.css" rel="stylesheet" type="text/css" /><link href="/Apps/Tpl/Home/Default/Public/css/preview.css" rel="stylesheet" type="text/css" /><link href="/Apps/Tpl/Home/Default/Public/css/modern-menu.css" rel="stylesheet" type="text/css" /><link href="/Apps/Tpl/Home/Default/Public/css/mian.css?<?php echo ($now_time); ?>" rel="stylesheet" type="text/css" /><link href="/Public/Css/common.css?<?php echo ($now_time); ?>" rel="stylesheet" type="text/css" /><!--[if lt IE 9]><script src="../Public/js/html5.js"></script><script src="../Public/js/respond.min.js"></script><![endif]--><script type="text/javascript" src="../Public/js/jquery.min.js"></script><script type="text/javascript" src="../Public/js/jquery-powerSwitch.js"></script><script type="text/javascript" src="../Public/js/jquery.scrollTo.min.js"></script><script type="text/javascript" src="../Public/js/scroll.js"></script><script type="text/javascript" src="../Public/js/jquery.transit.min.js"></script><script type="text/javascript" src="../Public/js/jquery.modern-menu.min.js"></script><script type="text/javascript" src="../Public/js/common.js?<?php echo ($now_time); ?>"></script><script src="../Public/js/bootstrap.min.js"></script><style>
.theme9 a span.active {background-color: #179050;}
</style></head><body><div class="header"><!--logo搜索--><div class="top_nav"><div class="w1100 auto clearfix"><div class="top_logo"><?php $is_h1 = false; if( ($module == 'New' && ($action_name == 'index' || $action_name == 'show')) || ($module == 'Page' && $action_name == 'index') || ($module == 'School' && $action_name == 'index') || ($module == 'Kecheng' && ($action_name == 'index' || $action_name == 'show') && ((is_numeric($template) || $template == '') || $template == 'list_sid')) ) { $is_h1 = true; } if($is_h1) : ?><a class="l" href="/"><img src="<?php echo ($logo); ?>" alt="79招生网" /></a><?php else :?><h1><a class="l" href="/"><img src="<?php echo ($logo); ?>" alt="79招生网" /></a></h1><?php endif; if('City'!=$module_name) : ?><div class="top_qie"><p><span style="white-space:normal;">总站</span></p><a href="/city">切换城市</a></div><?php endif;?></div><!--top--><div class="header_nav"><ul><li class=""><a rel="nofollow" href="/contact"><img src="../Public/images/head_tel.jpg" width="22" height="22" alt="79招生网业务联系" /> 联系我们</a></li><?php if($_COOKIE['YP_username']) : ?><li style="color:#529b12; font-weight: bold;"><a href="/User/Index"><?php echo ($user["username"]); ?></a></li><?php elseif('City'!=$module): ?><li class=""><a rel="nofollow" href="/User/Login">登录</a></li><li class=""><a rel="nofollow" href="/User/Register/" >注册</a></li><?php endif; if('City'!=$module) : ?><li><a href="/new/" >新闻中心</a></li><?php $r = M('Block')->where(" 1  and lang=2 and pos='weima' ")->find(); if ($r):?><li class="sj"><a rel="nofollow" href="javascript:void(0);"></a><div class="my_sj"><a class="my_sj1" rel="nofollow" href="javascript:void(0);"></a><div class="my_sj_down" style="height: 125px;"><img src="<?php echo ($r["image1"]); ?>" alt="79招生网微信公众号" style="width: 128px;height: 126px"></div></div></li><li class="wx"><a rel="nofollow" href="javascript:void(0);"></a><div class="my_wx"><a class="my_wx1" rel="nofollow" href="javascript:void(0);"></a><div class="my_wx_down"><img src="<?php echo ($r["image1"]); ?>" alt="79招生网微信公众号" style="margin-top: 15px; margin-left: 22px; width: 105px;height: 104px;"><div class="wx_down"><div class="wx_down_gdfw"><?php echo ($r["content"]); ?></div></div></div></div></li><?php endif; endif;?></ul></div><!--top end--><div class="msearch_box"><a class="btm ct" href="<?php if(!$_COOKIE['YP_username']) : ?>/User/Register/<?php else :?>/User/Index<?php endif;?>">免费发布课程</a><div class="top_search"><form method="GET" action="/index.php?" class="in-module"><input type="hidden" id=""  name="m" value="Search"/><?php if( APP_LANG) : ?><input type="hidden" name="l" value="<?php echo LANG_NAME;?>" /><?php endif;?><div class="search_course"><select id="module" name="module" onchange="" class=""><option selected="selected" value="Kecheng">培训课程</option><option value="School">培训学校</option><option  value="New">培训资讯</option></select></div><div class="search_img"></div><p class="search_input"><input type="text" name="keyword" id="" class="input-text" value="<?php echo ($keyword); ?>" /></p><p class="search_btn"><button id="" type="submit">搜索</button></p></form></div></div></div></div><!--logo搜索end--><div class="clear"></div><!--导航--><div class="nav_wrap clear"><div class="nav w1100 auto fix"><div class="nav_right1 fw1"><ul class="modern-menu theme9"><?php $k=0;foreach($Categorys as $key=>$r):if(1=="" && $r['isfootermenu']==0){ continue; }if( $r['ismenu']==1 && intval(0)==$r["parentid"] ) :++$k;?><li class=""><a href="<?php echo ($r["url"]); ?>"><span <?php if($bcid==$r['id']) : ?>class="active"<?php endif;?>><?php echo ($r["catname"]); ?></span></a><?php if('/' != $r['url']) : ?><ul><?php $kd=0;foreach($Categorys as $key=>$rd):if(1=="" && $rd['isfootermenu']==0){ continue; }if( $rd['ismenu']==1 && intval($r[id])==$rd["parentid"] ) :++$kd;?><li><a href="<?php echo ($rd["url"]); ?>"><span><?php echo ($rd["catname"]); ?></span></a></li><?php endif; endforeach;?></ul><?php endif;?></li><?php endif; endforeach;?></ul></div><script type="text/javascript">
				$(".modern-menu").modernMenu();
			</script></div></div></div><!--导航end--><div id="school"><div class="sctop"><div class="mian"><a class="active" href="/school2/<?php echo ($_GET['p']); ?>.html">学校首页</a><a class="" href="/kec/<?php echo ($_GET['p']); ?>.html">最新课程</a><!-- <a href="/online/?sid=<?php echo ($_GET['sid']); ?>">网上报名</a> --></div></div><div class="Space Index index"><div id="main"><div class="space-col"><div class="sbox"><div class="title"><h1><i class="ico ico-spacehome"></i><span style="font-size: 28px;"><?php echo ($schoolid["title"]); ?></span></h1></div><div class="endtext"><img src="<?php echo ($schoolid["file"]); ?>" alt="<?php echo ($schoolid["title"]); ?>" style="margin-right: 45px; max-width: 256px; max-height: 256px; float: left;"><?php echo ($schoolid["description"]); ?></div></div><div class="sbox nomb"><div class="title"><h3><i class="ico ico-contact"></i><span>联系我们</span></h3></div><ul class="space-contact"><li><span>学校名称：</span><?php echo ($schoolid["title"]); ?></li><li><span>注册时间：</span><?php echo (todate($schoolid["createtime"],'Y-m-d')); ?></li><li><span>联系电话：</span><span class=""><?php echo ($schoolid["dianhua"]); ?></span></li><!--<li><span>客服 QQ：</span>--><!--<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($schoolid["QQ"]); ?>&site=caimaozsw.com&menu=yes" target="_blank" title="点击这里给我发消息" ><span class=""><?php echo ($schoolid["QQ"]); ?></span></a>--></li><li><span>详细地址：</span><?php echo ($schoolid["address"]); ?></li><!--<li><span>学校主页：</span><a href="/" target="_blank" ><?php echo ($schoolid["zhuye"]); ?></a></li>--></ul></div></div><?php  $_GET[p] &&( $kcorder=M('kecheng')->where("school_id=$_GET[p]")->order('guanzhu desc')->limit('5')->select()) || ($kcorder=array()); $new=M('new')->where('posid=11')->order('id desc')->limit('5')->select(); ?><div class="space-side"><div class="online-bm school-info"><h3><i></i>学校信息</h3><div class="info"><b><?php echo ($schoolid["title"]); ?></b><?php echo ($user_mark); ?><p>详细地址：<?php echo ($schoolid["address"]); ?></p></div><div class="space-kf"><div class="mycall"><em><span class=""><?php echo ($schoolid["dianhua"]); ?></span></em></div><p class="course-bar"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($schoolid["QQ"]); ?>&site=caimaozsw.com&menu=yes" class="qqzx"
                   target="_blank" rel="nofollow" style="margin-right: 80px;">QQ咨询</a></p></div></div><div class="sbox"><div class="title"><h3><i class="ico ico-distr"></i><span>热门课程</span></h3><a href="" class="more">更多>></a></div><ul class="hot-list space-hotkc"><?php if(is_array($kcorder)): $k = 0; $__LIST__ = $kcorder;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($k % 2 );++$k;?><li><i class="n<?php echo ($k); ?>">0<?php echo ($k); ?></i><?php $url = explode(',', $r['url'])[0]; $url1 = '_'.$_GET['p'].'.html'; ?><p><a href="<?php echo ($url); ?>"><?php echo ($r["title"]); ?></a></p></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="sbox"><div class="title"><h3><i class="ico ico-distr"></i><span>最新动态</span></h3><a href="/new/" class="more">更多>></a></div><ul class="hot-list space-hotkc hot-new"><?php if(is_array($new)): $i = 0; $__LIST__ = $new;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li class="diandiandian"><a href="<?php echo ($r["url"]); ?>"><?php echo ($r["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="wa"><img src="/Uploads/201705/5929409fca920.jpg" alt=""></div><style>
	.xxfk {
		width: 300px;
		margin: 0px auto;
		padding-bottom: 0px;
		position: fixed;
		right: 0px;
		top: 60%;
		background: #FFF;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
	}

</style><div class="xxfk"><div class="dw"><div class="regist-title">学习课程、反馈问题请留言</div><form id="onlinec" action="<?php echo URL('User-Post/insert');?>" method="post"><input type='hidden' name='formhash' value='<?php echo ($formhash); ?>' /><input type="hidden" name="form_submit" value="ok" /><input type="hidden" name="catid" value="<?php echo ($catid); ?>"/><input type="hidden" id="moduleid" name="moduleid" value="8"/><input type="hidden" id="lang" name="lang" value="<?php echo ($langid); ?>"/><input type="hidden" id="title" name="title" value="信息反馈"/><input type="hidden" id="ref" name="ref" value="/"/><ul class="clearfix"><li class="li1"><input placeholder="职 业：" id="zhiye" name="zhiye" class="c-input" type="text"></li><li class="li2 nomgr"><input placeholder="手 机：" id="telephone" name="telephone" class="c-input"
						   type="text" ></li><li class="li3"><input placeholder="姓 名：" id="name" name="username" class="c-input" type="text"
					></li><li class="li4 nomgr"><input placeholder="邮 箱：" id="email" name="email" class="c-input" type="email"></li><li class="li5 nomgr clearfix"><textarea name="content" id="content" class="c-textarea lh22" placeholder="留 言："></textarea></li><li class="li6 nomgr"><input type="text" maxlength="4" name="verify" class="input-text" class="inputbox"
						   id="verify" placeholder="请输入验证码"/><img id="verifyImage" class="checkcode" style="height: 35px; width: 70px;"
						 src="<?php echo U('Home/Index/verify');?>" onclick="javascript:resetVerifyCode();" class="checkcode"
						 title="<?php echo L('resetVerifyCode');?>"/></li><li class="li7 nomgr"><input type="text" maxlength="6" name="cord" class="input-text" class="inputbox"
						   id="verifyCode" placeholder="请输入手机验证码"/><button type="button" class="btm duanx" id="duanxpt">点击获取短信验证码</button><button type="button" class="btm dengd" id="" style="display: none;">点击获取短信验证码</button></li><li class="li8 nomgr"><button type="submit" class="sub-btn">发送</button></button></li></ul></form></div></div><div class="clear"></div></div></div><script type="text/javascript" src="../Public/js/jquery.validation.min.js"></script><script type="text/javascript">
    function resetVerifyCode() {
        var timenow = new Date().getTime();
        document.getElementById('verifyImage').src = './index.php?g=Home&m=Index&a=verify#' + timenow;
    }
</script></div></div></div><style type="text/css">
	.nav_wrap {
		display: none;
	}
	
	.header {
		height: 104px;
	}
</style><!--底部--><div class="footer mt20 clear"><div class="site_map"><div class="site_map_con site_map_con w1100 auto"><ul class="inline_box"><li class="inline_any" style="background:#fff;padding:8px;width: 112px;text-align: center;margin-right: 111px;"><?php $r = M('Block')->where(" 1  and lang=2 and pos='weima' ")->find(); if ($r):?><p><img src="<?php echo ($r["image1"]); ?>" alt="79招生网微信公众号" /></p><?php endif;?><p class="" style="color:#666;">让学习变得更容易</p></li><?php $k=0;foreach($Categorys as $key=>$r):if(1=="" && $r['isfootermenu']==0){ continue; }if( $r['ismenu']==1 && intval(39)==$r["parentid"] ) :++$k;?><li class="inline_any"><h3 class="site_map_title"><?php echo ($r["catname"]); ?></h3><?php if($r[child]) : $kd=0;foreach($Categorys as $key=>$rd):if(1=="" && $rd['isfootermenu']==0){ continue; }if( $rd['ismenu']==1 && intval($r[id])==$rd["parentid"] ) :++$kd;?><p><a rel="nofollow" target="_bank" href="<?php echo ($rd["url"]); ?>"><?php echo ($rd["catname"]); ?></a></p><?php endif; endforeach; endif;?></li><?php endif; endforeach;?></ul></div></div><div class=" clear"></div><div class="lxwm tc mt10 w1100 auto"><ul><li style="font-size:14px;"><p><span style="color:#FFFFFF;font-size:14px;text-align:center;white-space:normal;background-color:#40B477;font-family:微软雅黑;">79招生网 版权所有 </span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">备案/许可证编号为：<a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank">粤ICP备</a></span><a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank"><span t="7" data="17158495" white-space:normal;background-color:#ffffff;border-bottom:1px="" dashed="" #cccccc;z-index:1;position:static;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">17158495</span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">号</span></a></p><p>	Copyright &copy; 2017 All rights reserved by 79招生网
</p> | Designed by site.nuo.cn</li></ul></div></div><!-- 右侧客服 --><style>
	.pan_right{
		    width: 160px;
		    margin: 0px auto;
		    padding-bottom: 16px;
		    position: fixed;
		    right: 0px;
		    top: 15%;
		    background: #FFF;
		    border: 1px solid #e5e5e5;
		    border-radius: 5px;
	}
	
	.pan_div h2{
		padding: 3px 0;
		margin: 10px 0;
		font-size: 14px;
		border-bottom: 1px solid #e5e5e5;
		border-top: 1px solid #e5e5e5;
		font-weight: normal;
		text-align: center;
	}
	.pan_div:first-child h2{border-top: none;}
	.pan_qq img{vertical-align: middle;}
	.pan_qq a{text-decoration: none;color: #04529a;font-size: 14px;}
	.pan_tel{font-size: 16px;text-align: center;font-weight: bold;color: #ff6600;}
	
	.pan_img img{width: 120px;height: 120px;}
	.pan_img,.pan_qq{text-align: center;}
</style><div class="pan_right"><div class="pan_div"><h2>QQ客服</h2><div class="pan_qq"><a href="http://wpa.qq.com/msgrd?v=3&uin=<p>	2950079739
</p>&site=qq&menu=yes" target="_blank"><img src="../Public/images/qq.png" alt="<?php echo ($city); ?>79招生网招生QQ客服"/><p>	2950079739
</p></a></div></div><div class="pan_div"><h2>联系电话</h2><div class="pan_tel"><p style="white-space:normal;"><span style="font-size:14px;color:#333333;">18924037954</span></p><p style="white-space:normal;"><span style="font-size:10px;color:#333333;">（微信同号）</span></p></div></div><div class="pan_div"><h2>微信公众号</h2><div class="pan_img"><p><img src="/Uploads/201801/5a59cb9dcd9d2.jpg" alt="" /></p><p>	79招生网微信公众号
</p></div></div></div><!--底部 end--><script type="text/javascript">
	$(function () {
		$('#myhouxue').mouseenter(function () {
			$('.my_hx').fadeIn(100);
		}).mouseleave(function () {
			$('.my_hx').fadeOut(100);
		});
		$('#webguide').mouseenter(function () {
			$('.my_wz').fadeIn(100);
		}).mouseleave(function () {
			$('.my_wz').fadeOut(100);
		});
		$('.sj').mouseenter(function () {
			$('.my_sj').fadeIn(100);
		}).mouseleave(function () {
			$('.my_sj').fadeOut(100);
		});
		$('.wx').mouseenter(function () {
			$('.my_wx').fadeIn(100);
		}).mouseleave(function () {
			$('.my_wx').fadeOut(100);
		});

		/*右侧官方微信、最新动态 */
		$('#dynamic').find('#dynamic_up a').click(function () {
			$('#dynamic').find('#dynamic_up a').attr('class', '');
			$('#dynamic').find('.dynamic_hide').css('display', 'none');
			$(this).attr('class', 'dynamic_up_one');
			$('#dynamic').find('.dynamic_hide').eq($(this).index()).css('display', 'block');
		});

	});
	//左侧列表10个
	$(".blockLUl li:first-child").addClass('current_left');
	$(".blockLUl li:first-child").find('.f14').addClass('current_link');
	$(".blockLUl li").mouseover(function () {
		$(this).siblings().removeClass('current_left');
		$(this).siblings().find('.f14').removeClass('current_link');
		$(this).addClass('current_left');
		$(this).find('.f14').addClass('current_link');
	});
	//右侧列表8个
	$(".blockRUl li:first-child").addClass('current_right');
	$(".blockRUl li").mouseover(function () {
		$(this).siblings().removeClass('current_right');
		$(this).addClass('current_right');
	});
	// 左侧分类
	$('.small_type li').mouseover(function () {
		$(this).addClass('current');
	}).mouseleave(function () {
		$(this).removeClass('current');
	});
	//兼容性处理，勿删
	$('.small_type').find('ul li').mouseover(function () {

	});
	$('#submitSearch').click(function () {
		$("#search").submit();
	});
	$('#search .search_input input').focus(function () {
		$(this).attr('placeholder', '');
	}).blur(function () {
		$(this).attr('placeholder', '请输入课程名字，学校名称，地址');
	});
	// 图片轮换
	$("#adSlideBtn a").powerSwitch({
		autoTime: 4000,
		animation: "translate",
		classAdd: "tb_slide_on",
		classRemove: "tb_slide_a",
		classPrefix: "tb_slide",
		container: $("#adSlideBox"),
		onSwitch: function (image) {
			if (!image.attr("src")) {
				image.attr("src", image.attr("data-src"));
			}
		}
	});

	$('.search_course').mouseenter(function () {
		$('.search_course_down').fadeIn(100);
	}).mouseleave(function () {
		$('.search_course_down').fadeOut(100);
	});
	$('.sj').mouseenter(function () {
		$('.my_sj').fadeIn(100);
	}).mouseleave(function () {
		$('.my_sj').fadeOut(100);
	});
	$('.wx').mouseenter(function () {
		$('.my_wx').fadeIn(100);
	}).mouseleave(function () {
		$('.my_wx').fadeOut(100);
	});
	$('.search_course a').click(function (e) {
		var se_value = $(this).attr('data');
		$("input[name='type']").val(se_value);


		var buffer = $('.visible_text').html();
		var text = $(this).html();
		$('.visible_text').html(text);
		$(this).html(buffer);
		var buffer1 = $('.visible_text').attr('data');
		$(this).attr('data', buffer1);
		$('.visible_text').attr('data', se_value);
		$('.search_course_down').hide();

	});

</script><script type="text/javascript" src="../Public/js/common.js"></script><script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?c3dbbebf1a09edcf81f1c610ca25a91a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script><?php echo ($b_gas ? $b_gas : ''); ?></body></html><?php else :?><div id="school"><div class="sctop"><div class="mian"><a class="active" href="/school2/<?php echo ($_GET['p']); ?>.html">学校首页</a><a class="" href="/kec/<?php echo ($_GET['p']); ?>.html">最新课程</a><!-- <a href="/online/?sid=<?php echo ($_GET['sid']); ?>">网上报名</a> --></div></div><div class="Space Index index"><div id="main"><div class="space-col"><div class="sbox"><div class="title"><h1><i class="ico ico-spacehome"></i><span style="font-size: 28px;"><?php echo ($schoolid["title"]); ?></span></h1></div><div class="endtext"><img src="<?php echo ($schoolid["file"]); ?>" alt="<?php echo ($schoolid["title"]); ?>" style="margin-right: 45px; max-width: 256px; max-height: 256px; float: left;"><?php echo ($schoolid["description"]); ?></div></div><div class="sbox nomb"><div class="title"><h3><i class="ico ico-contact"></i><span>联系我们</span></h3></div><ul class="space-contact"><li><span>学校名称：</span><?php echo ($schoolid["title"]); ?></li><li><span>注册时间：</span><?php echo (todate($schoolid["createtime"],'Y-m-d')); ?></li><li><span>联系电话：</span><span class=""><?php echo ($schoolid["dianhua"]); ?></span></li><!--<li><span>客服 QQ：</span>--><!--<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($schoolid["QQ"]); ?>&site=caimaozsw.com&menu=yes" target="_blank" title="点击这里给我发消息" ><span class=""><?php echo ($schoolid["QQ"]); ?></span></a>--></li><li><span>详细地址：</span><?php echo ($schoolid["address"]); ?></li><!--<li><span>学校主页：</span><a href="/" target="_blank" ><?php echo ($schoolid["zhuye"]); ?></a></li>--></ul></div></div><?php  $_GET[p] &&( $kcorder=M('kecheng')->where("school_id=$_GET[p]")->order('guanzhu desc')->limit('5')->select()) || ($kcorder=array()); $new=M('new')->where('posid=11')->order('id desc')->limit('5')->select(); ?><div class="space-side"><div class="online-bm school-info"><h3><i></i>学校信息</h3><div class="info"><b><?php echo ($schoolid["title"]); ?></b><?php echo ($user_mark); ?><p>详细地址：<?php echo ($schoolid["address"]); ?></p></div><div class="space-kf"><div class="mycall"><em><span class=""><?php echo ($schoolid["dianhua"]); ?></span></em></div><p class="course-bar"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($schoolid["QQ"]); ?>&site=caimaozsw.com&menu=yes" class="qqzx"
                   target="_blank" rel="nofollow" style="margin-right: 80px;">QQ咨询</a></p></div></div><div class="sbox"><div class="title"><h3><i class="ico ico-distr"></i><span>热门课程</span></h3><a href="" class="more">更多>></a></div><ul class="hot-list space-hotkc"><?php if(is_array($kcorder)): $k = 0; $__LIST__ = $kcorder;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($k % 2 );++$k;?><li><i class="n<?php echo ($k); ?>">0<?php echo ($k); ?></i><?php $url = explode(',', $r['url'])[0]; $url1 = '_'.$_GET['p'].'.html'; ?><p><a href="<?php echo ($url); ?>"><?php echo ($r["title"]); ?></a></p></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="sbox"><div class="title"><h3><i class="ico ico-distr"></i><span>最新动态</span></h3><a href="/new/" class="more">更多>></a></div><ul class="hot-list space-hotkc hot-new"><?php if(is_array($new)): $i = 0; $__LIST__ = $new;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li class="diandiandian"><a href="<?php echo ($r["url"]); ?>"><?php echo ($r["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="wa"><img src="/Uploads/201705/5929409fca920.jpg" alt=""></div><style>
	.xxfk {
		width: 300px;
		margin: 0px auto;
		padding-bottom: 0px;
		position: fixed;
		right: 0px;
		top: 60%;
		background: #FFF;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
	}

</style><div class="xxfk"><div class="dw"><div class="regist-title">学习课程、反馈问题请留言</div><form id="onlinec" action="<?php echo URL('User-Post/insert');?>" method="post"><input type='hidden' name='formhash' value='<?php echo ($formhash); ?>' /><input type="hidden" name="form_submit" value="ok" /><input type="hidden" name="catid" value="<?php echo ($catid); ?>"/><input type="hidden" id="moduleid" name="moduleid" value="8"/><input type="hidden" id="lang" name="lang" value="<?php echo ($langid); ?>"/><input type="hidden" id="title" name="title" value="信息反馈"/><input type="hidden" id="ref" name="ref" value="/"/><ul class="clearfix"><li class="li1"><input placeholder="职 业：" id="zhiye" name="zhiye" class="c-input" type="text"></li><li class="li2 nomgr"><input placeholder="手 机：" id="telephone" name="telephone" class="c-input"
						   type="text" ></li><li class="li3"><input placeholder="姓 名：" id="name" name="username" class="c-input" type="text"
					></li><li class="li4 nomgr"><input placeholder="邮 箱：" id="email" name="email" class="c-input" type="email"></li><li class="li5 nomgr clearfix"><textarea name="content" id="content" class="c-textarea lh22" placeholder="留 言："></textarea></li><li class="li6 nomgr"><input type="text" maxlength="4" name="verify" class="input-text" class="inputbox"
						   id="verify" placeholder="请输入验证码"/><img id="verifyImage" class="checkcode" style="height: 35px; width: 70px;"
						 src="<?php echo U('Home/Index/verify');?>" onclick="javascript:resetVerifyCode();" class="checkcode"
						 title="<?php echo L('resetVerifyCode');?>"/></li><li class="li7 nomgr"><input type="text" maxlength="6" name="cord" class="input-text" class="inputbox"
						   id="verifyCode" placeholder="请输入手机验证码"/><button type="button" class="btm duanx" id="duanxpt">点击获取短信验证码</button><button type="button" class="btm dengd" id="" style="display: none;">点击获取短信验证码</button></li><li class="li8 nomgr"><button type="submit" class="sub-btn">发送</button></button></li></ul></form></div></div><div class="clear"></div></div></div><script type="text/javascript" src="../Public/js/jquery.validation.min.js"></script><script type="text/javascript">
    function resetVerifyCode() {
        var timenow = new Date().getTime();
        document.getElementById('verifyImage').src = './index.php?g=Home&m=Index&a=verify#' + timenow;
    }
</script></div></div></div><style type="text/css">
	.nav_wrap {
		display: none;
	}
	
	.header {
		height: 104px;
	}
</style><?php endif;?>
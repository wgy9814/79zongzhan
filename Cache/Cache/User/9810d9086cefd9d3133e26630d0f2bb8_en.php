<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head lang="en"><meta name="description" content=""><meta name="keywords" content=""><meta charset="utf-8"><meta name="renderer" content="webkit"><!--360 极速模式--><link rel="shortcut icon" href="/Apps/Tpl/Home/Default/Public/images/favicon.ico" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><title>账户管理-79招生网</title><link href="../Public/css/common_header_footer.css" rel="stylesheet" type="text/css" /><link href="../Public/css/common_base.css" rel="stylesheet" type="text/css" /><link href="../Public/css/member.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="/Apps/Tpl/Home/Default/Public/js/jquery.min.js"></script></head><body><div class="header"><!--logo搜索--><div class="top_nav"><div class="w1200 auto clearfix" id="user_head"><div class="top_logo"><a class="l" href="/"><img src="<?php echo ($logo); ?>" /></a><div class="top_qie">
					你好！欢迎 <span style="color: #00b083;text-decoration:underline;"><?php echo ($vo["username"]); ?></span> 登录！
					<a href="/User/Login/logout">退出</a></div></div><!--top--><div class="head_r fr"><p class="f16" style="color: #00b083;">欢迎来到 79招生网，与大家一起共同学习与进步！</p></div></div></div><!--logo搜索end--><div class="clear"></div><!--导航--></div><!--导航end--><div class="Member_wall" id="Member_Index_index"><div class="Member Index index"><div class="main"><div class="container"><div class="main-left"><div class="main-left"><link href="/Public/Css/layer.css" rel="stylesheet" type="text/css"/><link href="/Public/Css/common.css" rel="stylesheet" type="text/css"/><div class="pic_box"><div class="side-adorn"><div class="pic-box"><img src="<?php echo ($vo['file']); ?>" alt="<?php echo ($vo['username']); ?>"></div></div><div class="" style="text-align: center;"><a href="javascript:;" class="user-name" title="<?php echo ($vo['username']); ?>"><?php echo ($vo['username']); ?></a>&nbsp;
        <?php if($user_mark) : echo ($user_mark); endif;?></div><div class="user-info"><dl class="user-info-dl"><?php if($user_mark) : ?><dd class="">V生效时间
                <a href="javascript:;"><?php echo (todate($user_level["updatetime"],'Y-m-d H:i:s')); ?></a></dd><dd class="">V失效时间
                <a href="javascript:;"><font <?php if($is_expire) : ?>color="red" <?php endif;?>><?php echo (todate($user_level["expire_time"],'Y-m-d
                    H:i:s')); ?></font></a></dd><?php endif;?><dd class="">最后登录
                <a href="javascript:;"><?php echo (todate($vo["last_logintime"],'Y-m-d H:i:s')); ?></a></dd><dd class="">注册时间
                <a href="javascript:;"><?php echo (todate($vo["createtime"],'Y-m-d H:i:s')); ?></a></dd></dl></div></div><div class="side-manu"><dl><dt>账户管理</dt><dd><a class="active" href="/User/Index">个人资料</a></dd><dd><?php if($vo['user']) : ?><a class="" id="fabu" href="javascript:;">我的课程及发布新课程</a><?php else :?><a class="" href="/User/Index/mykecheng2?sid=<?php echo ($vo['id']); ?>">我的课程</a><?php endif;?></dd><?php if($vo['user']) : else :?><dd><a href="/User/Index/mycoupon?sid=<?php echo ($vo['id']); ?>">优惠卷</a></dd><?php endif;?><dd><a href="/User/Index/news">我的消息</a></dd><?php if($vo['groupid'] != '3') : ?><dd><a href="/User/Index/vip">自主招生服务V</a></dd><dd><a href="javascript:;" id="treaty">代理招生服务D</a></dd><?php endif;?></dl></div></div><div id="tip" style="display: none;"><div id="new_kecheng_tip"><p class="MsoNormal" style="text-align:left;white-space:normal;text-indent:2em;">	免费发布课程及自主招生注意事项
</p><p class="MsoNormal" style="text-align:left;margin-left:0cm;text-indent:2em;white-space:normal;">	（1）课程内容尽量丰富，涵盖学生所需了解的课时、课程内容详情、课程价格、适合人群、授课形式等等；
</p><p class="MsoNormal" style="text-align:left;margin-left:0cm;text-indent:2em;white-space:normal;">	（2）<span style="text-indent:24px;white-space:normal;">课程排版尽量整齐清晰、图文并茂、段落分明、文字内容尽量多些，不要上传超大图片，避免只有图片无文字的课程内容；</span></p><p class="MsoNormal" style="text-align:left;margin-left:0cm;text-indent:2em;white-space:normal;">	（<span style="text-indent:2em;">3）注册成功即为普通机构会员，最多可以发布25个课程；</span></p><p class="MsoNormal" style="text-align:left;white-space:normal;text-indent:2em;">	（4）您注册时留有联系方式（手机、微信及qq），平台会自动将手机号留在您学校首页及最新课程列表页，<span style="text-indent:24px;white-space:normal;">开通自主招生V服务的</span><span style="text-indent:24px;white-space:normal;">用户</span>还会在课程页面显示联系方式。（自2020年10月1日起，您发布课程时请不要以任何形式再留任何联系方式：包括但不限于手机、微信、QQ、有联系方式的图片等等，也不要留网站链接，以免触规关停账号）。
</p><p class="MsoNormal" style="text-align:left;white-space:normal;text-indent:2em;">	（5）如果需要更多的服务，请点击“<span style="text-indent:24px;white-space:normal;">自主招生服务V</span>”按钮后选择需要的服务提交或联系客服咨询<span style="text-indent:2em;font-size:12px;">开通自主招生服务</span><span style="text-indent:2em;font-size:12px;">V</span><span style="text-indent:2em;font-size:12px;">。</span></p><div><br /></div><p><br /></p><p class="MsoNormal" style="text-align:left;white-space:normal;text-indent:2em;"><br /></p><p class="button"><a onclick="new_href('/User/Index/mykecheng?sid=<?php echo ($vo[id]); ?>#fabu_btn')" class="sub-btn">点击发布课程</a></p></div></div><div id="fuwu_content" style="display: none;"><div id="fuwu_content_tip"><p><table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" style="border:none;"><tbody><tr><td width="568" colspan="2" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal" align="center" style="text-align:center;"><b><span style="font-size:16pt;font-family:宋体;">代理招生服务</span></b><b><span style="font-size:16pt;"></span></b></p></td></tr><tr><td width="76" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><b></b></p><p class="MsoNormal" style="text-indent:10.55pt;"><b><span style="font-family:宋体;">说明</span></b></p></td><td width="493" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><span style="font-family:宋体;color:blue;">签约服务适用于代理招生用户：用户与平台签约后，平台提供代理招生服务（全程打包，一站式服务）。</span></p></td></tr><tr><td width="76" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><b></b></p><p class="MsoNormal"><b><span style="font-family:宋体;">服务内容</span></b></p></td><td width="493" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal" style="margin-left:0cm;text-indent:0cm;"><span style="color:blue;">（1）</span><span style="font-family:宋体;color:blue;">注册、发布课程及日常维护</span><span style="color:blue;"></span></p><p class="MsoNormal" style="margin-left:0cm;text-indent:0cm;"><span style="color:blue;">（2）</span><span style="font-family:宋体;color:blue;">课程优化、课程链接搜索引擎推送、宣传及推广</span><span style="color:blue;"></span></p><p class="MsoNormal" style="margin-left:0cm;text-indent:0cm;"><span style="color:blue;">（3）</span><span style="font-family:宋体;color:blue;">按需配置各类展示V位</span><span style="color:blue;"></span></p><p class="MsoNormal"><span style="font-family:宋体;color:blue;">（</span><span style="color:blue;">4</span><span style="font-family:宋体;color:blue;">）按约定方式推送学员</span><b><span style="color:blue;"></span></b></p></td></tr><tr><td width="76" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><b></b></p><p class="MsoNormal"><b><span style="font-family:宋体;">签约流程</span></b></p></td><td width="493" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><span style="font-family:宋体;color:blue;">复制《用户协议》</span><span style="color:blue;">----&gt;</span><span style="font-family:宋体;color:blue;">按空白提示填写机构名称、联系方式、地址、联系人等等</span><span style="color:blue;">----&gt;</span><span style="font-family:宋体;color:blue;">签名盖章</span><span style="color:blue;">----&gt;</span><span style="font-family:宋体;color:blue;">拍照（或扫描）微信发送客服</span><span style="color:blue;">----&gt;79</span><span style="font-family:宋体;color:blue;">招生网平台签名盖章发送用户</span><span style="color:blue;">----&gt;</span><span style="font-family:宋体;color:blue;">完成协议签约。</span><b><span style="color:blue;"></span></b></p></td></tr><tr><td width="76" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><b><span style="font-family:宋体;">《用户协议》内容</span></b></p></td><td width="493" valign="top" style="border:1pt solid windowtext;"><p class="MsoNormal"><span style="font-family:宋体;color:blue;">协议全部内容显示如下文：需要的用户可以复制签约</span><span style="color:blue;"></span></p><p class="MsoNormal"><span style="font-family:宋体;color:blue;"></span></p><h3 style="white-space:normal;text-indent:152pt;"></h3><h3 style="margin-left:0.0000pt;text-indent:152.0000pt;"><b><span>代</span><span>理</span><span>招</span><span>生</span><span>合</span><span>作</span><span>协</span><span>议</span></b><b>（</b><span>合同编号：</span>2020xxxxxx<b>）</b><b></b></h3><p class="MsoNormal" style="text-indent:0pt;"><span>甲</span> 方：&nbsp;广州柒玖教育服务有限公司 <span>乙</span><span>方：</span></p><p class="MsoNormal" style="text-indent:0pt;"><span>电</span> 话：&nbsp;020-26225931 <span>电</span><span>话：</span></p><p class="MsoNormal" style="text-indent:0pt;"><span>地</span><span>址：广州增城新塘摩托车市场</span>1#204 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;地 址：
					</p><p class="MsoNormal" style="text-indent:-285pt;"><span>地</span> 址：&nbsp;广州增城区新塘镇摩托车市场1栋204
					</p><p class="MsoNormal" style="text-indent:0pt;">						甲乙双方经过友好协商，本着营销推广共赢的原则，在自愿、平等、互惠互利的基础上携手，开展教学代理招生合作事宜。为了顺利合作、双方权益得到保障，特订立以下条款，由甲乙双方共同遵守。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><b>一、甲方权利义务：</b></p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						1. &nbsp;甲方经乙方授权自行推广、宣传甲方的课程及招生信息，代理乙方的招生业务。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						2.&nbsp;&nbsp;甲方为乙方提供网上宣传和招生咨询工作，包括在甲方网站注册、发布课程、课程优化及页面宣传推广、课程查询、网上咨询及向乙方推送获取的学生资源等。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						3. &nbsp;甲方如有针对乙方课程促销活动，特惠条件必须经过乙方的许可。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						4. &nbsp;甲方有权对乙方提供的课程的完整性、合理性（包括价格、合法合规等）向乙方提出质疑及修改要求，确保发布的课程合法、合规。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						5. 甲方发布完课程后需将课程链接告知乙方，乙方须在3-5天确定课程内容是否符合自己要求，超过此规定时间未提出异议，则默认无异议，甲方有权按照发布的课程开始正常代理招生工作。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><b>二、乙方权利义务：</b></p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						1. <span>乙方认同并遵守</span>79招生网《用户协议》及网站其它规定，合法合规使用网站及享受网站提供的服务。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						2. &nbsp;乙方授权甲方代理其招生业务，甲方利用自身的网站平台及其他招生方式对乙方培训课程（产品）进行推广、宣传及招生，为甲方争取学生资源，达到合作双赢。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						3. &nbsp;乙方对甲方招收的学员提供与乙方自行招生的学员同等待遇的教学、教务、优惠及社会公开承诺等服务；乙方保证不对甲方招收之学员收取歧视性收费，歧视性收费是指该费用只对甲方招收之学员收取而未对乙方自行招收之学员收取。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						4. &nbsp;乙方向甲方提供自身的招生信息并保证信息准确无误、合法合规及内容丰富以尽可能涵盖招生工作必须的资料：学校简介、课程资料、招生信息、开班计划、课程价格、联系方式、授课地址及环境条件等等。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						5. &nbsp;乙方应及时将自己的课程信息（开课计划、活动价格变动、报名截止等）在网上变更或通知甲方变更，对甲方发布的错误信息及时提出，确保课程信息合法合规、最新及不过时。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						6. &nbsp;乙方必须按照合同向甲方支付代理服务费用。
					</p><p class="MsoNormal" style="text-indent:0pt;"><b>三、合作流程细则</b></p><p class="MsoNormal" style="text-indent:0pt;"><b>1.合作流程</b><b></b></p><p class="MsoNormal" style="text-indent:0pt;"><span>双方签订协议</span>--&gt;乙方提供课程资料及支付技术服务费--&gt;甲方注册及发布课程资料--&gt;乙方核实内容准确性--&gt;甲方正式招生--&gt;甲方向乙方提供学员信息--&gt;乙方跟进及收取报名费--&gt;乙方向甲方返佣
					</p><p class="MsoNormal" style="text-indent:0pt;"><b>2.细则相关说明</b><b></b></p><p class="MsoNormal" style="text-indent:0pt;"><span>（</span>1）<span>报名信息提供：网上报名的学员，甲方过滤后对有意愿的尽可能真实的报名信息以约定的方式（如</span>QQ或微信）的形式发送给乙方，内容包括学员①咨询日期、②姓名、③手机号码或QQ邮箱、④所报课程等，尽可能详细。
					</p><p class="MsoNormal" style="text-indent:0pt;"><span>（</span>2）咨询预约、接待：乙方收到信息后立即进行咨询预约、回访及接待学员并完成学员的报名收费等转化手续。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><span>（</span>3）技术服务费：甲方为乙方注册、发布课程、提供课程优化及推广直至提供学员信息等一系列服务收取的费用，一次性收取300元，永久服务，以后不会再收取。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><b>四、支付与结算：</b></p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						1. 乙方授权甲方以乙方公开招生的价格进行招生，并按当月所招人数实际收费给甲方提成。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						2．返点佣金比例提成：
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						乙方按照学员报名培训费的<u>10%(驾驶培训)、</u>1<u>5%（其他培训）、</u>2<u>0%（学历教育）</u>返现给甲方
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						4. 每月结算方式：甲方每月1-10号会将上月发送甲方学员以报表形式发送乙<span>方相关人员核对成交学员，乙方应在收到学员统计报表后七个工作日与甲方如实核对成交学员；乙方每月</span>_15_号之前按比例统一结算结算日前核对的服务费用。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						5．支付方式：转帐、微信支付等。乙方转账后通过电话：&nbsp;或QQ： &nbsp;&nbsp;&nbsp;告知甲方。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						6.合约签订后，乙方即向甲方支付300元技术服务费。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						甲方官方指定银行账号
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						账户名：广州柒玖教育服务有限公司
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						开户银行：广发银行股份有限公司增城新塘解放路支行
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><span>账号：</span>9550880206731800192
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><span>支付宝：</span>18924037954
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><b>五、其他条款：</b></p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						双方联系方式：
					</p><table class="MsoNormalTable ke-zeroborder" border="0" cellspacing="0" style="border:none;"><tbody><tr><td width="43" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td><td width="78" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">联系人</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="73" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">课程顾问</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="115" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">联系电话</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="141" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">E-MAIL</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="100" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">其它</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td></tr><tr><td width="43" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">乙方</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="78" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td><td width="73" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td><td width="115" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td><td width="141" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td><td width="100" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td></tr><tr><td width="43" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">甲方</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="78" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">范老师</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="73" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Tahoma;font-size:9pt;"></span></p></td><td width="115" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">18924037954</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="141" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">1290884607@qq.com</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td><td width="100" valign="center" style="border:1.0000pt solid #000000;background:#FFFFFF;"><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">微 &nbsp;信</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p><p class="MsoNormal" align="center" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:center;"><span style="font-family:宋体;font-size:9pt;">18924037954</span><span style="font-family:Calibri;font-size:9.0000pt;"></span></p></td></tr></tbody></table><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><b>六、合同的违约与签订：</b></p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						1.本协议一式两份，双方各执一份。本协议自双方盖章之日起生效，有效期为三年，三年后若无争议合同自动延续。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						2.本协议若有修改，双方可另行约定，或签订补充协议；需要修改的一方需提前一周通知另外一方。补充协议与本协议具同等之法律效力。传真件、复印件具有同等之法律效力。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						3.一方违反协议条款，给对方造成损失，双方尽量协商解决，遭受损失的一方有权向违约方提出赔偿，赔偿最大限额为当月双方发生或应发生费用金额的两倍。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						4.以上各条款，如发生争议，双方尽量协商解决，如协商不成，以甲方所在地法院裁决为准。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;">						5.双方未尽事宜，协商再定。
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><br /></p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><span>甲方：广州柒玖教育服务有限公司</span> (盖章） <span>乙</span> 方：培训机构名称&nbsp;(盖章）
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><span>代</span> 表：签名 <span>代</span> 表：签名
					</p><p class="MsoNormal" align="justify" style="margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;"><span>日</span> 期：&nbsp;年&nbsp;月&nbsp;日&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;日 <span>期</span><span>：年</span> 月&nbsp;&nbsp;日
					</p></td></tr></tbody></table></p></div></div><script type="text/javascript" src="/Public/Js/layer.js"></script><script type="text/javascript" src="/Public/Js/common.js"></script></div><div id="news_right"><div class="news_right_t"><!-- <input type="checkbox" name="" id="qx" value="" /><span>全选</span><button onclick="deleteall();">批量删除</button> --><div class="fr nsearch"></div><div class="huanye fr"><?php echo ($pages); ?></div></div><div class="news_nva"><div class="nav-tabs"><li class="active"><a href="javascript:;" id="allread">全部消息</a></li><li><a href="javascript:;" id="unread">未读</a></li></div><div class="lis_con"><ul class="list active" id="list_table1"><li class="ct">暂无数据</li></ul><ul class="list"  id="list_table2"><li class="ct">暂无数据</li></ul></div></div></div></div></div></div></div><link rel="stylesheet" href="../Public/css/ziliao.css" /><!--底部--><div class="footer mt20 clear"><div class="site_map"><div class="site_map_con site_map_con w1100 auto"><ul class="inline_box"><li class="inline_any" style="background:#fff;padding:8px;width: 112px;text-align: center;margin-right: 111px;"><?php $r = M('Block')->where(" 1  and lang=2 and pos='weima' ")->find(); if ($r):?><p><img src="<?php echo ($r["image1"]); ?>" /></p><?php endif;?><p class="" style="color:#666;">让学习变得更容易</p></li><?php $k=0;foreach($Categorys as $key=>$r):if(1=="" && $r['isfootermenu']==0){ continue; }if( $r['ismenu']==1 && intval(39)==$r["parentid"] ) :++$k;?><li class="inline_any"><h3 class="site_map_title"><?php echo ($r["catname"]); ?></h3><?php if($r[child]) : $kd=0;foreach($Categorys as $key=>$rd):if(1=="" && $rd['isfootermenu']==0){ continue; }if( $rd['ismenu']==1 && intval($r[id])==$rd["parentid"] ) :++$kd;?><p><a rel="nofollow" target="_bank" href="<?php echo ($rd["url"]); ?>"><?php echo ($rd["catname"]); ?></a></p><?php endif; endforeach; endif;?></li><?php endif; endforeach;?></ul></div></div><div class=" clear"></div><div class="lxwm tc mt10 w1100 auto"><ul><li style="font-size:14px;"><p><span style="color:#FFFFFF;font-size:14px;text-align:center;white-space:normal;background-color:#40B477;font-family:微软雅黑;">79招生网 版权所有 </span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">备案/许可证编号为：<a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank">粤ICP备</a></span><a rel="nofollow" href="http://beian.miit.gov.cn" target="_blank"><span t="7" data="17158495" white-space:normal;background-color:#ffffff;border-bottom:1px="" dashed="" #cccccc;z-index:1;position:static;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">17158495</span><span white-space:normal;background-color:#ffffff;"="" style="text-decoration: none; color: rgb(255, 255, 255); padding: 1px 0px; outline: 0px; font-size: 14px; text-align: center; white-space: normal; background-color: rgb(64, 180, 119); font-family: 微软雅黑;">号</span></a></p><p>	Copyright &copy; 2017 All rights reserved by 79招生网
</p> | Designed bymqu.cn</li></ul></div></div><script>var formatDate=function (now,type,style) {
    type?type=[type,type,'',':']:type=['年','月','日',':'];
    var year = now.getFullYear();
    var month = now.getMonth() + 1;
    var date2 = now.getDate();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    switch(style){
    	case 1:
    		return year + type[0] + month;
    		break;
    	case 2:
    		return date2 + type[2];
    		break;
    	case 3:
    		return hour + type[3] + minute;
    		break;
    	default:
    		return year + type[0] + month + type[1]+ date2 + type[2];
    		
    }
  }
	//点击切换列表
	$('#news_right .nav-tabs>li').click(function(){
		var index = $(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		$('#news_right .list').eq(index).addClass('active').siblings().removeClass('active');
	})

	//点击展开内容
	$(document).on('click','#news_right .pb a',function(){
		
		$('#news_right .list li').removeClass('open');
		$(this).parents('li').addClass('open');
	});
	//点击缩回内容
	$(document).on('click','#news_right .open .pb a',function(){
		$(this).parents('li').removeClass('open');
	});
	//页面加载时读取消息
	var url,_json,_success;
	//封装ajax
	function _ajax(obj){
		
		$.ajax({
	        type:obj.type?obj.type:"post",
	        url:obj.url,
	        data:obj.data?obj.data:null,
	        dataType:'json',
	        success:function(msg){
	            if(typeof(obj.success)=="function"){
	            	obj.success(msg);
	            }
	        },
	        error:function(e){
	        	console.log("e---",e);
	        	alert("请求失败！");
	        }
    	});
	}
	//读取全部消息
	_ajax({
	 	url:"<?php echo URL('User-Post/getMessageList');?>",
	 	data:{'type':2},
	 	success:function(msg){
	 		_success(msg,'#list_table1',2);
	 	}
	 })
    //读取未读消息
    _ajax({
	 	url:"<?php echo URL('User-Post/getMessageList');?>",
	 	data:{'type':1},
	 	success:function(msg){
	 		_success(msg,'#list_table2',1);
	 	}
	})


    //封装成功事件
    function _success(msg,id,type){
    	if(msg){
    		if(msg.data.length>0){
	    		var list_html='';
	        	var message = msg.data;
	        	for (var i =0;i<message.length;i++) {
	        		list_html+='<li class="" data-id = "'+message[i].id+'"  data-type = "'+message[i].mtype+'"><div class="posa"><p class="f14">'+formatDate(new Date(message[i].createtime*1000),'-',1)+'</p><p class="f34">'+formatDate(new Date(message[i].createtime*1000),'-',2)+'</p></div>';
					list_html+='<div class="ovef"><div class="fl"></label></div>';
					list_html+='<div class="fr list_r"><div class="pt ovef"><span class="red f14">系统通知</span><span class="f16 c3">：'+message[i].title+'</span><span class="time">'+formatDate(new Date(message[i].createtime*1000),'-',3)+'</span></div>';
					list_html+='<div class="pb"><div class="con c6">'+message[i].content+'</div><a href="javascript:;">点击此查看更多内容详情</a></div></div></div></li>'
	        	}
	        	if(msg.count>0){
	        	    if(type ==1){
	        	        $('#unread').html('未读<span style="color: red;">['+msg.count+']</span>');
					}else{

					}
				}

	        	$(id).html(list_html);
	       }else{
	       		list_html = '<li class="ct">暂无数据</li>'
	       		$(id).html(list_html);
	       		
	       }
        }
    }
   	//查看未读消息
   	$(document).on('click','#news_right .pb a',function(){
   		var id = $(this).parents('li').attr('data-id');
   		var type = $(this).parents('li').attr('data-type');
   		_ajax({
		 	url:"<?php echo URL('User-Post/changeMessageStatus');?>",
		 	data:{'id':id,'type':type},
		 	success:function(msg){
		 		console.log(msg)
		 	}
		})
   	});
//删除单条
   	$(document).on('click','#news_right .list_r .pt .delete',function(){
   		var _this = $(this);
   		var id = $(this).parents('li').attr('data-id');
   		var type = $(this).parents('li').attr('data-type');
   		_ajax({
		 	url:"<?php echo URL('User-Post/deleteMessage');?>",
		 	data:{'id':id,'type':type},
		 	success:function(msg){
		 		if(msg.msg=='success'){
		 			alert('删除成功！')
		 			_this.parents('li').remove();
		 		}else{
		 			alert('网络错误！');
		 		}
		 		
		 	}
		 	
		})
   	});
//删除quanbu
	function deleteall(){
		var _checkbox=$('#news_right .list.active input[type=checkbox]:checked');
		var id=[];

		for(var i=0;i<_checkbox.length;i++){
			id.push({id:_checkbox.eq(i).parents('li').attr('data-id'),type:_checkbox.eq(i).parents('li').attr('data-type')});
		}
		_ajax({
		 	url:"<?php echo URL('User-Post/deleteMessage');?>",
		 	data:{id},
		 	success:function(msg){
		 		if(msg.msg=='success'){
		 			alert('删除成功！');
		 			_this.parents('li').remove();
		 		}else{
		 			alert('网络错误！');
		 		}
		 		
		 	}
		 	
		})

	}
//全选

	var flas=false;
	$(document).on('click','#qx',function(){
		if(!flas){
			$('#news_right .list.active li input[type=checkbox]').prop('checked',true);
			flas=true;
		}else{
			$('#news_right .list.active li input[type=checkbox]').prop('checked',false);
			flas=false;
		}
	});

</script><!--底部 end--></body></html>
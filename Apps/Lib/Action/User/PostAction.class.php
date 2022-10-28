<?php
/**
 *
 * PostAction.class.php (前台内容管理)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <web@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2011-03-01 yourphp.cn $
 */
if(!defined("Yourphp")) exit("Access Denied");
class PostAction extends BaseAction
{
    const USER_MESSAGE_READ = 2;
    const USER_MESSAGE_UNREAD = 1;
    const USER_MESSAGE_DELETE = 0;
    const SYSTEM_MESSAGE_READ = 1;
    const SYSTEM_MESSAGE_DELETE = 0;
    protected  $dao,$fields;
    public function _initialize()
    {
        parent::_initialize();
		$this->assign('jumpUrl',U('User/Login/index'));
		if(empty($this->Role[$this->_groupid]['allowpost'])){			
			$this->error(L('nologin'));
		}
		$this->assign('bcid',0);
		$this->moduleid=intval($_REQUEST['moduleid']);

		//权限判断
		// if(!in_array($this->_groupid,explode(',',$this->module[$this->moduleid]['postgroup']))) $this->error (L('add_no_postgroup'));
		if($this->moduleid){
			$this->assign ('moduleid',$this->moduleid);
			$module =$this->module[$this->moduleid]['name'];
			$this->dao = D($module);
			$fields = F($this->moduleid.'_Field');
			foreach($fields as $key => $res){
				if($res['unpostgroup']) $res['unpostgroup']=explode(',',$res['unpostgroup']);
				if(!in_array($this->_groupid,$res['unpostgroup'])  && $res['status']){
					$res['setup']=string2array($res['setup']);
					$this->fields[$key]=$res;
				}
			}
			unset($fields);
			unset($res);
			$this->assign ('fields',$this->fields);
		}
		 
    }

    /**
	 * 列表
	 *
	 */
    public function index()
    {
		if(!$this->_userid){
			$this->error(L('nologin'));
		}
		if($this->module[$this->moduleid]['type']==1){

				if($this->categorys){
					foreach ($this->categorys as $r){
						if($r['type']==1 || !in_array($this->_groupid, explode(',',$r['postgroup']))) continue;
						if($r['moduleid'] != $this->moduleid || $r['child']){
							$arr= explode(",",$r['arrchildid']);
							$show=0;
							foreach((array)$arr as $rr){
								if($this->categorys[$rr]['moduleid'] ==$this->moduleid) $show=1;
							}
							if(empty($show))continue;
							$r['disabled'] =  $r['child'] ? ' disabled' : '';
						}else{
							$r['disabled'] = '';
						}
						$array[] = $r;
					}
					import ( '@.ORG.Tree' );
					$str  = "<option value='\$id' \$disabled \$selected>\$spacer \$catname</option>";
					$tree = new Tree ($array);
					$select_categorys = $tree->get_tree(0, $str);
					$this->assign('select_categorys', $select_categorys);
					$this->assign('categorys', $this->categorys);
				}
				$this->assign('posids', F('Posid'));
		}

		import('@.Action.Adminbase');
		$c=new AdminbaseAction();		
		$module =$this->module[$this->moduleid]['name'];
		$map['userid']=array('eq',$this->_userid);
		if(APP_LANG)$map['lang'] =array('eq',$this->Lang[LANG_NAME][id]);
		$c->_list($module,$map);			
        $this->display ();
    }

	public function add()
    {
		$form=new Form();
		$form->isadmin=0;
		$form->doThumb  = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;
		$form->doAttach = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;;
		$this->assign ( 'form', $form );
		$module = $this->module[$this->moduleid]['name']; 
		$template =  file_exists(TMPL_PATH.'User/'.$this->sysConfig['DEFAULT_THEME'].'/'.$module.'_edit.html') ? $module.':edit' : 'Post:edit';
		$this->display ( $template);
	}


	public function edit()
    {
		if(!$this->_userid){
			$this->error(L('nologin'));
		}
		$id = intval($_REQUEST ['id']);		
		$vo = $this->dao->getById ( $id );
 		$form=new Form($vo);
		$form->isadmin=0;
		$form->doAttach= $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;;
		$form->doThumb  = $this->Role[$this->_groupid]['allowattachment'] ? 1 : 0;
		$this->assign ( 'vo', $vo );		
		$this->assign ( 'form', $form );
		$module = $this->module[$this->moduleid]['name']; 
		$template =  file_exists(TMPL_PATH.'User/'.$this->sysConfig['DEFAULT_THEME'].'/'.$module.'_edit.html') ? $module.':edit' : 'Post:edit';
		$this->display ( $template);
	}
	
	public function getPass()
	{
        $result = chksubmit(true,false,'num');
        if ($result){
            if ($result === -11){
                exit(json_encode(array('errno' => 1, 'msg' => '网络错误')));
            } elseif ($result === -12){
                exit(json_encode(array('errno' => 4, 'msg' => '验证码错误')));
            }
        } else {
            exit(json_encode(array('errno' => 1, 'msg' => '非法提交')));
        }
	    $username = trim(get_safe_replace($_REQUEST['username']));
	    $mobile = $_REQUEST['mobile'];
	    $verifyCode = $_REQUEST['verifyCode'];

	    # 验证图形验证码是否正确
	    if (md5($verifyCode) != $_SESSION['verify'])
	    {
	        exit(json_encode(array('errno' => 4, 'msg' => 'invalid verify code')));
	    }
        $sms_log = M("sms_log");

        $where =array();
        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $where['createtime'] = array('between',array($start,$end));
        $where['mobile'] = $mobile;
        $where['result']  = 0;
        $nums = $sms_log->where($where)->count();//获取今天内该手机号发送次数
        if($nums >= 20){
            exit(json_encode(array('errno' => 5, 'msg' => 'limit error')));

        }
	    $user = M('User')->where(array('username' => $username, 'mobile' => $mobile))->find();;
	    
	    # 判断对应的用户名和手机号码的用户是否存在
	    if ($user) 
	    {
	        # 生成10位随机密码
	        $password = substr(md5(mt_rand()), 2, 10);
	        # 构建发送短信参数
//	        $argv = array(
//	            'name'=>'qijiu',     //必填参数。用户账号
//	            'pwd'=>'3E27BD1D65E169DBD56233EEBF50',     //必填参数。（web平台：基本资料中的接口密码）
//	            'content'=>'【79招生网】尊敬的用户：您的新密码为:'.$password.'，请及时登录系统修改密码',   //必填参数。发送内容（1-500 个汉字）UTF-8编码
//	            'mobile'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
//	            'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
//	            'sign'=>'',    //必填参数。用户签名。
//	            'type'=>'pt',  //必填参数。固定值 pt
//	            'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
//	        );
//	        $params = '';
//	        foreach ($argv as $k => $v)
//	        {
//	            $params .= $k . '=' . urlencode($v) . '&';
//	        }
//	        $url = "http://web.daiyicloud.com/asmx/smsservice.aspx?".rtrim($params, '&');
//
//	        $result = file_get_contents($url);
//	        $con = substr($result, 0, 1);

            //阿里云短信
            $argv = array(
                'templateCode'=>'SMS_205131373',     //必填参数。用户账号
                'phone'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
                'code'=>  Array(  // 短信模板中字段的值
                    "password"=>$password,
                ),
            );
            $con = $this->sendSms($argv);
//            var_dump($con);
            $result = $con->Message == 'OK' ? 1 : 0;
            $data = array(
                'createtime' => time(),
                'result' => $result,
                'content' => '尊敬的用户：您的新密码为：'.$password.',请及时登录系统修改密码。',
                'mobile' => $mobile,
                'school' => '',
                'course' => '',
                'verify' => $password,
                'student' => '',
            );
            $res = $sms_log->add($data);
	        if ($result)
	        {
	            $user['password'] = sysmd5($password);
	            $userResult = M('User')->save($user);
	            if ($userResult)
	            {
	                # 修改成功
	                exit(json_encode(array('errno' => 0, 'msg' => 'success')));
	            }else {
	                # 数据更新失败
	                exit(json_encode(array('errno' => 1, 'msg' => 'system error')));
	            }
	        }else {
	            # 短信发送失败
	            exit(json_encode(array('errno' => 2, 'msg' => 'fail')));
	        }
	    }else {
	        # 用户不存在或用户名和手机号码不匹配
	        exit(json_encode(array('errno' => 3, 'msg' => 'invalid user')));
	    }
	}
	
    public function insert()
    {
    	//权限判断
		$c=A('Admin/Content');
		$_POST['ip'] = get_client_ip();

        $verifyCode  = !empty($_POST['verifyCode']) ? rtrim(strtolower($_POST['verifyCode'])) : '';
        $reqUrl = $_SERVER['HTTP_REFERER'];

        $telephone = get_safe_replace($_REQUEST['telephone']);
        $email = get_safe_replace($_REQUEST['email']);
        $content = get_safe_replace($_REQUEST['content']);
        $cord = get_safe_replace($_POST['cord']);
        $verify = get_safe_replace($_POST['verify']);

        $cord_moble=session('tel'.$telephone);

        if(!$telephone){
            $this->error(L('手机号码不能为空'),$reqUrl);
        };
        if(!check_Mobile($telephone)){
            $this->error(L('手机号码格式错误'),$reqUrl);
        };
//        if(!empty($email) && !check_Email($email)){
//            $this->error(L('邮箱格式错误'),$reqUrl);
//        };
        if(!$content){
            $this->error(L('请输入留言内容'),$reqUrl);
        };
        if(!$cord){
            $this->error(L('请输入手机验证码'),$reqUrl);
        };
        $sms_log = M("sms_log");
        $info = $sms_log->where(['mobile' => $telephone,'verify' => $cord_moble,'result' => 0])->order('createtime', 'desc')->find();
        if($info && (time() - $info['createtime'] > 60)){
            $this->error(L('手机验证码已过期'),$_SERVER["HTTP_REFERER"]);
        }
        if($cord!=$cord_moble){
            $this->error(L('手机验证码错误'),$_SERVER["HTTP_REFERER"]);
        }

        if($_SESSION['verify'] &&  md5($verify) != $_SESSION['verify']){
            $this->error(L('图形验证码错误'),$reqUrl);
            exit;
        }
        $list = M('blacklist')->field('ip')->where('status=1')->select();
        foreach ($list as $key => $val){
            $black[$key] =$val['ip'];
		}
//		echo '<pre>';
//		print_r($black);die;
        if (in_array($_POST['ip'], $black)){
            $this->success(L('添加成功！'),$_SERVER["HTTP_REFERER"]);
            exit;
        }

//		$count = M($this->module[$this->moduleid]['name'])->where("ip = '$_POST[ip]'")->count();
//
//         if ($count>5) {
//         	header("location:".getenv("HTTP_REFERER"));
//         	exit();
//         }
		$userid = $this->_userid;
		$username =  $this->_username ?  $this->_username : get_safe_replace($_POST['username']);
		$username =unicode_decode($username);
		$c->insert($this->module[$this->moduleid]['name'],$this->fields,$userid, $username,$this->_groupid);
		$subject = $_POST['title'];
		if(!$subject){
			$subject = $_POST['content'];
		}
		if(!$subject){
			$moduleTtitle =$this->module[$this->moduleid]['title'];
			$subject = $moduleTtitle;
		}
		$body = "";
		foreach ($this->fields as $key => $value) {
			$body .= '<div>'.$value['name'].'  :    '.$_POST[$key].'</div>';
		}
		$r = sendmail($this->Config[site_email],$subject,$body,$this->Config);
    }
	public function insert2()
    {
    	//权限判断

		$c=A('Admin/Content');
		$_POST['ip'] = get_client_ip();
		$ckid = get_safe_replace($_REQUEST['ckid']);
		$telephone = get_safe_replace($_REQUEST['telephone']);
		$uemail = get_safe_replace($_REQUEST['email']);
		$reqUrl = $_SERVER['HTTP_REFERER'];
        $cord = get_safe_replace($_POST['cord']);

        $cord_moble=session('tel'.$telephone);
        $verify = get_safe_replace($_POST['verify']);

		$ck_title = get_safe_replace($_REQUEST['kctitle']);
		$title = get_safe_replace($_POST['username']);
		$school = get_safe_replace($_REQUEST['project']);
		$school_user_id = intval(get_safe_replace($_REQUEST['school_user_id']));//当前课程的机构用户id
		$address = get_safe_replace($_REQUEST['address']);
		$form_content = get_safe_replace($_REQUEST['content']);



		if(!check_Mobile($telephone)){
            $this->error(L('手机号码格式错误'),$reqUrl);
            exit;
        };
        $sms_log = M("sms_log");
        $info = $sms_log->where(['mobile' => $telephone,'verify' => $cord_moble,'result' => 0])->order('createtime', 'desc')->find();
		if($info && (time() - $info['createtime'] > 60)){
            $this->error(L('手机验证码已过期'),$reqUrl);
		}

        if($cord!=$cord_moble){
            $this->error(L('手机验证码错误'),$reqUrl);
        }

        if($_SESSION['verify'] &&  md5($verify) != $_SESSION['verify']){
            $this->error(L('图形验证码错误'),$reqUrl);
            exit;
        }

        $kecheng_info = M('kecheng')->where('id='. $ckid)->find();
        if(!$kecheng_info){
            $this->error(L('该课程不存在'),$reqUrl);
            exit;
        }
        $schoolid = M('school')->where("id=".$kecheng_info['school_id'])->find();
        $project = $_REQUEST['kctitle'] = $kecheng_info['title'];
        $_POST['title'] = '预约报名';
        if($schoolid){
            $_POST['project'] = $schoolid['title'];
        }

        $userid = $this->_userid;//当前登录的用户id
		$username = get_safe_replace($_POST['username']);
		//判断是否使用优惠卷
		$coupons = get_safe_replace($_POST['coupons']);
		$name = get_safe_replace($_POST['username']);
		$tel = get_safe_replace($_POST['tel']);
//        if(!check_Mobile($tel)){
//            $this->error(L('学校联系手机号码格式错误'),$reqUrl);
//            exit;
//        };


		if($coupons==1){
			$verify = rand(123456, 999999);//获取随机验证码	
			$promotion = $verify;
			$_POST['promotion'] = $verify;
			//3r获取短信的优惠码
			
		}
		
		/**
		 * 验证一个手机号码是否已报名过该课程
		 * 如果已报名，则返回“无需重复报名”提示，不再重复写入新数据
		 */
		$feedback = M('Feedback')->where(['kcid' => $ckid, 'telephone' => $telephone])->count();
		if ($feedback)
		{
		    $this->success(L('本课程您已报名，无需重复报名！'),$_SERVER["HTTP_REFERER"]);
		    exit;
		}

		//判断是否登陆
		$c_userid = unicode_decode($userid);
		if($c_userid){
			$_POST['user'] = $c_userid;
			$_POST['userid'] = $c_userid;
		}
		
		$c->insert($this->module[$this->moduleid]['name'],$this->fields,$userid,$username,$this->_groupid,$schoolid['username']);
		$subject = $_POST['title'];
		
		$userck = M("user"); // 实例化User对象
		$user_collect = M('user')->where('id='.$userid)->find();
		
		$collect = explode(',', $user_collect['collect']);
		
		if(in_array($ckid, $collect)){
			
		}else{
			 // 要修改的数据对象属性赋值
			$data['collect'] = $user_collect['collect'].','.$ckid;
			$userck->where('id='.$userid)->save($data); // 根据条件保存修改的数据
		}
		
		if(!$subject){
			$subject = $_POST['content'];
		}
		if(!$subject){
			$moduleTtitle =$this->module[$this->moduleid]['title'];
			$subject = $moduleTtitle;
		}
		$body = "";
		foreach ($this->fields as $key => $value) {
			$body .= '<div>'.$value['name'].'  :    '.$_POST[$key].'</div>';
		}
		//判断是否使用优惠卷
		if($coupons==1){
//			$r2=$this->send_SMS($telephone,3,$verify);
//			$r3=$this->send_SMS($tel,4,$verify);
			//3r获取短信的优惠码
		}
		if ($userid)
		{
    		//1.发送成功系统消息
    		$b=A('User/Register');
    		$stitle = '您已成功报名-'.empty($project) ? $_REQUEST['project'] : $project;
    		$scontent = '恭喜你，成功！报名-"'.(empty($project) ? $_REQUEST['project'] : $project).'"课程。-【79教育平台】';
    		$b->get_messages($stitle,$scontent,$userid,$ckid);

    		//2.发送报名信息给该课程的学校
			$block_info = M('Block')->where(['lang' => 2, 'pos' => 'baoming_send_sysmess'])->find();//后台 碎片管理-学生报名咨询发送到机构账户中心系统消息

			$param_sys = array();
			$param_sys['code1']     = $title;
			$param_sys['code2']     = $ck_title;
			$param_sys['code3']     = $form_content;
			$param_sys['code4']     = $telephone;
			$param_sys['code5']     = $address;

			$stitle_other = '学员'.$title.'报名咨询';
			$scontent_other = ncReplaceText($block_info['content'],$param_sys);
			$b->get_messages($stitle_other,$scontent_other,$school_user_id,$ckid);
		}else{
			//游客用户
			//1.发送成功系统消息
			$userid = $school_user_id;
			$b=A('User/Register');
			$stitle = '您已成功报名-'.empty($project) ? $_REQUEST['project'] : $project;
			$scontent = '恭喜你，成功！报名-"'.(empty($project) ? $_REQUEST['project'] : $project).'"课程。-【79教育平台】';
			$b->get_messages($stitle,$scontent,$userid,$ckid);

			//2.发送报名信息给该课程的学校
			$block_info = M('Block')->where(['lang' => 2, 'pos' => 'baoming_send_sysmess'])->find();//后台 碎片管理-学生报名咨询发送到机构账户中心系统消息

			$param_sys = array();
			$param_sys['code1']     = $title;
			$param_sys['code2']     = $ck_title;
			$param_sys['code3']     = $form_content;
			$param_sys['code4']     = $telephone;
			$param_sys['code5']     = $address;

			$stitle_other = '学员'.$title.'报名咨询';
			$scontent_other = ncReplaceText($block_info['content'],$param_sys);
			$b->get_messages($stitle_other,$scontent_other,$school_user_id,$ckid);
		}

		$r = sendmail($this->Config[site_email],$subject,$body,$this->Config);
//		$r = sendmail('3208886054@qq.com',$subject,$body,$this->Config);//测试

		//发送手机短信 start
		//1.发送到学员手机
		$templateCode = 'SMS_254175123';
		$content = '报名咨询已发送，请等待老师回复';
		//阿里云短信
		$argv = array(
			'templateCode'=>$templateCode,     //必填参数。用户账号
			'phone'=>$telephone,   //必填参数。手机号码。多个以英文逗号隔开
			'code'=>  Array(  // 短信模板中字段的值
//				"code"=>$verify,
			),
		);
		$con = $this->sendSms($argv);
//        var_dump($con);die;
		$result = $con->Message == 'OK' ? 1 : 0;
		$file = dirname(APP_PATH) . '/Cache/Logs/sms_' . date('Y_m_d') . '.txt';
		$fdata = array(
			'time' => date('Y-m-d H:i:s'),
			'result' => $result,
			'content' => $content,
			'mobile' => $telephone,
			'school' => $school,
			'course' => $ck_title,
			'verify' => '',
			'student' => $title,
			'createtime' => time(),
		);
//        file_put_contents($file, var_export($fdata, true) . "\r\n", FILE_APPEND);

		$res = $this->sendSmsAddLog($fdata);

		//2.发送到机构手机
		//2.1.网上报名不发送短信手机号
		$block_not_send_sys = M('Block')->where(['lang' => 2, 'pos' => 'baoming_not_send_sys'])->find();//后台 碎片管理-网上报名不发送短信手机号
		if(!empty($schoolid['dianhua']) && $schoolid['dianhua'] != $block_not_send_sys['content']) {
			//如机构手机为18924037954，不发此短信
			$templateCode = 'SMS_254185135';
			$content = '有学员咨询，请登录账户查看详情';
			//阿里云短信
			$argv = array(
				'templateCode' => $templateCode,     //必填参数。用户账号
				'phone'=>$schoolid['dianhua'],   //必填参数。手机号码。多个以英文逗号隔开
				'code' => array(  // 短信模板中字段的值
//				"code"=>$verify,
				),
			);
			$con = $this->sendSms($argv);
//        var_dump($con);die;
			$result = $con->Message == 'OK' ? 1 : 0;
			$file = dirname(APP_PATH) . '/Cache/Logs/sms_' . date('Y_m_d') . '.txt';
			$fdata = array(
				'time' => date('Y-m-d H:i:s'),
				'result' => $result,
				'content' => $content,
				'mobile' => $schoolid['dianhua'],
				'school' => $school,
				'course' => $ck_title,
				'verify' => '',
				'student' => $title,
				'createtime' => time(),
			);
//        file_put_contents($file, var_export($fdata, true) . "\r\n", FILE_APPEND);

			$res = $this->sendSmsAddLog($fdata);
		}
		//发送手机短信 end

		if($r){
//			$this->assign('jumpUrl',"javascript:history.back(-1);");
//			$this->assign('waitSecond','1');
//			$this->assign('message','报名成功！');
//			$this->display(C('TMPL_ACTION_SUCCESS'));
			$this->success(L('报名成功！'),$_SERVER["HTTP_REFERER"]);
			exit;
		}
		//修改关注度
		
		if ($ckid > 0)
		{
    		$sql = 'update `mqu_kecheng` set `guanzhu`=`guanzhu`+1 where `id`='.$ckid;
    		M()->query($sql);
		}
    }
	function update()
	{  
		if(!$this->_userid){
			$this->error(L('nologin'));
		}
		if($this->moduleid!=6 && !in_array($this->_groupid,explode(',',$this->categorys[$_POST['catid']]['postgroup']))) $this->error (L('add_no_postgroup'));

		$c=A('Admin/Content');
		$c->update($this->module[$this->moduleid]['name'],$this->fields);
	}
	
 	public function industry()
    {
		$schoolid=M('Category')->where("parentid=".$_REQUEST['industry'])->select();
		exit(json_encode($schoolid));
    }
    
	/**
	 * 获取系统消息信息列表
	 * 
	 * @param int p    页码
	 * @param int type 类型：1-未读；2-全部
	 */
	public function getMessageList()
	{
	    $user = M('User')->find($this->_userid);
	    
	    $type = $_REQUEST['type'];
	    // 1 未读，2全部
	    $type = $type==1 ? $type : 2;
	    
	    $user['message'] = trim($user['message']);
	    $user['sysmessage'] = trim($user['sysmessage']);
	    
	    
	    if($type==1)
	    {
	    	$uMessageSql = 'select messageid from mqu_user_message where userid='.$this->_userid;
	        $csql = 'select count(1) as count from mqu_message where id not in('.$uMessageSql.')';
	        $sysSql = 'select count(1) as count from mqu_system where `status`=1 AND `userid`='.$this->_userid.' AND `type`='.self::USER_MESSAGE_UNREAD;
	    }else {
	    	$uMessageSql = 'select messageid from mqu_user_message where `status`=1 AND userid='.$this->_userid.' AND `type`='.self::SYSTEM_MESSAGE_DELETE;
	        $csql = 'select count(1) as count from mqu_message where id not in('.$uMessageSql.')';
	        $sysSql = 'select count(1) as count from mqu_system where `userid`='.$this->_userid.' AND `type`<>'.self::USER_MESSAGE_DELETE;
	    }
	    
	    $cquery = mysql_query($csql);
	    $sysQuery = mysql_query($sysSql);
	    $count1 = 0;
	    $count2 = 0;
	    if($crow = mysql_fetch_assoc($cquery))
	    {
	        $count1 += $crow['count'];
	    }
	    if ($sysRow = mysql_fetch_assoc($sysQuery))
	    {
	        $count2 = $sysRow['count'];
	    }
	    
	    $count = $count1 + $count2;
	    
	    $select = 'id,status,userid,username,url,listorder,createtime,updatetime,lang,title,content';
	    
	    if($type==1)
	    {
	        $sql = 'select '.$select.',1 as mtype from mqu_message where id not in('.$uMessageSql.')'
	            .' union '
	            .'select '.$select.',2 as mtype from mqu_system where `type`='.self::USER_MESSAGE_UNREAD.' AND `status`=1 AND `userid`='.$this->_userid
	            .' order by createtime desc';
	    }else {
	        $sql = 'select '.$select.',1 as mtype from mqu_message where id not in('.$uMessageSql.')'
	           .' union '
	            .'select '.$select.',2 as mtype from mqu_system where `type`<>'.self::USER_MESSAGE_DELETE.' AND `status`=1 AND `userid`='.$this->_userid
	            .' order by createtime desc';
	    }
//	    echo $sql;
	    
	    import ( "@.ORG.Page" );
	    $page = new Page($count, 10);
	    $page->urlrule = 'javascript:void(0);';
	    $pages = $page->show();
	    $sql .= ' limit '.$page->firstRow.','.$page->listRows;
	    
	    $query = mysql_query($sql);
	    $result = array();
	    while($row = mysql_fetch_assoc($query))
	    {
	        $result[] = $row;
	    }
	    
	    exit(json_encode(array('errno'=>0, 'data'=>$result, 'pages'=>$pages, 'count'=>$count)));
	}
	
	/**
	 * 修改消息状态，将消息置已读状态
	 * 
	 * @param int id	消息的id，必传
	 * @param int type	消息类型：1-系统消息（message）；2-用户消息(system)；默认为2-用户消息
	 */
	public function changeMessageStatus()
	{
		if(!$this->_userid)
		{
			// 未登录，需要先登录再操作
			exit(json_encode(array('islogin'=>0,'errno'=>3, 'msg'=>'please login first')));
		}
		$type = intval($_REQUEST['type']);
		$type = $type==2 ? $type : 1;
		$id = intval($_REQUEST['id']);
		
		if($id > 0)
		{
			$module = $type==1 ? 'Message' : 'System';
			if($type == 1)
			{
				$data = array('userid'=>$this->_userid,'username'=>$this->_username,'messageid'=>$id, 'type'=>self::SYSTEM_MESSAGE_READ);
				$model = M('User_message');
				$edata = $model->where(array('messageid'=>$id, 'userid'=>$this->_userid))->find();
				if (empty($edata)) 
				{
				    if($model->create($data))
				    {
				        $result = $model->add();
				    }else {
				        $result = false;
				    }
				}else {
				    $result = true;
				}
			}else {
			    $result = M('System')->where(array('id'=>$id, 'userid'=>$this->_userid, 'type'=>self::USER_MESSAGE_UNREAD))->save(array('type'=>self::USER_MESSAGE_READ));
			}
			
			if($result !== false)
			{
				// 修改成功
				exit(json_encode(array('errno'=>0, 'msg'=>'success')));
			}else {
				// 修改失败
				exit(json_encode(array('errno'=>1, 'msg'=>'fail')));
			}
		}else {
			// 参数错误，id需要大于0
			exit(json_encode(array('errno'=>2, 'msg'=>'invalid parameter')));
		}
	}
	
	/**
	 * 用户删除消息
	 *
	 * @param int id	消息的id，必传
	 * @param int type	消息类型：1-系统消息（message）；2-用户消息(system)；默认为2-用户消息
	 */
	public function deleteMessage()
	{
	    if(!$this->_userid)
	    {
	        // 未登录，需要先登录再操作
	        exit(json_encode(array('islogin'=>0,'errno'=>3, 'msg'=>'please login first')));
	    }
	    
	    $id = is_array($_REQUEST['id']) ? $_REQUEST['id'] : (json_decode($_REQUEST['id']) ? json_decode($_REQUEST['id']) : intval($_REQUEST['id']));
	    
	    if (is_array($id))
	    {
	        $sysmid = array();
	        $usermid = array();
	        foreach ($id as $k => $v)
	        {
	            if ($v['type'] == 1)
	            {
	                $sysmid[] = $v['id'];
	            }else {
	                $usermid[] = $v['id'];
	            }
	        }
	        
	        $sysResult = $sysmid ? $this->deleteSystemMessage($sysmid) : true;
	        $userResult = $usermid ? $this->deleteUserMessage($usermid) : true;
	        
	        if ($sysResult || $userResult)
	        {
	            // 删除成功
	            exit(json_encode(array('errno'=>0, 'msg'=>'success')));
	        }else {
	            // 删除失败
	            exit(json_encode(array('errno'=>1, 'msg'=>'fail')));
	        }
	    }elseif ($id > 0) {
	        $type = intval($_REQUEST['type']);
	        $type = $type==2 ? $type : 1;
	        $result = $type==2 ? $this->deleteUserMessage([$id]) : $this->deleteSystemMessage([$id]);
	        
	        if($result !== false)
	        {
	            // 删除成功
	            exit(json_encode(array('errno'=>0, 'msg'=>'success')));
	        }else {
	            // 删除失败
	            exit(json_encode(array('errno'=>1, 'msg'=>'fail')));
	        }
	    }else {
	        // 参数错误，id需要大于0
	        exit(json_encode(array('errno'=>2, 'msg'=>'invalid parameter')));
	    }
	}
	
	/**
	 * 消息用户的系统消息
	 * 
	 * @param array $id    需要删除的消息的id集合
	 * @return boolean
	 */
	private function deleteSystemMessage($id)
	{
	    $model = M('User_message');
	    $edata = $model->where(array('messageid'=>array('in', $id), 'userid'=>$this->_userid))->select();
	    $flipId = array_flip($id);
	    $update = array();
	    foreach ($edata as $k => $v)
	    {
	        if (!$v['type'])
	        {
	            $update[] = $v['id'];
	        }
	        unset($flipId[$v['id']]);
	    }
	    
	    $updateResult = true;
	    $insertResult = true;
	    if ($update)
	    {
	        $updateResult = $model->where(array('id'=>array('in', $update)))->save(array('type'=>self::SYSTEM_MESSAGE_DELETE));
	    }
	    if ($flipId)
	    {
	        $insert = array();
	        foreach ($flipId as $k => $v) 
	        {
	            $insert[] = array(
	                'userid'=>$this->_userid,
	                'username'=>$this->_username,
	                'messageid'=>$k, 
	                'status'=>1, 
	                'lang' => 1,
	                'type'=>self::SYSTEM_MESSAGE_DELETE
	            );
	        }
	        if($model->create($insert))
	        {
	        	$insertResult = $model->addAll($insert);
	        }
	    }
	    
	    if($updateResult || $insertResult)
	    {
	        return true;
	    }else {
	        return false;
	    }
	}
	
	/**
	 * 删除用户的消息
	 * 
	 * @param array $id    需要删除的消息的id集合
	 * @return boolean
	 */
	private function deleteUserMessage($id)
	{
	    $model = M('System');
	    $edata = $model->where(array('id'=>array('in', $id),'userid'=>$this->_userid))->select();
	    $flipId = array_flip($id);
	    $update = array();
	    
	    foreach($edata as $k => $v)
	    {
	        if (!$v['type'])
	        {
	            unset($flipId[$v['id']]);
	        }elseif (!$v['status']) {
	            continue ;
	        }
	    }
	    
	    $result = true;
	    if ($flipId)
	    {
	        $where = array(
	            'id'=>array('in', array_flip($flipId)),
	            'status'=>1, 
	            'type'=>array('not in',array(self::USER_MESSAGE_DELETE)),
	            'userid'=>$this->_userid
	        );
	        $result = $model->where($where)->save(array('type'=>self::USER_MESSAGE_DELETE));
	    }
	    
	    return $result !== false ? true : false;
	}
	
	/**
	 * 根据消息id和消息类型，删除用户的指定消息
	 * 
	 * @deprecated
	 * @param int $id  消息id
	 * @param int $type    消息类型：1-系统消息；2-用户消息
	 * @return boolean
	 */
	private function deleteOneMessage($id, $type)
	{
	    $module = $type==1 ? 'Message' : 'System';
	    if($type == 1)
	    {
	        $data = array('userid'=>$this->_userid,'username'=>$this->_username,'messageid'=>$id, 'status'=>1, 'type'=>self::SYSTEM_MESSAGE_DELETE);
	        $model = M('User_message');
	        $edata = $model->where(array('messageid'=>$id, 'userid'=>$this->_userid))->find();
	        if (empty($edata))
	        {
	            if($model->create($data))
	            {
	                $result = $model->add();
	            }else {
	                $result = false;
	            }
	        }else {
	            if ($edata['type'] != self::SYSTEM_MESSAGE_DELETE)
	            {
	                $result = $model->where(array('id'=>$edata['id']))->save(array('type'=>self::SYSTEM_MESSAGE_DELETE));
	            }else {
	                $result = true;
	            }
	        }
	    }else {
	        $result = M('System')->where(array('id'=>$id, 'userid'=>$this->_userid, 'type'=>array('neq',self::USER_MESSAGE_DELETE)))->save(array('type'=>self::USER_MESSAGE_DELETE));
	    }
	    
	    return $result;
	}
	
	/**
	 * 上传机构信息图片
	 */
	public function uploadOrgImage()
	{
	    if (!$this->_userid)
	    {
	        exit(json_encode(array('errno'=>2, 'msg'=>'please login first')));
	    }
		import('@.ORG.UploadFile');
		$upload = new UploadFile();
		//$upload->supportMulti = false;
		$upload->autoSub = true;
		$upload->subType = 'date';
		$upload->dateFormat = 'Ym';
		//设置上传文件类型
		$upload->allowExts = array('jpg', 'jpeg','png');
		//设置附件上传目录
		$upload->savePath = UPLOAD_PATH;
		//设置上传文件规则
		$upload->saveRule = uniqid;
		
		
		//删除原图
		$upload->thumbRemoveOrigin = true; 
		if (!$upload->upload()) {
		    $this->ajaxReturn(0,$upload->getErrorMsg(),0);
		}else {
		    //取得成功上传的文件信息
		    $uploadList = $upload->getUploadFileInfo();
		    
		    
		    if($_REQUEST['addwater']){ //$this->Config['watermark_enable']  $_REQUEST['addwater']
		        import("@.ORG.Image");
		        Image::watermark($uploadList[0]['savepath'].$uploadList[0]['savename'],'',$this->Config);
		    }
		    
		    $img = __ROOT__.substr($uploadList[0]['savepath'].strtolower($uploadList[0]['savename']),1);
		    
		    $user = M('User')->field('orgpics')->find($this->_userid);
		    $user['orgpics'] = $user['orgpics'] ? $user['orgpics'] : '';
		    $user['orgpics'] .= ':::' 
		                      .  $img
		                      . '|' . strtolower($uploadList[0]['savename']);
		    $result = M('User')->where(array('id'=>$this->_userid))->save(array('orgpics'=>trim($user['orgpics'], ':::')));
		    
		    if ($result !== false)
		    {
		        exit(json_encode(array('errno'=>0, 'msg'=>'success', 'img'=>$img)));
		    }else {
		        exit(json_encode(array('errno'=>1, 'msg'=>'fail')));
		    }
		}
	}	
	
	/**
	 * 删除机构信息图片
	 */
	public function deleteOrgImage()
	{
	    if (!$this->_userid)
	    {
	        exit(json_encode(array('errno'=>2, 'msg'=>'please login first')));
	    }
	    
	    $img = $_REQUEST['img'];
	    if (empty($img))
	    {
	        exit(json_encode(array('errno'=>3, 'msg'=>'invalid parameter')));
	    }
	    
	    $user = M('User')->field('orgpics')->find($this->_userid);
	    $images = explode(':::', $user['orgpics']);
	    foreach ($images as $k => $v)
	    {
	        if (strpos($v, $img) !== false)
	        {
	            unset($images[$k]);
	        }
	    }
	    
	    $result = M('User')->where(array('id'=>$this->_userid))->save(array('orgpics'=>implode(':::', $images)));
	    
	    if ($result !== false)
	    {
	        exit(json_encode(array('errno'=>0, 'msg'=>'success', 'img'=>$img)));
	    }else {
	        exit(json_encode(array('errno'=>1, 'msg'=>'fail')));
	    }
	}
	
	public function uploadImage()
	{
	    require_once './umeditor/php/Uploader.class.php';
	    header("Content-Type:text/html;charset=utf-8");
	    error_reporting( E_ERROR | E_WARNING );
	    date_default_timezone_set("Asia/chongqing");
	    include "Uploader.class.php";
	    //上传配置
	    $config = array(
	        "savePath" => "upload/" ,             //存储文件夹
	        "maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
	        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
	    );
	    //上传文件目录
	    $Path = "./Uploads/";
	    
	    //背景保存在临时目录中
	    $config[ "savePath" ] = $Path;
	    $up = new Uploader( "upfile" , $config );
	    $type = $_REQUEST['type'];
	    $callback=$_GET['callback'];
	    
	    $info = $up->getFileInfo();
	    /**
	     * 返回数据
	     */
	    if($callback) {
	        echo '<script>'.$callback.'('.json_encode($info).')</script>';
	    } else {
	        echo json_encode($info);
	    }
	}

    /**
     *
     *发送短信
     * @access send_SMS
     * @param $tels 手机号码
     * @param $site 类型 1是注册，2是登陆，3是报名用户收到短信,4是报名机构收到短信 5是报名咨询短信 6是信息反馈留言短信
	 * @param $verify
     * @return void
     */
    public function send_SMS($tels='', $site = 0, $verify='')
    {
        $ajax = isset($_REQUEST['ajax'] ) ? $_REQUEST['ajax'] : 0;
        $result = chksubmit(true,false,'num');
        if ($result){
            if ($result === -11){
                $ajax==1 ? $this->ajaxreturn(0,'网络错误',0) : $this->error(L('网络错误'));
            } elseif ($result === -12){
                $ajax==1 ? $this->ajaxreturn(0,'验证码错误',0) : $this->error(L('验证码错误'));
            }
        } else {
            $ajax==1 ? $this->ajaxreturn(0,'非法提交',0) : $this->error(L('非法提交'));
        }
    	if($ajax == 1){
            $tels = $_REQUEST['mobile'];
            $site = $_REQUEST['site'];
            $verifys = $_REQUEST['verify'];
            $verify = rand(123456, 999999);//获取随机验证码
        }
        if(!check_Mobile($tels)){
            $notice = L('手机号码格式错误');
            $ajax==1 ? $this->ajaxReturn(0,$notice,0) : $this->error($notice);
            exit;
        };
        if($_SESSION['verify'] &&  md5($verifys) != $_SESSION['verify']){
            $ajax==1 ? $this->ajaxReturn(0,L('图形验证码错误'),0) : $this->error(L('图形验证码错误'));
            exit;
        }
        $cord_moble=session('tel'.$tels);
        $sms_log = M("sms_log");
        $info = $sms_log->where(['mobile' => $tels,'verify' => $cord_moble,'result' => 0])->order('createtime', 'desc')->find();
        if($info && (time() - $info['createtime'] < 60)){
            $ajax==1 ? $this->ajaxReturn(0,L('手机验证码发送过于频繁'),0) : $this->error(L('手机验证码发送过于频繁'));
        }

        $real_ip = get_client_ip();
        $list = M('blacklist')->field('ip')->where('status=1')->select();
        foreach ($list as $key => $val){
            $black[$key] =$val['ip'];
        }

        if (in_array($real_ip, $black)){
            $ajax==1 ? $this->ajaxReturn(1,'发送短信成功',1) : $this->success(L('发送短信成功'));
        }

        $where =array();
        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $where['createtime'] = array('between',array($start,$end));
//        $where['mobile'] = $tels;
        $where['ip']  = $real_ip;
        $nums = $sms_log->where($where)->count();//获取今天内该手机号发送次数
        if($nums >= 20){
            $ajax==1 ? $this->ajaxReturn(0,L('今天你已经获取多次验证码，发送失败'),0) : $this->error(L('今天你已经获取多次验证码，发送失败'));
            exit;
        }

        header("Content-Type: text/html; charset=UTF-8");
        $flag = 0;
        $params = '';//要post的数据
        $content = '';
        $mobile = $tels;//手机号
        $sdudy = get_safe_replace($_REQUEST['telephone']);//学生手机号
        $ck_title = get_safe_replace($_REQUEST['kctitle']);
        $title = get_safe_replace($_POST['username']);
        $school = get_safe_replace($_REQUEST['project']);
        $templateCode = 'SMS_205126094';//默认
        if ($site) {
            if ($site == 1) {
                $content = '【79招生网】尊敬的用户:您的注册验证码是' . $verify . '，请在30分钟内完成注册。（柒玖教育）';
            } elseif ($site == 2) {
                $content = '短信验证码为：' . $verify . '，请勿将验证码提供给他人。';
            } elseif ($site == 3) {
                $content = '【79招生网】' . $title . '学员：报名' . $school . '学校' . $ck_title . '课程，稍后老师联系您，凭此编码' . $verify . '可按网上优惠价报名缴费';
        	} elseif ($site == 4) {
                $content = '【79招生网】学员' . $title . '，报名' . $ck_title . '课程，手机' . $sdudy . '，报名编码' . $verify . '，请及时联系';
            } elseif ($site == 5) {
            	$templateCode = 'SMS_205126094';
                $content = '您的验证码'.$verify.'，该验证码5分钟内有效，请勿泄漏于他人！';
            } elseif ($site == 6) {
                $templateCode = 'SMS_205126089';
                $content = '您的验证码：'.$verify.'，您正进行身份验证，打死不告诉别人！';
            }

        }

        //以下信息自己填以下


//        $encode = mb_detect_encoding($content, array("ASCII", 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
//        if ($encode != 'UTF-8') {
//            $content = mb_convert_encoding($content, 'UTF-8', $encode);
//        }
//
//        $argv = array(
//            'name' => 'qijiu',     //必填参数。用户账号
//            'pwd' => '3E27BD1D65E169DBD56233EEBF50',     //必填参数。（web平台：基本资料中的接口密码）
//            'content' => $content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
//            'mobile' => $mobile,   //必填参数。手机号码。多个以英文逗号隔开
//            'stime' => '',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
//            'sign' => '柒玖教育',    //必填参数。用户签名。
//            'type' => 'pt',  //必填参数。固定值 pt
//            'extno' => ''    //可选参数，扩展码，用户定义扩展码，只能为数字
//        );
////        print_r($argv);exit;
//        //构造要post的字符串
//        //echo $argv['content'];
//        foreach ($argv as $key => $value) {
//            if ($flag != 0) {
//                $params .= "&";
//                $flag = 1;
//            }
//            $params .= $key . "=";
//            $params .= urlencode($value);// urlencode($value);
//            $flag = 1;
//        }
//        $url = "http://web.daiyicloud.com/asmx/smsservice.aspx?" . $params; //提交的url地址
//
//        $result = file_get_contents($url);
//        $con = substr($result, 0, 1);  //获取信息发送后的状态

        //阿里云短信
        $argv = array(
            'templateCode'=>$templateCode,     //必填参数。用户账号
            'phone'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
            'code'=>  Array(  // 短信模板中字段的值
                "code"=>$verify,
            ),
        );
        $con = $this->sendSms($argv);
//        var_dump($con);die;
        $result = $con->Message == 'OK' ? 1 : 0;
        $file = dirname(APP_PATH) . '/Cache/Logs/sms_' . date('Y_m_d') . '.txt';
        $fdata = array(
            'time' => date('Y-m-d H:i:s'),
            'result' => $result,
            'content' => $content,
            'mobile' => $mobile,
            'school' => $school,
            'course' => $ck_title,
            'verify' => $verify,
            'student' => $title,
			'createtime' => time(),
        );
//        file_put_contents($file, var_export($fdata, true) . "\r\n", FILE_APPEND);

        $sms_log = M("sms_log");


        $res = $sms_log->add($fdata);
        if(!$result){
            if($ajax ==1){
                $this->ajaxreturn(0,'发送短信失败',0);//失败
            }
            echo "<script>alert('发送短信失败!');history.back();</script>";
        }else{
            //成功
            session('tel'.$mobile, $verify);
            if($ajax ==1){
                $this->ajaxReturn(1,'发送短信成功',1);
            }
            echo "<script>alert('发送短信成功!');history.back();</script>";
        }
    }

	//阿里云发送短信添加手机验证码记录表
	public function sendSmsAddLog($data)
	{
		$sms_log = M("sms_log");
		$res = $sms_log->add($data);
		return $res;
	}

}
?>

<?php
/**
 * 
 * User/LoginAction.class.php (前台会员登陆)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <admin@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2011-03-01 yourphp.cn $
 */
if(!defined("Yourphp")) exit("Access Denied");
class LoginAction extends BaseAction
{
	
	function _initialize()
    {
		parent::_initialize();
		$this->dao = M('User');
		$this->assign('bcid',0);
    }
    function index()
    {
		if($this->_userid){		
			$forward = $_POST['forward'] ? $_POST['forward'] :$this->forward ;
			$this->assign('jumpUrl',$forward);
			$this->success(L('login_ok'));exit;
		}
		
        $this->display();
    }
 
	function dologin()
	{
		$username = get_safe_replace($_POST['username']);
        $password = get_safe_replace($_POST['password']);
        $verifyCode = get_safe_replace($_POST['verifyCode']);
        $verify = get_safe_replace($_POST['verify']);

        if(empty($username) || empty($password)){
           $this->error(L('empty_username_empty_password'));
        }
		
		if($this->member_config['member_login_verify'] && md5($verifyCode) != $_SESSION['verify']){
           $this->error(L('error_verify'));
        }

		 $authInfo = $this->dao->getByUsername($username);
        //使用用户名、密码和状态的方式进行认证
        if(empty($authInfo)) {
            $this->success(L('empty_userid'));
        }else {
            if($authInfo['password'] != sysmd5($_POST['password'])) {
            	$this->error(L('password_error'));
            }
			if($authInfo['status'] != 1)$this->error(L('ACCOUNT_DISABLE'),'/User/Login');

			$cookietime =  intval($_REQUEST['cookietime']);
			$cookietime = $cookietime ? $cookietime : 0;

			$yourphp_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'].$_SERVER['HTTP_USER_AGENT']);
			$yourphp_auth = authcode($authInfo['id']."-".$authInfo['groupid']."-".$authInfo['password'], 'ENCODE', $yourphp_auth_key);

			cookie('auth',$yourphp_auth,$cookietime);
			cookie('username',$authInfo['username'],$cookietime);
			cookie('groupid',$authInfo['groupid'],$cookietime);
			cookie('userid',$authInfo['id'],$cookietime);
			cookie('email',$authInfo['email'],$cookietime);
			cookie('user',$authInfo['user'],$cookietime);
            //保存登录信息
			$dao = M('User');
			$data = array();
			$data['id']	=	$authInfo['id'];
			$data['last_logintime']	=	time();
			$data['last_ip']	=	 get_client_ip();
			$data['login_count']	=	array('exp','login_count+1');
			$dao->save($data);
			
 			$forward = $_POST['forward'] ? $_POST['forward'] :$this->forward ;			
			$this->assign('jumpUrl',$forward);
			$this->success(L('login_ok'),'/User/Index');
		}
 
	}

	function getpass(){
		$this->display();
	}

	function repassword(){
		if($_POST['dosubmit']){
			$verifyCode = trim($_POST['verify']);
//			if(md5($verifyCode) != $_SESSION['verify']){
//			   $this->error(L('error_verify'));
//			}
			if(trim($_POST['repassword'])!=trim($_POST['password'])){
				$this->error(L('password_repassword'));
			}
			list($userid,$username, $email) = explode("-", authcode($_POST['code'], 'DECODE', $this->sysConfig['ADMIN_ACCESS']));
			$user = M('User');
			//判断邮箱是用户是否正确
			$data =$user->where("id={$userid} and username='{$username}'")->find();
			if($data){
				$user->password	= sysmd5(trim($_POST['password']));
				$user->updatetime = time();
				$user->last_ip = get_client_ip();
				$user->save();
				$this->assign('jumpUrl',U('User/login/index'));
				$this->assign('waitSecond',3);
				$this->success(L('do_repassword_success'));
			}else{
				$this->error(L('check_url_error'));
			}
			exit;
		
		}
		$code = str_replace(' ','+',$_REQUEST['code']);
		$this->assign('code',$code);
		$this->display();
	}
 

	function sendmail(){
		$verifyCode = trim($_POST['verifyCode']);
		$username = get_safe_replace($_POST['username']);
		$email = get_safe_replace($_POST['email']);


        if(empty($username) || empty($email)){
           $this->error(L('empty_username_empty_password'));
        }elseif(md5($verifyCode) != $_SESSION['verify']){
           $this->error(L('error_verify'));
        }

		$user = M('User');
		//判断邮箱是用户是否正确
		$data =$user->where("username='{$username}' and email='{$email}'")->find();
		if($data){
			$yourphp_auth = authcode($data['id']."-".$data['username']."-".$data['email'], 'ENCODE',$this->sysConfig['ADMIN_ACCESS'],3600*24*3);//3天有效期
			$username=$data['username'];
			$url =  'http://'.$_SERVER['HTTP_HOST'].U('User/Login/repassword?code='.$yourphp_auth);
			$message = str_replace(array('{username}','{url}','{sitename}'),array($username,$url,$this->Config['site_name']),$this->member_config['member_getpwdemaitpl']);

			$r = sendmail($email,L('USER_FORGOT_PASSWORD').'-'.$this->Config['site_name'],$message,$this->Config); 
			if($r){
				$returndata['username'] = $data['username'];
				$returndata['email'] = $data['email'];
				$this->ajaxReturn($returndata,L('USER_EMAIL_ERROR'),1);
			}else{
				$this->ajaxReturn(0,L('SENDMAIL_ERROR'),0);
			}
		}else{
			$this->ajaxReturn(0,L('USER_EMAIL_ERROR'),0);
		}
		//$this->ajaxReturn(1,L('login_ok'),1);
	}


	function emailcheck(){
		 
		if(!$this->_userid && !$this->_username && !$this->_groupid && !$this->_email){
			$this->assign('forward','');
			$this->assign('jumpUrl',U('User/Login/index'));
			$this->success(L('noogin'));exit;
		}

		if($_REQUEST['resend']){
			$uid=$this->_userid;
			$username = $this->_username;
			$email = $this->_email;
			if($this->member_config['member_emailcheck']){
						$yourphp_auth = authcode($uid."-".$username."-".$email, 'ENCODE',$this->sysConfig['ADMIN_ACCESS'],3600*24*3);//3天有效期
						$url = 'http://'.$_SERVER['HTTP_HOST'].U('User/Login/regcheckemail?code='.$yourphp_auth);
						$click = "<a href=\"$url\" target=\"_blank\">".L('CLICK_THIS')."</a>";
						$message = str_replace(array('{click}','{url}','{sitename}'),array($click,$url,$this->Config['site_name']),$this->member_config['member_emailchecktpl']);
						$r = sendmail($email,L('USER_REGISTER_CHECKEMAIL').'-'.$this->Config['site_name'],$message,$this->Config);
						$this->assign('send_ok',1);
						$this->assign('username',$username);
						$this->assign('email',$email);
						$this->display();
						exit;
			}
		}
		if($this->_groupid==5){
			$this->display();
		}else{
			$this->error(L('do_empty'));
		}	
	}
	
	function regcheckemail(){
			$code = str_replace(' ','+',$_REQUEST['code']); 
			list($userid,$username, $email) = explode("-", authcode($code, 'DECODE', $this->sysConfig['ADMIN_ACCESS'])); 
			$user = M('User');
			//判断邮箱是用户是否正确
			$data =$user->where("id={$userid} and username='{$username}' and email='{$email}'")->find();
			if($data){
				$user->groupid = 3;
				$user->id = $userid;
				$user->save();
				$ru['role_id']=3;
				$roleuser=M('RoleUser');
				$roleuser->where("user_id=".$userid)->save($ru);
				$this->assign('jumpUrl',U('User/Login/index'));
				$this->assign('waitSecond',10);
				$this->success(L('do_regcheckemail_success'));
			}else{
				$this->error(L('check_url_error'));
			}
	}
 	function dologin2()
    {
    	//短信报名
		$phone = get_safe_replace($_REQUEST['phone']);
		$reqUrl = $_SERVER['HTTP_REFERER'];
		
		$verifyCode=$_REQUEST['verifyCode'];
		if(md5($verifyCode) != $_SESSION['verify']){
          $this->error(L('验证码错误'));
        }
        // 判断短信验证码是否正确
        if (session('tel'.$phone) != $_REQUEST['verify'])
        {
        	$this->error(L('短信验证码错误'));
        }
        $rephone = M('user')->where(array('mobile'=>$phone))->find();
        
        
		$yourphp_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'].$_SERVER['HTTP_USER_AGENT']);

        
        if($rephone)
        {
			$yourphp_auth = authcode($rephone['id']."-".$rephone['groupid']."-".$rephone['password'], 'ENCODE', $yourphp_auth_key);
        	cookie('auth',$yourphp_auth,$cookietime);
			cookie('username',$rephone['username'],$cookietime);
			cookie('groupid',$rephone['groupid'],$cookietime);
			cookie('userid',$rephone['id'],$cookietime);
			cookie('email',$rephone['email'],$cookietime);
			cookie('user',$rephone['user'],$cookietime);
			//保存登录信息
			$dao = M('User');
			$data = array();
			$data['id']	=	$authInfo['id'];
			$data['last_logintime']	=	time();
			$data['last_ip']	=	 get_client_ip();
			$data['login_count']	=	array('exp','login_count+1');
			$dao->save($data);
        }else{
        	 //创建用户信息
			$dao = M('User');
			$data = array();
			$data['username']	=	$phone;
			$data['mobile'] = $phone;
			$data['user'] = 0;
			$data['last_logintime']	=	time();
			$data['last_ip']	=	 get_client_ip();
			$data['login_count']	=	1;
			$id = $dao->add($data);
			//保存用户信息
			$yourphp_auth = authcode($id."-0-", 'ENCODE', $yourphp_auth_key);
			cookie('auth',$yourphp_auth,$cookietime);
			cookie('username',$phone,$cookietime);
			cookie('groupid',3,$cookietime);
			cookie('userid',$id,$cookietime);
			cookie('email','',$cookietime);
			cookie('user',0,$cookietime);
 			$forward = $_POST['forward'] ? $_POST['forward'] :$this->forward ;			
			$this->assign('jumpUrl',$forward);
			
        }$this->success(L('login_ok'),'/');
    }
    
	function login_SMS()
    {
        $result = chksubmit(true,false,'num');
        if ($result){
            if ($result === -11){
                $this->ajaxreturn(0,'网络错误',0);
            } elseif ($result === -12){
                $this->ajaxreturn(0,'验证码错误',0);
            }
        } else {
            $this->ajaxreturn(0,'非法提交',0);
        }
    	$phone = get_safe_replace($_REQUEST['phone']);
		$flag = 0; 
		$params='';//要post的数据 
		$verify = rand(123456, 999999);//获取随机验证码		
		$content='您的验证码为：';
        if(!check_Mobile($phone)){
            $this->ajaxreturn(0,L('手机号码格式错误'),0);
        }
        $cord_moble=session('tel'.$phone);
        $sms_log = M("sms_log");
        $info = $sms_log->where(['mobile' => $phone,'verify' => $cord_moble,'result' => 0])->order('createtime', 'desc')->find();
        if($info && (time() - $info['createtime'] < 60)){
            $this->ajaxreturn(0,'手机验证码发送过于频繁',0);
        }
        $real_ip = get_client_ip();
        $list = M('blacklist')->field('ip')->where('status=1')->select();
        foreach ($list as $key => $val){
            $black[$key] =$val['ip'];
        }

        if (in_array($real_ip, $black)){
            $this->ajaxreturn('ok');
        }

        $where =array();
        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $where['createtime'] = array('between',array($start,$end));
//        $where['mobile'] = $phone;
        $where['ip']  = $real_ip;
        $nums = $sms_log->where($where)->count();//获取今天内该手机号发送次数
        if($nums >= 20){
            $this->ajaxreturn(0,'今天你已经获取多次验证码，发送失败',0);
        }


        //以下信息自己填以下
		
//		$encode = mb_detect_encoding($content, array("ASCII",'UTF-8','GB2312','GBK','BIG5'));
//		if($encode != 'UTF-8')
//		{
//			$content = mb_convert_encoding($content, 'UTF-8', $encode);
//		}
//		$argv = array(
//			'name'=>'qijiu',     //必填参数。用户账号
//			'pwd'=>'3E27BD1D65E169DBD56233EEBF50',     //必填参数。（web平台：基本资料中的接口密码）
//			'content'=>'【79招生网】尊敬的用户：您的登录验证码是'.$verify.'，请在5分钟内完成登录。',   //必填参数。发送内容（1-500 个汉字）UTF-8编码
//			'mobile'=>$phone,   //必填参数。手机号码。多个以英文逗号隔开
//			'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
//			'sign'=>'柒玖教育',    //必填参数。用户签名。
//			'type'=>'pt',  //必填参数。固定值 pt
//			'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
//		);
//		//print_r($argv);exit;
//		//构造要post的字符串
//		//echo $argv['content'];
//		foreach ($argv as $key=>$value) {
//			if ($flag!=0) {
//				$params .= "&";
//				$flag = 1;
//			}
//			$params.= $key."="; $params.= urlencode($value);// urlencode($value);
//			$flag = 1;
//		}
//		$url = "http://web.daiyicloud.com/asmx/smsservice.aspx?".$params; //提交的url地址
//
//		$result = file_get_contents($url);
//		$con= substr( $result, 0, 1 );  //获取信息发送后的状态

        //阿里云短信
        $argv = array(
            'templateCode'=>'SMS_205136198',     //必填参数。用户账号
            'phone'=>$phone,   //必填参数。手机号码。多个以英文逗号隔开
            'code'=>  Array(  // 短信模板中字段的值
                "code"=>$verify,
            ),
        );
        $con = $this->sendSms($argv);
        $result = $con->Message == 'OK' ? 1 : 0;
        $data = array(
            'createtime' => time(),
            'result' => $result,
            'content' => '验证码为：'.$verify.'，您正在登录，若非本人操作，请勿泄露。',
            'mobile' => $phone,
            'school' => '',
            'course' => '',
            'verify' => $verify,
            'student' => '',
        );
        $sms_log = M("sms_log");
        $res = $sms_log->add($data);
		if($result){
			//成功
			session('tel'.$phone, $verify);
			$this->ajaxreturn('ok');
		}else{
			$this->ajaxreturn('no');
		}
    }
	function logout()
    {
		if($this->_userid) {
			cookie(null,'YP_');
            $this->assign('jumpUrl','/');
			$this->success(L('loginouted'));
        }else {
			$this->assign('jumpUrl','/');
            $this->error(L('logined'));
        }
    }
    
}
?>
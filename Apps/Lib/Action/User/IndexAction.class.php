<?php
/**
 * 
 * User/IndexAction.class.php (前台会员中心模块)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <admin@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2012-10-08 yourphp.cn $
 */
if(!defined("Yourphp")) exit("Access Denied");
class IndexAction extends BaseAction
{

	function _initialize()
    {
        $viewid = get_safe_replace($_POST['viewid']);
    	if($viewid){
    		$this->addview();
    	}
		parent::_initialize();
		if(!$this->_userid){
			$this->assign('jumpUrl',U('User/Login/index'));
			$this->error(L('nologin'));
			exit;
		}
		$this->dao = M('User');
		$this->assign('bcid',0);
		$this->user = $user = $this->dao->find($this->_userid);
		$orgimages = $this->getImageList($user['orgpics']);
		$this->assign('orgimages', $orgimages);
		$this->assign('vo',$user);
		unset($_POST['status']);
		unset($_POST['groupid']);
		unset($_POST['amount']);
		unset($_POST['point']);

        $now = time();
        $where = [];
        $where['userid'] = $this->_userid;
        $where['status'] = 1;
        $where['expire_time'] = array('gt',$now);
        $where['type'] = $this->user['groupid'];
        $user_level = M('User_level')->where($where)->find();

        if($user_level){//后台有审核通过的vip会员信息
            $user_mark = verify_groupid($user_level['type']);
            $this->assign('user_level', $user_level);

            $this->assign('user_mark', $user_mark);
            $time = time();
            $expire = 15*86400;
            if($time > ($user_level['expire_time']-$expire)){
                $this->assign('is_expire', 1);
            }

        }
//        print_r($user_mark);

        $_GET =get_safe_replace($_GET);

    }

    public function index()
    {
        $this->display();
    }
	
	public function profile()
    {	 
		if($_POST['dosubmit']){
			
			$_POST['id']=$this->_userid;
			if(!$this->dao->create($_POST)) {
				$this->error($this->dao->getError());
			}
			$this->dao->update_time = time();
			$this->dao->last_ip = get_client_ip();
			$result	=	$this->dao->save();
			if(false !== $result) {
				$this->success(L('do_success'));
			}else{
				$this->error(L('do_error'));
			}
			exit;
		}
        $this->display();
    }

	public function avatar()
    {	
		
		if($_POST['dosubmit']){
		
			$_POST['id']=$this->_userid;
			if(!$this->dao->create($_POST)) {
				$this->error($this->dao->getError());
			}
			$this->dao->update_time = time();
			$this->dao->last_ip = get_client_ip();
			$result	=	$this->dao->save();
			if(false !== $result) {
				if($_POST['aid']){
				$Attachment =M('Attachment');		
				$aids =  implode(',',$_POST['aid']);
				$data['userid']= $this->_userid;
				$data['catid']= 0;
				$data['status']= '1';
				$Attachment->where("aid in (".$aids.")")->save($data);
				}

				$this->success(L('do_success'));
			}else{
				$this->error(L('do_error'));
			}
			exit;
		}

		$yourphp_auth_key = sysmd5(C('ADMIN_ACCESS').$_SERVER['HTTP_USER_AGENT']);
		$yourphp_auth = authcode('0-1-0-1-jpeg,jpg,png,gif-3-0', 'ENCODE',$yourphp_auth_key);
		$this->assign('yourphp_auth',$yourphp_auth);
        $this->display();
    }

	public function password()
    {
		if($_POST['dosubmit']){

//			if(md5($_POST['verify']) != $_SESSION['verify']) {
//				$this->error(L('error_verify'));
//			}
			if($_POST['password'] != $_POST['repassword']){
				$this->error(L('password_repassword'));
			}
			$map	=	array();
			$map['password']= array('eq',sysmd5($_POST['oldpassword']));
			$map['id']		=	$this->_userid;
			
			//检查用户
			if(!$this->dao->where($map)->field('id')->find()) {
				$this->error(L('旧密码错误'));
			}else {
				$this->dao->id = $this->_userid;
				$this->dao->update_time = time();
				$this->dao->password	=	sysmd5($_POST['password']);
				$r = $this->dao->save();
				$this->assign('jumpUrl',U('User/Index'));
				if($r>=0){
					//发送成功系统消息
					$b=A('User/Register');
					$stitle = '密码修改成功';
					$scontent = '密码修改成功！你的新密码为'.$_POST['password'].'请不要在公共场合查看此消息！';
					$b->get_messages($stitle,$scontent,$this->_userid);
					
					$this->success(L('修改成功'),'User/Index');
				}else{
					$this->error(L('修改失败'));
				}
			 }
			 exit;
		}
		$this->display();
    }
	
	function mykecheng()
	{
		$this->display();
	}
	function release()
	{
        $schoolid = $this->user['schoolid'];
        $school = M('school')->where("id=$schoolid")->find();
        if(!$school || $school['status'] == 0){
            $this->error(L('帐号异常，暂不能发布课程，请联系客服处理'),'/User/Index');
            exit;
        }
        $limit = $school['limit']>0 ? $school['limit'] : $this->Config['kecheng_num'];
        $kec= M('kecheng')->where("school_id=$schoolid")->count();
        if($kec >= $limit){
            $this->error(L('您的课程发布数量已达上限，请开通VIP会员以发布更多课程'), '/User/Index/vip');
            exit;
        }
        $this->display();
	}
	function mycoupon()
	{
		$this->display();
	}
	function amend()
	{
		$this->display();
	}
	function news()
	{
		$this->display();
	}
    function vip()
    {
        $this->display();
    }
	function Modify()
	{
		//获取action过来的数据
		$title = get_safe_replace($_REQUEST['title']);
		$industry = get_safe_replace($_REQUEST['industry']);
		$address = get_safe_replace($_REQUEST['address']);
		$mobile = get_safe_replace($_REQUEST['mobile']);
        $email = get_safe_replace($_REQUEST['email']);
		$give_instruction = get_safe_replace($_REQUEST['give_instruction']);
		$qq = get_safe_replace($_REQUEST['qq']);
        $wechat = get_safe_replace($_REQUEST['wechat']);
        $web = get_safe_replace($_REQUEST['web']);
		$description = get_safe_replace($_REQUEST['description']);
		$schoolid = get_safe_replace($_REQUEST['schoolid']);
        if(!empty($mobile) && !check_Mobile($mobile)){
            $this->error(L('手机号码格式错误'),'/User/Index');
            exit;
        }
        if(!empty($email) && !check_Email($email)){
            $this->error(L('邮箱格式错误'),'/User/Index');
            exit;
        }
		//判断是那个用户
		$userid = intval(cookie('userid'));
		//找出修改对象
		$muser = M('user');
		$muser2 = M('School');
		//修改对象
		$muser->title = $title;
		$muser->industry = $industry;
		$muser->address = $address;
		$muser->mobile = $mobile;
        $muser->email = $email;
        $muser->give_instruction = $give_instruction;
		$muser->qq = $qq;
        $muser->wechat = $wechat;
        $muser->web = $web;
		$muser->description = $description;
		$muser->schoolid = $schoolid;

		//同时修改学校数据
		$muser2->title = $title;
		$muser2->industryx = $industry;
		$muser2->address = $address;
		$muser2->mobile = $mobile;
		$muser2->give_instruction = $give_instruction;
		$muser2->QQ = $qq;
		$muser2->zhuye = $web;
		$muser2->description = $description;
		//保存>
		$result = $muser->where('id='.$userid)->save();
		$result2 = $muser2->where('id='.$schoolid)->save();
		if($result>=0 && $result2>=0){
			$this->success(L('修改成功'));
		}else {
			$this->success(L('数据更新失败'), '/');
		}
	}
	function Modify2()
	{
		//获取action过来的数据
		$username = get_safe_replace($_REQUEST['username']);
		$linkman = get_safe_replace($_REQUEST['linkman']);
		$address = get_safe_replace($_REQUEST['address']);
		$mobile = get_safe_replace($_REQUEST['mobile']);
		$email = get_safe_replace($_REQUEST['email']);
		$qq = get_safe_replace($_REQUEST['qq']);
		$description = get_safe_replace($_REQUEST['description']);
		$motto = get_safe_replace($_REQUEST['motto']);

        if(!empty($mobile) && !check_Mobile($mobile)){
            $this->error(L('手机号码格式错误'),'/User/Index');
            exit;
        }
        if(!empty($email) && !check_Email($email)){
            $this->error(L('邮箱格式错误'),'/User/Index');
            exit;
        }
		//判断是那个用户
		$userid = intval(cookie('userid'));
		//找出修改对象
		$muser = M('user');
		//修改对象
		$muser->username = $username;
		$muser->linkman = $linkman;
		$muser->address = $address;
		$muser->mobile = $mobile;
		$muser->email = $email;
		$muser->qq = $qq;
		$muser->description = $description;
		$muser->motto = $motto;
		
		//保存>
		$result = $muser->where('id='.$userid)->save();
		if($result>=0 && $result2>=0){
			$this->success(L('修改成功'));
		}else {
			$this->success(L('数据更新失败'), '/');
		}
	}
	function Modifypic()
	{
		//修改图片
		import("@.ORG.UploadFile");
        $upload = new UploadFile(); 
        //$upload->supportMulti = false;
        //设置上传文件大小 
        $upload->maxSize = $this->Config['attach_maxsize']; 
        $upload->autoSub = true; 
        $upload->subType = 'date';
        $upload->dateFormat = 'Ym';
        //设置上传文件类型 
        $upload->allowExts = explode(',', $this->Config['attach_allowext']); 
        //设置附件上传目录 
        $upload->savePath = UPLOAD_PATH; 
         //设置上传文件规则 
        $upload->saveRule = uniqid; 

        //删除原图 
        $upload->thumbRemoveOrigin = true; 
        if(!$upload->upload()) {
            $this->ajaxReturn(array('status'=>-1));
        }else{
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo();
        }
        $file=str_replace('.','',$uploadList[0]['savepath']).$uploadList[0]['savename'];
		
		//判断是那个用户
		$userid = intval(cookie('userid'));
		//找出修改对象
		$muser = M('user');
		//修改对象
		$muser->file = $file;
		$userInfo = M('User')->find($userid);
		if ($userInfo && $userInfo['schoolid'])
        {
            M('School')->save(array('id' => $userInfo['schoolid'], 'file' => $file));
        }
		//保存>
		$result = $muser->where('id='.$userid)->save();
		if($result){
			$this->success(L('修改成功'));
		}
	}
	//删除课程
	function kcdelete(){
		//接收数据
		$id = get_safe_replace($_REQUEST['id']);
		$user = get_safe_replace($_REQUEST['user']);
		
		$id = is_array($id) ? $id : json_decode($id);
		
		$User = M("kecheng");
		
		if(empty($id))
		{
			echo 0;
			return ;
		}
		if(is_array($id))
		{
			$where = array('id'=>array('in',$id));
		}else {
			$where = array('id'=>$id);
		}
		$re=$User->where($where)->delete($id);
		if($re){
			echo 1;
		}else{
			echo 0;
		}
	}
	//添加课程
	function addkc(){
		//接收数据
		
		$title = get_safe_replace($_POST['title']);
		$kccity = get_safe_replace($_POST['kccity']);
        $dx = get_safe_replace($_POST['dx']);
		$address = get_safe_replace($_POST['address']);
		$guanzhu = get_safe_replace($_POST['guanzhu']);
		$schoolid = get_safe_replace($_POST['schoolid']);
		$industry = get_safe_replace($_POST['industry']);
		$price = get_safe_replace($_POST['price']);
		$pc = get_safe_replace($_POST['pc']);
		$systme = get_safe_replace($_POST['systme']);
		$content = $_POST['content'];

		//修改图片
		import("@.ORG.UploadFile");
        $upload = new UploadFile(); 
        //$upload->supportMulti = false;
        //设置上传文件大小 
        $upload->maxSize = $this->Config['attach_maxsize']; 
        $upload->autoSub = true; 
        $upload->subType = 'date';
        $upload->dateFormat = 'Ym';
        //设置上传文件类型 
        $upload->allowExts = explode(',', $this->Config['attach_allowext']); 
        //设置附件上传目录 
        $upload->savePath = UPLOAD_PATH; 
         //设置上传文件规则 
        $upload->saveRule = uniqid; 

        //删除原图 
        $upload->thumbRemoveOrigin = true; 
        if(!$upload->upload()) {
           
        }else{
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo();
        }
        $file=str_replace('.','',$uploadList[0]['savepath']).$uploadList[0]['savename'];

		
        $category = M('category')->where('id='.$industry)->find();
        
		$addkc = M("kecheng"); //实例化对象
		$data['title'] = $title;
		$data['dx'] = $dx;
		$data['address'] = $address;
		$data['guanzhu'] = $guanzhu;
		$data['scpic'] = $file;
		$data['school_id'] = $schoolid;
		$data['kccity'] = $kccity;
		$data['content'] = $content;
		$data['pc'] = $pc;
		$data['systme'] = $systme;		
		$data['price'] = $price;
		$data['lang'] = '2';
		$data['status'] = '1';
		$data['catid'] = $industry;
		$data['createtime'] = time();
		$date['updatetime'] = time();
		$re=$addkc->add($data);
		if($re){
			//成功插入后再拼接url
			$save_url = M("kecheng");
			$url = '/'.$category['catdir'].'/show/'.$re.'.html';
			$data['url'] = $url;
			$re2 = $save_url->where('id='.$re)->save($data);

			if($re2){
				$this->success('添加成功');
			}else{
				$this->success('添加失败');
			}
		}else{
			$this->success('添加失败');
		}
	}

    //添加vip服务
    function addvip(){
        //接收数据
        $user_level = M("user_level"); //实例化对象
        $type = get_safe_replace($_POST['type']);
        $userid = intval(cookie('userid'));


        $user =M('user')->where('id='.$userid)->find();

        $ip =get_client_ip();

        $count = $user_level->where('userid='.$userid)->count();

        if(!in_array($type,$this->vip_list)){
            $this->error(L('所选VIP服务类型错误'),$_SERVER["HTTP_REFERER"]);
        }
        $data['userid'] = $userid;
        $data['user_name'] = $user['username'];
        $data['title'] = $user['title'];
        $data['type'] = $type;
        $data['lang'] = '2';
        $data['ip'] = $ip;
        $data['status'] = 0;
        $data['createtime'] = time();
        $date['updatetime'] = time();
        $re= $user_level->add($data);
        if($re){
            $r = sendmail($this->Config['site_email'],'新机构申请VIP会员','新机构申请VIP会员，请登录后台核审核',$this->Config);
            $this->success('您已成功提交，请耐心等待批复');
        }else{
            $this->error('添加失败');
        }
    }

    //用户申请添加课程
    function addcourse(){
        //接收数据
        $apply_add_course = M("apply_add_course"); //实例化对象
        $userid = intval(cookie('userid'));
        $type = get_safe_replace($_POST['type']);



        $user =M('user')->where('id='.$userid)->find();
        if(empty($user)){
            $this->ajaxreturn('0','该用户不存在');
        }


        $ip =get_client_ip();


        $data['userid'] = $userid;
        $data['user_name'] = $user['username'];
        $data['title'] = $user['title'];
        $data['lang'] = '2';
        $data['ip'] = $ip;
        $data['status'] = 0;
        $data['createtime'] = time();
        $date['updatetime'] = time();
        $re= $apply_add_course->add($data);

        if($re){
            $r = sendmail($this->Config['site_email'],'新机构申请增加课程','新机构申请增加课程，请登录后台核审核',$this->Config);
            $this->ajaxReturn(1,'您已成功提交，请耐心等待批复',1);
        }else{
            $this->ajaxreturn('0','添加失败');//添加失败
        }
    }

	//修改课程
	function amends(){
		//接收数据
		
		$title = get_safe_replace($_POST['title']);
		$kccity = get_safe_replace($_POST['kccity']);
        $dx = get_safe_replace($_POST['dx']);
		$address = get_safe_replace($_POST['address']);
		$guanzhu = get_safe_replace($_POST['guanzhu']);
		$industry = get_safe_replace($_POST['industry']);
		$price = floatval(get_safe_replace($_POST['price']));
		$pc = get_safe_replace($_POST['pc']);
		$systme = get_safe_replace($_POST['systme']);
		$content = $_POST['content'];
		$file2 = get_safe_replace($_POST['file2']);
		$id = get_safe_replace($_POST['id']);
		//修改图片
		import("@.ORG.UploadFile");
        $upload = new UploadFile(); 
        //$upload->supportMulti = false;
        //设置上传文件大小 
        $upload->maxSize = $this->Config['attach_maxsize']; 
        $upload->autoSub = true; 
        $upload->subType = 'date';
        $upload->dateFormat = 'Ym';
        //设置上传文件类型 
        $upload->allowExts = explode(',', $this->Config['attach_allowext']); 
        //设置附件上传目录 
        $upload->savePath = UPLOAD_PATH; 
         //设置上传文件规则 
        $upload->saveRule = uniqid;

        //删除原图 
        $upload->thumbRemoveOrigin = true; 
        if(!$upload->upload()) {
            $file= $file2;
        }else{
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo();
            $file=str_replace('.','',$uploadList[0]['savepath']).$uploadList[0]['savename'];
        }
       
        
		$savekc = M("kecheng"); //实例化对象
		$data['title'] = $title;
		$data['kccity'] = $kccity;
		$data['dx'] = $dx;
		$data['address'] = $address;
		$data['guanzhu'] = $guanzhu;
		$data['scpic'] = $file;
		$data['content'] = $content;
		$data['price'] = $price;
		$data['pc'] = $pc;
		$data['systme'] = $systme;
		$data['catid'] = $industry;
		$data['updateime'] = time();
		
		$re = $savekc->where('id='.$id)->save($data);
		if($re>=0){
			$this->success('修改成功');
		}else{
			$this->success('添加失败');
		}
	}
	//普通客户删除课程
	function kcdelete2(){
		//接收数据
		$id = get_safe_replace($_REQUEST['id']);
		$user = get_safe_replace($_REQUEST['user']);
		
		$id = is_array($id) ? $id : json_decode($id);
		
		$User = M("kecheng");
		
		if(empty($id))
		{
			echo 0;
			return ;
		}
		if(is_array($id))
		{
			$where = array('id'=>array('in',$id));
		}else {
			$where = array('id'=>$id);
		}
		$re=$User->where($where)->delete($id);
		if($re){
			echo 1;
		}else{
			echo 0;
		}
	}
	//添加课程评论
	function addview(){
		//接收数据
		$viewid = get_safe_replace($_POST['viewid']);
		$score = get_safe_replace($_POST['score']);
        $title = get_safe_replace($_POST['title']);
        $content = get_safe_replace($_POST['content']);
        $r_userid = intval(cookie('userid'));
		if($r_userid){
			$collect=M('user')->where('id='.$r_userid)->getfield('collect');
			$new=trim($collect,',');
	        $arr=explode(',',$new);
	        if(in_array($viewid,$arr)){//存在
	        	
	        }else{
	        	$this->ajaxreturn('-2');//未报名
	        }
		}else{
			$this->ajaxreturn('-1');//未登录
		}
		
		$addview = M("view"); //实例化对象
		$data['title'] = $title;
		$data['viewid'] = $viewid;
		$data['score'] = $score;
		$data['ruserid'] = $r_userid;
		$data['content'] = $content;
		$data['lang'] = '2';
		$data['status'] = 1;
		$re=$addview->add($data);
		
		if($re){
			$this->ajaxreturn('1');//评论成功
		}else{
			$this->ajaxreturn('0');//评论失败
		}
	}
	//课程
    function column()
    {
		$id = get_safe_replace($_REQUEST['id']);
		$childid = M('category')->where('parentid='.$id)->order( 'listorder asc')->select();
		if($childid){
			//成功
			$this->ajaxreturn($childid);
		}else{
			$this->ajaxreturn('0');
		}
    }
    
    protected function getImageList($image)
    {
        if (is_string($image))
        {
            $nimages = explode(':::', $image);
            $images = array();
            $tmp = array();
            foreach ($nimages as $img)
            {
                $tmp = explode('|', $img);
                if ($tmp[0])
                {
                    $images[] = $tmp[0];
                }
            }
            return $images;
        }else {
            return array();
        }
    }
}
?>
<?php
/**
 * 
 * User(会员管理文件)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <admin@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2012-10-08 yourphp.cn $
 */
if(!defined("Yourphp")) exit("Access Denied");
class UserAction extends AdminbaseAction {

    public $dao,$usergroup;
	function _initialize()
	{
		parent::_initialize();
		$this->dao = D('User');
		$this->usergroup=F('Role');
		$this->assign('usergroup',$this->usergroup);
	}


	function index(){
		import ( '@.ORG.Page' );

		$keyword=$_GET['keyword'];
		$searchtype=$_GET['searchtype'];
		$groupid =intval($_GET['groupid']);

		$this->assign($_GET);
		
		if(!empty($keyword) && !empty($searchtype)){
			$where[$searchtype]=array('like','%'.$keyword.'%');
		}
		if($groupid)$where['groupid']=$groupid;

        if (! empty ( $_REQUEST ['listRows'] ) && $_REQUEST ['listRows'] > 0) {
            $listRows = $searchParam['listRows'] = $_REQUEST ['listRows'];
        }else{
            $listRows = 20;
        }

		$user=$this->dao;
		$count=$user->where($where)->count();
		$page=new Page($count,$listRows);
		$show=$page->show(1);
		$this->assign("page",$show);
		$list=$user->order('id')->where($where)
		->limit($page->firstRow.','.$page->listRows)->select();

		$this->assign('ulist',$list);
		$this->display();
	}

	function insert(){
		$user=$this->dao;
		$_POST['password'] = sysmd5($_POST['pwd']);
		if($data=$user->create()){
			if(false!==$user->add()){
				$uid=$user->getLastInsID();
				$ru['role_id']=$_POST['groupid'];
				$ru['user_id']=$uid;
				$roleuser=M('RoleUser');
				$roleuser->add($ru);			
				$this->success(L('add_ok'));
			}else{
				$this->error(L('add_error'));
			}
		}else{
			$this->error($user->getError());
		}
	}

	function update(){
		$user=$this->dao;
		$_POST['password'] = $_POST['pwd'] ? sysmd5($_POST['pwd']) : $_POST['opwd'];
        $info = $user->where('id='.$_POST['id'])->find();

		if(!empty($_POST['id'])){
		    $orgpics = '';
		    foreach ($_POST['orgpics'] as $k => $v)
		    {
		        if ($v)
		        {
                    $orgpics .= $v . '|' . $_POST['orgpics_name'][$k] . ':::';
		        }
		    }
		    $_POST['orgpics'] = trim($orgpics, ':::');
		    unset($_POST['orgpics_name']);
		    
				if(false!==$user->save($_POST)){
					$ru['user_id']=$_POST['id'];
					$ru['role_id']=$_POST['groupid'];
					$roleuser=M('RoleUser');
					$roleuser->where('user_id='.$_POST['id'])->delete();
					$roleuser->where('user_id='.$_POST['id'])->add($ru);

//                    if(in_array($_POST['groupid'],$this->vip_list)){//新增改变会员组同时改变学校和课程groupid
//                        $data['groupid'] = $_POST['groupid'];
//                    }else{
//                        $data['groupid'] = 0;
//                    }
//                    $school = M('School');
//                    $school->where("id=".$info['schoolid'])->save($data);
//                    $kecheng = M('Kecheng');
//                    $kecheng->where("school_id=".$info['schoolid'])->save($data);

					$this->success(L('edit_ok'));
				}else{
					$this->error(L('edit_error').$user->getDbError());
				}
		}else{
				$this->error(L('do_error'));
		}
	}
 

	function _before_add(){
		$this->assign('rlist',$this->usergroup);	
	}

	function _before_edit(){
		$this->assign('rlist',$this->usergroup);	
	}


	function delete(){
		$id=$_GET['id'];
		$user=$this->dao;
		if(false!==$user->delete($id)){
			$roleuser=M('RoleUser');
			$roleuser->where('user_id ='.$id)->delete();
			delattach(array('moduleid'=>0,'catid'=>0,'id'=>0,'userid'=>$id));
			$this->success(L('delete_ok'));
		}else{
			$this->error(L('delete_error').$user->getDbError());
		}
	}

	function deleteall(){		
		$ids=$_POST['ids'];
		if(!empty($ids) && is_array($ids)){
			$user=$this->dao;
			$id=implode(',',$ids);
			if(false!==$user->delete($id)){
				$roleuser=M('RoleUser');
				$roleuser->where('user_id in('.$id.')')->delete();
				delattach("moduleid=0 and catid=0 and id=0 and userid in($id)");
				$this->success(L('delete_ok'));
			}else{
				$this->error(L('delete_error'));
			}
		}else{
			$this->error(L('do_empty'));
		}
	}

    //后台-用户申请vip消息 获取用户信息
    function getUserInfo(){
        //接收数据
        $userid = get_safe_replace($_POST['userid']);

        if(!$userid){
            $this->ajaxreturn('0','该用户已失效，请重新登录');
        }

        $user =M('user')->where('id='.$userid)->find();
        if(empty($user)){
            $this->ajaxreturn('0','该用户不存在');
        }

        $this->ajaxReturn($user,'获取用户信息成功',1);

    }

    //群发短信
    function sendBtachSms(){
        $con = $this->sendBatchSms($argv=[]);
//        var_dump($con);
    }
}
?>
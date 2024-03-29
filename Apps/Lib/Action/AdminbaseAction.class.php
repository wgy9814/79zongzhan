<?php
/**
 * 
 * Adminbase (后台公共模块)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <admin@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2012-10-08 yourphp.cn $
 */
require(__ROOT__."Core/Extend/PHPExcel.php");
if(!defined("Yourphp")) exit("Access Denied");
class AdminbaseAction extends Action
{
	protected   $mod,$Config,$sysConfig,$nav,$menudata,$cache_model,$categorys,$module,$moduleid,$Type,$Urlrule,$Lang;
	protected   $currentModule,$parentModule,$parentModuleKey,$parentModuleValue,$parentParam,$isChildModule,$vip_list;

	function _initialize()
	{
		$this->sysConfig = F('sys.config');
		$this->menudata = F('Menu');		
		$this->module = F('Module');
		$this->Type =F('Type');
		$this->Urlrule =F('Urlrule');
		$this->mod = F('Mod');
        $this->Role = F('Role');


		//add by jzp
		$this->isChildModule = false;
		$this->currentModule =  $this->module[$this->mod[MODULE_NAME]];
		$this->parentModule = null;
		$this->parentParam = array();
		
		if($this->currentModule['parent_moduleid'] > 0){
			$this->parentModule = $this->module[$this->currentModule['parent_moduleid']];
		}
		$this->assign ( 'currentModule',  $this->currentModule );
		$this->assign ( 'parentModule',  $this->parentModule );
		if($this->currentModule && $this->parentModule) {
			$this->isChildModule = true;
			$map['parent_moduleid'] = $this->currentModule['parent_moduleid'];
			$this->parentModuleKey = strtolower($this->parentModule['name'] . '_id');
			if(!isset($_REQUEST[$this->parentModuleKey])) {
				$this->error(L('add_error').': ' . L('缺少参数， 父模型的主键参数 ') . $this->parentModuleKey);
			}
			$this->parentParam[$this->parentModuleKey] = $_REQUEST[$this->parentModuleKey];
			$this->assign ( 'isChildModule',  $this->isChildModule );
			$this->assign ( 'parentModuleKey',  $this->parentModuleKey );
			$this->assign ( 'parentModuleValue',  $_REQUEST[$this->parentModuleKey] );
		}
		$this->assign ( 'parentParam',  $this->parentParam );
		//end by jzp

		if(APP_LANG){
			$this->Lang = F('Lang');
			if($_GET['l']){
				if($this->Lang[$_GET['l']]['id']){
					$_SESSION['YP_lang'] = $_GET['l'];
					$_SESSION['YP_langid'] = $this->Lang[$_GET['l']]['id'];
				}else{
					$this->error ( L ( 'NO_LANG' ) );
				}
			}elseif(!$_SESSION['YP_lang'] || !$_SESSION['YP_langid']){
				$_SESSION['YP_lang'] = $this->sysConfig['DEFAULT_LANG'];
				$_SESSION['YP_langid'] = $this->Lang[$this->sysConfig['DEFAULT_LANG']]['id'];
			}
			define('LANG_NAME',$_SESSION['YP_lang']);
			define('LANG_ID',$_SESSION['YP_langid']);
 
			$this->assign('l',LANG_NAME);
			$this->assign('langid',LANG_ID);
			$this->categorys = F('Category_'.LANG_NAME);
			$this->Config = F('Config_'.LANG_NAME);
			$this->assign('Lang',$this->Lang);
		}else{
			$this->Config = F('Config');
			$this->categorys = F('Category');
		}
	
		$this->assign('module_name',MODULE_NAME);
		$this->assign('action_name',ACTION_NAME);
		$this->cache_model=array('Lang','Menu','Config','Module','Role','Category','Posid','Field','Type','Urlrule','Dbsource');
		
		C('HOME_ISHTML',$this->sysConfig['HOME_ISHTML']);
		C('PAGE_LISTROWS',$this->sysConfig['PAGE_LISTROWS']);
		C('URL_LANG',$this->sysConfig['DEFAULT_LANG']);
		C('URL_M',$this->sysConfig['URL_MODEL']);
		C('URL_M_PATHINFO_DEPR',$this->sysConfig['URL_PATHINFO_DEPR']);
		C('URL_M_HTML_SUFFIX',$this->sysConfig['URL_HTML_SUFFIX']);
		C('URL_URLRULE',$this->sysConfig['URL_URLRULE']);	

		
		C('ADMIN_ACCESS',$this->sysConfig['ADMIN_ACCESS']);
		// 用户权限检查
		if (C ( 'USER_AUTH_ON' ) && !in_array(MODULE_NAME,explode(',',C('NOT_AUTH_MODULE')))) {
			import ( '@.ORG.RBAC' );
			if (! RBAC::AccessDecision ('Admin')) {
				//检查认证识别号

				if (! $_SESSION [C ( 'USER_AUTH_KEY' )]) {
					//跳转到认证网关
					redirect ( PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
				}
				// 没有权限 抛出错误
				if (C ( 'RBAC_ERROR_PAGE' )) {
					// 定义权限错误页面
					redirect ( C ( 'RBAC_ERROR_PAGE' ) );
				} else {
					if (C ( 'GUEST_AUTH_ON' )) {
						$this->assign ( 'jumpUrl', PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
					}
					// 提示错误信息
					$this->error ( L ( '_VALID_ACCESS_' ) );
				}
			}
		}

	 	$menuid = intval($_GET['menuid']);
		if(empty($menuid)) $menuid = cookie('menuid');
		if(!empty($menuid)){
			$this->nav = $this->getnav($menuid,1);
			if($this->nav)$this->assign('nav', $this->nav);
		}

		if($this->mod[MODULE_NAME]){
			$this->moduleid = $this->mod[MODULE_NAME];
			$this->m = $this->module[$this->moduleid];
			$this->assign('moduleid',$this->moduleid);
			$this->Type = F('Type');
			$this->assign('Type',$this->Type);

			if($this->module[$this->moduleid]['type']==1 && ACTION_NAME=='index'){

				if($this->categorys){
					foreach ($this->categorys as $r){
						
						if($_SESSION['groupid']!=1 && !in_array($_SESSION['groupid'],explode(',',$r['postgroup']))) continue;
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
					//$str  = "<option value='\$id' \$disabled \$selected>\$spacer \$catname</option>";
					$str  = "<option value='\$id'  \$selected>\$spacer \$catname</option>";
					$tree = new Tree ($array);
					$select_categorys = $tree->get_tree(0, $str);
					$this->assign('select_categorys', $select_categorys);
					$this->assign('categorys', $this->categorys);
				}

				
				$this->assign('posids', F('Posid'));
			}
		}
        $list = ['vip普通会员', 'vip高级会员', 'vip钻石会员','定制服务'];
        foreach ($this->Role as $val){
            if(in_array($val['name'],$list)){
                $this->vip_list[$val['remark']] = $val['id'];
            }
        }
//        echo '<pre>';
//        print_r($this->vip_list);
        $this->assign('vip_list', $this->vip_list);
        change_groupid();//vip过期改变用户组

        import("@.ORG.Form");
		$this->assign('Form', new Form());
	}

	function getnav($menuid,$isnav=0){
		
			if($menuid){
				$bnav = $this->menudata[$menuid];
				if(empty($bnav['action']))$bnav['action'] ='index';
				$array = array('menuid'=> $bnav['id']);
				parse_str($bnav['data'],$c);
				$bnav['data'] = $c + $array + $this->parentParam;
			}
//        echo '<pre>';
//				print_r($this->menudata);
			if($this->menudata){
				$accessList = $_SESSION['_ACCESS_LIST'];
//                print_r($accessList);die;
				foreach($this->menudata as $key=>$module) {
					if($module['parentid'] != $menuid || $module['status']==0) continue;

					if(isset($accessList[strtoupper('Admin')][strtoupper($module['model'])]) || $_SESSION[C('ADMIN_AUTH_KEY')]) {

						//设置模块访问权限$module['access'] =   1;
						if(empty($module['action'])) $module['action']='index';
						//检测动作权限

						if(isset($accessList[strtoupper('Admin')][strtoupper($module['model'])][strtoupper($module['action'])]) || $_SESSION[C('ADMIN_AUTH_KEY')]){
							$nav[$key]  = $module;
						
							if($isnav){
								$array=array('menuid'=> $nav[$key]['parentid']);
								cookie('menuid',$nav[$key]['parentid']);
								//$_SESSION['menuid'] = $nav[$key]['parentid'];
							}else{
								 $array=array('menuid'=> $nav[$key]['id']);
							}
							if(empty($menuid) && empty($isnav)) $array=array();
							$c=array();
							parse_str($nav[$key]['data'],$c);
							$nav[$key]['data'] = $c + $array + $this->parentParam;
						}
					}
				}
			}
		
			$navdata['bnav']=$bnav;
			$navdata['nav']=$nav;
			return $navdata;
	}

	// 列表输出 
	function _list($modelname, $map = '', $sortBy = '', $asc = false ,$listRows = 15) {
		$model = M($modelname);
		$id = $model->getPk ();
		$this->assign ( 'pkid', $id );
		
		if (isset ( $_REQUEST ['order'] )) {
			$order = $_REQUEST ['order'];
		} else {
			$order = ! empty ( $sortBy ) ? $sortBy : $id;
		}
		if (isset ( $_REQUEST ['sort'])) {
			$_REQUEST ['sort']=='asc' ? $sort = 'asc' : $sort = 'desc';
		} else {
			$sort = $asc ? 'asc' : 'desc';
		}


		$_REQUEST ['sort'] = $sort;
		$_REQUEST ['order'] = $order;

		$keyword = $_REQUEST['keyword'];
		$searchtype = $_REQUEST['searchtype'];
		$groupid = intval($_REQUEST['groupid']);
		$catid = intval($_REQUEST['catid']);
		$posid = intval($_REQUEST['posid']);
		$typeid = intval($_REQUEST['typeid']);
		$schoolid = intval($_REQUEST['school_id']);
        $userid = intval($_REQUEST['userid']);
        $project = $_REQUEST['project'];
        $kccity = intval($_REQUEST['kccity']);
        $parent_top_place = intval($_REQUEST['parent_top_place']);
        $child_top_place = intval($_REQUEST['child_top_place']);



        if(APP_LANG)if($this->moduleid) $map['lang']=array('eq',LANG_ID);

		/*
			add by xqy
			问题：$map 进行查询重组后,直接作为分页的URL是错误的,造成搜索有分页后出现搜索条件消失
			解决:增加一个变量($searchParam),记录查询条件
		*/
		if(!empty($keyword) && !empty($searchtype)){
			$searchParam['searchtype'] = $searchtype;
			$searchParam['keyword'] = $keyword;
			$map[$searchtype] = array('like','%'.$keyword.'%');
		}

		//如需新增参数做查询条件 需要 添加$map 和 $searchParam两个参数 确保分页参数正确
		if($groupid) $map['groupid'] = $searchParam['groupid'] = $groupid;
		//if($catid)$map['catid']=$catid;
        //*edit by jzp end
        //to-do: 如果有副栏目关联表， 加一个条件(exists) add by jzp
        if($catid) {
            if ($modelname == 'Kecheng')
            {
                $map['catid'] = array('in', explode(',', $this->categorys[$catid]['arrchildid']));
                $searchParam['catid'] =$catid;
            }elseif($relationId = hasCatalogField($this->moduleid))
            {
                $module = $modelname ? $modelname : MODULE_NAME;
                $tablename=C('DB_PREFIX').strtolower($module).'_catalog';
                $primaryKey = strtolower($module) . '_id';
                $where_catid = " (`catid` = $catid or exists(select 1 from `$tablename` where `id` = `$primaryKey` and `$relationId` = $catid))";
            	$map['_string'] = $where_catid;
			}else{
				$map['catid'] = $searchParam['catid'] = $catid;
			}
        }

        // $map['catid'] = 6;
		if($posid) $map['posid'] = $searchParam['posid'] = $posid;
		if($typeid) $map['typeid'] = $searchParam['typeid'] = $typeid;
        if($userid) $map['userid'] = $searchParam['userid'] = $userid;
        if($project) $map['project'] = $searchParam['project'] = $project;
        if ('Kecheng' == MODULE_NAME && $schoolid) $map['school_id'] = $searchParam['school_id'] = $schoolid;
        if ('Kecheng' == MODULE_NAME && $kccity) $map['kccity'] = $searchParam['kccity'] = $kccity;
        if($parent_top_place) $map['parent_top_place'] = $searchParam['parent_top_place'] = $parent_top_place;
        if($child_top_place) $map['child_top_place'] = $searchParam['child_top_place'] = $child_top_place;

        if($this->isChildModule) {
			$map[$this->parentModuleKey] = $searchParam[$this->parentModuleKey] = $_REQUEST[$this->parentModuleKey];
		}
		$tables = $model->getDbFields();

 		// start from qiuye
		$this->assign('listfields',$tables);
 		//end from qiuye
		foreach($_REQUEST['map'] as $key=>$res){
				if(  ($res==='0' || $res>0) || !empty($res) ){					 
					if($_REQUEST['maptype'][$key]){
						$map[$key] = array($_REQUEST['maptype'][$key],$res);
					}else{
						$map[$key] = $searchParam[$key] = intval($res);
					}
					$_REQUEST[$key] = $res;
				}else{					
					unset($_REQUEST[$key]);
				}
		}
        //写死 所有会员 1000 搜索出 9,10,11,12的会员
        if($map['groupid'] == 1000){
            $map['groupid'] = array('in', $this->vip_list);
            $searchParam['groupid'] = 1000;
        }
        $this->assign($_REQUEST);

		//取得满足条件的记录总数
		$count = $model->where ( $map )->count ( $id );
//        echo  $model->getLastSql();
//echo $count;
		if ($count > 0) {
			import ( "@.ORG.Page" );
			//创建分页对象
			// var_dump($_REQUEST ['listRows']);exit;
			if (! empty ( $_REQUEST ['listRows'] ) && $_REQUEST ['listRows'] > 0) {
				$listRows = $searchParam['listRows'] = $_REQUEST ['listRows'];
			}
			$page = new Page ( $count, $listRows );
			//分页查询数据

//            if(is_array($map['groupid'])) {
////                $map['groupid']=array('eq',1000);
////                $map['groupid']= 1000;
//
//            }
//            if(is_array($map['catid'])) {
////                $map['catid'] = $catid;
//                $map['catid']=array('eq',$catid);
//            }

			$field=$this->module[$this->moduleid]['listfields'];
			$field= (empty($field) || $field=='*') ? '*' : 'id,catid,url,posid,title,thumb,title_style,userid,username,hits,createtime,updatetime,status,listorder' ;
			$voList = $model->field($field)->where($map)->order( "`" . $order . "` " . $sort)->limit($page->firstRow . ',' . $page->listRows)->select ( );
//            echo  $model->getLastSql();
			//分页跳转的时候保证查询条件

//            echo '<pre>';
//            print_r($map);
			foreach ( $map as $key => $val ) {
				if (! is_array ( $val )) {
					$page->parameter .= "$key=" . urlencode ( $val ) . "&";
				}
			}

			
			$searchParam[C('VAR_PAGE')]='{$page}';
			unset($searchParam['lang']);
			$searchParam['lang']=LANG_ID;
			$page->urlrule = U($modelname.'/index', $searchParam);
			//分页显示
			$page = $page->show ();
			//列表排序显示
			$sortImg = $sort; //排序图标
			$sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
			$sort = $sort == 'desc' ? 1 : 0; //排序方式
			//模板赋值显示
//            echo '<pre>';
//            echo $groupid;
//            print_r($voList);
            foreach ($voList as $key => $value) {
                if ('School' == MODULE_NAME ) {
//                    $user = M('User')->where('schoolid='.$value['id'])->find();
//                    $user_level = M('User_level')->where('user_id = '.$user['id'].' and status=1 and type = '.$user['groupid'])->find();
//                    if($user_level){//后台有审核通过的vip会员信息
////                        $user_mark = verify_groupid($user_level['type']);
////                        $voList[$key]['user_mark'] = $user_mark;
//                        $voList[$key]['type'] = $user_level['type'];
//                    }

                }
                if ('Kecheng' == MODULE_NAME ) {

                }
            }
//            print_r($voList);

            $this->assign ( 'list', $voList );
			$this->assign ( 'page', $page );
		}
		return;
	}


	/**
     * 添加
     *
     */

	function add() {
		$name = MODULE_NAME;
		$this->display ('edit');
	}


	function insert() {

		if($_POST['setup']) $_POST['setup']=array2string($_POST['setup']);
		$name = MODULE_NAME;
		$model = D ($name);
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		$id = $model->add();
		if ($id !==false) {
			if(in_array($name,$this->cache_model)) savecache($name);
			if($_POST['aid']){
				$Attachment =M('Attachment');		
				$aids =  implode(',',$_POST['aid']);
				$data['id']= $id;
				$data['catid']= intval($_POST['catid']);
				$data['status']= '1';
				$Attachment->where("aid in (".$aids.")")->save($data);
			}
			if($_POST['isajax'])$this->assign('dialog','1');
			$jumpUrl = $_POST['forward'] ? $_POST['forward'] : U(MODULE_NAME.'/index');
			$this->assign ( 'jumpUrl',$jumpUrl );
			//判断是否是系统消息
			if(MODULE_NAME == 'Message')
			{
				$mtitle = $_POST['setup'];
				$mcontent = $_POST['$mcontent'];
				
			}
			
			$this->success (L('add_ok'));
		} else {
			$this->error (L('add_error').': '.$model->getDbError());
		}
	}

	/**
     * 更新
     *
     */

	function edit() {
		$name = MODULE_NAME;
		$model = M ( $name );
		$pk=ucfirst($model->getPk ());
		$id = intval($_REQUEST [$model->getPk ()]);
		if(empty($id))   $this->error(L('do_empty'));
		$do='getBy'.$pk;
		$vo = $model->$do ( $id );
		
		$yourphp_auth_key = sysmd5(C('ADMIN_ACCESS').$_SERVER['HTTP_USER_AGENT']);
		$yourphp_auth = authcode('1-1-0-10-jpeg,jpg,gif,png-2-3', 'ENCODE',$yourphp_auth_key);
		$this->assign('yourphp_auth', $yourphp_auth);
		
		if($vo['setup']) $vo['setup']=string2array($vo['setup']);
		$this->assign ( 'vo', $vo );
		$this->display ();
	}

	function update() {
		if($_POST['setup']) $_POST['setup']=array2string($_POST['setup']);
		$name = MODULE_NAME;
		$model = D ( $name );
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		if (false !== $model->save ()) {
			if(in_array($name,$this->cache_model)) savecache($name);
			if($_POST['aid']){
				$Attachment =M('Attachment');		
				$aids =  implode(',',$_POST['aid']);
				$data['id']= $_POST['id'];
				$data['catid']= intval($_POST['catid']);
				$data['status']= '1';
				$Attachment->where("aid in (".$aids.")")->save($data);
			}
			if($_POST['isajax'])$this->assign('dialog','1');
			$jumpUrl = $_POST['forward'] ? $_POST['forward'] : U(MODULE_NAME.'/index', $this->parentParam);
			$this->assign ( 'jumpUrl', $jumpUrl);
			$this->success (L('edit_ok'));
		} else {
			$this->success (L('edit_error').': '.$model->getDbError());
		}
	}

	/**
     * 删除
     *
     */
	function delete(){
		$name = MODULE_NAME;
		$model = M ( $name );
		$pk = $model->getPk ();
		$id = $_REQUEST [$pk];
		if (isset ( $id )) {
            if ('School' == $name){
                $kec = M('Kecheng')->where("school_id =$id")->find();
                if($kec){
                    $this->error(L('选中的学校下还有课程，删除失败'),$_SERVER["HTTP_REFERER"]);
                }
            }
            if(false!==$model->delete($id)){
				if(in_array($name,$this->cache_model)) savecache($name);
				if($this->moduleid){
					$fields =  $model->getDbFields();
					delattach(array('moduleid'=>$this->moduleid,'id'=>$id));
					if($fields['keywords']){
						$olddata  = $model->field('keywords')->find($id);
						$where['name']=array('in',$olddata['keywords']);
						$where['moduleid']=array('eq',$this->moduleid);
						if(APP_LANG)$where['lang']=array('eq',LANG_ID);
						M('Tags')->where($where)->setDec('num');
						M('Tags_data')->where("id=".$id)->delete();
					}
				}

				if ('School' == $name)
                {
                    M('Kecheng')->where(array('school_id' => $id))->delete();
                    M('User')->where(array('schoolid' => $id))->delete();
                }

				if($name=='Order')M('Order_data')->where('order_id='.$id)->delete();
				$jumpUrl = $_POST['forward'] ? $_POST['forward'] : U(MODULE_NAME.'/index', $this->parentParam);
				$this->assign ( 'jumpUrl', $jumpUrl);
				$this->success(L('delete_ok'));
			}else{
				$this->error(L('delete_error').': '.$model->getDbError());
			}
		}else{
			$this->error (L('do_empty'));
		}
	}

	/**
     * 批量删除
     *
     */

	function deleteall(){
		$name = MODULE_NAME;
		$model = M ( $name );
		$ids=$_POST['ids'];
		if(!empty($ids) && is_array($ids)){
			$id=implode(',',$ids);
            if ('School' == $name){
                $tip = '';
                foreach ($ids as $val){
                    $kec = M('Kecheng')->where("school_id =$val")->find();
                    if($kec){
                        $baoliu[] = $val;
                        $tip .= $val.',';
                    }
                }
                $diff = array_diff($ids,$baoliu);
                if(count($diff) <=0){
                    $this->error(L('选中的学校下还有课程，删除失败'),$_SERVER["HTTP_REFERER"]);
                }else{
                    $id = implode(',',$diff);
                }
            }

			if(false!==$model->delete($id)){
				if(in_array($name,$this->cache_model)) savecache($name);
				if($this->moduleid){
					$fields =  $model->getDbFields();
					delattach("moduleid=$this->moduleid and id in($id)");
					if($fields['keywords']){
						$olddata  = $model->field('keywords')->where("id in($id)")->select();
						foreach((array)$olddata as $r){
								$where['name']=array('in',$r['keywords']);
								$where['moduleid']=array('eq',$this->moduleid);
								if(APP_LANG)$where['lang']=array('eq',LANG_ID);
								M('Tags')->where($where)->setDec('num');
						}
						M('Tags_data')->where("id in($id)")->delete();
						M('Tags')->where('num<=0')->delete();
					}
				}

                if ('School' == $name)
                {
                    M('Kecheng')->where('school_id in(' . $id . ')')->delete();
                    M('User')->where('schoolid in(' . $id . ')')->delete();
                }

                if($name=='Order')M('Order_data')->where('order_id in('.$id.')')->delete();
				$this->success(L('delete_ok'));
			}else{
				$this->error(L('delete_error').': '.$model->getDbError());
			}
		}else{
			$this->error(L('do_empty'));
		}
	}

	/**
     * 批量操作
     *
     */
	public function listorder()
	{
		$name = MODULE_NAME;
		$model = M ( $name );
		$pk = $model->getPk ();
		$ids = $_POST['listorders'];
		foreach($ids as $key=>$r) {
			$data['listorder']=$r;
			$model->where($pk .'='.$key)->save($data);
		}
		if(in_array($name,$this->cache_model)) savecache($name);
		$this->success (L('do_ok'));

	}

	/*状态*/

	public function status(){
		$name = MODULE_NAME;
		$model = D ($name);
		$_GET = get_safe_replace($_GET);
		if($model->save($_GET)){
			savecache(MODULE_NAME);
			$this->success(L('do_ok'));
		}else{
			$this->error(L('do_error'));
		}
	}

	/**
     * 默认操作
     *
     */
	public function index() {
        $name = MODULE_NAME;
		$model = M ($name);
		$id=$model->getPk ();
		$count = $model->where($_REQUEST['where'])->count();
		import ( "@.ORG.Page" );
		$p = new Page ( $count, 15 );
		unset($_GET[C('VAR_PAGE')]);
		$map=$_GET;
		$map[C('VAR_PAGE')]='{$page}';
		$p->urlrule = U($name.'/index',$map);
		$page = $p->show ();

        $list = $model->where($_REQUEST['where'])->order("$id desc")->limit($p->firstRow . ',' . $p->listRows)->select();
        $this->assign('list', $list);
		$this->assign ( 'page', $page );
        $this->display();
    }


	public function create_show($id,$module)
    {
		C('DEFAULT_THEME_NAME',$this->sysConfig['DEFAULT_THEME']);
		C('HTML_FILE_SUFFIX',$this->sysConfig['HTML_FILE_SUFFIX']);
		C('TMPL_FILE_NAME',str_replace('Admin/Default','Home/'.$this->sysConfig['DEFAULT_THEME'],C('TMPL_FILE_NAME')));

		
		if(APP_LANG){
			C('TMPL_CACHFILE_SUFFIX','_'.LANG_NAME.'.php');
			$lang =  C('URL_LANG')!=LANG_NAME ? $lang = LANG_NAME.'/' : '';
			L(include LANG_PATH.LANG_NAME.'/common.php');
			$T = F('config_'.LANG_NAME,'', './Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/');
		}else{
			L(include LANG_PATH.$this->sysConfig['DEFAULT_LANG'].'/common.php');
			$T = F('config_'.$this->sysConfig['DEFAULT_LANG'],'', './Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/');
		}
		$this->assign('T',$T);
		foreach((array)$this->module as $r){
			if($r['issearch'])$search_module[$r['name']] = L($r['name']);
		}
		$this->assign('search_module',$search_module);
		$this->assign ( 'form',new Form());
		$p =1;
		$id=intval($id);
		if(empty($id)) $this->success (L('do_empty'));;
		$this->assign($this->Config);
		$this->assign('Categorys',$this->categorys);
		$this->assign('Module',$this->module);
		$this->assign('Type',$this->Type);
		$this->assign('module_name',$module);
		$dao= M($module);
		$data = $dao->find($id);

		$catid = $data['catid'];
		$this->assign('catid',$catid);
		$cat = $this->categorys[$data['catid']];
		$this->assign ($cat);
		$bcid = explode(",",$cat['arrparentid']);
		$bcid = $bcid[1];
		if($bcid == '') $bcid=intval($catid);
		$this->assign('bcid',$bcid);

		$seo_title = $data['title'].'-'.$cat['catname'];
		$this->assign ('seo_title',$seo_title);
		$this->assign ('seo_keywords',$data['keywords']);
		$this->assign ('seo_description',$data['description']);

		$fields = F($this->mod[$module].'_Field');
		foreach($data as $key=>$c_d){
			$setup='';
			$fields[$key]['setup'] =$setup=string2array($fields[$key]['setup']);
			if($setup['fieldtype']=='varchar' && $fields[$key]['type']!='text'){
				$data[$key.'_old_val'] =$data[$key];
				$data[$key]=fieldoption($fields[$key],$data[$key]);
			}elseif($fields[$key]['type']=='images' || $fields[$key]['type']=='files'){
				$p_data=explode(':::',$data[$key]);
				$data[$key]=array();
				foreach($p_data as $k=>$res){
					$p_data_arr=explode('|',$res);
					$data[$key][$k]['filepath'] = $p_data_arr[0];
					$data[$key][$k]['filename'] = $p_data_arr[1];
				}
				unset($p_data);
				unset($p_data_arr);
			}
			unset($setup);
		}
		$this->assign('fields',$fields);
		$this->assign ('form',new Form());

		$urlrule = geturl($cat,$data,$this->Urlrule);

		if(!empty($data['template'])){
			$template = $cat['module'].'_'.$data['template'];
		}elseif(!empty($cat['template_show'])){
			$template = $cat['module'].'_'.$cat['template_show'];
		}else{
			$template = $cat['module'].'_show';
		}
		//手动分页
		$CONTENT_POS = strpos($data['content'], '[page]');
		if($CONTENT_POS !== false){
			
				$pageurls=array();
				$contents = array_filter(explode('[page]',$data['content']));
				$pagenumber = count($contents);
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = str_replace('{$page}',$i,$urlrule);
				}
				//生成分页
				foreach ($pageurls as $p=>$urls) {
					$pages = content_pages($pagenumber,$p, $pageurls);
					$this->assign ('pages',$pages);
					$data['content'] = $contents[$p-1];
					$this->assign ($data);
					$url= ($p > 1 ) ? $urls[1] :  $urls[0];
					if(strstr($url,C('HTML_FILE_SUFFIX'))){
						$filename = basename($url,C('HTML_FILE_SUFFIX'));
						$dir = dirname($url).'/';
					}else{
						$filename = 'index';
						$dir= $url; 
					}
					$dir = substr($dir,strlen(__ROOT__.'/'));
					$this->buildHtml($filename,$dir,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/'.$template.C('TMPL_TEMPLATE_SUFFIX'));
				}
		}else{
				$url = str_replace('{$page}', $p, $urlrule[0]);
				if(strstr($url,C('HTML_FILE_SUFFIX'))){
					$filename = basename($url,C('HTML_FILE_SUFFIX'));
					$dir = dirname($url).'/';
				}else{
					$filename = 'index';
					$dir= $url; 
				}
				$this->assign ('pages','');
				$this->assign ($data);
				$dir = substr($dir,strlen(__ROOT__.'/'));
				$this->buildHtml($filename,$dir,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/'.$template.C('TMPL_TEMPLATE_SUFFIX'));
		}
 
		return true;
    }

	public function create_list($catid,$p=1,$count=0)
    {
		C('DEFAULT_THEME_NAME',$this->sysConfig['DEFAULT_THEME']);
		C('HTML_FILE_SUFFIX',$this->sysConfig['HTML_FILE_SUFFIX']);
		C('TMPL_FILE_NAME',str_replace('Admin/Default','Home/'.$this->sysConfig['DEFAULT_THEME'],C('TMPL_FILE_NAME')));

		if(APP_LANG){
			C('TMPL_CACHFILE_SUFFIX','_'.LANG_NAME.'.php');
			$lang =  C('URL_LANG')!=LANG_NAME ? $lang = LANG_NAME.'/' : '';
			L(include LANG_PATH.LANG_NAME.'/common.php');
			$T = F('config_'.LANG_NAME,'', './Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/'); 
		}else{
			L(include LANG_PATH.$this->sysConfig['DEFAULT_LANG'].'/common.php');
			$T = F('config_'.$this->sysConfig['DEFAULT_LANG'],'', './Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/');
		}
		$this->assign('T',$T);
		foreach((array)$this->module as $r){
			if($r['issearch'])$search_module[$r['name']] = L($r['name']);
		}
		$this->assign('search_module',$search_module);
		$this->assign ( 'form',new Form());

		$this->assign($this->Config);
		$this->assign('Categorys',$this->categorys);
		$this->assign('Module',$this->module);
		$this->assign('Type',$this->Type);
		$catid =intval($catid);
		if(empty($catid)) $this->success (L('do_empty'));

		$cat = $this->categorys[$catid];
		$this->assign('catid',$catid);
		if($cat['type']) return;
		if(empty($cat['ishtml'])) return;
		unset($cat['id']);
		$this->assign($cat);
		$cat['id']=$catid;
		$bcid = explode(",",$cat['arrparentid']);
		$bcid = $bcid[1];
		if($bcid == '') $bcid=intval($catid);
		$this->assign('bcid',$bcid);
		
		$urlrule = geturl($cat,'',$this->Urlrule);
		$url= ($p > 1 ) ? $urlrule[1] :  $urlrule[0];
		$url = str_replace('{$page}', $p, $url);
		if(strstr($url,C('HTML_FILE_SUFFIX'))){
			$filename = basename($url,C('HTML_FILE_SUFFIX'));
			$dir = dirname($url).'/';
		}else{
			$filename = 'index';
			$dir= $url; 
		}
		$dir = substr($dir,strlen(__ROOT__.'/'));
		if(empty($module))$module=$cat['module'];
		$this->assign('module_name',$module);


		$this->assign ( 'fields', F($cat['moduleid'].'_Field') ); 
		$this->assign ( 'form',new Form());


		if($cat['moduleid']==1){
			$cat['listtype']=2;
			$module = $cat['module'];
			$dao= M($module);
			$data = $dao->find($catid);
			$seo_title = $cat['title'] ? $cat['title'] : $data['title'];
			$this->assign ('seo_title',$seo_title);
			$this->assign ('seo_keywords',$data['keywords']);
			$this->assign ('seo_description',$data['description']);

			$template = $cat['template_list']? $cat['template_list'] : 'index';
			//手动分页
			$CONTENT_POS = strpos($data['content'], '[page]');

			if($CONTENT_POS !== false){

					$contents = array_filter(explode('[page]',$data['content']));
					$pagenumber = count($contents);
					for($i=1; $i<=$pagenumber; $i++) {
						$pageurls[$i] = str_replace('{$page}',$i,$urlrule);
					}
					//生成分页
					foreach ($pageurls as $p=>$urls) {
						$pages = content_pages($pagenumber,$p, $pageurls);
						$this->assign ('pages',$pages);
						$data['content'] = $contents[$p-1];
						$this->assign ($data);
						if($p > 1)$filename = basename($pageurls[$p]['1'],C('HTML_FILE_SUFFIX'));
						//$this->buildHtml($filename,$dir,'Home/'.$template);
						$r=$this->buildHtml($filename,$dir,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/Page_'.$template.C('TMPL_TEMPLATE_SUFFIX'));
					}
			}else{
					$this->assign($data);
					//$r=$this->buildHtml($filename,$dir,'Home/'.$template);
					$r=$this->buildHtml($filename,$dir,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/Page_'.$template.C('TMPL_TEMPLATE_SUFFIX'));
			}
			 
		}else{

			$seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
			$this->assign ('seo_title',$seo_title);
			$this->assign ('seo_keywords',$cat['keywords']);
			$this->assign ('seo_description',$cat['description']);

			if($cat['listtype']==1){
				$template_r = 'index';
			}else{
				$where = " status=1 ";
				if($cat['child']){
					$where .= " and catid in(".$cat['arrchildid'].")";
				}else{
					$where .=  " and catid=".$catid;
				}

				$module = $cat['module'];
				$dao= M($module);
				if(empty($count))$count = $dao->where($where)->count();
				if($count){
					import ( "@.ORG.Page" );
					$listRows =  !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');
					$page = new Page ( $count, $listRows ,$p );
					$page->urlrule = $urlrule;
					$pages = $page->show();
					$field =  $this->module[$this->mod[$module]]['listfields'];
					$field =  $field ? $field : 'id,catid,userid,url,username,title,title_style,keywords,description,thumb,createtime,hits';

					$list = $dao->field($field)->where($where)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
					$this->assign('pages',$pages);
					$this->assign('list',$list);
				}
				$template_r = 'list';
			}
			
			$template = $cat['template_list']? $cat['template_list'] : $template_r;
			$r=$this->buildHtml($filename,$dir,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/'.$cat['module'].'_'.$template.C('TMPL_TEMPLATE_SUFFIX'));

		}
		if($r) return true;
	}

	public function create_index($sitemap)
    {
		C('HTML_FILE_SUFFIX',$this->sysConfig['HTML_FILE_SUFFIX']);
		C('DEFAULT_THEME_NAME',$this->sysConfig['DEFAULT_THEME']);
		C('TMPL_FILE_NAME',str_replace('Admin/Default','Home/'.$this->sysConfig['DEFAULT_THEME'],C('TMPL_FILE_NAME')));


		if(APP_LANG){
			C('TMPL_CACHFILE_SUFFIX','_'.LANG_NAME.'.php');
			$lang =  C('URL_LANG')!=LANG_NAME ? $lang = LANG_NAME.'/' : '';
			L(include LANG_PATH.LANG_NAME.'/common.php');
			$T = F('config_'.LANG_NAME,'', './Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/'); 
		}else{
			L(include LANG_PATH.$this->sysConfig['DEFAULT_LANG'].'/common.php');
			$T = F('config_'.$this->sysConfig['DEFAULT_LANG'],'', './Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/');
		}
		$this->assign('T',$T);
		foreach((array)$this->module as $r){
			if($r['issearch'])$search_module[$r['name']] = L($r['name']);
		}
		$this->assign('search_module',$search_module);
 
		
		$this->assign ( 'form',new Form());
		$this->assign('Module',$this->module);
		$this->assign('Type',$this->Type);
		$this->assign($this->Config);
		$this->assign('Categorys',$this->categorys);
 		//$r=$this->buildHtml('index','./','Home/Index_index');
		if(empty($sitemap)){
			$this->assign('ishome','home');
			if(!$this->sysConfig['HOME_ISHTML']) $this->error(L('NO_HOME_ISHTML'));
			$this->assign('bcid',0);
			$r=$this->buildHtml('index','./'.$lang,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/Index_index'.C('TMPL_TEMPLATE_SUFFIX'));
		}else{
			$this->assign('sitemap','1');
			$r=$this->buildHtml('sitemap','./'.$lang,'./Apps/Tpl/Home/'.$this->sysConfig['DEFAULT_THEME'].'/Sitemap'.C('TMPL_TEMPLATE_SUFFIX'));
		}
		if($r) return true;
    }

	function clisthtml($id){
			$pagesize= 10;
			$p = max(intval($p), 1);
			$j = 1;
			do {
				$this->create_list($id,$p);
				$j++;
				$p++;
				$pages = isset($pages) ? $pages : PAGESTOTAL;
			} while ($j <= $pages && $j < $pagesize);
	}


//add by zeb
	public function copy()
	{
		$name = MODULE_NAME;
		$model = M ( $name );
		$pk = $model->getPk ();
		$id = $_REQUEST [$pk];
		$times = isset($_REQUEST ['times']) && is_numeric($_REQUEST ['times']) ? intval($_REQUEST ['times']) : 1;
		if (isset ( $id )) {
			$res = $model->find($id);
			if(false!==$res){
				for ($i=0; $i < $times; $i++) { 
					unset($res[id]);
					if($id= $model->add($res)){
						$result = $model->find($id);
					}
					if($result['url']){
						$data='';
						$cat = $this->categorys[$result['catid']];
						$url = geturl($cat,$result,$this->Urlrule);
						$data['id']= $id;
						$data['url']= $url[0];
						$model->save($data);
					}
					if (false === $id) {
						$this->error ( $model->getError () );
					}else{
						$this->success(L('copy_ok'));
					}
				}	
			}else{
				$this->error(L('copy_error').': '.$model->getDbError());
			}
		}else{
			$this->error (L('do_empty'));
		}
	}

	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);

        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        /*header('charset=utf-8;name="'.$xlsTitle.'.xls"');*/
        header("Content-type:application/vnd.ms-excel;charset=UTF-8");
        /*echo 123;die();*/
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        /*echo 123;die();*/
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        /*echo 123;die(); */
        $objWriter->save('php://output'); 
        exit;   
    }
/**
     *
     * 导出Excel
     */
    public function excel(){//导出Excel
    	$fieldList=M(MODULE_NAME)->getDbFields();
        foreach ($fieldList as $k => $v) {
        	$fieldNameList[]=M('field')->where(array('field'=>$v))->getfield('name');
        	if($fieldNameList[$k]==NULL){
        		$fieldNameList[$k]=$fieldList[$k];
        	}
        	$xlsCell[]=array($fieldList[$k],$fieldNameList[$k]);
        }
        $xlsName  = time();
        $ids=$_POST['ids'];
        if($ids){
        	$where=array('id'=>array('in',$ids),'lang'=>LANG_ID);
        }else{
        	$where=array('lang'=>LANG_ID);
        }
        $xlsData  = M(MODULE_NAME)->where($where)->select();
        foreach ($xlsData as $k => $v)
        {
        	$xlsData[$k]['lang']=$v['lang']==1?'中文':'英文';
            $xlsData[$k]['status']=$v['status']==1?'已审核':'未审核';
            $xlsData[$k]['createtime']=date('Y-m-d h:i:s',$v['createtime']);
            $xlsData[$k]['updatetime']=date('Y-m-d h:i:s',$v['updatetime']);
        }
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }

    //阿里云发送短信
    public function sendSms($data)
    {
        set_time_limit(0);
        header('Content-Type: text/plain; charset=utf-8');
        vendor("AliSms.AliSms");
        $sms = new AliSms($this->Config['accessKeyId'],$this->Config['accessKeySecret']);
        $res = $sms->sendSms(
            "79招生网", // 短信签名
            $data['templateCode'], // 短信模板编号
            $data["phone"], // 短信接收者
            $data["code"] // 短信模板中字段的值
        );
        return $res;

    }

    //阿里云群发送短信
    public function sendBatchSms($data)
    {
        set_time_limit(0);
        header('Content-Type: text/plain; charset=utf-8');
        vendor("AliSms.AliSms");
        $sms = new AliSms($this->Config['accessKeyId'],$this->Config['accessKeySecret']);
        $res = $sms->sendBatchSms(
//            "79招生网", // 短信签名
//            $data['templateCode'], // 短信模板编号
//            $data["phone"], // 短信接收者
//            $data["code"] // 短信模板中字段的值
        );
        return $res;

    }



}
?>
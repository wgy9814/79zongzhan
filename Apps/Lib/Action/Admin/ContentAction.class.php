<?php
/**
 *
 * Content(内容管理模块)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <web@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2012-10-08 yourphp.cn $
 */
if(!defined("Yourphp")) exit("Access Denied");
class ContentAction extends AdminbaseAction
{
    protected  $dao,$fields;
    public function _initialize()
    {
        parent::_initialize();
		$module =$this->module[$this->moduleid]['name'];
		$this->dao = D($module);

		$fields = F($this->moduleid.'_Field');
        $this->Role = F('Role');
		foreach($fields as $key => $res){
			$res['setup']=string2array($res['setup']);
			$this->fields[$key]=$res;
		}
		unset($fields);
		unset($res);
		$this->assign ('fields',$this->fields);
    }

    /**
	 * 列表
	 *
	 */
    public function index()
    {
		// THEME_PATH == './Yourphp/Tpl/Admin/Default/';
		// $this->assign('mode_name',MODULE_NAME);
		$template =  file_exists(THEME_PATH.MODULE_NAME.'_index.html') ? MODULE_NAME.':index' : 'Content:index';
		$childModules = array();
		
		foreach ($this->module as $key => $value) {
			if($this->moduleid == $value['parent_moduleid']) {
				$menu = M('Menu')->where(array('model'=>ucfirst( $value['name'] ), 'action'=>'index'))->find();
				if($menu){
					$value['menuid'] = $menu['id'];
				}
				$childModules[] = $value;
			}
		}
		
		$map = null;
		if ('System' == MODULE_NAME && 6 == $_SESSION['groupid'])
		{
		    $school = M('School')->where(array('indestryx'=>$_SESSION['userid'],'status'=>1))->select();
		    $schoolid = array();
		    foreach ($school as $s)
		    {
		        $schoolid[] = $s['id'];
		    }
		    if (!empty($schoolid))
		    {
		        $course = M('Kecheng')->where(array('school_id'=>array('in',$schoolid),'status'=>1))->select();
		        $courseid = array();
		        foreach ($course as $c)
		        {
		            $courseid[] = $c['id'];
		        }
		        
		        if (!empty($courseid))
		        {
		            $map['courseid'] = array('in', $courseid);
		        }
		    }
		}
        if(MODULE_NAME == 'Tdk') {

            //$str  = "<tr>
				//		<td>\$id</td>
				//		<td ><input type='text' value='\$listorder' class='listorder' data-listorder='\$listorder' data-id='\$id' /></td>
				//		<td>\$spacer\$title</td>
				//		<td id='courseStatus\$id'>\$status</td>
				//		<td>\$createtime</td>
				//		<td>\$edit\$delete</td>
				//	</tr>";
            //
            //import('@.ORG.Tree');
            //$list = M('tdk')->where(['status' => 1])->order ('type asc')->select();//自定义tdk
            //
            //foreach ($list as $key =>$val){
            //    $list[$key]['createtime'] = date('Y-m-d h:i:s',$val['createtime']);
            //    $id = $val["id"];
            //    if($val['status'] == 1){
            //        $list[$key]['status'] =  '<a class="cursor green"  onclick="updateStatus('.$id.');">'.已审核.'</a>';
            //    }else{
            //        $list[$key]['status'] =  '<a class="cursor red"  onclick="updateStatus('.$id.');">'.未审核.'</a>';
            //    }
            //    //$addchildurl = URL('Admin-Book/chapteraddchild',array('id'=>$id,'parentid'=>$val['parentid']));
            //    $editurl = URL('Admin-Tdk/edit',array('id'=>$id));
            //    $deleteurl = URL('Admin-Tdk/ delete',array('id'=>$id));
            //    //$list[$key]['addchildurl'] =  '<a href="'.$addchildurl.'">添加子栏目</a>&nbsp;&nbsp;';
            //    $list[$key]['edit'] =  '<a href="'.$editurl.'">修改</a>&nbsp;&nbsp;';
            //    $list[$key]['delete'] =  '<a data-href="'.$deleteurl.'">删除</a>';
            //    //$list[$key]['copy'] =  '<a  data-href="'.$deleteurl.'">复制</a>';
            //
            //
            //}
            ////echo '<pre>';
            ////print_r($list);
            //
            //$tree = new Tree ($list);
            //$tree->icon = array('&nbsp;&nbsp;&nbsp;'.L('tree_1'),'&nbsp;&nbsp;&nbsp;'.L('tree_2'),'&nbsp;&nbsp;&nbsp;'.L('tree_3'));
            //$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            //$data = $tree->get_tree(1, $str);


            $this->assign('categorys', $this->categorys);
        }

		$this->assign('pmidname',strtolower($this->currentModule['name'].'_id'));
		$this->assign('childModules',$childModules);
	    $this->_list(MODULE_NAME, $map);
        $this->display ($template);
    }

	public function add()
    {
        $arr = [];
        if(MODULE_NAME == 'Tdk'){
            $user_school = M('user')->field('id,username,schoolid')->where(array('status'=>1, 'schoolid'=>array('neq', '')))->select();//最新课程页面的所有列表
            $school = M('school')->field('id,username')->where(array('status'=>1))->select();//学校首页列表
            //课程文章页面
            //echo '<pre>';
            $school_article = M('category')->field('id,catname,catdir,module')->where(array('module'=>'Kecheng'))->select();//学校首页列表
            foreach ($school_article as $val){
                $where['catid'] = $val['id'];
                $kecheng = M('kecheng')->field('id,catid,school_id,title,url')->where($where)->order ('listorder desc')->select();
                foreach ($kecheng as $k =>$val1){
                    $article[$val1['id']] = $val1;//课程文章列表
                }
            }
            //print_r($article);
            foreach ($user_school as $val){
                //$arr[] =$val['schoolid'];
                $where['school_id'] = $val['schoolid'];
                $school = M('kecheng')->field('id,school_id,title')->where($where)->order('listorder desc')->select();
                foreach ($school as $val1){
                    array_push($arr,$val1);//最新课程页面的所有
                }
            }
            $tdk_arr= M('tdk')->where(['status' => 1,'parentid' => 0])->order ('type asc')->select();//自定义tdk

            //print_r($tdk_arr);
        }
		$vo['catid']= intval($_GET['catid']);
		$form=new Form($vo);
		$form->isadmin=1;
		$this->assign ( 'form', $form );
		$template =  file_exists(THEME_PATH.MODULE_NAME.'_edit.html') ? MODULE_NAME.':edit' : 'Content:edit';
		$this->display ( $template);
	}


	public function edit()
    {
		$id = $_REQUEST ['id'];		
		if(MODULE_NAME=='Page'){
					$Page=D('Page');
					$p = $Page->find($id);
					if(empty($p)){
					$data['id']=$id;
					$data['title'] = $this->categorys[$id]['catname'];
					$data['keywords'] = $this->categorys[$id]['keywords'];
					$Page->add($data);	
					}
		}
		//echo '<pre>';

		$vo = $this->dao->getById ( $id );
		$vo['content'] = htmlspecialchars($vo['content']);
        //to-do: 这里需要判断有没有副栏目字段，如果有，从副栏目得到选中的数据放到$vo的对应字段名中里。
        $relatedId = hasCatalogField($this->moduleid);
        if($relatedId)
        {
            $vo[$relatedId] = $this->getCatalogData($id);
        }
 		$form=new Form($vo);
        if(MODULE_NAME=='Tdk'){
            switch($vo['type']) {
                case '1' :
                    $list = M('school')->field('id,username as title')->where(array('status'=>1))->select();//学校首页列表
                    break;
                case '2' :
                    $list = M('user')->field('schoolid as id,username as title')->where(array('status'=>1, 'schoolid'=>array('neq', '')))->select();//最新课程页面的所有列表
                    break;
                case '3' :
                    $list = M('kecheng')->field('id,title')->where(array('status'=>1))->select();
                    break;
            }
            $this->assign ( 'child_list', $list );
        }
        //echo '<pre>';
        //print_r($list);
		$this->assign ( 'vo', $vo );
		$this->assign ( 'form', $form );

		$template =  file_exists(THEME_PATH.MODULE_NAME.'_edit.html') ? MODULE_NAME.':edit' : 'Content:edit';
		$this->display ( $template);
	}

    // add by jzp
    private function getCatalogData($id, $module = ''){
        $relatedId = hasCatalogField($this->moduleid);
        if(!$relatedId)
        {
            return array();
        }
        
        $module = $module ? $module : MODULE_NAME;
        $modelCat = M($module . '_catalog');
        $primaryKey = strtolower($module) . '_id';
        $catsData = $modelCat->field($relatedId)->where(array($primaryKey => $id))->select();
        $result = array();
        foreach($catsData as $item)
        {
            $result[] = $item[$relatedId];
        }
        return $result;
    }
    
    // add by jzp
    private function insertCatalog($id, $module = '')
    {
        $relatedId = hasCatalogField($this->moduleid);
        if(!$relatedId || !isset($_POST[$relatedId]))
        {
            return;
        }
        
        $cat_ids = $_POST[$relatedId];
        if(is_string($_POST[$relatedId])){
            $cat_ids = array($cat_ids);
        }
        $module = $module ? $module : MODULE_NAME;
        $modelCat = M($module . '_catalog');
        $primaryKey = strtolower($module) . '_id';
        foreach($cat_ids as $val)
        {
            $modelCat->$primaryKey = $id;
            $modelCat->$relatedId = $val;
            $modelCat->add();   
        }
    }
    
    // add by jzp
    private function deleteCatalog($id, $module = '')
    {
        $relatedId = hasCatalogField($this->moduleid);
        if(!$relatedId)
        {
            return;
        }
        
        $cat_ids = $_POST[$relatedId];
        if(is_string($_POST[$relatedId])){
            $cat_ids = array($cat_ids);
        }
        $module = $module ? $module : MODULE_NAME;
        $modelCat = M($module . '_catalog');
        $primaryKey = strtolower($module) . '_id';
        $modelCat->where(array($primaryKey => $id))->delete();
    }
    
    /**
     * 录入
     *
     */
    public function insert($module='',$fields=array(),$userid=0,$username='',$groupid=0,$schoolname='')
    {
		$model = $module ?  M($module) : $this->dao;
		$fields = $fields ? $fields : $this->fields ;

		if($fields['verifyCode']['status'] && (md5($_POST['verifyCode']) != $_SESSION['verify'])){
			$this->assign ( 'jumpUrl','javascript:history.go(-1);');
			$this->error(L('error_verify'));
        }
        
        $ref = $_POST['ref'];
        
		$_POST = checkfield($fields,$_POST);
		if(empty($_POST)) $this->error (L('do_empty'), empty($ref) ? $_SERVER['REQUEST_URI'] : $ref);
		
		// $_POST['createtime'] = time();		 
		// $_POST['updatetime'] = $_POST['createtime'];	
		if(!$_POST['createtime']) $_POST['createtime'] = time();
		$_POST['updatetime'] = time();		
		if ($this->module[$this->moduleid]['name'] != 'System')
		{
            if ($this->module[$this->moduleid]['name'] != 'User_level')
            {
                //用户申请vip消息 使用默认提交参数
                $_POST['userid'] = $module ? $userid : $_SESSION['userid'];
                $_POST['username'] = $module ? $username : $_SESSION['username'];
                $_POST['user_name'] = $schoolname ? $schoolname : '';
            }
		}else {
		    $user = M('User')->find($_POST['userid']);
		    $_POST['username'] = $user['username'];
		}
		
		if($_POST['style_color']) $_POST['style_color'] = 'color:'.$_POST['style_color'];
		if($_POST['style_bold']) $_POST['style_bold'] =  ';font-weight:'.$_POST['style_bold'];
		if($_POST['style_color'] || $_POST['style_bold'] ) $_POST['title_style'] = $_POST['style_color'].$_POST['style_bold'];
 
		$module = $module? $module : MODULE_NAME ;
		if(GROUP_NAME=='User')$_POST['status'] = $this->Role[$groupid]['allowpostverify'] ? 1 : 0;
        if(MODULE_NAME == 'Tdk') {
            if($_POST['type'] == 1 && !is_numeric($_POST['description_rule'])){//学校首页 description只截取前60位
                $this->error (L('学校首页description规则默认截取前几位，修改失败'));
            }
            if($_POST['parentid'] == 1){
                $_POST['parentid'] = $_POST['type'] ;
            }else if($_POST['parentid'] == 0){
                $_POST['child_id'] = 0 ;
            }

            $tdks = M('tdk')->where(['type' => $_POST['type'],'parentid' => $_POST['parentid'],'child_id' => $_POST['child_id']])->order ('type asc')->find();//自定义tdk
            //echo M('tdk')->getLastSql();
            //print_r($tdks);die;
            if($tdks){
                $this->error (L('该信息已存在'));
            }

        }

		if (false === $model->create ()) {
			$this->error ( $model->getError() );
		}
        
		$_POST['id'] = $id= $model->add();
        
		if ($id !==false) {
			$catid = $module =='Page' ? $id : $_POST['catid'];

            //to-do: 这里需要判断有没有副栏目字段， 如果有，就把副栏目的数据更新到对应的数据表中。 
            $relatedId = hasCatalogField($this->moduleid);
            if($relatedId && isset($_POST[$relatedId])){
                $this->insertCatalog($id);
            }
			if($_POST['aid']){
				$Attachment =M('Attachment');		
				$aids =  implode(',',$_POST['aid']);
				$data['id']=$id;
				$data['catid']= $catid;
				$data['status']= '1';
				$Attachment->where("aid in (".$aids.")")->save($data);
			}
			
			$tablename=C('DB_PREFIX').strtolower($module);
			$db=D('');
			$db =   DB::getInstance();
			$tables = $db->getTables();			
			$Fields=$db->getFields($tablename); 
			
			if(isset($Fields['url'])){
				$data='';
				$data['id']= $id;
				if($catid) {
					$cat = $this->categorys[$catid];
					$url = geturl($cat,$_POST,$this->Urlrule);
					$data['url']= $url[0];
				} else{
					$data['url'] = U('Home/'. $module . '/show/', array('id'=>id) );
				}
				$model->save($data);
			}

			
			if($_POST['keywords'] && $module !='Page'){
				$keywordsarr=explode(',',$_POST['keywords']);
				$i=0;
				$tagsdata =M('Tags_data');
				$tagsdata->where("id=".$id)->delete();
				foreach((array)$keywordsarr as $tagname){
					if($tagname){
						$tagidarr=$tagdatas=$where=array();
						$where['name']=array('eq',$tagname);
						$where['moduleid']=array('eq',$cat['moduleid']);
						$tagid=M('Tags')->where($where)->field('id')->find();
						$tagidarr['id']=$id;
						if($tagid){
							$num = $tagsdata->where("tagid=".$tagid[id])->count();
							$tagdatas['num']=$num+1;
							M('Tags')->where("id=".$tagid[id])->save($tagdatas);
							$tagidarr['tagid']=$tagid['id'];
						}else{
							$tagdatas['moduleid']=$cat['moduleid'];
							$tagdatas['name'] = $tagname;
							$tagdatas['slug'] = Pinyin($tagname);
							$tagdatas['num']=1;
							$tagdatas['lang']=$_POST['lang'];
							$tagdatas['module']= $cat['module'];
							$tagidarr['tagid']=M('Tags')->add($tagdatas);
						}
						$i++;
						$tagsdata->add($tagidarr);
					}
				}
			}

			if($cat['presentpoint']){
				$user =M('User');
				if($cat['presentpoint']>0) $user->where("id=".$_POST['userid'])->setInc('point',$cat['presentpoint']);
				if($cat['presentpoint']<0) $user->where("id=".$_POST['userid'])->setDec('point',$cat['presentpoint']);
			}
 
			if($cat['ishtml'] && $_POST['status']){
				if($module!='Page'   && $_POST['status'])	$this->create_show($id,$module);				
				$arrparentid = array_filter(explode(',',$cat['arrparentid'].','.$cat['id']));
				foreach($arrparentid as $catid) {
					if($this->categorys[$catid]['ishtml'])	$this->clisthtml($catid);					
				}
 			}
			if($this->sysConfig['HOME_ISHTML']) $this->create_index();
			if(GROUP_NAME=='Admin'){
				$this->assign ( 'jumpUrl', U($module.'/index', $this->parentParam) );
			}elseif(GROUP_NAME=='User'){
				$this->assign ( 'jumpUrl',$_SERVER['HTTP_REFERER']);
				//$this->assign ( 'jumpUrl', U(GROUP_NAME.'-'.MODULE_NAME.'/add?moduleid='.$cat['moduleid']) );
			}
			if ('feedback' !=  strtolower($module))
			{
                $this->success (L('add_ok'));
			}
		} else {
			$this->error (L('add_error').': '.$model->getDbError());
		}
    }

	function update($module='',$fields=array(),$userid=0,$username='')
	{  
		$model = $module ?  M($module) : $this->dao;
		$fields = $fields ? $fields : $this->fields ;
		if($fields['verifyCode']['status'] && (md5($_POST['verifyCode']) != $_SESSION['verify'])){
			$this->assign ( 'jumpUrl','javascript:history.go(-1);');
			$this->error(L('error_verify'));
        }

		$_POST = checkfield($fields,$_POST);
		if(empty($_POST)) $this->error (L('do_empty'));

		$_POST['updatetime'] = time();		
		if($_POST['style_color']) $_POST['style_color'] = 'color:'.$_POST['style_color'];
		if($_POST['style_bold']) $_POST['style_bold'] =  ';font-weight:'.$_POST['style_bold'];
		if($_POST['style_color'] || $_POST['style_bold'] ) $_POST['title_style'] = $_POST['style_color'].$_POST['style_bold'];

		$cat = $this->categorys[$_POST['catid']];
		$module = $module? $module : MODULE_NAME ;
		if($cat) {
			$_POST['url'] = geturl($cat,$_POST,$this->Urlrule);
			$_POST['url'] =$_POST['url'][0];
		} else {
			$_POST['url'] = U('Home/'. $module . '/show/', array('id'=>$_POST['id']) );
		}
		if ($this->module[$this->moduleid]['name'] == 'System')
		{
		    $user = M('User')->find($_POST['userid']);
		    $_POST['username'] = $user['username'];
		}
		
		$olddata = $model->find($_POST['id']);

        if(MODULE_NAME == 'Tdk') {
            if($_POST['type'] == 1 && !is_numeric($_POST['description_rule'])){//学校首页 description只截取前60位
                $this->error (L('学校首页description规则默认截取前几位，修改失败'));
            }
            if($_POST['parentid'] == 1){
                $_POST['parentid'] = $_POST['type'] ;
            }else if($_POST['parentid'] == 0){
                $_POST['child_id'] = 0 ;
            }
            $dirty = false;
            if($olddata['type'] != $_POST['type'] || $olddata['parentid'] != $_POST['parentid']  || $olddata['child_id'] != $_POST['child_id'] ){//判断tdk
                $dirty = true;
            }
            $tdks = M('tdk')->where(['type' => $_POST['type'],'parentid' => $_POST['parentid'],'child_id' => $_POST['child_id']])->order ('type asc')->find();//自定义tdk
            if($tdks && $dirty){
                $this->error (L('该信息已存在'));
            }
        }
        if(MODULE_NAME == 'User_level') {//用户申请vip消息
            if($_POST['expire_time'] == 0){
                $this->error (L('过期时间不能为空'));
            }
            $user = M('User');

            $info = $user->where("id=".$olddata['userid'])->find();
            $level = M(MODULE_NAME);

            if($_POST['status'] == 1){
                $level->where("userid=".$olddata['userid'].' and id <>'.$_POST['id'])->delete();
                if($olddata['expire_time'] == 0){
                    $_POST['expire_time'] = time() + (86400*365);
                }
                $data['groupid'] = $_POST['type'];
//                print_r($olddata);die;
                $user->where("id=".$olddata['userid'])->save($data);
                $school = M('School');
                $school->where("id=".$info['schoolid'])->save($data);
                $kecheng = M('Kecheng');
                $kecheng->where("school_id=".$info['schoolid'])->save($data);
            }else{
                $old = $level->where("userid=".$olddata['userid'].' and id <>'.$_POST['id'].' and status =1')->find();
                if(!$old){//未审核先查找有没有已审核通过的消息 没有的话才修改信息
                    $data['groupid'] = 6;
                    $user->where("id=".$olddata['userid'])->save($data);
                    $school = M('School');
                    $school->where("id=".$info['schoolid'])->save($data);
                    $kecheng = M('Kecheng');
                    $kecheng->where("school_id=".$info['schoolid'])->save($data);
                }
            }

        }
//        echo '<pre>';
//        print_r($olddata);
//        print_r($_POST);
//        die;
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		
		// 更新数据
		$list=$model->save ();
		if (false !== $list) {
			$id= $_POST['id'];
			$catid = $module =='Page' ? $id : $_POST['catid'];
            
            //to-do: 这里需要判断有没有副栏目字段， 如果有，就把副栏目的数据更新到对应的数据表中。 
            $this->deleteCatalog($id);
            $this->insertCatalog($id);
            
			if($olddata['keywords']!=$_POST['keywords']  && $module !='Page'){
				 

				$tagidarr=$tagdatas=$where=array();
				$where['name']=array('in',$olddata['keywords']);
				$where['moduleid']=array('eq',$cat['moduleid']);
				$where['lang']=array('eq',$_POST['lang']);
				M('Tags')->where($where)->setDec('num'); 

				$tagsdata =M('Tags_data');
				$tagsdata->where("id=".$id)->delete();

				$keywordsarr=explode(',',$_POST['keywords']);			
				foreach((array)$keywordsarr as $tagname){
					if($tagname){
						$tagidarr=$tagdatas=$where=array();
						$where['name']=array('eq',$tagname);
						$where['moduleid']=array('eq',$cat['moduleid']);
						$where['lang']=array('eq',$_POST['lang']);
						$tagid=M('Tags')->where($where)->field('id')->find();
						$tagidarr['id']=$id;
						if($tagid['id']>0){
							M('Tags')->where("id=".$tagid[id])->setInc('num'); ;
							$tagidarr['tagid']=$tagid['id'];
						}else{
							$tagdatas['moduleid']=$cat['moduleid'];
							$tagdatas['name'] = $tagname;
							$tagdatas['slug'] = Pinyin($tagname);
							$tagdatas['num']=1;
							$tagdatas['lang']=$_POST['lang'];
							$tagdatas['module']= $cat['module'];
							$tagidarr['tagid']=M('Tags')->add($tagdatas);
						}
						$tagsdata->add($tagidarr);
					}
				}
				M('Tags')->where('num<=0')->delete();
			}

			if($_POST['aid']) {
				$Attachment =M('Attachment');		
				$aids =  implode(',',$_POST['aid']);
				$data['id']= $id;
				$data['catid']= $catid;
				$data['status']= '1';
				$Attachment->where("aid in (".$aids.")")->save($data);
			}
			$cat = $this->categorys[$catid];
			if($cat['ishtml']){
				if($module!='Page'  && $_POST['status'])	$this->create_show($_POST['id'],$module);
				$arrparentid = array_filter(explode(',',$cat['arrparentid'].','.$cat['id']));
				foreach($arrparentid as $catid) {
					if($this->categorys[$catid]['ishtml'])	$this->clisthtml($catid);					
				}
 			}
			if($this->sysConfig['HOME_ISHTML']) $this->create_index();
			$this->assign ( 'jumpUrl', $_POST['forward'] );
			$this->success (L('edit_ok'));
		} else {
			//错误提示
			$this->success (L('edit_error').': '.$model->getDbError());
		}
	}

 
	function statusallok(){

		$module = MODULE_NAME;
		$model = M ( $module );
		$ids=$_POST['ids'];
		if(!empty($ids) && is_array($ids)){
			$id=implode(',',$ids);
			$data = $model->select($id);
			if($data){				
				foreach($data as $key=>$r){	
					$model->save(array(id=>$r['id'],status=>1));
					if($this->categorys[$r['catid']]['ishtml'] && $r['status'])$this->create_show($r['id'],$module);	
				}
				$cat =  $this->categorys[$r['catid']];
				if($cat['ishtml']){			
					if($this->sysConfig['HOME_ISHTML']) $this->create_index();
					$arrparentid = array_filter(explode(',',$cat['arrparentid'].','.$cat['id']));
					foreach($arrparentid as $catid) {
						if($this->categorys[$catid]['ishtml'])	$this->clisthtml($catid);					
					}
				}
				$this->success(L('do_ok'));
			}else{
				$this->error(L('do_error').': '.$model->getDbError());
			}
		}else{
			$this->error(L('do_empty'));
		}
	}

	/*状态*/

	public function status(){
		$module = MODULE_NAME;
		$model = D ($module);
		if($model->save($_GET)){
			$_POST ='';
			$_POST = $model->find($_GET['id']);
			$cat =  $this->categorys[$_POST['catid']];
			if($cat['ishtml']){
				if($module!='Page'  && $_POST['status'])	$this->create_show($_POST['id'],$module);				
				if($this->sysConfig['HOME_ISHTML']) $this->create_index();
				$arrparentid = array_filter(explode(',',$cat['arrparentid'].','.$cat['id']));
				foreach($arrparentid as $catid) {
					if($this->categorys[$catid]['ishtml'])	$this->clisthtml($catid);					
				}
 			}

			$this->success(L('do_ok'));
		}else{
			$this->error(L('do_error'));
		}
	}

	/**
	*  edit by qiuye
	*  ajax 更新产品状态(新品,促销等)
	*
	*/
	public function changeSatuas(){
		$name = MODULE_NAME;
		$model = M($name);
		$pk = $model->getPk();
		$post = $_POST;
		if($post['id']){
			$data[$post['field']] = $post['value'];
			if($model->where($pk . "=" .$post['id'])->save($data)){
				exit(json_encode(array('status'=>true,'message'=>L('do_ok'))));
			} else {
				exit(json_encode(array('status'=>false,'message'=>L('do_error'))));
			}
		} else{
			exit(json_encode(array('status'=>false,'message'=>L('do_error'))));
		}
	}

	/**
	*  edit by qiuye
	*  批量 更新产品状态(新品,促销等)
	*
	*/
	public function ChangeYes(){
		$name = MODULE_NAME;
		$model = M($name);
		$pk = $model->getPk();
		$ids = $_REQUEST['ids'];
		$field = $_REQUEST['catalog'];
		$value = $_REQUEST['value'];
		if(!empty($ids) && is_array($ids) && $field && ($value == 0 || $value == 1)){
			$data[$field] = $value;
			foreach ($ids as $id) {
				$model->where($pk . '=' .$id)->save($data);
			}
			if(in_array($name,$this->cache_model)) savecache($name);
			$this->success (L('do_ok'));
		} else {
			$this->error(L('do_empty'));
		} 
	}
}?>
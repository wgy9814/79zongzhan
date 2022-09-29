<?php
/**
 *
 * Base (前台公共模块)
 *
 * @package        YOURPHP
 * @author          liuxun QQ:147613338 <admin@yourphp.cn>
 * @copyright        Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version            YourPHP企业网站管理系统 v2.1 2011-03-01 yourphp.cn $
 */
if (!defined("Yourphp")) exit("Access Denied");

class BaseAction extends Action
{
    protected $Config, $sysConfig, $categorys, $module, $moduleid, $mod, $dao, $Type, $Role, $_userid, $_groupid, $_email, $_username, $forward, $user_menu, $Lang, $member_config, $vip_list;
    public $tdk_arr = array();//自定义tdk列表
    public function _initialize()
    {
        //md5秘钥
        define('MD5_KEY', '7723d3058efe1eb544c0a14aa182aabe');
        define('TIMESTAMP',time());
        import ( '@.ORG.Security' );
        $formhash = Security::getToken();
        $this->assign('formhash', $formhash);

        $_REQUEST = htmlspecialchars_array($_REQUEST);
//        sql注入过滤开始
        $_GET = filterArr($_GET);
        if(GROUP_NAME == 'Home'){
            $_REQUEST = filterArr($_REQUEST);
            $_POST = filterArr($_POST);
        }
//        sql注入过滤结束
        $this->sysConfig = F('sys.config');
        $this->module = F('Module');
        $this->Role = F('Role');
        $this->Type = F('Type');
        $this->mod = F('Mod');
        $this->moduleid = $this->mod[MODULE_NAME];
        if (APP_LANG) {
            $this->Lang = F('Lang');
            $this->assign('Lang', $this->Lang);
            if (get_safe_replace($_GET['l'])) {
                if (!$this->Lang[$_GET['l']]['status']) $this->error(L('NO_LANG'));
                $lang = $_GET['l'];
            } else {
                $lang = $this->sysConfig['DEFAULT_LANG'];
            }
            define('LANG_NAME', $lang);
            define('LANG_ID', $this->Lang[$lang]['id']);
            $this->categorys = F('Category_' . $lang);
            $this->Config = F('Config_' . $lang);
            $this->assign('l', $lang);
            $this->assign('langid', LANG_ID);
            $this->assign('langname', $this->Lang[$lang]['name']);
            $T = F('config_' . $lang, '', APP_PATH . 'Tpl/Home/' . $this->sysConfig['DEFAULT_THEME'] . '/');
            C('TMPL_CACHFILE_SUFFIX', '_' . $lang . '.php');
            cookie('think_language', $lang);
        } else {
            $T = F('config_' . $this->sysConfig['DEFAULT_LANG'], '', APP_PATH . 'Tpl/Home/' . $this->sysConfig['DEFAULT_THEME'] . '/');
            $this->categorys = F('Category');
            $this->Config = F('Config');
            cookie('think_language', $this->sysConfig['DEFAULT_LANG']);
        }
        $this->assign('T', $T);
        $this->assign($this->Config);
        $this->assign('Role', $this->Role);
        $this->assign('Type', $this->Type);
        $this->assign('Module', $this->module);
        $this->assign('Categorys', $this->categorys);
        import("@.ORG.Form");
        $this->assign('form', new Form());

        C('HOME_ISHTML', $this->sysConfig['HOME_ISHTML']);
        C('PAGE_LISTROWS', $this->sysConfig['PAGE_LISTROWS']);
        C('URL_M', $this->sysConfig['URL_MODEL']);
        C('URL_M_PATHINFO_DEPR', $this->sysConfig['URL_PATHINFO_DEPR']);
        C('URL_M_HTML_SUFFIX', $this->sysConfig['URL_HTML_SUFFIX']);
        C('URL_LANG', $this->sysConfig['DEFAULT_LANG']);
        C('DEFAULT_THEME_NAME', $this->sysConfig['DEFAULT_THEME']);


        import("@.ORG.Online");
        $session = new Online();
        if (cookie('auth')) {
            $yourphp_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'] . $_SERVER['HTTP_USER_AGENT']);
            list($userid, $groupid, $password) = explode("-", authcode(cookie('auth'), 'DECODE', $yourphp_auth_key));
            $this->_userid = $userid;
            $this->_username = cookie('username');
            $this->_groupid = $groupid;
            $this->_email = cookie('email');
        } else {
            $this->_groupid = cookie('groupid') ? cookie('groupid') : 4;
            $this->_userid = 0;
        }


        foreach ((array)$this->module as $r) {
            if ($r['issearch']) $search_module[$r['name']] = L($r['name']);
            if ($r['ispost'] && (in_array($this->_groupid, explode(',', $r['postgroup'])))) $this->user_menu[$r['id']] = $r;
        }
        if (GROUP_NAME == 'User') {
            $langext = $lang ? '_' . $lang : '';
            $this->member_config = F('member.config' . $langext);
            $this->assign('member_config', $this->member_config);
            $this->assign('user_menu', $this->user_menu);
            if ($this->_groupid == '5' && MODULE_NAME != 'Login') {
                $this->assign('jumpUrl', URL('User-Login/emailcheck'));
                $this->assign('waitSecond', 3);
                $this->success(L('no_regcheckemail'));
                exit;
            }
            $this->assign('header', TMPL_PATH . 'Home/' . THEME_NAME . '/Home_header.html');
        }
        if ($_GET['forward'] || $_POST['forward']) {
            $this->forward = get_safe_replace($_GET['forward'] . $_POST['forward']);
        } else {
            if (MODULE_NAME != 'Register' || MODULE_NAME != 'Login')
                $this->forward = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->Config['site_url'];
        }
        $this->assign('forward', $this->forward);

        $this->assign('search_module', $search_module);
        $this->assign('module_name', MODULE_NAME);
        $this->assign('action_name', ACTION_NAME);
        $this->assign('site_name', $this->Config['site_name']);

        //add BY zeb 设备判断 0-pc 1-手机 2-ipad
        $this->assign('device', is_mobile());

        if (cookie("userid")) {
            $user = M('user')->where('id=' . cookie("userid"))->find();
            $this->assign('user', $user);
        }

        $city = M('Block')->where(['lang' => 2, 'pos' => 'city'])->find();
        $city = $city ? trim(strip_tags($city['content'])) : '';
        $this->assign('city', $city);



        $this->tdk_arr= M('tdk')->where(['status' => 1,'parentid' => 0])->order ('type asc')->select();//自定义tdk

//        $school= M('category')->field('id,catname,catdir,module')->where(array('module'=>'School'))->find();//学校首页列表
        //echo '<pre>';
//        $school_article = M('category')->field('id,catname,catdir,module')->where(array('module'=>'Kecheng'))->select();//学校首页列表
//        foreach ($school_article as $val){
//            $where['catid'] = $val['id'];
//            $kecheng = M('kecheng')->where($where)->order ('listorder desc')->select();
//            foreach ($kecheng as $k =>$val1){
//                $schoolid = M('school')->where("id=".$val1['school_id'])->find();
//                //print_r($schoolid);
//                $school_name[$val1['id']] =$schoolid['title'];//学校名称列表
//                $address_name[$val1['id']] =$schoolid['address'];//地址列表
//                $article[$val1['id']] = $val1['url'];//课程文章url列表
//                $article_title[$val1['id']] = $val1['title'];//课程文章名称列表
//            }
//
//        }

        $list = ['vip普通会员', 'vip高级会员', 'vip钻石会员','定制服务'];
        foreach ($this->Role as $val){
            if(in_array($val['name'],$list)){
                $this->vip_list[$val['remark']] = $val['id'];
            }
        }
//        echo '<pre>';
//        print_r($this->vip_list);
        $url = $_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        $request_uri = request_uri();
        //print_r($request_uri);
        //print_r($article);

        $id = intval($_REQUEST['id']);
        $this->assign('now_time', time());
        $this->assign('city', $city);
    }

    public function index($catid = '', $module = '')
    {
        $this->Urlrule = F('Urlrule');
        if (empty($catid)) $catid = intval($_REQUEST['id']);
        $p = max(intval($_REQUEST[C('VAR_PAGE')]), 1);
        if ($catid) {
            $cat = $this->categorys[$catid];
            $bcid = explode(",", $cat['arrparentid']);
            $bcid = $bcid[1];
            if ($bcid == '') $bcid = intval($catid);
            if (empty($module)) $module = $cat['module'];
            $this->assign('module_name', $module);
            unset($cat['id']);
            $this->assign($cat);
            $cat['id'] = $catid;
            $this->assign('catid', $catid);
            $this->assign('bcid', $bcid);
        }
        if ($cat['readgroup'] && $this->_groupid != 1 && !in_array($this->_groupid, explode(',', $cat['readgroup']))) {
            $this->assign('jumpUrl', URL('User-Login/index'));
            $this->error(L('NO_READ'));
        }
        $fields = F($this->mod[$module] . '_Field');
        foreach ($fields as $key => $r) {
            $fields[$key]['setup'] = string2array($fields[$key]['setup']);
        }
        $this->assign('fields', $fields);


        $seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
        $this->assign('seo_title', $seo_title);
        $this->assign('seo_keywords', $cat['keywords']);
        $this->assign('seo_description', $cat['description']);

        if ('Kecheng' == $module && !empty($_GET['p'])) {
            $schoolid = M('school')->where("id=$_GET[p]")->find();
            $this->assign('schoolid', $schoolid);
        }

        if ($module == 'Guestbook') {
            $where['status'] = array('eq', 1);
            $this->dao = M($module);
            $count = $this->dao->where($where)->count();
            if ($count) {
                import("@.ORG.Page");
                $listRows = !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');
                $page = new Page ($count, $listRows);
                $page->urlrule = geturl($cat, '');
                $pages = $page->show();
                $field = $this->module[$cat['moduleid']]['listfields'];
                $field = $field ? $field : '*';
                $list = $this->dao->field($field)->where($where)->order('createtime desc,id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
                $this->assign('pages', $pages);
                $this->assign('list', $list);
            }
            $template = $cat['module'] == 'Guestbook' && $cat['template_list'] ? $cat['template_list'] : 'index';
            $this->display(THEME_PATH . $module . '_' . $template . '.html');
        } elseif ($module == 'Feedback') {
            $template = $cat['module'] == 'Feedback' && $cat['template_list'] ? $cat['template_list'] : 'index';

            $this->display(THEME_PATH . $module . '_' . $template . '.html');
        } elseif ($module == 'Page') {
            $modle = M('Page');
            $data = $modle->find($catid);
            unset($data['id']);

            //分页
            $CONTENT_POS = strpos($data['content'], '[page]');
            if ($CONTENT_POS !== false) {
                $urlrule = geturl($cat, '', $this->Urlrule);
                $urlrule[0] = urldecode($urlrule[0]);
                $urlrule[1] = urldecode($urlrule[1]);
                $contents = array_filter(explode('[page]', $data['content']));

                $pagenumber = count($contents);
                for ($i = 1; $i <= $pagenumber; $i++) {
                    $pageurls[$i] = str_replace('{$page}', $i, $urlrule);
                }
                $pages = content_pages($pagenumber, $p, $pageurls);

                //判断[page]出现的位置
                if ($CONTENT_POS < 7) {
                    $data['content'] = $contents[$p];
                } else {
                    $data['content'] = $contents[$p - 1];
                }
                $this->assign('pages', $pages);
            }

            $template = $cat['template_list'] ? $cat['template_list'] : 'index';

            $this->assign($data);
            $this->display(THEME_PATH . $module . '_' . $template . '.html');

        } else {
            $request_uri = request_uri();
            //if(strpos($request_uri,'/school2/')){//学校首页
            //    $list = $this->tdk_arr[0];
            //    $child_arr = M('tdk')->where(['status' => 1,'type' => 1,'child_id' => $_GET['p']])->find();//查找该学校首页有没有自定义tdk
            //    if(!empty($child_arr)){
            //        $list = $child_arr;
            //    }else{
            //        $list = $this->tdk_arr[0];
            //    }
            //}else if(strpos($request_uri,'/kec/')){ //最新课程页面
            //
            //}


            if ($catid) {
                $seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
                $this->assign('seo_title', $seo_title);
                $this->assign('seo_keywords', $cat['keywords']);
                $this->assign('seo_description', $cat['description']);
                $prefix=C( "DB_PREFIX" );

                if ('Kecheng' == $module ) {
                    $areaName = isset($this->categorys[$_GET['id']]) && 69== $this->categorys[$_GET['id']]['parentid'] ? $this->categorys[$_GET['id']]['catname']:'';
                    $this->assign('areaName', $areaName);
//                    echo '<pre>';
//                    print_r($this->tdk_arr);
                    if(empty($cat['listtype'])){
                        $child_arr = M('tdk')->where(['status' => 1,'type' => 4,'child_id' => $_GET['id']])->find();//查找该最新课程页面有没有自定义tdk
                        if(!empty($child_arr)){
                            $list = $child_arr;
                        }else{
                            $list = $this->tdk_arr[3];
                        }

                        $areas_name = '';
                        if(!empty($areaName)){
                            $areas_name = $areaName;
                        }

                        $new_title = $seo_title;
                        $new_description = $cat['description'] ;
                        $new_keywords = $cat['keywords'];

                        $param = array();
                        $param['area']     = trim($areas_name);
                        $param['industry']     = trim($cat['catname']);
                        $param['site_name'] = $this->Config['site_name'];

                        if(!empty($areaName) || empty($seo_title)){
                            $new_title = ncReplaceText($list['title_rule'],$param);
                        }
                        if(!empty($areaName) || empty($cat['description'])){
                            $new_description = ncReplaceText($list['description_rule'],$param);
                        }
                        if(!empty($areaName) || empty($cat['keywords'])){
                            $new_keywords = ncReplaceText($list['keywords_rule'],$param);
                        }

                        $this->assign('seo_title', $new_title);
                        $this->assign('seo_keywords', $new_keywords);
                        $this->assign('seo_description', $new_description);

                    }
                    if(!empty($_GET['p']) && $cat['catdir'] == 'kec'){
                        $schoolid = M('school')->where("id=$_GET[p]")->find();
                        if($schoolid['status'] == 0){
                            $this->error(L('该学校不存在或审核暂未通过'), $_SERVER["HTTP_REFERER"]);
                        }
                        $child_arr = M('tdk')->where(['status' => 1,'type' => 2,'child_id' => $_GET['p']])->find();//查找该最新课程页面有没有自定义tdk
                        if(!empty($child_arr)){
                            $list = $child_arr;
                        }else{
                            $list = $this->tdk_arr[1];
                        }
                        $param = array();
                        $param['title']     = $schoolid['title'];
                        $new_title = ncReplaceText($list['title_rule'],$param);
                        $param = array();
                        //print_r($new_title);
                        //$schoolid = M('school')->where("id=".$key)->find();

                        //$cat_list = M('user')->where(array('status'=>1, 'schoolid'=>$_GET['p']))->find();//最新课程页面的所有列表
                        //echo '<pre>';
                        $cat_list = M('category')->table($prefix.'category as a')->join($prefix."kecheng as b on a.id=b.catid ")
                            ->where("b.status=1 and b.school_id=".$_GET['p'])->find();

                        $param['title']     = $schoolid['title'];
                        $param['area']     = $schoolid['area'];
                        $param['industry'] = $cat_list['catname'];
                        $param['site_name'] = $this->Config['site_name'];
                        $new_description = ncReplaceText($list['description_rule'],$param);

                        $param = array();
                        $param['title']     = $schoolid['title'];
                        $new_keywords = ncReplaceText($list['keywords_rule'],$param);
                        $this->assign('seo_title', $new_title);
                        $this->assign('seo_keywords', $new_keywords);
                        $this->assign('seo_description', $new_description);
                    }

                }

                if ('School' == $module) {
                    $schoolid = M('school')->where("id=$_GET[p]")->find();
                    $user = M('User')->where('schoolid='.$_GET['p'])->find();
                    if($user) {
                        $now = time();
                        $where['userid'] = $user['id'];
                        $where['status'] = 1;
                        $where['expire_time'] = array('gt',$now);
                        $where['type'] = $user['groupid'];
                        $user_level = M('User_level')->where($where)->find();
//                        echo  M('User_level')->getLastSql();
                        if ($user_level) {//后台有审核通过的vip会员信息
                            $user_mark = verify_groupid($user_level['type']);
                            $this->assign('user_mark', $user_mark);
                        }
                    }
//                    print_r($user_level);

                    $user->schoolid = $schoolid;
                    if($schoolid['status'] == 0){
                        $this->error(L('该学校不存在或审核暂未通过'), $_SERVER["HTTP_REFERER"]);
                    }
                    $this->assign('schoolid', $schoolid);
                    $child_arr = M('tdk')->where(['status' => 1,'type' => 1,'child_id' => $_GET['p']])->find();//查找该学校首页有没有自定义tdk
                    if(!empty($child_arr)){
                        $list = $child_arr;
                    }else{
                        $list = $this->tdk_arr[0];
                    }
                    //print_r($list);
                    $cat_list = M('category')->table($prefix.'category as a')->join($prefix."school as b on a.id=b.industryx ")
                        ->where("b.status=1 and b.id=".$_GET['p'])->find();

                    $param = array();
                    $param['title']     = $schoolid['title'];
                    $param['area']     = $schoolid['area'];
                    $param['industry'] = $cat_list['catname'];
                    $new_title = ncReplaceText($list['title_rule'],$param);
                    $len = mb_strlen($schoolid['title'],'utf8');
                    $maths = mb_substr($schoolid["description"],0,$len,'utf-8');
                    if($maths == $schoolid['title']){
                        $new_description=mb_substr($schoolid["description"],$len,$list['description_rule'],'utf-8');
                    }else{
                        $new_description=mb_substr($schoolid["description"],0,$list['description_rule'],'utf-8');
                    }

                    //print_r($new_description);
                    //echo '<pre>';
                    //print_r($param);
                    $param = array();
                    $param['title']     = $schoolid['title'];
                    $param['area']     = $schoolid['area'];
                    $param['industry'] = $cat_list['catname'];
                    $param['address']     = $schoolid['address'];
                    $new_keywords = ncReplaceText($list['keywords_rule'],$param);

                    $this->assign('seo_title', $new_title);
                    $this->assign('seo_keywords', $new_keywords);
                    $this->assign('seo_description', $new_description);
                }

                //*edit by jzp start
                $where = " status=1 and ";
                $where_catid = "";
                if ($cat['child']) {
                    $where_catid .= " catid in(" . $cat['arrchildid'] . ")";
                } else {
                    $where_catid .= " catid=" . $catid;
//                    if(!empty($_GET['p'])){
//                        $where_catid .= " school_id=" . $_GET['p'];
//                    }else{
//                        $where_catid .= " catid=" . $catid;
//                    }

                }
                //*edit by jzp end
                //to-do: 如果有副栏目关联表， 加一个条件(exists) add by jzp
                if ($relationId = hasCatalogField($cat['moduleid'])) {
                    $module = $module ? $module : MODULE_NAME;
                    $tablename = C('DB_PREFIX') . strtolower($module) . '_catalog';
                    $primaryKey = strtolower($module) . '_id';
                    $where_catid = " ($where_catid or exists(select 1 from `$tablename` where `id` = `$primaryKey` and `$relationId` = $catid))";
                }
                $where .= $where_catid;
                if (strtolower($module) == 'logistics') {
                    $order_sn = isset($_REQUEST['order_sn']) ? $_REQUEST['order_sn'] : '';
                    $match = preg_match('/\w+/', $order_sn);
                    if ($match) {
                        $where .= " and order_sn like '%{$order_sn}%'";
                    }
                }
                if (empty($cat['listtype'])) {
                    $this->dao = M($module);
                    $count = $this->dao->where($where)->count();
//                    echo $this->dao->getLastSql();

                    if ($count) {
                        $this->assign('count', $count);
                        import("@.ORG.Page");
                        $listRows = !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');
                        $page = new Page ($count, $listRows);
                        $page->urlrule = geturl($cat, '', $this->Urlrule);
                        $pages = $page->show();
                        //add by zeb响应式手机端 上一页和下一页
                        $this->assign('prePage', $page->prePage);
                        $this->assign('nextPage', $page->nextPage);
                        //end
                        $field = $this->module[$this->mod[$module]]['listfields'];

                        $list = $this->dao->field($field)->where($where)->order('listorder desc, createtime desc,id desc')
                            ->limit($page->firstRow . ',' . $page->listRows)->select();

//                        echo '<pre>';
//                        print_r($list);
                        foreach ($list as $key => $value) {
                            if ('Kecheng' == $module ) {
                                $school = M('school')->where("id=$value[school_id]")->find();
//                                print_r($school['status']);
                                if($school['status'] == 0){
                                    unset($list[$key]);
                                    continue;
                                }
                                $user = M('User')->where('schoolid='.$school['id'])->find();
                                if($user){
                                    $now = time();
                                    $where = [];
                                    $where['userid'] = $user['id'];
                                    $where['status'] = 1;
                                    $where['expire_time'] = array('gt',$now);
                                    $where['type'] = $user['groupid'];
                                    $user_level = M('User_level')->where($where)->find();
//                                    echo  M('User_level')->getLastSql();
                                    if($user_level){//后台有审核通过的vip会员信息
                                        $user_mark = verify_groupid($user_level['type']);
                                        $list[$key]['user_mark'] = $user_mark;
    //                                    $this->assign('user_mark', $user_mark);
                                    }
                                }
                            }
                            if ($value['pics']) {
                                $p_data = explode(':::', $value['pics']);
                                $value['pics'] = array();
                                foreach ($p_data as $k => $res) {
                                    $p_data_arr = explode('|', $res);
                                    $value['pics'][$k]['filepath'] = $p_data_arr[0];
                                    $value['pics'][$k]['filename'] = $p_data_arr[1];
                                }
                                $list[$key] = $value;
                                unset($p_data);
                                unset($p_data_arr);
                            }
                        }
//                        print_r($list);
                        $this->assign('pageNum', ceil($count / $listRows));
                        $this->assign('pages', $pages);
                        $this->assign('list', $list);
                    }
                    $template_r = 'list';
                } else {
                    $template_r = 'index';
                }
            } else {
                $template_r = 'list';
            }
            $template = $cat['template_list'] ? $cat['template_list'] : $template_r;
            if ($module == 'Kecheng' && 'show'!=$action_name && isset($_REQUEST['p']) && !empty($_REQUEST['p']) && 'kec'==$cat['catdir']) {
                $template = $template . '_sid';
            }

            $this->assign('template', $template);
            $this->display($module . ':' . $template);
        }
    }


    public function show($id = '', $module = '')
    {
        $this->Urlrule = F('Urlrule');
        $p = max(intval($_REQUEST[C('VAR_PAGE')]), 1);
        $id = $id ? $id : intval($_REQUEST['id']);
        $module = $module ? $module : MODULE_NAME;
        $this->assign('module_name', $module);
        $this->dao = M($module);
        $data = $this->dao->find($id);
        if ($module=='Kecheng' && $data['status'] == 0) {
            $this->error(L('该课程不存在或审核暂未通过'), $_SERVER["HTTP_REFERER"]);
        }
        $catid = $data['catid'];
        $cat = $this->categorys[$data['catid']];
        if (empty($cat['ishtml'])) $this->dao->where("id=" . $id)->setInc('hits'); //添加点击次数
        $bcid = explode(",", $cat['arrparentid']);
        $bcid = $bcid[1];
        if ($bcid == '') $bcid = intval($catid);

        if ($data['readgroup']) {
            if ($this->_groupid != 1 && !in_array($this->_groupid, explode(',', $data['readgroup']))) $noread = 1;
        } elseif ($cat['readgroup']) {
            if ($this->_groupid != 1 && !in_array($this->_groupid, explode(',', $cat['readgroup']))) $noread = 1;
        }
        if ($noread == 1) {
            $this->assign('jumpUrl', URL('User-Login/index'));
            $this->error(L('NO_READ'));
        }

        $chargepoint = $data['readpoint'] ? $data['readpoint'] : $cat['chargepoint'];
        if ($chargepoint && $data['userid'] != $this->_userid) {
            $user = M('User');
            $userdata = $user->find($this->_userid);
            if ($cat['paytype'] == 1 && $userdata['point'] >= $chargepoint) {
                $chargepointok = $user->where("id=" . $this->_userid)->setDec('point', $chargepoint);
            } elseif ($cat['paytype'] == 2 && $userdata['amount'] >= $chargepoint) {
                $chargepointok = $user->where("id=" . $this->_userid)->setDec('amount', $chargepoint);
            } else {
                $this->error(L('NO_READ'));
            }
        }
        //echo '<pre>';
        $request_uri = request_uri();
        //print_r($data);
        if(in_array($request_uri,$article)){
            //$key = array_search($request_uri,$article);
            //$param = array();

        }else{

        }
        $child_arr = M('tdk')->where(['status' => 1,'type' => 3,'child_id' => $id])->find();//查找该课程文章有没有自定义tdk
        if(!empty($child_arr)){
            $list = $child_arr;
        }else{
            $list = $this->tdk_arr[2];
        }


        if ($module=='Kecheng') {
            $cat_list = M('category')->field('id,catname')->where(array('id'=>$data['kccity']))->find();//学校首页列表

            $schoolid = M('school')->where("id=".$data['school_id'])->find();
            if($schoolid['status'] == 0){
                $this->error(L('该学校不存在或审核暂未通过'), $_SERVER["HTTP_REFERER"]);
            }

            $user = M('User')->where('schoolid='.$schoolid['id'])->find();
            if($user) {
                $now = time();
                $where = [];
                $where['userid'] = $user['id'];
                $where['status'] = 1;
                $where['expire_time'] = array('gt',$now);
                $where['type'] = $user['groupid'];
                $user_level = M('User_level')->where($where)->find();
//                echo M('User_level')->getLastSql();
                if ($user_level) {//后台有审核通过的vip会员信息
                    $user_mark = verify_groupid($user_level['type']);
                    $this->assign('user_mark', $user_mark);
                    $user_special_mark = verify_special_groupid($user_level['type']);
                    $this->assign('user_special_mark', $user_special_mark);
                }
            }
            $param = array();
            $param['title']     = $data['title'];
            $param['site_name'] = $this->Config['site_name'];
            $new_title = ncReplaceText($list['title_rule'],$param);
            $param = array();
            //$schoolid = M('school')->where("id=".$key)->find();

            $param['title']     = $data['title'];
            $param['school'] = $schoolid['title'];
            $param['area']     = $cat_list['catname'];
            $param['industry'] = $cat['catname'];
            $param['contact'] = $schoolid['dianhua'];
            $new_description = ncReplaceText($list['description_rule'],$param);
            //print_r($new_description);
            $param = array();
            $param['title']     = $data['title'];
            $param['area']     = $cat_list['catname'];
            $param['industry'] = $cat['catname'];
            $new_keywords = ncReplaceText($list['keywords_rule'],$param);
            //print_r($new_keywords);

            //$url = $_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
            //if(strpos($url,'/wlpx/show/')){
            //    $seo_title = $data['title'] . '-' . $data['address']. $cat['catname'];
            //}else{
            //    $seo_title = $data['title'] . '-' . $cat['catname'];
            //}
            //1.网上报名 线下价格都有填写
            if(($data['price1'] || $data['price1'] != '0.00') && ($data['pc'] || $data['pc'] != '0.00')){
                $data['price1_desc'] = $data['price1'].'元';
                $data['pc_desc'] = $data['pc'].'元';
            }

            //2.网上报名 线下价格都没有填写
            if((!$data['price1'] || $data['price1'] == '0.00') && (!$data['pc'] || $data['pc'] == '0.00')){
                $data['price1_desc'] = '';
                $data['pc_desc'] = '有优惠';
            }

            //3.网上报名有填写 线下价格没有填写
            if((!$data['price1'] || $data['price1'] == '0.00') && ($data['pc'] || $data['pc'] != '0.00')){
                $data['price1_desc'] = '';
                $data['pc_desc'] = $data['pc'].'元';
            }

            //4.网上报名没有填写 线下价格有填写
            if(($data['price1'] || $data['price1'] != '0.00') && (!$data['pc'] || $data['pc'] == '0.00')){
                $data['price1_desc'] = $data['price1'].'元';
                $data['pc_desc'] = '有优惠';
            }
//            print_r($data);
            $this->assign('seo_title', $new_title);
            $this->assign('seo_keywords', $new_keywords);
            $this->assign('seo_description', $new_description);
            $this->assign('fields', F($cat['moduleid'] . '_Field'));
        } else {
            $seo_title = $data['title'] . '-' . $cat['catname'];
            $this->assign('seo_title', $seo_title);
            $this->assign('seo_keywords', $data['keywords']);
            $this->assign('seo_description', $data['description']);
            $this->assign('fields', F($cat['moduleid'] . '_Field'));
        }

        $fields = F($this->mod[$module] . '_Field');
        foreach ($data as $key => $c_d) {
            $setup = '';
            $fields[$key]['setup'] = $setup = string2array($fields[$key]['setup']);
            if ($setup['fieldtype'] == 'varchar' && $fields[$key]['type'] != 'text') {
                $data[$key . '_old_val'] = $data[$key];
                $data[$key] = fieldoption($fields[$key], $data[$key]);
            } elseif ($fields[$key]['type'] == 'images' || $fields[$key]['type'] == 'files') {
                if (!empty($data[$key])) {
                    $p_data = explode(':::', $data[$key]);
                    $data[$key] = array();
                    foreach ($p_data as $k => $res) {
                        $p_data_arr = explode('|', $res);
                        $data[$key][$k]['filepath'] = $p_data_arr[0];
                        $data[$key][$k]['filename'] = $p_data_arr[1];
                    }
                    unset($p_data);
                    unset($p_data_arr);
                }
            }
            unset($setup);
        }
        $this->assign('fields', $fields);


        //手动分页
        $CONTENT_POS = strpos($data['content'], '[page]');
        if ($CONTENT_POS !== false) {

            $urlrule = geturl($cat, $data, $this->Urlrule);
            $urlrule = str_replace('%7B%24page%7D', '{$page}', $urlrule);
            $contents = array_filter(explode('[page]', $data['content']));
            $pagenumber = count($contents);
            for ($i = 1; $i <= $pagenumber; $i++) {
                $pageurls[$i] = str_replace('{$page}', $i, $urlrule);
            }
            $pages = content_pages($pagenumber, $p, $pageurls);
            //判断[page]出现的位置是否在文章开始
            if ($CONTENT_POS < 7) {
                $data['content'] = $contents[$p];
            } else {
                $data['content'] = $contents[$p - 1];
            }
            $this->assign('pages', $pages);
        }

        if (!empty($data['template'])) {
            $template = $data['template'];
        } elseif (!empty($cat['template_show'])) {
            $template = $cat['template_show'];
        } else {
            $template = 'show';
        }

        $this->assign('catid', $catid);
        $this->assign($cat);
        $this->assign('bcid', $bcid);

        $this->assign($data);

        //上一篇 下一篇
        $nextWhere = "id < $id ";
        if (defined('LANG_ID')) {
            $nextWhere .= " and lang=" . LANG_ID;
        }
        $tid = $this->dao->field("id")->where($nextWhere)->order("id desc")->find();
        if ($tid) {
            $next = $this->dao->field("title,url")->find($tid["id"]);
        }
        $this->assign('nextPage', $next);
        $prevWhere = "id > $id ";
        if (defined('LANG_ID')) {
            $prevWhere .= " and lang=" . LANG_ID;
        }
        $tid = $this->dao->field("id")->where($prevWhere)->order("id")->find();
        if ($tid) {
            $pre = $this->dao->field("title,url")->find($tid["id"]);
        }
        $this->assign('prePage', $pre);

        //浏览记录
        $ids = cookie('ids') ? cookie('ids') : array();
        if (!in_array($id, $ids)) {
            array_push($ids, $id);
            cookie('ids', $ids, 0);
            $ids = cookie('ids');
        }
        $all = implode(',', $ids);
        $view_data = M($module)->field('id,url,title,thumb')->select($all);
        $this->assign('view_data', $view_data);

        if ($module == 'Kecheng' && isset($_REQUEST['sid'])) {
            $template = $template . '_sid';
        }

        $this->display($module . ':' . $template);
    }

    public function down()
    {

        $module = $module ? $module : MODULE_NAME;
        $id = $id ? $id : intval($_REQUEST['id']);
        $this->dao = M($module);
        $filepath = $this->dao->where("id=" . $id)->getField('file');
        $this->dao->where("id=" . $id)->setInc('downs');

        if (strpos($filepath, ':/')) {

            header("Location: $filepath");
        } else {
            $filepath = '.' . $filepath;
            if (!$filename) $filename = basename($filepath);
            $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
            if (strpos($useragent, 'msie ') !== false) $filename = rawurlencode($filename);
            $filetype = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
            $filesize = sprintf("%u", filesize($filepath));
            if (ob_get_length() !== false) @ob_end_clean();
            header('Pragma: public');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: pre-check=0, post-check=0, max-age=0');
            header('Content-Transfer-Encoding: binary');
            header('Content-Encoding: none');
            header('Content-type: ' . $filetype);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-length: ' . $filesize);
            readfile($filepath);
        }
        exit;
    }

    public function hits()
    {
        $module = $module ? $module : MODULE_NAME;
        $id = $id ? $id : intval($_REQUEST['id']);
        $this->dao = M($module);
        $this->dao->where("id=" . $id)->setInc('hits');

        if ($module == 'Download') {
            $r = $this->dao->find($id);
            echo '$("#hits").html(' . $r['hits'] . ');$("#downs").html(' . $r['downs'] . ');';
        } else {
            $hits = $this->dao->where("id=" . $id)->getField('hits');
            echo '$("#hits").html(' . $hits . ');';
        }
        exit;
    }

    public function verify()
    {
        header('Content-type: image/jpeg');
        $type = isset($_GET['type']) ? get_safe_replace($_GET['type']) : 'jpeg';
        import("@.ORG.Image");
        Image::buildImageVerify(4, 5, $type);
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



}

?>
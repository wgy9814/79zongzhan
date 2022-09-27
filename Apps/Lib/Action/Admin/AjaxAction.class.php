<?php
/**
 * 
 * AreaAction.class.php (ajax 获取地址)
 *
 * @package      	YOURPHP
 * @author          liuxun QQ:147613338 <admin@yourphp.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.yourphp.cn)
 * @license         http://www.yourphp.cn/license.txt
 * @version        	YourPHP企业网站管理系统 v2.1 2011-03-01 yourphp.cn $
 */
if(!defined("Yourphp")) exit("Access Denied");
class AjaxAction extends AdminbaseAction
{

	public function get_tdk(){
		$type =$_REQUEST['type'];
        switch($type) {
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
        $str = '<option value="0">请选择</option>';
        foreach($list as $key=>$pro){
            $selected = ( $pro['id']==$provinceid) ? ' selected="selected" ' : '';
            $str .='<option value="'.$pro['id'].'"'.$selected.'>'.$pro['title'].'</option>';
        }
        echo json_encode($str); exit;
        //echo '<pre>';
        //print_r($str);

	}

}
?>
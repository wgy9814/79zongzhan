<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" /><title><?php echo L('welcome');?></title><link rel="stylesheet" type="text/css" href="__ROOT__/Public/Css/style.css" /><link rel="stylesheet" type="text/css" href="__ROOT__/Public/Css/common.css" /><link rel="stylesheet" type="text/css" href="__ROOT__/Public/Css/jquery.searchableSelect.css" /><script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/jquery.artDialog.js?skin=default"></script><script type="text/javascript" src="__ROOT__/Public/Js/iframeTools.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/jquery.form.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/jquery.validate.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/MyDate/WdatePicker.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/jquery.colorpicker.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/my.js"></script><script type="text/javascript" src="__ROOT__/Public/Js/swfupload.js"></script><?php if('System'==$module_name || 'Feedback'==$module_name) : ?><script type="text/javascript" src="__ROOT__/Public/Js/jquery-1.11.1.min.js"></script><?php endif;?><script type="text/javascript" src="__ROOT__/Public/Js/jquery.searchableSelect.js"></script><script language="JavaScript"><!--
var ROOT =	 '__ROOT__';
var URL = '__URL__';
var APP	 =	 '__APP__';
var PUBLIC = '__PUBLIC__';
function confirm_delete(url){
	art.dialog.confirm("<?php echo L('real_delete');?>", function(){location.href = url;});
}
//--></script></head><body width="100%"><div id="loader" ><?php echo L('load_page');?></div><div id="result" class="result none"></div><div class="mainbox"><?php if(empty($_GET['isajax'])): ?><div id="nav" class="mainnav_title"><div id="lang"><?php if(APP_LANG): parse_str($_SERVER['QUERY_STRING'],$urlarr); unset($urlarr[l]); $url='index.php?'.http_build_query($urlarr); if(is_array($Lang)): $i = 0; $__LIST__ = $Lang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$langvo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($url); ?>&l=<?php echo ($langvo["mark"]); ?>" <?php if($langvo[mark]==$_SESSION['YP_lang']): ?>class="on"<?php endif; ?>><?php echo ($langvo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; endif; ?></div><?php if('Feedback'!=$module_name) : ?><ul><a href="<?php echo U($nav[bnav][model].'/'.$nav[bnav][action],$nav[bnav][data]);?>"><?php echo ($nav["bnav"]["name"]); ?></a>|
	<?php if(is_array($nav["nav"])): $i = 0; $__LIST__ = $nav["nav"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vonav): $mod = ($i % 2 );++$i; if($vonav[data][isajax]): ?><a href="javascript:void(0);" onclick="openwin('<?php echo ($vonav[action]); ?>','<?php echo U($vonav[model].'/'.$vonav[action],$vonav[data]);?>','<?php echo ($vonav["name"]); ?>',600,440)"><?php echo ($vonav["name"]); ?></a>|
	<?php else: ?><a href="<?php echo U($vonav[model].'/'.$vonav[action],$vonav[data]);?>"><?php echo ($vonav["name"]); ?></a>|<?php endif; endforeach; endif; else: echo "" ;endif; ?></ul><?php endif;?></div><script>
	//|str_replace=__ROOT__.'/index.php','',###
	var onurl ='<?php echo ($_SERVER["REQUEST_URI"]); ?>';
	jQuery(document).ready(function(){
		$('#nav ul a ').each(function(i){
		if($('#nav ul a').length>1){
			var thisurl= $(this).attr('href');
			thisurl = thisurl.replace('&menuid=<?php echo cookie("menuid");?>','');
			if(onurl.indexOf(thisurl) == 0 ) $(this).addClass('on').siblings().removeClass('on');
		}else{
			$('#nav ul').hide();
		}
		});
		if($('#nav ul a ').hasClass('on')==false){
		$('#nav ul a ').eq(0).addClass('on');
		}
	});
	</script><?php endif; ?><div id="msg"></div><form name="myform" id="myform" action="<?php if($action_name=='add'): echo U($module_name.'/insert'); else: echo U($module_name.'/update'); endif; ?>&iscreatehtml=1" method="post"><div id="filelist" class="hide"></div><div class="error"><ul></ul></div><table cellpadding=0 cellspacing=0 class="table_form" width="100%"><?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if(!empty($r['status'])): if('Kecheng' == MODULE_NAME && 'kccity' == $r['field']) : ?><tr><td width="10%" ><?php if($r['required']): ?><font color="red">*</font><?php endif; echo ($r["name"]); ?></td><td width="90%" id="box_<?php echo ($r['field']); ?>"><select name="kccity"><?php $city = M('Category')->where(array('parentid' => 69))->field('id,catname')->select(); foreach($city as $c) { echo '<option value="'.$c['id'].'">'.$c['catname'].'</option>'; } ?></select><script>console.log('<?php echo ($vo["kccity"]); ?>')
                	$(function(){
                		var kccity = "<?php echo ($vo['kccity']); ?>";
                		$('select[name="kccity"]').find('option').each(function(){
                			if($(this).val()==kccity)
                			{
                				$(this).attr('selected', 'selected');
                				return false;
                			}
                		});
                	});
                </script></td></tr><?php else :?><tr><td width="10%" ><?php if($r['required']): ?><font color="red">*</font><?php endif; echo ($r["name"]); ?></td><td width="90%" id="box_<?php echo ($r['field']); ?>"><?php echo (getform($form,$r)); if($r[field]=='title'&&$fields[cc]): ?><span style="position: absolute;left:510px; top:170px">缩略图尺寸为：<?php echo($fields['cc']['setup']['default']); ?></span><?php endif; ?></td></tr><?php endif; if($r['field']=='title' && $module_name=='System') : ?><tr><td width="10%">指定用户</td><td width="90%" id="box_user"><select name="userid" id="userid"><?php $user = M('User')->where(array('status'=>1, 'id'=>array('neq', 3)))->select(); if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$u): $mod = ($i % 2 );++$i;?><option value="<?php echo ($u["id"]); ?>" <?php if($vo['userid']==$u['id']) : ?>selected="selected"<?php endif;?>>[<?php echo ($u["id"]); ?>] <?php echo ($u["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></td></tr><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?></table><div id="bootline"></div><div id="btnbox" class="btn"><?php if($vo['id']!=''): ?><input TYPE="hidden" name="id" value="<?php echo ($vo["id"]); ?>"><?php endif; ?><input type='hidden' name='<?php echo ($parentModuleKey); ?>' value='<?php echo ($parentModuleValue); ?>'><input type="hidden"  name="lang" value="<?php echo ($langid); ?>" /><input type="hidden" name="forward" value="<?php echo ($_SERVER['HTTP_REFERER']); ?>" /><INPUT TYPE="submit"  value="<?php echo L('dosubmit');?>" class="button" ><input TYPE="reset"  value="<?php echo L('cancel');?>" class="button"></div></form></div><script>
    $(function(){
        $('#userid').searchableSelect();
    });
</script></body></html>
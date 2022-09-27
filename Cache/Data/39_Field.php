<?php
return array ( 'user_name' => array ( 'id' => '492', 'moduleid' => '39', 'field' => 'user_name', 'name' => '用户名称', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '1', 'status' => '1', 'issystem' => '0', ), 'title' => array ( 'id' => '493', 'moduleid' => '39', 'field' => 'title', 'name' => '机构名称', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '2', 'status' => '1', 'issystem' => '0', ), 'type' => array ( 'id' => '494', 'moduleid' => '39', 'field' => 'type', 'name' => '会员类别', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'select', 'setup' => 'array (
  \'options\' => \'vip普通会员|9
vip高级会员|10
vip钻石会员|11
定制服务|12\',
  \'multiple\' => \'0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'size\' => \'\',
  \'default\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '3', 'status' => '1', 'issystem' => '0', ), 'ip' => array ( 'id' => '495', 'moduleid' => '39', 'field' => 'ip', 'name' => 'ip地址', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'150\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '4', 'status' => '1', 'issystem' => '0', ), 'expire_time' => array ( 'id' => '496', 'moduleid' => '39', 'field' => 'expire_time', 'name' => '过期时间', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '5', 'status' => '1', 'issystem' => '0', ), 'createtime' => array ( 'id' => '490', 'moduleid' => '39', 'field' => 'createtime', 'name' => '发布时间', 'tips' => '', 'required' => '1', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '1', 'issystem' => '1', ), 'status' => array ( 'id' => '491', 'moduleid' => '39', 'field' => 'status', 'name' => '状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'已审核|1
未审核|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'75\',
  \'default\' => \'1\',
)', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '99', 'status' => '1', 'issystem' => '1', ), ); ?>
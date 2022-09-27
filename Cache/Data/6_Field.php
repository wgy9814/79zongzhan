<?php
return array ( 'typeid' => array ( 'id' => '79', 'moduleid' => '6', 'field' => 'typeid', 'name' => '反馈类别', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'typeid', 'setup' => 'array (
  \'inputtype\' => \'select\',
  \'fieldtype\' => \'smallint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'\',
  \'default\' => \'4\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '0', 'status' => '0', 'issystem' => '0', ), 'promotion' => array ( 'id' => '394', 'moduleid' => '6', 'field' => 'promotion', 'name' => '报名编码', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'user' => array ( 'id' => '408', 'moduleid' => '6', 'field' => 'user', 'name' => '用户ID', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '0', 'issystem' => '0', ), 'kcid' => array ( 'id' => '423', 'moduleid' => '6', 'field' => 'kcid', 'name' => '课程id', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => 'digits', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '1', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'kctitle' => array ( 'id' => '424', 'moduleid' => '6', 'field' => 'kctitle', 'name' => '课程名称', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'user_name' => array ( 'id' => '460', 'moduleid' => '6', 'field' => 'user_name', 'name' => '用户名', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'title' => array ( 'id' => '74', 'moduleid' => '6', 'field' => 'title', 'name' => '标题', 'tips' => '', 'required' => '1', 'minlength' => '4', 'maxlength' => '50', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'40\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '1', 'status' => '1', 'issystem' => '0', ), 'username' => array ( 'id' => '69', 'moduleid' => '6', 'field' => 'username', 'name' => '姓名', 'tips' => '', 'required' => '1', 'minlength' => '2', 'maxlength' => '20', 'pattern' => 'cn_username', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'10\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '2', 'status' => '1', 'issystem' => '0', ), 'email' => array ( 'id' => '71', 'moduleid' => '6', 'field' => 'email', 'name' => '邮箱', 'tips' => '', 'required' => '1', 'minlength' => '0', 'maxlength' => '50', 'pattern' => 'email', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'20\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '2', 'status' => '0', 'issystem' => '0', ), 'address' => array ( 'id' => '377', 'moduleid' => '6', 'field' => 'address', 'name' => '地址', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '2', 'status' => '1', 'issystem' => '0', ), 'coupons' => array ( 'id' => '378', 'moduleid' => '6', 'field' => 'coupons', 'name' => '优惠券', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '2', 'status' => '0', 'issystem' => '0', ), 'project' => array ( 'id' => '379', 'moduleid' => '6', 'field' => 'project', 'name' => '报名学校', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '2', 'status' => '1', 'issystem' => '0', ), 'telephone' => array ( 'id' => '70', 'moduleid' => '6', 'field' => 'telephone', 'name' => '电话', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => 'tel', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'20\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '4', 'status' => '1', 'issystem' => '0', ), 'content' => array ( 'id' => '72', 'moduleid' => '6', 'field' => 'content', 'name' => '内容', 'tips' => '', 'required' => '1', 'minlength' => '4', 'maxlength' => '200', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'textarea', 'setup' => 'array (
  \'fieldtype\' => \'mediumtext\',
  \'rows\' => \'5\',
  \'cols\' => \'60\',
  \'default\' => \'\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '5', 'status' => '1', 'issystem' => '0', ), 'ip' => array ( 'id' => '73', 'moduleid' => '6', 'field' => 'ip', 'name' => '提交IP', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'20\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '6', 'status' => '1', 'issystem' => '0', ), 'createtime' => array ( 'id' => '76', 'moduleid' => '6', 'field' => 'createtime', 'name' => '提交时间', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '98', 'status' => '1', 'issystem' => '0', ), 'status' => array ( 'id' => '78', 'moduleid' => '6', 'field' => 'status', 'name' => '审核状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '1', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'己审核|1
未审核|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'\',
  \'default\' => \'0\',
)', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '99', 'status' => '1', 'issystem' => '0', ), ); ?>
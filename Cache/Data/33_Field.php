<?php
return array ( 'messageid' => array ( 'id' => '420', 'moduleid' => '33', 'field' => 'messageid', 'name' => '系统消息', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => 'digits', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'0\',
)', 'ispost' => '0', 'unpostgroup' => '1,2,3,4,5,6,7', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'type' => array ( 'id' => '421', 'moduleid' => '33', 'field' => 'type', 'name' => '类型', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => 'digits', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'已读|1
删除|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'\',
  \'default\' => \'1\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'createtime' => array ( 'id' => '418', 'moduleid' => '33', 'field' => 'createtime', 'name' => '发布时间', 'tips' => '', 'required' => '1', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '1', 'issystem' => '1', ), 'status' => array ( 'id' => '419', 'moduleid' => '33', 'field' => 'status', 'name' => '状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'已审核|1
未审核|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'75\',
  \'default\' => \'1\',
)', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '99', 'status' => '1', 'issystem' => '1', ), ); ?>
<?php
return array ( 'child_id' => array ( 'id' => '449', 'moduleid' => '35', 'field' => 'child_id', 'name' => '子类id', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '0', 'issystem' => '0', ), 'parentid' => array ( 'id' => '448', 'moduleid' => '35', 'field' => 'parentid', 'name' => '父类id', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '0', 'issystem' => '0', ), 'type' => array ( 'id' => '443', 'moduleid' => '35', 'field' => 'type', 'name' => '类型', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'select', 'setup' => 'array (
  \'options\' => \'学校首页|1
最新课程页面|2
课程文章页面|3
行业页面|4\',
  \'multiple\' => \'0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'size\' => \'\',
  \'default\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '1', 'status' => '0', 'issystem' => '0', ), 'title_rule' => array ( 'id' => '442', 'moduleid' => '35', 'field' => 'title_rule', 'name' => 'title规则', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'200\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '2', 'status' => '1', 'issystem' => '0', ), 'description_rule' => array ( 'id' => '444', 'moduleid' => '35', 'field' => 'description_rule', 'name' => 'description规则', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'200\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '3', 'status' => '1', 'issystem' => '0', ), 'keywords_rule' => array ( 'id' => '445', 'moduleid' => '35', 'field' => 'keywords_rule', 'name' => 'keywords规则', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'200\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '4', 'status' => '1', 'issystem' => '0', ), 'createtime' => array ( 'id' => '80', 'moduleid' => '35', 'field' => 'createtime', 'name' => '发布时间', 'tips' => '', 'required' => '1', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '1', 'issystem' => '1', ), 'status' => array ( 'id' => '441', 'moduleid' => '35', 'field' => 'status', 'name' => '状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'已审核|1
未审核|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'75\',
  \'default\' => \'1\',
)', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '99', 'status' => '1', 'issystem' => '1', ), ); ?>
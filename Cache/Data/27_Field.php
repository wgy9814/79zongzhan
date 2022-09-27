<?php
return array ( 'catid' => array ( 'id' => '347', 'moduleid' => '27', 'field' => 'catid', 'name' => '栏目', 'tips' => '', 'required' => '1', 'minlength' => '1', 'maxlength' => '6', 'pattern' => '', 'errormsg' => '必须选择一个栏目', 'class' => '', 'type' => 'catid', 'setup' => '', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '1', ), 'title' => array ( 'id' => '348', 'moduleid' => '27', 'field' => 'title', 'name' => '标题', 'tips' => '', 'required' => '1', 'minlength' => '1', 'maxlength' => '80', 'pattern' => '', 'errormsg' => '标题必须为1-80个字符', 'class' => '', 'type' => 'title', 'setup' => 'array (
  \'thumb\' => \'1\',
  \'style\' => \'1\',
  \'size\' => \'55\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '1', ), 'link' => array ( 'id' => '360', 'moduleid' => '27', 'field' => 'link', 'name' => '加盟连接', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'shi' => array ( 'id' => '361', 'moduleid' => '27', 'field' => 'shi', 'name' => '有无加盟商', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'select', 'setup' => 'array (
  \'options\' => \'无|none
有|you\',
  \'multiple\' => \'0\',
  \'fieldtype\' => \'varchar\',
  \'numbertype\' => \'1\',
  \'size\' => \'\',
  \'default\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '0', 'issystem' => '0', ), 'keywords' => array ( 'id' => '349', 'moduleid' => '27', 'field' => 'keywords', 'name' => '关键词', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '80', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'55\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '2', 'status' => '0', 'issystem' => '1', ), 'description' => array ( 'id' => '350', 'moduleid' => '27', 'field' => 'description', 'name' => 'SEO简介', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'textarea', 'setup' => 'array (
  \'fieldtype\' => \'mediumtext\',
  \'rows\' => \'4\',
  \'cols\' => \'55\',
  \'default\' => \'\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '3', 'status' => '0', 'issystem' => '1', ), 'content' => array ( 'id' => '351', 'moduleid' => '27', 'field' => 'content', 'name' => '内容', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'editor', 'setup' => 'array (
  \'toolbar\' => \'full\',
  \'default\' => \'\',
  \'height\' => \'\',
  \'showpage\' => \'1\',
  \'enablekeylink\' => \'0\',
  \'replacenum\' => \'\',
  \'enablesaveimage\' => \'0\',
  \'flashupload\' => \'1\',
  \'alowuploadexts\' => \'\',
)', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '10', 'status' => '0', 'issystem' => '1', ), 'createtime' => array ( 'id' => '352', 'moduleid' => '27', 'field' => 'createtime', 'name' => '发布时间', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '1', 'issystem' => '1', ), 'recommend' => array ( 'id' => '353', 'moduleid' => '27', 'field' => 'recommend', 'name' => '允许评论', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '1', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'允许评论|1
不允许评论|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'\',
  \'default\' => \'\',
)', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '0', 'issystem' => '0', ), 'readpoint' => array ( 'id' => '354', 'moduleid' => '27', 'field' => 'readpoint', 'name' => '阅读收费', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '5', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'5\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'0\',
)', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '0', 'issystem' => '0', ), 'hits' => array ( 'id' => '355', 'moduleid' => '27', 'field' => 'hits', 'name' => '点击次数', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '8', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'10\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'0\',
)', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '0', 'issystem' => '0', ), 'readgroup' => array ( 'id' => '356', 'moduleid' => '27', 'field' => 'readgroup', 'name' => '访问权限', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'groupid', 'setup' => 'array (
  \'inputtype\' => \'checkbox\',
  \'fieldtype\' => \'tinyint\',
  \'labelwidth\' => \'85\',
  \'default\' => \'\',
)', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '96', 'status' => '0', 'issystem' => '1', ), 'posid' => array ( 'id' => '357', 'moduleid' => '27', 'field' => 'posid', 'name' => '推荐位', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'posid', 'setup' => '', 'ispost' => '1', 'unpostgroup' => '', 'listorder' => '97', 'status' => '1', 'issystem' => '1', ), 'template' => array ( 'id' => '358', 'moduleid' => '27', 'field' => 'template', 'name' => '模板', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'template', 'setup' => '', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '98', 'status' => '0', 'issystem' => '1', ), 'status' => array ( 'id' => '359', 'moduleid' => '27', 'field' => 'status', 'name' => '状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'发布|1
定时发布|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'75\',
  \'default\' => \'1\',
)', 'ispost' => '1', 'unpostgroup' => '3,4', 'listorder' => '99', 'status' => '1', 'issystem' => '1', ), ); ?>
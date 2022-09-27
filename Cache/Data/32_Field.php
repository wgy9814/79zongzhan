<?php
return array ( 'title' => array ( 'id' => '416', 'moduleid' => '32', 'field' => 'title', 'name' => '标题', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'text', 'setup' => 'array (
  \'size\' => \'\',
  \'default\' => \'\',
  \'ispassword\' => \'0\',
  \'fieldtype\' => \'varchar\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'content' => array ( 'id' => '417', 'moduleid' => '32', 'field' => 'content', 'name' => '内容', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'editor', 'setup' => 'array (
  \'edittype\' => \'kindeditor\',
  \'default\' => \'\',
  \'height\' => \'\',
  \'show_add_description\' => \'0\',
  \'show_auto_thumb\' => \'0\',
  \'showpage\' => \'0\',
  \'enablekeylink\' => \'0\',
  \'replacenum\' => \'\',
  \'enablesaveimage\' => \'0\',
  \'flashupload\' => \'0\',
  \'alowuploadexts\' => \'\',
  \'alowuploadlimit\' => \'\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'type' => array ( 'id' => '422', 'moduleid' => '32', 'field' => 'type', 'name' => '类型', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => 'digits', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'已读|2
未读|1
已删|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'\',
  \'default\' => \'1\',
)', 'ispost' => '0', 'unpostgroup' => '1,2,3,4,5,6,7,8', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'courseid' => array ( 'id' => '425', 'moduleid' => '32', 'field' => 'courseid', 'name' => '课程', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => 'digits', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => 'array (
  \'size\' => \'\',
  \'numbertype\' => \'1\',
  \'decimaldigits\' => \'0\',
  \'default\' => \'0\',
)', 'ispost' => '0', 'unpostgroup' => '', 'listorder' => '0', 'status' => '1', 'issystem' => '0', ), 'createtime' => array ( 'id' => '414', 'moduleid' => '32', 'field' => 'createtime', 'name' => '发布时间', 'tips' => '', 'required' => '1', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '', 'errormsg' => '', 'class' => '', 'type' => 'datetime', 'setup' => '', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '93', 'status' => '1', 'issystem' => '1', ), 'status' => array ( 'id' => '415', 'moduleid' => '32', 'field' => 'status', 'name' => '状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => 'array (
  \'options\' => \'已审核|1
未审核|0\',
  \'fieldtype\' => \'tinyint\',
  \'numbertype\' => \'1\',
  \'labelwidth\' => \'75\',
  \'default\' => \'1\',
)', 'ispost' => '0', 'unpostgroup' => '3,4', 'listorder' => '99', 'status' => '1', 'issystem' => '1', ), ); ?>
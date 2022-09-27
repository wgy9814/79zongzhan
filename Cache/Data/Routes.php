<?php
return array(
':l/Tags/:module/:tag/:p' => 'Home/Tags/index',
':l/Tags/:tag/:p' => 'Home/Tags/index',
':l/Tags/:module/:tag' => 'Home/Tags/index',
':l/Tags/:p\d' => 'Home/Tags/index',
':l/Tags/:tag' => 'Home/Tags/index',
':l/Tags' => 'Home/Tags/index',
'Tags/:module/:tag/:p' => 'Home/Tags/index',
'Tags/:tag/:p' => 'Home/Tags/index',
'Tags/:module/:tag' => 'Home/Tags/index',
'Tags/:p\d' => 'Home/Tags/index',
'Tags/:tag' => 'Home/Tags/index',
'Tags' => 'Home/Tags/index',
'/^(en)$/' => 'Index/index?l=:1',
'/^([\w^_]+)\/(\d+)\/([0-9]+)$/' => 'Urlrule/index?catdir=:1&id=:2&p=:3&',
'/^(en)\/([\w^_]+)\/show\/(\d+)_(\d+)$/' => 'Urlrule/show?l=:1&catdir=:2&id=:3&p=:4&',
'/^([\w^_]+)\/show\/(\d+)_(\d+)$/' => 'Urlrule/show?catdir=:1&id=:2&p=:3&',
'/^(en)\/([\w^_]+)\/show\/(\d+)$/' => 'Urlrule/show?l=:1&catdir=:2&id=:3&',
'/^([\w^_]+)\/show\/(\d+)$/' => 'Urlrule/show?catdir=:1&id=:2&',
'/^(en)\/([\w^_]+)\/(\d+)$/' => 'Urlrule/index?l=:1&catdir=:2&p=:3&',
'/^([\w^_]+)\/(\d+)$/' => 'Urlrule/index?catdir=:1&p=:2&',
'/^(en)\/([\w^_]+)$/' => 'Urlrule/index?l=:1&catdir=:2&',
'/^([\w^_]+)$/' => 'Urlrule/index?catdir=:1&'
);
?>
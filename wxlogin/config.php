<?php

header("Content-Type: text/html; charset=utf-8");
session_start();
$host = "localhost";
$db_user = "tyx1038562879";
$db_pass = "tyx417lzl";
$db_name = "nmooc";
$timezone = "Asia/Shanghai";

$link = mysql_connect($host, $db_user, $db_pass);
mysql_select_db($db_name, $link);
mysql_query("SET names UTF8");


$appid = 'wxbd9dc9d48cb1f6f1';
$appsecret = 'e48cd311122b01ea03ac60fea64a274a';
?>
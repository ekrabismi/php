<?php 
$localhost = 'localhost';
$user = 'user';
$password = '';
$database = 'tommy_jessesclubhouse';
$prefix = 'jos_';
$link = mysql_connect($localhost,$user,$password);
mysql_select_db($database,$link);
?>
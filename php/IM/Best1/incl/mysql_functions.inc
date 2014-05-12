<?php

function neutral_escape($a,$b,$c){
if(strlen($a)>$b){$a=substr($a,0,$b);}
if($c=='int'){$a=(int)$a;}
else{
if(get_magic_quotes_gpc()){$a=stripslashes($a);}
if($c!='txt'){
$a=str_replace("\r",'',$a);
$a=str_replace("\n",' ',$a);}
$a=str_replace("\0",'',$a);
$a=addslashes($a);
$a=trim($a);}return $a;}

function neutral_dbconnect(){
global $dbss;
mysql_connect($dbss['host'],$dbss['user'],$dbss['pass']) or process_error('Cannot connect to database. Please, check config.php...');
mysql_select_db($dbss['name']) or process_error(mysql_error());}

function neutral_dbpconnect(){
global $dbss;
mysql_pconnect($dbss['host'],$dbss['user'],$dbss['pass']) or process_error('Cannot connect to database. Please, check config.php...');
mysql_select_db($dbss['name']) or process_error(mysql_error());}

function neutral_query($q){
global $queries;$queries+=1;
$r=mysql_query($q) or process_error(mysql_error());
return $r;}

function neutral_fetch_array($q){
$r=mysql_fetch_array($q);return $r;}

function neutral_num_rows($q){
$r=mysql_num_rows($q);return $r;}

?>
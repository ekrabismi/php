<?php

$sqli_link=0;

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
global $sqli_link,$dbss;
$sqli_link=mysqli_connect($dbss['host'],$dbss['user'],$dbss['pass'],$dbss['name']) or process_error('Cannot connect to database. Please, check config.php...');
}

function neutral_dbpconnect(){
global $sqli_link,$dbss;
$sqli_link=mysqli_connect($dbss['host'],$dbss['user'],$dbss['pass'],$dbss['name']) or process_error('Cannot connect to database. Please, check config.php...');
}

function neutral_query($q){
global $sqli_link,$queries;$queries+=1;
$r=mysqli_query($sqli_link,$q) or process_error(mysqli_error($sqli_link));
return $r;}

function neutral_fetch_array($q){
$r=mysqli_fetch_array($q);return $r;}

function neutral_num_rows($q){
$r=mysqli_num_rows($q);return $r;}

?>
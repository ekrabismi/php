<?php

// if(!function_exists('pg_query')){if(stristr(PHP_OS,'win')){dl('php_pgsql.dll');}else{dl('php_pgsql.so');}}

function neutral_escape($a,$b,$c){
if(strlen($a)>$b){$a=substr($a,0,$b);}
if($c=='int'){$a=(int)$a;}
else{
if(get_magic_quotes_gpc()){$a=stripslashes($a);}
if($c!='txt'){
$a=str_replace("\r",'',$a);
$a=str_replace("\n",' ',$a);}
$a=str_replace("\0",'',$a);
$a=pg_escape_string($a);
}$a=trim($a);return $a;}


function neutral_dbconnect(){
global $dbss;
$conn_str='host='.$dbss['host'].' port=5432 dbname='.$dbss['name'].' user='.$dbss['user'].' password='.$dbss['pass'];
pg_connect($conn_str) or process_error('Cannot connect to database. Please, check config.php...');
}

function neutral_dbpconnect(){
global $dbss;
$conn_str='host='.$dbss['host'].' port=5432 dbname='.$dbss['name'].' user='.$dbss['user'].' password='.$dbss['pass'];
pg_pconnect($conn_str) or process_error('Cannot connect to database. Please, check config.php...');
}

function neutral_query($q){
global $queries;$queries+=1;
if(stristr($q,'INSERT INTO')){$q=str_replace('NULL','DEFAULT',$q);}
$r=pg_query($q) or process_error(pg_last_error());
return $r;}

function neutral_fetch_array($q){
$r=pg_fetch_array($q);return $r;}

function neutral_num_rows($q){
$r=pg_num_rows($q);return $r;}

?>
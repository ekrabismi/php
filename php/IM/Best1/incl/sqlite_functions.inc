<?php

$dbo=0;

function neutral_escape($a,$b,$c){
if(strlen($a)>$b){$a=substr($a,0,$b);}
if($c=='int'){$a=(int)$a;}
else{
if(get_magic_quotes_gpc()){$a=stripslashes($a);}
if($c!='txt'){
$a=str_replace("\r",'',$a);
$a=str_replace("\n",' ',$a);}
$a=str_replace("\0",'',$a);
$a=str_replace("'","''",$a);
}$a=trim($a);return $a;}

function neutral_dbconnect(){
global $dbo,$dbss;
$dbo=sqlite_open($dbss['sqlt']) or process_error('Cannot open database. Please, check config.php...');
neutral_query('PRAGMA synchronous = '.$dbss['sqlp']);}

function neutral_dbpconnect(){
global $dbo,$dbss;
$dbo=sqlite_popen($dbss['sqlt']) or process_error('Cannot open database. Please, check config.php...');
neutral_query('PRAGMA synchronous = 0');}

function neutral_query($q){
global $dbo,$queries;$queries+=1;
$r=sqlite_query($dbo,$q) or process_error(sqlite_error_string(sqlite_last_error($dbo)));
return $r;}

function neutral_fetch_array($q){
$r=sqlite_fetch_array($q);return $r;}

function neutral_num_rows($q){
$r=sqlite_num_rows($q);return $r;}

?>
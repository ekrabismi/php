<?php

function process_error($s){
global $error_log;
if(is_writeable($error_log)){
$s="\r\n".date('Y-m-d H:i:s').' '.$s;
$fd=fopen($error_log,"a");
$fout=fwrite($fd,$s);fclose($fd);}
die('SQL error... Please check your error log file for details...');}

// -----

function htmrem($a){
$a=str_replace('<','&lt;',$a);
$a=str_replace('>','&gt;',$a);
$a=str_replace('"','&quot;',$a);
$a=str_replace('|:|','|&#58;|',$a);
return $a;}

// -----

function bbcode($t){
global $skin_dir,$emo_file;

include $skin_dir.'/'.$emo_file;
$emoticons=array_merge($emoticons,$aliases);

for($i=0;$i<count($emoticons);$i++){
$row=explode(' ',$emoticons[$i]);if(isset($row[2])){$row[1]=$row[2];}
$t=str_replace($row[0],"<img src=\"$skin_dir/smilies/$row[1]\"  title=\"$row[0]\" alt=\"$row[0]\" />",$t);}

return $t;}


// -----

function hsh($a){
global $salt;
$a=md5(md5($a).$salt);
return $a;}

// ----- 

function redirect($url,$wait,$msg){
global $settings,$skin_dir,$css_file,$lang;
if($settings['header_rdr']>0 && $wait==0){header('location:'.$url);die();}
else{
$title=$lang['redirect'];
if($msg=='0'){$message=$lang['reqst_ok'];}else{$message=$msg;}
include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/redirect.pxtm';
die();}}

// -----

function adm_rdr($url,$wait){
global $settings,$lang,$settings;
if($settings['header_rdr']>0 && $wait==0){header('location:'.$url);die();}
else{
$title=$lang['redirect'];
include 'admin/head.pxtm';
include 'admin/redirect.pxtm';
die();}}

// -----

function dbconnect(){global $dbss;if($dbss['pcon']>0){neutral_dbpconnect();}else{neutral_dbconnect();}}


// -----

function get_guest(){
global $settings,$dbss;$user=array();

if(isset($_COOKIE['bmf_guest'])){
$guest=explode(':',$_COOKIE['bmf_guest']);
if(isset($guest[1]) && is_numeric($guest[0])){
$query='SELECT * FROM '.$dbss['prfx'].'_users WHERE usr_id='.$guest[0];
$result=neutral_query($query);
if(neutral_num_rows($result)>0){
$dbg=neutral_fetch_array($result);
if(hsh($guest[0].trim($dbg['salt']))==trim($guest[1])){
$user['id']=$dbg['usr_id'];
$user['name']=htmrem($dbg['usr_name']);
}}}}

if(!isset($user['id'])){
$r_name=mt_rand(1000,9999); $r_name='U-'.$r_name;
$r_salt=time(); $r_salt.=microtime(); $r_salt=hsh($r_name.$r_salt);
$query='INSERT INTO '.$dbss['prfx']."_users VALUES(NULL,'$r_name','$r_salt')";
neutral_query($query);
$query='SELECT MAX(usr_id) AS usr_id FROM '.$dbss['prfx']."_users WHERE salt='$r_salt'";
$result=neutral_query($query);
$guest=neutral_fetch_array($result);
$user['id']=$guest['usr_id'];
$user['name']=$r_name;
$cc=hsh($guest['usr_id'].$r_salt);$cc=$guest['usr_id'].':'.$cc;
setcookie('bmf_guest',$cc,time()+3600*24*30,'/');}
return $user;}

// -----

function get_user(){
global $dbss,$intg,$settings;unset($user);
if(isset($_SESSION['bmf_id'])){$oldsessid=(int)$_SESSION['bmf_id'];unset($_SESSION['bmf_id']);}

if(!isset($user)){$user=get_guest();}

if(isset($user)){
if(isset($oldsessid) && $user['id']!=$oldsessid){
$tmm=time()-($settings['main_refresh']*$settings['main_ofactor']);
$query='UPDATE '.$dbss['prfx']."_online SET rtime=$tmm WHERE usr_id=$oldsessid";
neutral_query($query);}

$_SESSION['bmf_id']=(int)$user['id'];
$_SESSION['bmf_name']=$user['name'];
}}

// -----

function get_language(){
global $options;
include 'lang/languages.inc';

$set_lang='lang/'.$lang_files[$options[0]];
if(!is_file($set_lang)){$set_lang='lang/'.$lang_files[0];}

include $set_lang;return $lang;}


// ----

function get_settings(){
global $dbss;$settings=array();
$query='SELECT set_id,set_value FROM '.$dbss['prfx'].'_settings';
$result=neutral_query($query);
while($row=neutral_fetch_array($result)){$settings[$row['set_id']]=$row['set_value'];}
return $settings;}

// ----

function get_options(){
global $settings;$options=array();
if(isset($_COOKIE['bmf_options'])){$options=explode('|',$_COOKIE['bmf_options']);}

if(!isset($options[10])){
$options[0]=$settings['default_language'];
$options[1]=$settings['default_timezone'];
$options[2]=$settings['default_timeform'];
$options[3]=$settings['default_veffect'];
$options[4]=$settings['default_sound1'];
$options[5]=$settings['default_sound2'];
$options[6]=0;       // bold [m]
$options[7]=0;       // bold [y]
$options[8]='';      // color [m]
$options[9]='';      // color [y]
$options[10]=1;      // close UCP
}

for($i=0;$i<8;$i++){$options[$i]=(int)$options[$i];}
$options[8]=htmrem($options[8]);
$options[9]=htmrem($options[9]);
$options[10]=(int)$options[10];
return $options;}

// ----

function get_status(){
$status=0;
if(isset($_COOKIE['bmf_status'])){
$status=explode('|',$_COOKIE['bmf_status']);
if(isset($status[1]) && hsh($status[0])==$status[1]){$status=(int)$status[0];}}
return $status;}

/* --- */

$random=mt_rand(1,999999);
$timestamp=time();
//set_magic_quotes_runtime(0);
$queries=0;
unset($settings);

require_once 'incl/'.$dbss['type'].'_functions.inc';
include $skin_dir.'/skin.inc';

if(!headers_sent()){
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-type: text/html; charset=UTF-8");}

?>
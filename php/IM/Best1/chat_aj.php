<?php 

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id']) || !isset($_SESSION['bmf_name'])){
if($settings['no_session_err']=='1'){print $lang['cookies_r'];}die();}

if(isset($_POST['u'])){$u=(int)$_POST['u'];}else{$u=0;} if($u<1){die();}
if(isset($_POST['l'])){$l=(int)$_POST['l'];}else{$l=0;}
if(isset($_POST['c'])){$c=(int)$_POST['c'];}else{$c=0;}

$bim_id=(int)$_SESSION['bmf_id']; $lid=0;
$bim_name=neutral_escape($_SESSION['bmf_name'],64,'str');
$keep_time=$settings['chat_refresh']*$settings['main_ofactor'];

if(isset($_POST['p'])){$post=neutral_escape($_POST['p'],$settings['post_length'],'str');
if(strlen($post)>0){
$query='INSERT INTO '.$dbss['prfx']."_lines VALUES(NULL,$bim_id,'$bim_name',$u,$timestamp,'$post')";
neutral_query($query);
}}

$query='DELETE FROM '.$dbss['prfx']."_chatting WHERE (usr_id=$bim_id AND chatto=$u) OR ($timestamp-timestamp)>$keep_time";
neutral_query($query);

$query='INSERT INTO '.$dbss['prfx']."_chatting VALUES($bim_id,'$bim_name',$u,$timestamp)";
neutral_query($query);

$query='SELECT * FROM '.$dbss['prfx']."_chatting WHERE usr_id=$u AND chatto=$bim_id";
$result=neutral_query($query);

if(neutral_num_rows($result)>0){
$uname=neutral_fetch_array($result);
$uname=htmrem($uname['usr_name']);
}else{$uname='00';}

$history=(int)$settings['latest_mssg'];$history=($history*60)+1;
if($l==-1){$where_clause="($timestamp-timestamp)<$history";}else{$where_clause="line_id>$l";}

$query='SELECT * FROM '.$dbss['prfx']."_lines WHERE $where_clause AND ((usr_id=$bim_id AND chatto=$u) OR (usr_id=$u AND chatto=$bim_id)) ORDER BY line_id ASC";
$result=neutral_query($query);

$messages='';
switch($options[2]){
case 1:$format='h:i:s A';break;
case 2:$format='Y-m-d H:i:s';break;
case 3:$format='d.m.Y H:i:s';break;
case 4:$format='m/d/Y h:i:s A';break;
case 5:$format='';break;
default :$format='H:i:s';break;
}

if(neutral_num_rows($result)>0){
while($row=neutral_fetch_array($result)){
$lid=(int)$row['line_id'];
$usr=htmrem($row['usr_name']);
$msg=htmrem($row['line_txt']); 
$msg=bbcode($msg);
$msg=eregi_replace('[[:alpha:]]+://[^;[:space:]]+[[:alnum:]/]','<a href="info.php?why=link" onclick="window.open(\'\\0\');return false">\\0</a>',$msg);

if($bim_id==$row['usr_id']){$tx=1;}else{$tx=2;}
if($options[2]!=5){$tmm=gmdate($format,$row['timestamp']+$options[1]*3600);$tmm='['.$tmm.']';}else{$tmm='';}
$messages.='<div class="tx0">'.$tmm.' <b>'.$usr.'</b>: <span class="tx'.$tx.'"">'.$msg.'</span></div>';
}
}

print $uname.'|:|'.$lid.'|:|'.$c.'|:|'.$messages;
?>
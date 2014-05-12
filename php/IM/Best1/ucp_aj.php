<?php 

require_once 'config.php';
require_once 'incl/main.inc';

session_start();

if(isset($_POST['ajx_sett'])){$ajx_sett=$_POST['ajx_sett'];}else{$ajx_sett='0|0|0|0';}

$ajx_sett=explode('|',$ajx_sett);
dbconnect(); $settings=get_settings(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id']) || !isset($_SESSION['bmf_name'])){
print $lang['cookies_r'];die();}

$bim_id=(int)$_SESSION['bmf_id'];
$bim_name=neutral_escape($_SESSION['bmf_name'],64,'str');
$title=$lang['users_onl'];

$ipaddr=$_SERVER['REMOTE_ADDR'];
$status=get_status();

if(!isset($ajx_sett[0])){$ajx_sett[0]=0;}
if(!isset($ajx_sett[1])){$ajx_sett[1]=0;}
if(!isset($ajx_sett[3])){$ajx_sett[3]=0;}
$from=(int)$ajx_sett[3];

if($dbss['type']=='mysql' || $dbss['type']=='mysqli'){$llim="LIMIT $from,10";}else{$llim="LIMIT 10 OFFSET $from";}
if($ajx_sett[0]=='1'){$order='usr_name ASC';}else{$order='rtime DESC, usr_name ASC';}

$keep_time=$settings['main_refresh']*$settings['main_ofactor'];

$query='DELETE FROM '.$dbss['prfx']."_online WHERE usr_id=$bim_id";
neutral_query($query);

$query='INSERT INTO '.$dbss['prfx']."_online VALUES($bim_id,'$bim_name','$ipaddr',$timestamp,$status)";
neutral_query($query);

/* --- */

if(isset($ajx_sett[2]) && $ajx_sett[2]=='1'){

$query='SELECT count(*) FROM '.$dbss['prfx']."_online WHERE ($timestamp-rtime)<$keep_time";
$total=neutral_query($query);$total=neutral_fetch_array($total);$total=$total[0];

$query='SELECT * FROM '.$dbss['prfx']."_online WHERE ($timestamp-rtime)<$keep_time ORDER BY $order $llim";

$online=neutral_query($query);
if(neutral_num_rows($online)>0){
$tr=1;

$p_from=$from+1;$p_to=$from+10;if($p_to>$total){$p_to=$total;}
$colspan=5;
include $skin_dir.'/templates/ucp_users_aj_header.pxtm';

while($row=neutral_fetch_array($online)){

$uid=(int)$row['usr_id'];
$req=1;if($row['status']>2){$req=0;}
$status=(int)$row['status'];
if($tr==0){$tr=1;}else{$tr=0;}

$name=htmrem($row['usr_name']);
if(strlen($name)>32){$name=substr($name,0,50);$name=$name.'..';}

$lseen=$timestamp-$row['rtime'];$last_seen=$lang['seconds_ago'];
if($lseen>90){$lseen=round($lseen/60);$last_seen=$lang['minutes_ago'];}
$last_seen=$lseen.' '.$last_seen;

include $skin_dir.'/templates/ucp_users_aj_entry.pxtm';}
include $skin_dir.'/templates/ucp_users_aj_footer.pxtm';}else{print '<div>'.$lang['no_users'].'</div>';}}

/* --- */

if(isset($ajx_sett[2]) && $ajx_sett[2]=='2'){

$query='SELECT count(*) FROM '.$dbss['prfx']."_invite WHERE usr_id=$bim_id OR chatto=$bim_id";
$total=neutral_query($query);$total=neutral_fetch_array($total);$total=$total[0];

$query='SELECT * FROM '.$dbss['prfx']."_invite WHERE usr_id=$bim_id OR chatto=$bim_id ORDER BY timestamp DESC $llim";

$chats=neutral_query($query); 
if(neutral_num_rows($chats)>0){

$tr=1;

switch($options[2]){
case 1:$format='h:i:s A';break;
case 2:$format='Y-m-d H:i:s';break;
case 3:$format='d.m.Y H:i:s';break;
case 4:$format='m/d/Y h:i:s A';break;
default :$format='H:i:s';break;
}

$p_from=$from+1;$p_to=$from+10;if($p_to>$total){$p_to=$total;}
include $skin_dir.'/templates/ucp_chats_aj_header.pxtm';

while($row=neutral_fetch_array($chats)){

if($row['usr_id']!=$bim_id){$uid=(int)$row['usr_id'];$name=htmrem($row['usr_name']);$drct1='b';$drct2=$lang['from'];}
else{$uid=(int)$row['chatto'];$name=htmrem($row['chatto_name']);$drct1='a';$drct2=$lang['to'];}

if(strlen($name)>32){$name=substr($name,0,50);$name=$name.'..';}
$show_time=gmdate($format,$row['timestamp']+$options[1]*3600);

if($tr==0){$tr=1;}else{$tr=0;}

include $skin_dir.'/templates/ucp_chats_aj_entry.pxtm';}
include $skin_dir.'/templates/ucp_chats_aj_footer.pxtm';}else{print '<div>'.$lang['no_chats'].'</div>';}}

/* --- */

$query='SELECT COUNT(*) FROM '.$dbss['prfx']."_invite WHERE chatto=$bim_id AND status=0";
$chats=neutral_query($query);
$chats=neutral_fetch_array($chats);
$chats=(int)$chats[0];
print '|:|'.$chats;

?>
<?php 

require_once 'config.php';

if(isset($_COOKIE['bmf_disable'])){
print '<input type="button" style="font-weight:bold;background-color:#fff;color:#000;border-width:0px" value="&nbsp;'.$bim_disable.'&nbsp;" onclick="window.location=enable_url" />';
die();}

session_start();
if(isset($_SESSION['bmf_cche']) && isset($_SESSION['bmf_updt']) && isset($_SESSION['bmf_last']) && (time()-$_SESSION['bmf_last'])<$_SESSION['bmf_updt']){
if(!headers_sent()){
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-type: text/html; charset=UTF-8");}
print $_SESSION['bmf_cche'];die();}

require_once 'incl/main.inc';

dbconnect(); $settings=get_settings(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id']) || !isset($_SESSION['bmf_name'])){
if($settings['no_session_err']=='1'){print $lang['cookies_r'];}die();}

$bim_id=(int)$_SESSION['bmf_id'];
$bim_name=neutral_escape($_SESSION['bmf_name'],64,'str');
$pnt_name=htmrem($_SESSION['bmf_name']);

$ipaddr=$_SERVER['REMOTE_ADDR'];
$status=get_status();

$query='DELETE FROM '.$dbss['prfx']."_online WHERE usr_id=$bim_id";
neutral_query($query);

$query='INSERT INTO '.$dbss['prfx']."_online VALUES($bim_id,'$bim_name','$ipaddr',$timestamp,$status)";
neutral_query($query);

$_SESSION['bmf_last']=time();
$_SESSION['bmf_updt']=(int)$settings['main_refresh'];

$query='SELECT COUNT(*) FROM '.$dbss['prfx']."_invite WHERE chatto=$bim_id AND status=0 AND ($timestamp-timestamp)<600";
$chats=neutral_query($query);
$chats=neutral_fetch_array($chats);
$chats=(int)$chats[0];

if($chats>0){

$elements=$settings['bar_chatreqt'];

$elements=str_replace('{C1_LANG}',$lang['custom_1'],$elements);
$elements=str_replace('{C2_LANG}',$lang['custom_2'],$elements);
$elements=str_replace('{C3_LANG}',$lang['custom_3'],$elements);
$elements=str_replace('{C4_LANG}',$lang['custom_4'],$elements);
$elements=str_replace('{C5_LANG}',$lang['custom_5'],$elements);
$elements=str_replace('{WELCOME}',$lang['welcome'],$elements);
$elements=str_replace('{USER}',$pnt_name,$elements);
$elements=str_replace('{CHATS_NUM}',$chats,$elements);
$elements=str_replace('{CHATS_LANG}',$lang['chatr_l'],$elements);
$elements=str_replace('{CHATS_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_chats.php\')">',$elements);
$elements=str_replace('{SETTINGS_LANG}',$lang['settings'],$elements);
$elements=str_replace('{SETTINGS_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_settings.php\')">',$elements);
$elements=str_replace('{HELP_LANG}',$lang['help'],$elements);
$elements=str_replace('{HELP_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_help.php\')">',$elements);
$elements=str_replace('{CLOSE_LINK}','</a>',$elements);
$elements=str_replace('{SKIN_DIR}',$site_to_bim.$skin_dir,$elements);

if($chats>$_SESSION['bmf_chat'] && $options[4]>0){
$swf='|:|1';
}else{$swf='|:|0';}

$_SESSION['bmf_cche']=$elements.'|:|0';
$_SESSION['bmf_chat']=$chats;

$elements.=$swf;print $elements;die();}

/* --- */

$elements=$settings['bar_elements']; $online=0;

if(strstr($elements,'{ONLINE_NUM}') || strstr($elements,'{ONLINE_BOOL}')){
$keep_time=$settings['main_refresh']*$settings['main_ofactor'];

$query='SELECT COUNT(*) FROM '.$dbss['prfx']."_online WHERE ($timestamp-rtime)<$keep_time";
$online=neutral_query($query);
$online=neutral_fetch_array($online);
$online=(int)$online[0];}

$elements=str_replace('{C1_LANG}',$lang['custom_1'],$elements);
$elements=str_replace('{C2_LANG}',$lang['custom_2'],$elements);
$elements=str_replace('{C3_LANG}',$lang['custom_3'],$elements);
$elements=str_replace('{C4_LANG}',$lang['custom_4'],$elements);
$elements=str_replace('{C5_LANG}',$lang['custom_5'],$elements);
$elements=str_replace('{WELCOME}',$lang['welcome'],$elements);
$elements=str_replace('{USER}',$pnt_name,$elements);
$elements=str_replace('{ONLINE_NUM}',$online,$elements);
$elements=str_replace('{ONLINE_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_users.php\')">',$elements);
$elements=str_replace('{ONLINE_LANG}',$lang['online'],$elements);
$elements=str_replace('{SETTINGS_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_settings.php\')">',$elements);
$elements=str_replace('{SETTINGS_LANG}',$lang['settings'],$elements);$elements=str_replace('{HELP_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_help.php\')">',$elements);
$elements=str_replace('{HELP_LINK}','<a href="info.php?why=link" onclick="return go_main(\'ucp_help.php\')">',$elements);
$elements=str_replace('{HELP_LANG}',$lang['help'],$elements);
$elements=str_replace('{CLOSE_LINK}','</a>',$elements);
$elements=str_replace('{SKIN_DIR}',$site_to_bim.$skin_dir,$elements);

$_SESSION['bmf_cche']=$elements;
$_SESSION['bmf_chat']=0;
print $elements;

?> 
<?php

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); $settings=get_settings(); get_user();

include 'lang/languages.inc';
include 'lang/'.$lang_admin[$settings['admin_lang']];

$wrong_acp=(int)$settings['wrong_acp'];$wrong_acp=$timestamp-$wrong_acp;
if(isset($_POST['acp_key']) && hsh($_POST['acp_key'])==$settings['acp_key'] && $wrong_acp>60){
$acp_key=hsh($settings['acp_key']);
setcookie('acpkey',$acp_key,time()+3600*6,'/');
adm_rdr('admin.php',1);}

elseif(isset($_POST['acp_key'])){
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$timestamp' WHERE set_id='wrong_acp'";
neutral_query($query);
adm_rdr('admin.php',0);}

if(!isset($_COOKIE['acpkey']) || hsh($settings['acp_key'])!=$_COOKIE['acpkey']){
$title=$lang['acpkey'];
include 'admin/head.pxtm';
include 'admin/acpkey.pxtm';
die();}

if(isset($_GET['q']) && $_GET['q']=='logout'){
setcookie('acpkey','',time()+3600*6,'/');
adm_rdr('admin.php',1);}

/* ----- */



if(isset($_POST['mssg_history']) && isset($_POST['user_history']) && isset($_POST['del_gbuddies']) && isset($_POST['optimize_tbl'])){
if($_POST['mssg_history']!=$settings['mssg_history']){
$mssg_history=(int)$_POST['mssg_history'];
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$mssg_history' WHERE set_id='mssg_history'";
neutral_query($query);}

if($_POST['user_history']!=$settings['user_history']){
$user_history=(int)$_POST['user_history'];
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$user_history' WHERE set_id='user_history'";
neutral_query($query);}

if($_POST['del_gbuddies']!=$settings['del_gbuddies']){
$del_gbuddies=(int)$_POST['del_gbuddies'];
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$del_gbuddies' WHERE set_id='del_gbuddies'";
neutral_query($query);}

if($_POST['optimize_tbl']!=$settings['optimize_tbl']){
$optimize_tbl=(int)$_POST['optimize_tbl'];
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$optimize_tbl' WHERE set_id='optimize_tbl'";
neutral_query($query);}

adm_rdr('admin.php?q=database',1);}

// -----

if(isset($_POST['notebook']) && isset($_POST['rdr'])){
$notebook=neutral_escape($_POST['notebook'],10000,'txt');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$notebook' WHERE set_id='notebook'";
neutral_query($query);
switch($_POST['rdr']){
case '2':adm_rdr('admin.php?q=settings',1);break;
case '3':adm_rdr('admin.php?q=looknfeel',1);break;
default:adm_rdr('admin.php',1);break;}}


// -----

if(isset($_POST['html_title'])){

if($_POST['html_title']!=$settings['html_title']){
$html_title=neutral_escape($_POST['html_title'],64,'str');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$html_title' WHERE set_id='html_title'";
neutral_query($query);}

if(isset($_POST['popup_ucp']) && $_POST['popup_ucp']!=$settings['popup_ucp']){
$popup_ucp=neutral_escape($_POST['popup_ucp'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$popup_ucp' WHERE set_id='popup_ucp'";
neutral_query($query);}

if(isset($_POST['ucp_effect']) && $_POST['ucp_effect']!=$settings['ucp_effect']){
$ucp_effect=neutral_escape($_POST['ucp_effect'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$ucp_effect' WHERE set_id='ucp_effect'";
neutral_query($query);}

if(isset($_POST['ucp_width']) && $_POST['ucp_width']!=$settings['ucp_width']){
$ucp_width=neutral_escape($_POST['ucp_width'],4,'int');
if($ucp_width<100 || $ucp_width>900){$ucp_width=550;}
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$ucp_width' WHERE set_id='ucp_width'";
neutral_query($query);}

if(isset($_POST['ucp_height']) && $_POST['ucp_height']!=$settings['ucp_height']){
$ucp_height=neutral_escape($_POST['ucp_height'],4,'int');
if($ucp_height<100 || $ucp_height>600){$ucp_height=360;}
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$ucp_height' WHERE set_id='ucp_height'";
neutral_query($query);}

adm_rdr('admin.php?q=ucp',1);
}
// -----

if(isset($_POST['settings'])){

if(isset($_POST['header_rdr']) && $_POST['header_rdr']!=$settings['header_rdr']){
$header_rdr=neutral_escape($_POST['header_rdr'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$header_rdr' WHERE set_id='header_rdr'";
neutral_query($query);}

if(isset($_POST['no_session_err']) && $_POST['no_session_err']!=$settings['no_session_err']){
$no_session_err=neutral_escape($_POST['no_session_err'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$no_session_err' WHERE set_id='no_session_err'";
neutral_query($query);}

if(isset($_POST['admin_css']) && $_POST['admin_css']!=$settings['admin_css']){
$admin_css=neutral_escape($_POST['admin_css'],2,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$admin_css' WHERE set_id='admin_css'";
neutral_query($query);}

if(isset($_POST['latest_mssg']) && $_POST['latest_mssg']!=$settings['latest_mssg']){
$latest_mssg=(int)$_POST['latest_mssg']; if($latest_mssg>120){$latest_mssg=10;}
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$latest_mssg' WHERE set_id='latest_mssg'";
neutral_query($query);}

if(isset($_POST['ajax_delay']) && $_POST['ajax_delay']!=$settings['ajax_delay']){
$ajax_delay=(int)$_POST['ajax_delay']; if($ajax_delay>900 || $ajax_delay<10){$ajax_delay=200;}
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$ajax_delay' WHERE set_id='ajax_delay'";
neutral_query($query);}

if(isset($_POST['m_interval']) && $_POST['m_interval']!=$settings['m_interval']){
$m_interval=(int)$_POST['m_interval']; if($m_interval>9000 || $m_interval<500){$m_interval=500;}
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$m_interval' WHERE set_id='m_interval'";
neutral_query($query);}

if(isset($_POST['post_length']) && $_POST['post_length']!=$settings['post_length']){
$post_length=(int)$_POST['post_length']; if($post_length>2048 || $post_length<128){$post_length=512;}
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$post_length' WHERE set_id='post_length'";
neutral_query($query);}


if(isset($_POST['admin_lang']) && $_POST['admin_lang']!=$settings['admin_lang']){
$admin_lang=neutral_escape($_POST['admin_lang'],2,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$admin_lang' WHERE set_id='admin_lang'";
neutral_query($query);}


if(isset($_POST['stat_entries']) && $_POST['stat_entries']!=$settings['stat_entries']){
$stat_entries=(int)$_POST['stat_entries'];
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$stat_entries' WHERE set_id='stat_entries'";
neutral_query($query);}

if(isset($_POST['default_timezone']) && $_POST['default_timezone']!=$settings['default_timezone']){
$default_timezone=neutral_escape($_POST['default_timezone'],3,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$default_timezone' WHERE set_id='default_timezone'";
neutral_query($query);}

if(isset($_POST['default_timeform']) && $_POST['default_timeform']!=$settings['default_timeform']){
$default_timeform=neutral_escape($_POST['default_timeform'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$default_timeform' WHERE set_id='default_timeform'";
neutral_query($query);}

if(isset($_POST['default_language']) && $_POST['default_language']!=$settings['default_language']){
$default_language=neutral_escape($_POST['default_language'],2,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$default_language' WHERE set_id='default_language'";
neutral_query($query);}

if(isset($_POST['default_veffect']) && $_POST['default_veffect']!=$settings['default_veffect']){
$default_veffect=neutral_escape($_POST['default_veffect'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$default_veffect' WHERE set_id='default_veffect'";
neutral_query($query);}

if(isset($_POST['default_sound1']) && $_POST['default_sound1']!=$settings['default_sound1']){
$default_sound1=neutral_escape($_POST['default_sound1'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$default_sound1' WHERE set_id='default_sound1'";
neutral_query($query);}

if(isset($_POST['default_sound2']) && $_POST['default_sound2']!=$settings['default_sound2']){
$default_sound2=neutral_escape($_POST['default_sound2'],1,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$default_sound2' WHERE set_id='default_sound2'";
neutral_query($query);}

if(isset($_POST['chat_refresh']) && $_POST['chat_refresh']!=$settings['chat_refresh']){
$chat_refresh=neutral_escape($_POST['chat_refresh'],2,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$chat_refresh' WHERE set_id='chat_refresh'";
neutral_query($query);}

if(isset($_POST['main_refresh']) && $_POST['main_refresh']!=$settings['main_refresh']){
$main_refresh=neutral_escape($_POST['main_refresh'],2,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$main_refresh' WHERE set_id='main_refresh'";
neutral_query($query);}

if(isset($_POST['main_ofactor']) && $_POST['main_ofactor']!=$settings['main_ofactor']){
$main_ofactor=neutral_escape($_POST['main_ofactor'],2,'int');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$main_ofactor' WHERE set_id='main_ofactor'";
neutral_query($query);}

adm_rdr('admin.php?q=options',1);
}

// -----


if(isset($_POST['cacp']) && isset($_POST['nacp']) && isset($_POST['racp'])){
$cacp=trim($_POST['cacp']);$nacp=trim($_POST['nacp']);$racp=trim($_POST['racp']);

if(strlen($nacp)>4 && $nacp==$racp && hsh($cacp)==$settings['acp_key']){
$acp_key=hsh($nacp);
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$acp_key' WHERE set_id='acp_key'";
neutral_query($query);
adm_rdr('admin.php?q=acpkey',1);
}}

// -----

if(isset($_POST['bar_style'])){

$bar_style=str_replace('"','',$_POST['bar_style']);
$bar_style=str_replace("'",'',$bar_style);
$bar_style=neutral_escape($bar_style,99999,'txt');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$bar_style' WHERE set_id='bar_style'";
neutral_query($query);

adm_rdr('admin.php?q=bbstyle',1);}

// -----

if(isset($_POST['bar_elements']) && isset($_POST['bar_chatreqt'])){

$bar_elements=neutral_escape($_POST['bar_elements'],99999,'txt');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$bar_elements' WHERE set_id='bar_elements'";
neutral_query($query);

$bar_chatreqt=neutral_escape($_POST['bar_chatreqt'],99999,'txt');
$query='UPDATE '.$dbss['prfx']."_settings SET set_value='$bar_chatreqt' WHERE set_id='bar_chatreqt'";
neutral_query($query);

adm_rdr('admin.php?q=bbelements',1);}


/* ----- */

if(!isset($_GET['q'])){$q='main';}else{$q=$_GET['q'];}

switch ($q){
case 'settings':$title=$lang['settings'];$page='st_overview.pxtm';break;
case 'options':$title=$lang['settings'];$page='st_settings.pxtm';break;
case 'database':$title=$lang['settings'];$page='st_database.pxtm';break;
case 'acpkey':$title=$lang['settings'];$page='st_acpkey.pxtm';break;
case 'looknfeel':$title=$lang['lookfeel'];$page='lf_overview.pxtm';break;
case 'bbstyle':$title=$lang['lookfeel'];$page='lf_bbstyle.pxtm';break;
case 'bbelements':$title=$lang['lookfeel'];$page='lf_bbelements.pxtm';break;
case 'ucp':$title=$lang['lookfeel'];$page='lf_ucp.pxtm';break;
default:$title=$lang['main'];$page='main.pxtm';break;}

include 'admin/head.pxtm';
include 'admin/overal_header.pxtm';
include 'admin/'.$page;
include 'admin/overal_footer.pxtm';

?>
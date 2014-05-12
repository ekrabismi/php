<?php 

require_once 'config.php';
require_once 'incl/main.inc';

if(isset($_GET['del_cookie'])){
setcookie('bmf_guest','',time(),'/');
setcookie('bmf_options','',time(),'/');
setcookie('bmf_status','',time(),'/');
redirect('ucp_users.php',0,0);}

dbconnect(); session_start();
$settings=get_settings(); get_user(); $status=get_status(); $options=get_options(); $lang=get_language(); 

if(!isset($_SESSION['bmf_id'])){die();}

$title=htmrem($settings['html_title']).' '.$lang['settings'];

if(isset($_GET['disable_bar'])){
$v=(int)$_GET['disable_bar']; if($v==0){$v='';}
setcookie('bmf_disable',$v,time()+3600*24*30,'/');
redirect('ucp_settings.php',2,0);}

if(isset($_POST['mbold']) && isset($_POST['mcolor']) && isset($_POST['ybold']) && isset($_POST['ycolor']) && isset($_POST['language']) && isset($_POST['timezone']) && isset($_POST['timeform']) && isset($_POST['veffects']) && isset($_POST['snd_c']) && isset($_POST['snd_m'])){

$cc=array();
$cc[0]=(int)$_POST['language'];
$cc[1]=(int)$_POST['timezone'];
$cc[2]=(int)$_POST['timeform'];
$cc[3]=(int)$_POST['veffects'];
$cc[4]=(int)$_POST['snd_c'];
$cc[5]=(int)$_POST['snd_m'];
$cc[6]=(int)$_POST['mbold'];
$cc[7]=(int)$_POST['ybold'];
$cc[8] = str_replace('|','',$_POST['mcolor']);
$cc[9] = str_replace('|','',$_POST['ycolor']);
$cc[10]=(int)$_POST['closeucp'];

$cc=implode('|',$cc);
setcookie('bmf_options',$cc,time()+3600*24*365,'/');
redirect('ucp_settings.php',2,0);
}

include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/ucp_settings.pxtm';

?>
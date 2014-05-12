<?php 

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); get_user(); $status=get_status(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id'])){die();}

$displ_ch=0;
if(isset($_POST['start_fr'])){$start_fr=(int)$_POST['start_fr'];}else{$start_fr=0;}

$title=htmrem($settings['html_title']).' '.$lang['chatr_l'];

include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/ucp_chats.pxtm';

?>
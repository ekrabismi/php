<?php 

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); get_user(); $status=get_status(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id'])){die();}

$_SESSION['bmf_last']=0;

$title=htmrem($settings['html_title']).' '.$lang['screen_name'];

if(isset($_POST['guest_name'])){
$guest=trim($_POST['guest_name']);
$guest=neutral_escape($guest,32,'str');
$uid=(int)$_SESSION['bmf_id'];

$query='SELECT * FROM '.$dbss['prfx']."_users WHERE usr_name='$guest'";
$result=neutral_query($query);

if(strlen($guest)>2 && neutral_num_rows($result)<1){
$query='UPDATE '.$dbss['prfx']."_users SET usr_name='$guest' WHERE usr_id=$uid";
neutral_query($query);redirect('ucp_settings.php',2,0);}
else{redirect('ucp_name.php',5,$lang['name_taken']);}}

include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/ucp_name.pxtm';

?>
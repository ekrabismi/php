<?php 

require_once 'config.php';
require_once 'incl/main.inc';

session_start();

$status=(int)$_GET['q']; $hash=hsh($status); $status=$status.'|'.$hash;
setcookie('bmf_status',$status,time()+3600*6,'/');

if(isset($_GET['r'])){$r=$_GET['r'];}else{$r=0;}
$r=explode('ucp_',$r);if(isset($r[1])){$r=str_replace('.php','',$r[1]);}

switch($r){
case 'users':$page='ucp_users.php';break;
case 'chats':$page='ucp_chats.php';break;
case  'help':$page='ucp_help.php';break;
case  'name':$page='ucp_name.php';break;
default: $page='ucp_settings.php';break;}

redirect($page,0,0);
?>
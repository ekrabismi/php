<?php

if(isset($_GET['u'])){$u=(int)$_GET['u'];}else{$u=0;} if($u<1){die();}

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); get_user(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id']) || !isset($_SESSION['bmf_name'])){die();}

$bim_id=(int)$_SESSION['bmf_id'];

$file_list='';
include $skin_dir.'/'.$emo_file;

$sm_tag=array(); $sm_img=array();

for($i=0;$i<count($emoticons);$i++){
$csm=explode(' ',$emoticons[$i]);
if(isset($csm[1])){$sm_tag[]="'$csm[0]'";$sm_img[]="'$csm[1]'";}}

$sm_tag=implode(',',$sm_tag);
$sm_img=implode(',',$sm_img);

$title=htmrem($settings['html_title']);

include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/chat.pxtm';

?>
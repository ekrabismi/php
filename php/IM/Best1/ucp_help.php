<?php 

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); get_user(); $status=get_status(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id'])){die();}

$title=htmrem($settings['html_title']).' '.$lang['help'];

include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/ucp_help.pxtm';

?>
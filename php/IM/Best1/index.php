<?php 
require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); $settings=get_settings();

if(isset($_GET['enable'])){
setcookie('bmf_disable','',time(),'/');
redirect($bim_to_site,0,0);}

$title=htmrem($settings['html_title']);

include $skin_dir.'/templates/head.pxtm';
include $skin_dir.'/templates/index.pxtm';

?>
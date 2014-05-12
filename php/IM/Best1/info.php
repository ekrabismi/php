<?php

if(isset($_GET['why'])){

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); $settings=get_settings(); $options=get_options(); $lang=get_language();

$title=htmrem($settings['html_title']);
include $skin_dir.'/templates/head.pxtm';

switch($_GET['why']){
case 'link':$message=$lang['newwin_lnk'];break;
default:$message='---';break;}

print '<body><div style="margin:10px">'.$message.'<br /><br /><a href="http://hot-things.net"><b>BlaB! IM</b></a></div></body></html>'; die();
}

?>
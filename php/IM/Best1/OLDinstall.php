<?php
require_once 'config.php';
require_once 'incl/'.$dbss['type'].'_functions.inc';

function process_error($s){print '<pre>'.$s.'</pre>';die();}
function hsh($a){global $salt;$a=md5(md5($a).$salt);return $a;}

if(isset($_POST['step'])){$step=(int)$_POST['step'];}else{$step=0;}
$next_step=$step+1; $rn="\r\n";

print '<?xml version="1.0" encoding="utf-8"?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>BlaB! IM Install</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin/style2.css" />
</head><body>
<form action="install.php" method="post" style="margin:0px;padding:0px">
<p><input type="hidden" name="step" value="<?php print $next_step;?>" /></p>

<div style="text-align:center;background-color:transparent"><div class="mainbox">

<?php

switch ($step){

case 1: neutral_dbconnect();?>
<div id="dbf">Database details in <b>config.php</b> are not correct.  Please open <b>config.php</b> with a text editor, make sure that all required variables are correct, re-upload <b>config.php</b> and press F5 to reload this page.</div>
<script type="text/javascript">document.getElementById('dbf').style.display='none';</script>
<div class="navbar1">BlaB! IM Install [Step 2 of 3]</div>
<div class="content"><br /><div class="title">Setting ACP key and creating database tables<br />&nbsp;</div>
<div style="text-align:justify">Database OK. You are about to install BlaB! IM.
Please set your ACP KEY in the fields below and click <b>NEXT</b>. The ACP KEY is a password that allows you to enter ADMIN CONTROL PANEL  (ACP = ADMIN CONTROL PANEL). 
Your ACP KEY is case-sensitive and must be between 5 and 12 chars. It is recommended to use a mix of numbers, lowercase and uppercase letters.
</div><br /><br />
<div class="tbl"><div class="tr1" style="padding:22px;margin:1px;text-align:center"><b>ACP KEY</b>: <input type="text" name="acp_key" maxlength="12" value="" />
&nbsp; &nbsp; &nbsp; <b>RETYPE ACP KEY</b>: <input type="text" name="retype" maxlength="12" value="" />
</div></div>
<div style="text-align:right"><br /><input type="button" class="btn" value="&nbsp; NEXT &nbsp;" onclick="a=document.forms[0]; if(5>a.acp_key.value.length || a.acp_key.value!=a.retype.value){a.acp_key.value='';a.retype.value='';return false}else{document.forms[0].submit()}" /></div>
</div>
<?php  ;break; case 2:

/* --- */

if(!isset($_POST['acp_key']) || strlen(trim($_POST['acp_key']))<5){print '<script type="text/javascript">window.location=\'install.php?whats_wrong=acp_key\';</script></div></div></form></body></html>';die();}

$acp_key=hsh($_POST['acp_key']);

switch($dbss['type']){
case 'pdo_sqlite'  :$auto_increment='integer NOT NULL PRIMARY KEY';                $heap_type='';break;
case 'sqlite'      :$auto_increment='integer NOT NULL PRIMARY KEY';                $heap_type='';break;
case 'postgre'     :$auto_increment='serial PRIMARY KEY';                          $heap_type='';break;
default            :$auto_increment='integer NOT NULL auto_increment PRIMARY KEY'; $heap_type=' TYPE=HEAP MAX_ROWS=15000;';break;
}

$install=array();
neutral_dbconnect();

$install[]='CREATE TABLE '.$dbss['prfx'].'_users(
usr_id '.$auto_increment.',
usr_name varchar(255) NOT NULL,
salt char(40) NOT NULL)';

/* ---- */

$install[]='CREATE TABLE '.$dbss['prfx'].'_chatting(
usr_id integer NOT NULL,
usr_name varchar(255) NOT NULL,
chatto integer NOT NULL,
timestamp integer NOT NULL)'.$heap_type;

/* ---- */

$install[]='CREATE TABLE '.$dbss['prfx'].'_invite(
id '.$auto_increment.',
usr_id integer NOT NULL,
usr_name varchar(255) NOT NULL,
chatto integer NOT NULL,
chatto_name varchar(255) NOT NULL,
timestamp integer NOT NULL,
status smallint NOT NULL)';

/* ---- */

$install[]='CREATE TABLE '.$dbss['prfx'].'_lines(
line_id '.$auto_increment.',
usr_id integer NOT NULL,
usr_name varchar(255) NOT NULL,
chatto integer NOT NULL,
timestamp integer NOT NULL,
line_txt text NOT NULL)';

/* ---- */

$install[]='CREATE TABLE '.$dbss['prfx'].'_online(
usr_id integer NOT NULL,
usr_name varchar(255) NOT NULL,
usr_ip varchar(15) NOT NULL,
rtime integer NOT NULL,
status smallint NOT NULL)';

/* ---- */

$install[]='CREATE TABLE '.$dbss['prfx'].'_settings(
set_id varchar(16) NOT NULL PRIMARY KEY,
set_value text NOT NULL)';

$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('default_timezone','3')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('default_timeform','0')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('default_language','0')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('default_veffect','1')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('default_sound1','3')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('default_sound2','2')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('chat_refresh','5')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('main_refresh','10')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('main_ofactor','3')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('mssg_history','24')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('user_history','336')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('bar_style',' font-family:verdana,sans-serif; $rn font-size:9px; $rn color:#000; $rn background-color:#E1EBF2; $rn font-weight:bold; $rn text-transform:uppercase; $rn margin:0px; $rn padding:1px; $rn width:auto; $rn height:auto; $rn position:fixed; $rn float:left; $rn top:auto; $rn bottom:8px; $rn left:auto; $rn right:8px; $rn border:1px solid #098DCE; $rn border-bottom-width:2px; $rn z-index:1;')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('bar_elements',' <div style=\"background-color:#03557E;color:#fff;padding:5px\">Instant Messenger</div> $rn <div style=\"padding:5px\">{WELCOME} {USER} $rn $rn {ONLINE_LINK}<input style=\"color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff\" type=\"button\" value=\"{ONLINE_LANG}: {ONLINE_NUM}\" />{CLOSE_LINK} $rn $rn {SETTINGS_LINK}<input style=\"color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff\" type=\"button\" value=\"{SETTINGS_LANG}\" />{CLOSE_LINK} $rn </div>')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('bar_chatreqt',' <div style=\"background-color:#a00;color:#fff;padding:5px\">Instant Messenger</div> $rn <div style=\"padding:5px\">{WELCOME} {USER} $rn $rn {CHATS_LINK}<input style=\"color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff\" type=\"button\" value=\"{CHATS_LANG}: {CHATS_NUM}\" />{CLOSE_LINK}</div>')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('acp_key','$acp_key')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('wrong_acp','0')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('admin_css','2')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('admin_lang','0')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('header_rdr','1')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('html_title',':::BlaB! IM:::')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('popup_ucp','0')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('optimize_tbl','1')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('del_gbuddies','0')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('no_session_err','1')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('ucp_width','550')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('ucp_height','360')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('ucp_effect','1')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('latest_mssg','20')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('ajax_delay','10')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('post_length','129')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('m_interval','600')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('stat_entries','50')";
$install[]='INSERT INTO '.$dbss['prfx']."_settings VALUES('notebook','notes...')";

/* ---- */

for($i=0;$i<count($install);$i++){neutral_query($install[$i]);}

/* --- */

?>
<div class="navbar1">BlaB! IM Install [Step 3 of 3]</div>
<div class="content"><br /><div class="title">Install completed<br />&nbsp;</div>
Remove or rename <b>install.php</b> and <a href="admin.php"><b>CLICK HERE</b></a> to  enter Admin CP.</div>

<?php ;break; default:?>
<div class="navbar1">BlaB! IM Install [Step 1 of 3]</div>
<div class="content"><br /><div class="title">Database test<br />&nbsp;</div>
Preparing to install... Click <b>NEXT</b> to continue with a database test. If the test fails, open <i>config.php</i> with a text editor, make sure that all required variables are correct and re-upload <i>config.php</i>.
<div class="hr"></div>
<div style="text-align:right"><br /><input type="button" class="btn" value="&nbsp; NEXT &nbsp;" onclick="document.forms[0].submit()" /></div>
</div>


<?php ;break;}?>

</div></div>
</form></body></html>
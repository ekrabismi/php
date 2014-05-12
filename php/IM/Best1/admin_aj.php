<?php

function time_to_run(){
$time=microtime();
$time=explode(' ',$time);
return $time[1]+$time[0];}
$start_time=time_to_run();

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); $settings=get_settings(); get_user(); $options=get_options();

include 'lang/languages.inc';
include 'lang/'.$lang_admin[$settings['admin_lang']];

if(!isset($_COOKIE['acpkey']) || hsh($settings['acp_key'])!=$_COOKIE['acpkey']){die();}

/* --- */

if(isset($_POST['ajx_sett'])){$ajx_sett=$_POST['ajx_sett'];}else{$ajx_sett='0|0|0';}

$ajx_sett=explode('|',$ajx_sett);
if(!isset($ajx_sett[0])){$ajx_sett[0]=0;}else{$ajx_sett[0]=(int)$ajx_sett[0];} // page
if(!isset($ajx_sett[1])){$ajx_sett[1]=0;}else{$ajx_sett[1]=(int)$ajx_sett[1];} // from
if(!isset($ajx_sett[2])){$ajx_sett[2]=0;}                                      // what

$entries=(int)$settings['stat_entries'];

$back=$ajx_sett[1]-$entries;if($back<0){$back=0;}
$next=$ajx_sett[1]+$entries; $bn_range=$lang['range'].': <b>'.$ajx_sett[1].'-'.$next.'</b>';

if($dbss['type']=='mysql' || $dbss['type']=='mysqli'){$llim='LIMIT '.$ajx_sett[1].','.$entries;}else{$llim='LIMIT '.$entries.' OFFSET '.$ajx_sett[1];}

switch($options[2]){
case 3:$format='d.m.Y H:i:s';break;
case 4:$format='m/d/Y h:i:s A';break;
default :$format='Y-m-d H:i:s';break;}

/* --- */

if($ajx_sett[0]==1){

if($dbss['type']!='sqlite' && $dbss['type']!='pdo_sqlite'){
$query='SELECT COUNT(DISTINCT(usr_id)) AS cnt FROM '.$dbss['prfx'].'_lines';
$result=neutral_query($query); $cnt=neutral_fetch_array($result); $cnt=$cnt['cnt'];}else{$cnt='~~';}


$query='SELECT COUNT(*) AS posts,usr_id,usr_name FROM '.$dbss['prfx'].'_lines GROUP BY usr_id,usr_name ORDER BY posts DESC '.$llim;
$result=neutral_query($query); $tr=1;

print '<div class="title">'.$lang['top_users'].'</div>';
print '<p style="text-align:justify">'.$lang['sl2_desc'].'</p>';
print '<div style="float:left">'.$bn_range.' ('.$lang['entries'].': <b>'.$cnt.'</b>)</div><div class="title" style="text-align:right"><a href="info.php?why=link" onclick="res_send(1,'.$back.',\''.$ajx_sett[2].'\');return false">'.$lang['back'].'</a> &middot; <a href="info.php?why=link" onclick="res_send(1,'.$next.',\''.$ajx_sett[2].'\');return false">'.$lang['next'].'</a></div><div class="hr"></div>';
print '<table cellspacing="1" cellpadding="8" class="tbl">';

while($row=neutral_fetch_array($result)){
$uid=(int)$row['usr_id'];
$name=htmrem($row['usr_name']);

print '<tr class="tr'.$tr.'"><td>UID: <b>'.$uid.'</b></td><td><b>'.$name.'</b></td><td>'.$lang['messages'].': <b>'.$row['posts'].'</b></td></tr>';
if($tr==1){$tr=2;}else{$tr=1;}}

if(neutral_num_rows($result)<1){print '<tr class="tr2"><td>'.$lang['no_data'].'</td></tr>';}
print '</table>';
}

/* --- */

if($ajx_sett[0]==2){

$query='SELECT COUNT(*) AS cnt FROM '.$dbss['prfx'].'_invite';
$result=neutral_query($query); $cnt=neutral_fetch_array($result); $cnt=$cnt['cnt'];

$query='SELECT * FROM '.$dbss['prfx'].'_invite ORDER BY timestamp DESC '.$llim;
$result=neutral_query($query); $tr=1;

print '<div class="title">'.$lang['crequests'].'</div>';
print '<p style="text-align:justify">'.$lang['sl3_desc'].'</p>';
print '<div style="float:left">'.$bn_range.' ('.$lang['entries'].': <b>'.$cnt.'</b>)</div><div class="title" style="text-align:right"><a href="info.php?why=link" onclick="res_send(2,'.$back.',\''.$ajx_sett[2].'\');return false">'.$lang['back'].'</a> &middot; <a href="info.php?why=link" onclick="res_send(2,'.$next.',\''.$ajx_sett[2].'\');return false">'.$lang['next'].'</a></div><div class="hr"></div>';
print '<table cellspacing="1" cellpadding="8" class="tbl">';

while($row=neutral_fetch_array($result)){

$f_name=htmrem($row['usr_name']);
$t_name=htmrem($row['chatto_name']);
$show_time=gmdate($format,$row['timestamp']+$options[1]*3600);
$img='<img src="admin/inv_'.$row['status'].'.png" alt="" />';

print '<tr class="tr'.$tr.'">';
print '<td><b>'.$f_name.'</b></td><td><b>&raquo;</b></td><td><b>'.$t_name.'</b></td>';
print '<td>'.$img.'</td><td>'.$show_time.'</td></tr>';
if($tr==1){$tr=2;}else{$tr=1;}}

if(neutral_num_rows($result)<1){print '<tr class="tr2"><td>'.$lang['no_data'].'</td></tr>';}

print '</table>';
}

/* --- */


if($ajx_sett[0]==6){

$keep_time=$settings['chat_refresh']*$settings['main_ofactor'];
$query='DELETE FROM '.$dbss['prfx']."_chatting WHERE ($timestamp-timestamp)>$keep_time";
neutral_query($query); 

$query='SELECT COUNT(*) AS cnt FROM  '.$dbss['prfx'].'_chatting a, '.$dbss['prfx'].'_chatting b WHERE a.usr_id=b.chatto AND b.usr_id=a.chatto AND a.usr_id>=b.usr_id';
$result=neutral_query($query); $cnt=neutral_fetch_array($result); $cnt=$cnt['cnt'];

$query='SELECT a.usr_id AS aid, b.usr_id AS bid, a.usr_name AS aname, b.usr_name AS bname FROM  '.$dbss['prfx'].'_chatting a, '.$dbss['prfx'].'_chatting b WHERE a.usr_id=b.chatto AND b.usr_id=a.chatto AND a.usr_id>=b.usr_id '.$llim;
$result=neutral_query($query);$tr=1;

print '<div class="title">'.$lang['now_chatt'].'</div>';
print '<p style="text-align:justify">'.$lang['sl7_desc'].'</p>';
print '<div style="float:left">'.$bn_range.' ('.$lang['entries'].': <b>'.$cnt.'</b>)</div><div class="title" style="text-align:right"><a href="info.php?why=link" onclick="res_send(6,'.$back.',\''.$ajx_sett[2].'\');return false">'.$lang['back'].'</a> &middot; <a href="info.php?why=link" onclick="res_send(6,'.$next.',\''.$ajx_sett[2].'\');return false">'.$lang['next'].'</a></div><div class="hr"></div>';
print '<table cellspacing="1" cellpadding="8" class="tbl">';

while($row=neutral_fetch_array($result)){

$aname=htmrem($row['aname']); $bname=htmrem($row['bname']);
$aid=(int)$row['aid']; $bid=(int)$row['bid']; $msg=$row['aid'].':'.$row['bid'];

print '<tr class="tr'.$tr.'"><td><b>'.$aname.'</b></td><td><b>&amp;</b></td><td><b>'.$bname.'</b></td></tr>';
if($tr==1){$tr=2;}else{$tr=1;}}

if(neutral_num_rows($result)<1){print '<tr class="tr2"><td>'.$lang['no_data'].'</td></tr>';}
print '</table>';}

/*---*/

if($ajx_sett[0]==7){

$keep_time=$settings['main_refresh']*$settings['main_ofactor'];
if($ajx_sett[2]>0){$where_clause='';$order_by='ORDER BY rtime DESC';$t2=$lang['all'];}
else{$where_clause="WHERE ($timestamp-rtime)<$keep_time";$order_by='ORDER BY usr_name ASC';$t2=$lang['online'];}
$query='SELECT COUNT(*) as cnt FROM '.$dbss['prfx']."_online $where_clause";
$result=neutral_query($query); $cnt=neutral_fetch_array($result); $cnt=$cnt['cnt'];

$query='SELECT * FROM '.$dbss['prfx']."_online $where_clause $order_by ".$llim;
$result=neutral_query($query); $tr=1;

print '<div style="float:left"><span class="title">'.$lang['users'].'</span>: <b>'.$t2.'</b></div>';
print '<div style="float:right" class="title"><a href="info.php?why=link" onclick="res_send(7,0,0);return false">'.$lang['online'].'</a> &middot; <a href="info.php?why=link" onclick="res_send(7,0,1);return false">'.$lang['all'].'</a></div>';
print '<br style="clear:both" /><br /><p style="text-align:justify">'.$lang['sl8_desc'].'</p>';
print '<div style="float:left">'.$bn_range.' ('.$lang['entries'].': <b>'.$cnt.'</b>)</div><div class="title" style="text-align:right"><a href="info.php?why=link" onclick="res_send(7,'.$back.',\''.$ajx_sett[2].'\');return false">'.$lang['back'].'</a> &middot; <a href="info.php?why=link" onclick="res_send(7,'.$next.',\''.$ajx_sett[2].'\');return false">'.$lang['next'].'</a></div><div class="hr"></div>';
print '<table cellspacing="1" cellpadding="8" class="tbl">';

while($row=neutral_fetch_array($result)){
$name=htmrem($row['usr_name']);
$status=(int)$row['status'];
$ip=htmrem($row['usr_ip']);

$lseen=$timestamp-$row['rtime'];$last_seen=$lang['secs_ago'];
if($lseen>90000){$lseen=round($lseen/86400);$last_seen=$lang['days_ago'];$status=5;}
elseif($lseen>5400){$lseen=round($lseen/3600);$last_seen=$lang['hrs_ago'];$status=5;}
elseif($lseen>90){$lseen=round($lseen/60);$last_seen=$lang['mins_ago'];$status=5;}
$last_seen=$lseen.' '.$last_seen;

print '<tr class="tr'.$tr.'"><td class="o_ico"><img class="o_sts" src="admin/status'.$status.'.png" alt="" /></td>';
print '<td><b>'.$name.'</b></td><td>UID: <b>'.$row['usr_id'].'</b></td><td>'.$last_seen.'</td><td>'.$ip.'</td></tr>';
if($tr==1){$tr=2;}else{$tr=1;}}

if(neutral_num_rows($result)<1){print '<tr class="tr2"><td>'.$lang['no_data'].'</td></tr>';}
print '</table>';}

$time_to_exec=round(time_to_run()-$start_time,3);
print '<div style="text-align:right">('.$lang['queries'].': '.$queries.' / '.$time_to_exec.'s)</div>';
?>
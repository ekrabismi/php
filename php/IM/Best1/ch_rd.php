<?php

if(!isset($_GET['u'])){die();}
if(!isset($_GET['r'])){$rd=0;}else{$rd=(int)$_GET['r'];}
if(!isset($_GET['z'])){$cto_name='xxx';}else{$cto_name=$_GET['z'];}

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); $options=get_options(); $lang=get_language();

if(!isset($_SESSION['bmf_id']) || !isset($_SESSION['bmf_name'])){die();}

$chatto=(int)$_GET['u'];
$bim_id=(int)$_SESSION['bmf_id'];
$bim_name=neutral_escape($_SESSION['bmf_name'],64,'str');
$cto_name=neutral_escape($cto_name,64,'str');

$status=0;
$_SESSION['bmf_last']=0;

/* $rd:  1=request; 2=accept; 3=chat; 4=cancel; 5=all_read; */

if($rd==1){
$query='SELECT id,usr_id,chatto,status FROM '.$dbss['prfx']."_invite WHERE usr_id=$bim_id AND chatto=$chatto";
$result=neutral_query($query);

if(neutral_num_rows($result)<1){
if($bim_id==$chatto){$status=1;}
$query='INSERT INTO '.$dbss['prfx']."_invite VALUES(NULL,$bim_id,'$bim_name',$chatto,'$cto_name',$timestamp,$status)";
neutral_query($query);}
else{
$result=neutral_fetch_array($result);
$id=(int)$result['id']; $status=(int)$result['status'];
if($result['usr_id']==$result['chatto']){$status=1;}else{$status=0;}
$query='UPDATE '.$dbss['prfx']."_invite SET status=$status, timestamp=$timestamp, usr_name='$bim_name', chatto_name='$cto_name' WHERE id=$id";
neutral_query($query);}
redirect('chat.php?u='.$chatto,0,0);die();}

if($rd==2){
$query='UPDATE '.$dbss['prfx']."_invite SET status=1 WHERE chatto=$bim_id AND usr_id=$chatto";
neutral_query($query);
if($_SESSION['bmf_chat']>0){$_SESSION['bmf_chat']-=1;}
redirect('chat.php?u='.$chatto,0,0);die();}

if($rd==3){redirect('chat.php?u='.$chatto.'&preview=1',0,0);die();}

if($rd==4){
$query='UPDATE '.$dbss['prfx']."_invite SET status=1 WHERE chatto=$bim_id AND usr_id=$chatto";
if($_SESSION['bmf_chat']>0){$_SESSION['bmf_chat']-=1;}
neutral_query($query);
redirect('ucp_chats.php',0,0);die();}


if($rd==5){
$query='UPDATE '.$dbss['prfx']."_invite SET status=1 WHERE chatto=$bim_id AND status=0";
neutral_query($query);
$_SESSION['bmf_chat']=0;
redirect('ucp_chats.php',0,0);die();}

?>
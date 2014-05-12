<pre><?php

function time_to_run(){$time=microtime();$time=explode(' ',$time);return $time[1]+$time[0];}
$start_time=time_to_run();

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect();$settings=get_settings();

$hist_msg=$settings['mssg_history']*3600;$hist_msg=$timestamp-$hist_msg;
$hist_usr=$settings['user_history']*3600;$hist_usr=$timestamp-$hist_usr;

// -----

$query='DELETE FROM '.$dbss['prfx']."_invite WHERE timestamp<$hist_msg";
neutral_query($query);

if($dbss['type']=='mysql'){$affr=mysql_affected_rows();}else{$affr='~';}
print 'chat req. deleted: '.$affr."\r\n";

// -----

$query='DELETE FROM '.$dbss['prfx']."_lines WHERE timestamp<$hist_msg";
neutral_query($query);

if($dbss['type']=='mysql'){$affr=mysql_affected_rows();}else{$affr='~';}
print 'messages deleted: '.$affr."\r\n";

// -----

$query='DELETE FROM '.$dbss['prfx']."_online WHERE rtime<$hist_usr";
neutral_query($query);

if($dbss['type']=='mysql'){$affr=mysql_affected_rows();}else{$affr='~';}
print 'usr-log entries deleted: '.$affr."\r\n";

// -----

if($settings['del_gbuddies']!='0'){
$query='DELETE FROM '.$dbss['prfx']."_users";
neutral_query($query);

if($dbss['type']=='mysql'){$affr=mysql_affected_rows();}else{$affr='~';}
print 'guest names deleted: '.$affr."\r\n";
}


// -----

if($settings['optimize_tbl']!='0'){
switch($dbss['type']){
case 'sqlite':$comm='VACUUM';break;
case 'postgre':$comm='VACUUM';break;
default:$comm='OPTIMIZE TABLE';break;
}

$dbt=array('invite','lines','online');

if($dbss['type']!='sqlite'){
while(list($key,$val)=each($dbt)){
$val=$dbss['prfx'].'_'.$val;
$query=$comm.' '.$val;
neutral_query($query);
}}
else{$query='VACUUM';neutral_query($query);}
print 'DB optimized';}

// -----


$total_time=time_to_run();$total_time=substr(($total_time-$start_time),0,5);
print "\r\n---------------------\r\n".'done / ' .$total_time.' sec';

?></pre>

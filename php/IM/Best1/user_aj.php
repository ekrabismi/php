<?php

if(isset($_POST['q'])){$uid=(int)$_POST['q'];}else{$uid=0;}
if($uid<1){die();}

require_once 'config.php';
require_once 'incl/main.inc';

session_start(); dbconnect();
$settings=get_settings(); $options=get_options(); $lang=get_language(); $name='('.$lang['guest'].')';

// ---

$query='SELECT usr_name FROM '.$dbss['prfx']."_online WHERE usr_id=$uid";
$result=neutral_query($query);

if(neutral_num_rows($result)>0){
$name=neutral_fetch_array($result);
$name=$name[0];$name=htmrem($name);}
$enc_name=urlencode($name);

?>
<div class="box_barr" style="float:left">
<a href="info.php?why=link" onclick="process_chat(<?php print $uid;?>,1,'<?php print $enc_name;?>');return false"><?php print $lang['req_chat'];?>: <?php print $name;?></a>
</div>

<div class="box_barr" style="float:right"><a href="info.php?why=link" onclick="opa_st(document.getElementById('s_usr'),0);return false"><?php print $lang['close'];?></a></div>

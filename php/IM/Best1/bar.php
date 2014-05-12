<?php 

require_once 'config.php';
require_once 'incl/main.inc';

dbconnect(); session_start();
$settings=get_settings(); get_user(); $options=get_options(); 

if(!isset($_SESSION['bmf_id'])){die();}

$_SESSION['bmf_last']=0;
$_SESSION['bmf_chat']=0;

$bar_style=htmrem($settings['bar_style']);
$bar_style=str_replace("\r",' ',$bar_style);
$bar_style=str_replace("\n",' ',$bar_style);
$bar_style=str_replace("'","\'",$bar_style);

?>

if(typeof bim_path=='undefined'){bim_path='<?php print $site_to_bim;?>';}
opt_fsnd=bim_path+'<?php print $skin_dir.'/sounds/snd'. $options[4];?>.swf';
enable_url=bim_path+'index.php?enable=1';
ajx_updt=<?php print $settings['main_refresh'];?>;
ucppopup=<?php print $settings['popup_ucp'];?>;
ucpwidth=<?php print $settings['ucp_width'];?>;
ucpheight=<?php print $settings['ucp_height'];?>;
ucpeffect=<?php if($settings['ucp_effect']>0 && $options[3]>0){print '1';}else{print '0';}?>;
document.writeln('<div style="<?php print $bar_style;?>" id="blabimbar"></div>');
<?php if(!isset($_COOKIE['bmf_disable'])){?>
document.writeln('<script type="text/javascript" src="'+bim_path+'incl/bar.js"></script>');
<?php }else{?>
document.getElementById('blabimbar').innerHTML='<input type="button" style="font-weight:bold;background-color:#fff;color:#000;border-width:0px" value="&nbsp;<?php print $bim_disable;?>&nbsp;" onclick="window.location=enable_url" />';
<?php }?>

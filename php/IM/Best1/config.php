<?php

/* PLEASE DO NOT ALLOW EVEN ONE BLANK SPACE/LINE IN THIS FILE OUTSIDE '<?php' AND '?>' */


/* ------ BLAB!IM DATABASE SETTINGS ------  */

$dbss=array();

$dbss['type']='mysql';             // database type, *lowercase* (options: mysql, mysqli, postgre, sqlite, pdo_sqlite)
$dbss['host']='localhost';         // database host (in most cases 'localhost')

if($_SERVER['HTTP_HOST']=='localhost')
{
	$dbss['user']='root';                  // database user (not used with sqlite)
	$dbss['pass']='';                  // database password  (not used with sqlite)
	$dbss['name']='ben_speakserve';                  // Database name 
}
else
{
	$dbss['user']='root';                  // database user (not used with sqlite)
	$dbss['pass']='speaker';                  // database password  (not used with sqlite)
	$dbss['name']='symphony';                  // Database name 
}



$dbss['prfx']='bmf';               // Table prefix for BLAB!IM tables, default 'bmf'
$dbss['sqlt']='';                  // Database file [sqlite]: 'path/filename', a 0-byte file CHMODed to 777 in a dir that is CHMODed to 777
$dbss['sqlp']=0;                   // SQLITE only: PRAGMA synchronous; options: 0|1|2; 0 = OFF /fastest/; 1= NORMAL; 2 = FULL /slowest/
$dbss['pcon']=0;                   // [0 or 1] Establishes a persistent connection to the SQL server. If you are not sure leave it 0.

/* ---------------------------------------  */

$site_to_bim='./blab_im/';         // URL or relative path from your main site to BLAB!IM, default: $site_to_bim='./blab_im/'; [must end with a trailing slash]
$bim_to_site='../';                // URL or relative path from BLAB!IM to your main site, default: $bim_to_site='../'; [must end with a trailing slash]
$bim_disable='im';                 // What to display when BlaB!IM is disabled, set '+' or 'im'

$skin_dir='skin_default';          // skin directory: 'skin_default' or 'skin_tower'
$css_file='style_1.css';           // style file in use: 'style_1.css' or 'style_2.css' or 'style_3.css'
$error_log='errors.txt';           // CHMODed to 777 file to store sql errors if any ( it is recommended to rename this file )
$salt='rand0m_string_321';         // Salt.

?>
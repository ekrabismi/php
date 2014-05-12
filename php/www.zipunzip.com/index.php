<?php session_start(); ?>

<html>
<head><title>PHP Zipper and  Unzipper</title>
</head>

<style type="text/css">
 A {text-decoration:none;}
 A:hover {text-decoration:underline;}
 body {
      
      }
 
 .dirlist {
        display:table-cell;
        padding-right:40px;
        margin-top:10px;
        width:40%;
		font-size:16px;
        }

 .filelist {
        display:table-cell;
        width:40%;
        text-align:left;
		font-size:16px;
        }

 .filedirtitle {
        background-color: #7CFFCC;
        border: 1px #006699 solid;
        text-align:center;
        }

 .bigblock {
        display:table-cell;
        padding:5px;
        }

 .contents, .unzip {
        border: #FFFFFF 1px solid;
        padding:5px;
        height:auto;
        width:100%;
        position:relative;
        font-family:Tahoma;
        font-size:13px;
        text-align:left;
        }
        
 .unzip {
        text-align:left;
        margin-bottom: 20px;
        background:#00DDDD;
        }
        
 .heads {
        position:relative;
        font-family: Tahoma;
        font-size:20px;
        text-align:center;
        padding:5px;
        margin-bottom:20px;
        width:100%;
        clear:left;
        }
        
</style>

<body
<div class=heads>
PHP Zipper and  Unzipper
<?php
 $docname = basename(getenv('script_name'));

function fileext ($file) {
$p = pathinfo($file);
return $p['extension'];
}

function convertsize($size){

$times = 0;
$comma = '.';
while ($size>1024){
$times++;
$size = $size/1024;
}
$size2 = floor($size);
$rest = $size - $size2;
$rest = $rest * 100;
$decimal = floor($rest);

$addsize = $decimal;
if ($decimal<10) {$addsize .= '0';};

if ($times == 0){$addsize=$size2;} else
 {$addsize=$size2.$comma.substr($addsize,0,2);}

switch ($times) {
  case 0 : $mega = ' bytes'; break;
  case 1 : $mega = ' KB'; break;
  case 2 : $mega = ' MB'; break;
  case 3 : $mega = ' GB'; break;
  case 4 : $mega = ' TB'; break;}

$addsize .= $mega;

return $addsize;
}
$dir = $_GET['dir'];
$action = $_GET['action'];
$adm_user = $_POST['adm_user'];
$adm_pass = $_POST['adm_pass'];
$adm_pass_conf = $_POST['adm_pass_conf'];

/*      THE REAL STUFF BEGINS HERE     */

include "pclzip.lib.php";

chdir($dir);

$basedir = getcwd();
$mypath = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$mypath = substr($mypath,0,strpos($mypath,'/zipunzip/index.php'));
//echo "Base: " . $mypath;
$basedir = str_replace('\\','/',$basedir);        //'

if (is_dir($basedir)) { //show directory list

$parent = dirname($basedir);

$cur = $basedir;

while (substr($cur,0,1) == '/') {
        $cur = substr($cur,1,strlen($cur));
        $path .= '/'; }

$p_out = $path;
while (strlen($cur) > 0) {
$k = strpos($cur,'/');
if (!strpos($cur,'/')) $k = strlen($cur);
$s = substr($cur,0,$k);
$cur = substr($cur,$k+1,strlen($cur));
$path .= $s.'/';
$p_out .= "<a href='?dir=$path'>$s</a>/";
}

echo "<br><center><div>Current dir: ".$p_out."</div>";
echo "<center><div class=bigblock><div class=contents>";
echo "<div class=dirlist>";
echo "<div class=filedirtitle>Subdirectories</div>";
echo "<b><center><a href='?dir=$parent'>Parent directory</a></b></center><br>\n";

$glob = array();$c = 0;
if ($dh = opendir(getcwd())) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '..' && $file != '.') $glob[$c++] = $file;
        }
    closedir($dh);
    }

foreach ($glob as $filename) {
if (is_dir($filename)) {
    echo "&nbsp;&nbsp;
	/<a href='?dir=$basedir/$filename'>$filename</a>
	<a href='zip.php?zipdir=$basedir/$filename'>[Zip]</a> <br>\n";
}
}

echo "</div><div class=filelist>";
echo "<div class=filedirtitle>ZIP files</div>";
$filez = $glob;
reset($filez);
if (sizeof($filez) > 0)
foreach ($filez as $filename) {

if (strtolower(fileext($filename)) == 'zip')
{
	if (is_file($filename)) {
		
		$size = convertsize(filesize($filename));
		
	echo "&nbsp;&nbsp;<a href='?dir=$basedir&unzip=$filename&action=view' title='View archive contents'>$filename [view]</a> <a href='?dir=$basedir&unzip=$filename&action=unzip' title='Extract files from archive'><font color=red>[Unzip]</font></a>
	<a href='$mypath/$filename' title='Download archive'><font color=red>[Download, $size]</font></a>
	<br>";
	}
}

else if (strtolower(fileext($filename)) == 'bz2')
{
	if (is_file($filename)) {
		
		$size = convertsize(filesize($filename));
		
	echo "&nbsp;&nbsp;$filename <a href='?dir=$basedir&bzip=$filename&action=bz2' title='Extract files from archive'><font color=red>[Unzip]</font></a>
	<a href='$mypath/$filename' title='Download archive'><font color=red>[Download, $size]</font></a>
	<br>";
	}
}
}


echo "</div></div><br>";
}

$bzip = $_GET['bzip'];
$dir = $_GET['dir'];
$bz2 = $dir."/".$bzip;
 if ($_GET[action] == 'bz2')
	 {
     
	 exec("tar -jxvf $bz2");
	 //echo $bz2;
	 }
	 
	 
$unzip = $_GET['unzip'];

if (is_file($unzip)) {       //unzipping...

$zip = new PclZip($unzip);
if (($list = $zip->listContent()) == 0) {die("Error : ".$zip->errorInfo(true));  }

/*
File 0 / [stored_filename] = config
File 0 / [size] = 0
File 0 / [compressed_size] = 0
File 0 / [mtime] = 1027023152
File 0 / [comment] =
File 0 / [folder] = 1
File 0 / [index] = 0
File 0 / [status] = ok
*/

//calculate statistics...
  for ($i=0; $i<sizeof($list); $i++) {
    if ($list[$i][folder]=='1') {$fold++;
       $dirs[$fold] = $list[$i][stored_filename];
    if ($_GET[action] == 'unzip')
	 {
     $dirname = $list[$i][stored_filename];
     $dirname = substr($dirname,0,strlen($dirname)-1);
     mkdir($basedir.'/'.$dirname); 
	 
	 }
	
	 
     chmod($basedir.'/'.$dirname,0777);
       }
	   else{$fil++;}
    $tot_comp += $list[$i][compressed_size];
    $tot_uncomp += $list[$i][size];
    }


echo "<div class=unzip>".($_GET[action] == 'unzip' ? 'Unzipping' : 'Viewing')." file <b>$unzip</b><br>\n";
echo "$fil files and $fold directories in archive<br>\n";
echo "Compressed archive size: ".convertsize($tot_comp)."<br>\n";
echo "Uncompressed archive size: ".convertsize($tot_uncomp)."<br>\n";

if ($_GET[action] == 'unzip') {
echo "<br><b>Starting to decompress...</b><br>";
$zip->extract('');
echo "Archive sucessfuly extracted!<br>\n";
}

if ($_GET[action] == 'view') {
echo "<br>";
for ($i=0; $i<sizeof($list); $i++) {
    if ($list[$i][folder] == 1) {
         echo "<b>Folder: ".$list[$i][stored_filename]."</b><br>";
         } else {
         echo $list[$i][stored_filename]." (".convertsize($list[$i][size]).")<br>";
         }
  }
}



echo "</div>";

}

?>
</div>
</body>
</html>

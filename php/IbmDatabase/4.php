<?php

$localhost = "localhost";
$user = "ibmargentin";
$password = "ibm12345";
$database = "joomlaargentin_jo151";
$table = "jos_content";


$link = mysql_connect($localhost,$user,$password);
mysql_select_db($database,$link);

$sql = "select * from $table";

$result = mysql_query($sql,$link) or die(msql_error());

//$data = mysql_fetch_row($result);

$data = mysql_fetch_array($result);

$msgkey = "";
$msgvalue = "";

foreach($data as $key=>$value)
{
 if(is_string($key))
  {
   $msgkey = $msgkey . $key . ", ";
   if(is_null($value))
   {
    $msgvalue = $msgvalue . "'" . "'". ", ";
   } 	
   else if(is_numeric($value))
   {
    $msgvalue = $msgvalue . $value . ", ";
   }
   else 
   {
    $msgvalue = $msgvalue . "'" . $value . "'". ", ";
   } 	
  } 
}
$msgkey = substr($msgkey,0,-2); //removing last (, )
$msgvalue = substr($msgvalue,0,-2); //removing last (, )

$header = "DROP TABLE IF EXISTS $table;
CREATE TABLE IF NOT EXISTS $table(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL DEFAULT '',
  alias varchar(255) NOT NULL DEFAULT '',
  title_alias varchar(255) NOT NULL DEFAULT '',
  introtext mediumtext NOT NULL,
  fulltext mediumtext NOT NULL,
  state tinyint(3) NOT NULL DEFAULT '0',
  sectionid int(11) unsigned NOT NULL DEFAULT '0',
  mask int(11) unsigned NOT NULL DEFAULT '0',
  catid int(11) unsigned NOT NULL DEFAULT '0',
  created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  created_by int(11) unsigned NOT NULL DEFAULT '0',
  created_by_alias varchar(255) NOT NULL DEFAULT '',
  modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  modified_by int(11) unsigned NOT NULL DEFAULT '0',
  checked_out int(11) unsigned NOT NULL DEFAULT '0',
  checked_out_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  publish_up datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  publish_down datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  images text NOT NULL,
  urls text NOT NULL,
  attribs text NOT NULL,
  version int(11) unsigned NOT NULL DEFAULT '1',
  parentid int(11) unsigned NOT NULL DEFAULT '0',
  ordering int(11) NOT NULL DEFAULT '0',
  metakey text NOT NULL,
  metadesc text NOT NULL,
  access int(11) unsigned NOT NULL DEFAULT '0',
  hits int(11) unsigned NOT NULL DEFAULT '0',
  metadata text NOT NULL,
  PRIMARY KEY (id),
  KEY idx_section (sectionid),
  KEY idx_access (access),
  KEY idx_checkout (checked_out),
  KEY idx_state (state),
  KEY idx_catid (catid),
  KEY idx_createdby (created_by)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=145 ;";

$body = "INSERT INTO $table ($msgkey) VALUES($msgvalue)";

$file = fopen ("c:\\ibm.txt","w") or die("Can\'t open file");

print "<h1>Starting file writing to c:\\ibm.txt ....</h1>";

fputs($file,$header);
fputs($file,"\n\n");
fputs($file,$body);
fclose($file);

print "<h1>File writing to c:\\ibm.txt is cussessful</h1>";
//echo "<textarea rows=\"20\" cols=\"50\">$msgkey</textarea>";
///echo "<textarea rows=\"20\" cols=\"50\">".
   ///           addslashes($msgvalue) . "</textarea>";

?>







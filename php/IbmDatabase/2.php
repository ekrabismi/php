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
   $msgkey = $msgkey . $key . "\n";
   $msgvalue = $msgvalue . stripslashes($value) . "\n";
   
  } 
}

echo "<textarea rows=\"20\" cols=\"50\">$msgkey</textarea>";
echo "<textarea rows=\"20\" cols=\"50\">".
              addslashes($msgvalue) . "</textarea>";

?>







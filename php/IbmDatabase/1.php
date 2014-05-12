<?php

$localhost = "localhost";
$user = "ibmargentin";
$password = "ibm12345";
$database = "joomlaargentin_jo151";


$link = mysql_connect($localhost,$user,$password);
mysql_select_db($database,$link);

$sql = "select * from jos_content";

$result = mysql_query($sql,$link) or die(msql_error());

//$data = mysql_fetch_row($result);

$data = mysql_fetch_array($result);

//print_r ($data);
print $data['title'];
//print "<textarea rows=\"30\" cols=\"50\">$data['id']</textarea>";

//print $data[0];

?>


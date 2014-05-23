<?php
//$IP  = "181.197.75.17";
$IP  = "58.97.141.19";
$url ="http://api.netimpact.com/qv1.php?key=79facd6luuU2mXLP&qt=geoip&d=json&q=$IP";
$info = json_decode(file_get_contents($url));
echo "<pre>";
print_r($info);
?>
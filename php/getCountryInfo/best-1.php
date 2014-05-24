<?php
$ip = gethostbyname(isset($REMOTE_ADDR));
 
 if(!empty($ip))
	 {
	  
	 }
	elseif (!empty($_SERVER['HTTP_CLIENT_IP']))
	{
     $ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}

$url ="http://api.netimpact.com/qv1.php?key=79facd6luuU2mXLP&qt=geoip&d=json&q=$ip";
$info = json_decode(file_get_contents($url));
echo "<pre>";
print_r($info);
?>
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

	$c_data = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    
	$country = $c_data->geoplugin_countryName;
	$city = $c_data->geoplugin_city;
	
   echo "Ip: $ip, Country: $country, City: $city";
?>
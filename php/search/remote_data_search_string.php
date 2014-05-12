<?php
function remote_data_search($mypath, $search_str)
{
	$content = file_get_contents($mypath);
		
		if ($content !== false) {
		  
		  
		  $content = substr($content, strpos($content,'<body>') , strpos($content,'</body>')- strpos($content,'<body>'));
		  //cut the content in a length
		  
		  $content = strip_tags($content);
		  //removing html tags
		  
		  $content = str_replace("\n", " ", $content); 
	      //replacing new line to space
		  
		  $content = str_replace(".", " ", $content); 
	      //replacing . to space
		  
		  $content = str_replace(",", " ", $content); 
	      //replacing , to space
		  
		  
		  $content = strtolower($content);
		  //conterting string to lower case

		  $content = explode(" ",$content);
		  //converting to array ; explode into words 
		  
		  $content = array_map('trim', $content);
		  //removing space value from array
		  
		  $content = array_filter($content);
		  //removing empty array
		  
		  $result = array_search($search_str,$content);
		  
		  return $result;
		} 
}
?>
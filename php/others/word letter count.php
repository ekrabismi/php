<?php
$str = "Lorem ipsum dolor sit amet,  consectetur adipiscing elit. Cras justo mauris, imperdiet sit amet  ornare in, tristique ut est. Nulla pharetra interdum ipsum ut euismod.  Curabitur nec orci at arcu mattis accumsan ac at turpis. Nam condimentum  ante quis ipsum accumsan id tempus tortor consectetur. Praesent  tristique euismod pharetra. Nam in erat sapien. Duis ac nulla vitae mi  congue tincidunt varius id turpis. Donec arcu dolor, lacinia vitae  imperdiet ac, pharetra a dolor. Integer at risus imperdiet turpis  lobortis posuere. Nam vitae est quis mauris dignissim pretium id id  nibh. Nulla facilisi. Morbi eget mauris eget augue tincidunt cursus.";
$arrword = explode(" ",$str);
$range = count($arrword);
for($i=0;$i<$range/2+1;$i++)
{
    $len1 = strlen($arrword[$i]);
    $word=0;
    
    for($j=0;$j<$range;$j++)
    {
        $len2 = strlen($arrword[$j]);
        if($len1 == $len2)     $word++;
     }
     echo "$word words with ". $len1 ." letters<br>";
}




 
?>
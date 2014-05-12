<?php	
 if($_SERVER['HTTP_HOST']=='localhost')
	{
		$localhost = 'localhost';
		$user = 'root';
		$password = '';
		$database = 'prince_importcarsnow';
	}
	else
	{
		$localhost = 'localhost';
		$user = 'donkorp_prince2';
		$password = 'donkorp_prince2';
		$database = 'donkorp_carauction';
	}
	
	
	$link = mysql_connect($localhost,$user,$password);
	mysql_select_db($database,$link);
	
	$sql = "select id from mydealer order by id asc" ;
	
	$result = mysql_query($sql,$link) or die(mysql_error());
  while($data = mysql_fetch_array($result))
  {
	  $idarr[] = $data[0];
  }
  
  //print_r($idarr);
  $tp = count($idarr);
  $limit = 5;
  $p = ceil($tp/$limit);
  $l=0;
  $h=0;
  
  if(isset($_GET['p']))
   $curr = $_GET['p'];
  else
   $curr = 1;
   
  echo "Pages ($curr/$p): ";
  for($i=1;$i<=$p;$i++)
  {
	 // echo "$i , ";
	  //echo "<br>";
	  
	  if(!$h)
	  {
	   $l=$i-1;
	   }
	  else
	  {
		  $l=$h+1;
	  }
	  $h=$l+$limit-1;
	  if($h>=$tp) $h=$tp-1;
	  
	  //echo "l= " . $idarr[$l] . " , h= " . $idarr[$h] ."<br><br>";
	  echo "<a href='?l=" . $idarr[$l] . "&h= " . $idarr[$h] . "&p=$i'>$i</a> ,";
  }
 if(isset($_GET["l"]))
{  
 $l = $_GET["l"];
 $h = $_GET["h"];
}

else{
	$l=0;
	$h=$limit-1;
}
 $sql = "select * from mydealer where id >= $l and id <= $h" ;
	
 $result = mysql_query($sql,$link);
  while($data = mysql_fetch_array($result))
  {
	  echo $data[0] . "<br>";
  }
	?>
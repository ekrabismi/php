<?php	
$numrow=$i-1;
$limit=28;
$lower=0;
$upper=-1;
$pages= ceil($numrow/$limit);

print "Number of rows = $numrow<br>";
print "Rows per page (limit) = $limit<br>";
print "Pages = $pages<br>";

if($_REQUEST['upper'])
{
 $lower=$_REQUEST['lower'];
 $upper=$_REQUEST['upper']; 

for($i=$lower; $i<=$upper;$i++) 
 { 
    
 }

}

else
{
 $lower=0;
 $upper=$limit-1; 

for($i=$lower; $i<=$upper;$i++) 
 { 
  
 }

}

$lower=0;
$upper=-1;
print "<div align='right'>";
for($i=1;$i<=$pages; $i++)
{
$lower = $upper+1;
$upper = $lower + $limit - 1; 

print "<a href=\"?q=node/1&lower=$lower&upper=$upper\">";
print "$i</a> , ";

}

	?>
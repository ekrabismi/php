    <?php
	
		$numrow =  mysql_num_rows(mysql_query("SELECT * FROM sub_model"));
		$limit=28;
		$lower=0;
		$upper=-1;
		$pages= ceil($numrow/$limit);
		
		//print "Number of rows = $numrow<br>";
		//print "Rows per page (limit) = $limit<br>";
		//print "Pages = $pages<br>";
		
		if($_REQUEST['pages'])
		{
		 $mypage = $_REQUEST['pages'];
		 
		 $lower = ($mypage) * ($limit) - ($limit);
		 $upper = ($lower) + ($limit) - 1; 
		 if($upper > $numrow) $upper = $numrow-1;
		
		
		if($mypage==1)
			{	
			 echo "<img  src='images/left-inactive.png' />";
			 echo "<a href=\"?model_id=$model_id&pages=2\">";			 
			 echo "<img border='0'  src='images/right-active.png' />"; 
			 echo "</a>";   
			}
		else if($mypage==$pages)
			{	
			 $mypage = $mypage-1;
			 echo "<a href=\"?model_id=$model_id&pages=$mypage\">";
			 echo "<img border='0'  src='images/left-active.png' />";
			 echo "</a>"; 
			 echo "<img  src='images/right-inactive.png' />"; 
			}	
		else
			{	
			
			 $mypage = $mypage-1;
			 echo "<a href=\"?model_id=$model_id&pages=$mypage\">";
			 echo "<img border='0'  src='images/left-active.png' />";
			 echo "</a>";
			 $mypage = $mypage+2;
			 echo "<a href=\"?model_id=$model_id&pages=$mypage\">";
			 echo "<img  border='0' src='images/right-active.png' />";
			 echo "</a>";   
			}	
		
		 
		for($i=$lower; $i<=$upper;$i++) 
		 { 
			
		 }
		
		}
		
		else
		{
			
			if($numrow < $limit)
			{	
			 echo "<img  src='images/left-inactive.png' />";
			 echo "<img  src='images/right-inactive.png' />";   
			}
			
			else
			{	
			 echo "<img  src='images/left-inactive.png' />";
			 echo "<a href=\"?model_id=$model_id&pages=2\">";			 
			 echo "<img border='0'  src='images/right-active.png' />"; 
			 echo "</a>"; 
			}
				 
		
		 $lower=0;
		 $upper=$limit-1; 
		
		 if($upper > ($numrow-1)) $upper = $numrow-1;
		  
		for($i=$lower; $i<=$upper;$i++) 
		 { 
          
		 }
		
		}

		/*$lower=0;
		$upper=-1;
		print "<div align='right'>";
		for($i=1;$i<=$pages; $i++)
		{
		$lower = $upper+1;
		$upper = $lower + $limit - 1; 
		
		print "<a href=\"?model_id=$model_id&lower=$lower&upper=$upper&pages=$i\">";
		print "$i</a> , ";
		
		}	//*/

	
	?>
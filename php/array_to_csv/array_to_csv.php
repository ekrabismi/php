<?php
// Declare array to csv conversion function
	function arrayToCSV($array) 
	{

		$csv = '';
		$i=0;
		foreach($array[0] as $k=>$v)
		{
			if($i==0)
			 { $csv = $k; $i=1; }
			else
			 $csv .= ", " . $k; 
		}
		$csv .= ";\n";
		
		
		foreach ($array as $k=>$v) 
		{
			$i=0;
			foreach ($v as $sk=>$sv)
			 {
				 if($i==0)
				 { $csv .= $sv; $i=1; }
				else
				 $csv .= ", " . $sv;
				
			 }
			 $csv .= ";\n";
		}
		
		
		return $csv;
	}
	
?>
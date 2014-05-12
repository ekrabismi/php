
<?php
class inc_calendar
{
	var $cal = "CAL_GREGORIAN";
	var $format = "%Y%m%d";
	var $today;
	var $day;
	var $month;
	var $year;
	var $pmonth;
	var $pyear;
	var $nmonth;
	var $nyear;
	var $wday_names = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	
	function inc_calendar()
	{
		$this->day = "1";
		$today = "";
		$month = "";
		$year = "";
		$pmonth = "";
		$pyear = "";
		$nmonth = "";
		$nyear = "";
	}


	function dateNow($month,$year)
	{
		if(empty($month))
			$this->month = strftime("%m",time());
		else
			$this->month = $month;
		if(empty($year))
			$this->year = strftime("%Y",time());	
		else
		$this->year = $year;
		$this->today = strftime("%d",time());		
		$this->pmonth = $this->month - 1;
		$this->pyear = $this->year - 1;
		$this->nmonth = $this->month + 1;
		$this->nyear = $this->year + 1;
	} 

	function daysInMonth($month,$year)
	{
		if(empty($year))
			$year = inc_calendar::dateNow("%Y");

		if(empty($month))
			$month = inc_calendar::dateNow("%m");
		
		if($month == 2)
		{
			if(inc_calendar::isLeapYear($year))
			{
				return 29;
			}
			else
			{
				return 28;
			}
		}
		else if($month==4 || $month==6 || $month==9 || $month==11)
			return 30;
		else
			return 31;
	}

	function isLeapYear($year)
	{
      return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0); 
	}

	function dayOfWeek($month,$year) 
  { 
		if($month > 2) 
				$month -= 2; 
		else 
		{ 
				$month += 10; 
				$year--; 
		} 
		 
		$day =  ( floor((13 * $month - 1) / 5) + 
						$this->day + ($year % 100) + 
						floor(($year % 100) / 4) + 
						floor(($year / 100) / 4) - 2 * 
						floor($year / 100) + 77); 
		 
		$weekday_number = (($day - 7 * floor($day / 7))); 
		 
		return $weekday_number; 
  }

	function getWeekDay()
	{
		$week_day = inc_calendar::dayOfWeek($this->month,$this->year);
		//return $this->wday_names[$week_day];
		return $week_Day;
	}

	function showThisMonth()
	{
	/*	
		
	$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
    mysql_select_db(DB_NAME, $connection) or die(mysql_error());
	
	$loguser = $_SESSION['loguser'];
					  
    $q = 'select * from calendar where username = ' . "'" . $loguser . "'";
    
	$result = mysql_query($q, $connection);
    $mydate = 0;*/
	
	//$myarray = array();
/*	$j = 0;
	
	  if(!$result ){ 
	  print '<h2 style="color:#ff0000;">Date retrival error.</h2>'; }
		
	
	else{
	
      while($data = mysql_fetch_row($result))
	  {
		 $myday[$j]= substr($data[1],0,2);
		 $mymonth[$j] = substr($data[1],3,2);
	     $myyear[$j] = substr($data[1],6,4);
	     $j++;

	  } //while
	  
	  $myday = array_unique($myday); //remove duplicate element
	  }	*/
  
    /*
	foreach($myday as $key=>$value)
	{
	 print '<h1> Key:'. $key .' Value: ' . $value . '</h1>';
	}	
   //*/	
	
		print '<table cellpadding="2" cellspacing="2" border=0 class="calender_border_table">';
		print '<tr><td colspan="7" align="center"><h2><div class="calender_txt"><b>Month: '.$this->month .", Year: " .$this->year .'</b></div></h2></td></tr>';
		print '<tr>';
		for($i=0;$i<7;$i++)
			print '<td width="40" height="30"class="calender_txt4" align="center">'. $this->wday_names[$i]. '</td>';
		print '</tr>';		
		$wday = inc_calendar::dayOfWeek($this->month,$this->year);
		$no_days = inc_calendar::daysInMonth($this->month,$this->year);
		$count = 1;
		print '<tr>';
		for($i=1;$i<=$wday;$i++)
		{
			print '<td align="center" height="25">&nbsp;</td>';
			$count++;
		}
		for($i=1;$i<=$no_days;$i++)
		{
				$f=0;
				if($count > 6)
				{
					
				
				
				/*foreach ($myday as $key=>$value)
					{
					 if(($i == $value) and ($mymonth[$key]==$this->month) and ($myyear[$key]==$this->year))
					  {
						print '<td align="center" height="25" bgcolor="#FF0000"><font size=3 color="#00ff00">'
						 . $i . '</font></td></tr>'; $f=1;  break;
					  } 
					}
				*/
				if($f==0)
				   {
				
					if($i == $this->today)
						{
						print '<td align="center" height="25" bgcolor="#00FF00" ><font size=3 color="#ffcc00">' . 
						$i . '</font></td></tr>';
						}
					else
						{
						print '<td align="center" height="25"><font size=3 color="#ffffff">' . 
							$i . '</font></td></tr>';
						}
					}
					
					$count = 0;
					
					
				}
				else
				{
					
					/*
					foreach ($myday as $key=>$value)
					{
					 if(($i == $value) and ($mymonth[$key]==$this->month) and ($myyear[$key]==$this->year))
					 {
						print '<td align="center" height="25" bgcolor="#FF0000"><font size=3 color="#00ff00">'
						 . $i . '</font></td>'; $f=1; break;
					  } 
					}
				   */
				   if($f==0)
				   {
					   if($i ==$this->today)
						{
						print '<td align="center" height="25" bgcolor="#00FF00"><font size=3 color="#ffcc00">' .
						 $i . '</font></td>';
						}
						else
						{
						 print '<td align="center" height="25"><font size=3 color="#ffffff">' . 
							$i . '</font></td>';
						}	
					}
				}
				$count++;
		      
			  		
		}
		print '</tr></table>';
	} 
}

?>
      
 
  <style type="text/css">
<!--
.style1 {font-weight: bold}
-->

/**********************************************/
.calender_border{
}
.calender_border2{
border:1px solid #999999;
padding:4px;
}
.calender_border3{border:1px solid #999999; padding:3px;}
.pic_border1{
border:1px solid #999999;
padding:2px;
}
.calender_border_table{
background-color:#d1cfcf;
width:316px;
}
.calender_border_table td { padding:3px; background-color:#999999;}

.calender_border_table td div { height:40px;}
.calender_bg{
background-color:#CCCCCC;
border:1px solid #000000;
padding:2px;
}
.calender_bg2{
background-color:#FF0000;
font-family:Arial, Helvetica, sans-serif;
size:11px;
color:#FFFFFF;
font-weight:normal;
text-align:center;
}

.calender_txt{
font-family:Arial, Helvetica, sans-serif;
size:12px;
font-weight:bold;
text-align:center;
background-color:#999999;
color:#006699;
padding:15px;
}
.calender_txt4{
font-family:Arial, Helvetica, sans-serif;
size:12px;
font-weight:bold;
text-align:center;
color:#006666;
padding:2px;
}
.calender_txt5{
font-family:Arial, Helvetica, sans-serif;
size:12px;
font-weight:bold;
text-align:center;
color:#FFFFFF;
padding:2px;
}
.calender_txt6{
font-family:Arial, Helvetica, sans-serif;
size:9px;
font-weight:normal;
color:#FFFFFF;
}
.calender_txt2{
font-family:Arial, Helvetica, sans-serif;
size:12px;
font-weight:bold;
padding-left:15px;
color:#006666;
}
.calender_txt3{
font-family:Arial, Helvetica, sans-serif;
size:12px;
font-weight:bold;
padding-left:40px;
color:#006666;
}
.gallery_txt1{
font-family:"Times New Roman", Times, serif;
size:10px;
font-weight:bold;
padding-left:5px;
padding-top:3px;
color:#336666;
text-align:left;
}
.gallery_txt2{
font-family:"Times New Roman", Times, serif;
size:12px;
font-weight:normal;
padding-top:3px;
color:#666666;
}
.gallery_txt_orange{
font-family:"Times New Roman", Times, serif;
size:10px;
font-weight:bold;
padding-left:5px;
padding-top:3px;
color:#FF9900;;
}


</style>
  
                 
				 
				       <?php 
																	
												
						$oCalendar = new inc_calendar();
						
						if(isset($_REQUEST['month']) and isset($_REQUEST['year']))
						{
						 $month = $_REQUEST['month'];
						 $year = $_REQUEST['year'];
						}
						else
						{
						 $month = date("m");
						 $year = date("Y");
						 
						}
						
											
						$oCalendar->dateNow($month,$year);
						?>
                        <script language="JavaScript" type="text/javascript">
						
											
						function showPrevMonth()
						{
							
							
							document.cform.mon.value="" + "<?php echo $month?>";
							document.cform.yr.value="" + "<?php echo $year?>";
							if(document.cform.mon.value == "")
							{
								getMonthYear();
							}
							m = eval(document.cform.mon.value + "-" + 1);
						  y = document.cform.yr.value;
							if(m < 1)
							{
								m = 12;
								y = eval(y + "-" + 1);
							}
							window.location.href="?month=" + m + "&year=" + y;
						}
						function showNextMonth()
						{
							document.cform.mon.value="" + "<?php echo $month?>";
							document.cform.yr.value="" + "<?php echo $year?>";
							if(document.cform.mon.value == "")
							{
								getMonthYear();
							}
							m = eval(document.cform.mon.value + "+" + 1);
						  y = document.cform.yr.value;
							if(m > 12)
							{
								m = 1;
								y = eval(y + "+" + 1);
							}
					window.location.href= "?month=" + m + "&year=" + y;
							window.writeln(document.name);
						}
						function getMonthYear()
						{
								cdate = new Date();
								mvalue = cdate.getMonth();
								yvalue = cdate.getYear();
								document.cform.mon.value = mvalue;
								document.cform.yr.value = yvalue;
						}
						
						</script>
				 
				 
				 <script	src="calendar1.js" type="text/javascript"></script>
				 	 
				 
                        <form action="" method="post" name="cform" id="cform">
				         
		 <table width="335" cellpadding="0" cellspacing="0" border="0" class="calender_bg">
                            <tr style="color: #000066">
                              <td colspan="3" align="right" class="calender_bg">
							   
	<div align="center" class="calender_txt"><h2>Showing Calendar</h2></div></td>
							  </tr>
                            <tr>
                              <td colspan="3"  height="50" style="color: #660000">
							  <strong class="calender_txt3">Month:   </strong>
							  <select name="month">
                                <option value="<?php echo $month?>"><?php echo $month?></option>
                                <?php
							for($i=1;$i<=12;$i++)
								print '<option value="'.$i.'">'.$i. '</option>';
						?>
                              </select>							  &nbsp;&nbsp;&nbsp;
								<strong class="calender_txt3">Year:</strong>&nbsp;
                                <select name="year">
                     <option value="<?php echo $year?>"><?php echo $year?></option>
                                  <?php
							for($i=2009;$i<2050;$i++)
								print '<option value="'.$i.'">'.$i. '</option>';
						?>
                                </select>                              </td>
                            </tr>
                            <tr>
  <td width="145" align="left"><input type="button" name="prev" value="&lt;&lt; Previous" onclick="showPrevMonth();" /></td>
                  <td width="83" align="left"><input name="submit2" type="submit" value="Show" /></td>
							  <td width="107" align="right"><input type="button" name="next" value="Next &gt;&gt;" onclick="showNextMonth();" />
                                  <input type="hidden" name="mon" />
                                <input type="hidden" name="yr" /></td>
                            </tr>
                          </table>
						 
						 
						 <script> 
						  document.cform.month.value="<?php echo $month?>";
            			  document.cform.year.value="<?php echo $year?>";
						 </script>
						 <div style="border:solid #333333; width: 310px;">
						 <?php
						 
					$oCalendar->showThisMonth();
						?>
						</form>
</div> </div>
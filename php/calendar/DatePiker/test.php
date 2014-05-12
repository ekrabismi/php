<?php
require_once('calendar/classes/tc_calendar.php');
?>


<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar/calendar.js"></script>

<style type="text/css">
body { font-size: 11px; font-family: "verdana"; }

pre { font-family: "verdana"; font-size: 10px; background-color: #FFFFCC; padding: 5px 5px 5px 5px; }
pre .comment { color: #008000; }
pre .builtin { color:#FF0000;  }
</style>

  <?php
	  $myCalendar = new tc_calendar("date1", true);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(date('d'), date('m'), date('Y'));
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(2014, 2030);
	  $myCalendar->setDateFormat('j F Y');
	  $myCalendar->setAlignment('left', 'bottom');
	   $myCalendar->setOnChange("myChanged()");
	  $myCalendar->writeScript();
	 ?>
     
     <input type="text" id="mydate" />
     
<script>
function myChanged()
{
	document.getElementById('mydate').value = document.getElementById("date1").value;
	
}
</script>     

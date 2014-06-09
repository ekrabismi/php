<?php

function Hijri($GetDate)
	 {


		$TDays=round(strtotime($GetDate)/(60*60*24));
		$HYear=round($TDays/354.37419);
		$Remain=$TDays-($HYear*354.37419);
		$HMonths=round($Remain/29.531182);
		$HDays=$Remain-($HMonths*29.531182);
		$HYear=$HYear+1389;
		$HMonths=$HMonths+10;
		$HDays=$HDays+23;

		// If the days is over 29, then update month and reset days
		if ($HDays>29.531188 and round($HDays)!=30)
		{
			$HMonths=$HMonths+1;
			$HDays=Round($HDays-29.531182);
		}

		else
		{
			$HDays=Round($HDays);
		}

		// If months is over 12, then add a year, and reset months
		if($HMonths>12)
		{
			$HMonths=$HMonths-12;
			$HYear=$HYear+1;
		}

	    return array ($HDays, $HMonths, $HYear);
	}
?>

<br />
<div align="center">
<?php

$cur_year = date("Y",time());

$year = (isset($_REQUEST['y'])) ? $_REQUEST['y'] : $cur_year;

if(isset($_POST['refresh']))
{
	$adj = $_POST['adj'];
}

$adj = isset($adj)? $adj : 0;

?>
<form action="" method="post">
<input type="radio" <?= ($adj==-1)? ' checked="checked" ': '' ?> name="adj" value="-1" /> -1
<input type="radio" <?= ($adj==0)? ' checked="checked" ': '' ?> name="adj" value="0" /> 0
<input type="radio" <?= ($adj==1)? ' checked="checked" ': '' ?> name="adj" value="1" /> 1
<input type="submit" name="refresh" class="button1" value="Refresh" />

    <select name='my_year' onchange="window.location.href='?page=islamic-calendar&y='+this.value">
     <?php for($i=$year_start;$i<=$year_end;$i++)
	      {
		   if($i==$year)
		    echo "<option value='". $i . "' selected='selected'>$i</option>";
		   else
		    echo "<option value='". $i . "'>$i</option>";
		  }
	 ?>
    </select>

<a href="#today">Today</a>
</form>
</div>
<br />
<?php

//set here font, background etc for the calendar
$fontfamily = "Verdana";
$defaultfontcolor = "#000000";
$defaultbgcolor = "#E0E0E0";
$defaultwbgcolor = "#F5F4D3";
$todayfontcolor = "#000000";
$todaybgcolor = "#F2BFBF";
$monthcolor = "#000000";
$relfontsize = "3";
$cssfontsize = "9pt";


 // obtain month, today date etc
 $cur_month = date("n",time());
 //$month=5;
 for($month=1; $month<=12; $month++)
 {
   if(isset($span2)>0) { $span1=null; }

   $textmonth = $arr_month[$month-1];

   $today = (isset($today))? $today : date("j", time());

	// The Names of Hijri months
	$mname = array("Muharram","Safar","Rabi'ul Awal","Rabi'ul Akhir","Jamadil Awal","Jamadil Akhir","Rajab","Sha'ban","Ramadhan","Shawwal","Zul Qida","Zul Hijja");
	// End of the names of Hijri months

	// Setting how many days each month has

	$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

	//checking leap year to adjust february days
	if ($month == 2)
	$days = (date("L",time())) ? 29 : 28;

	$dayone = date("w",mktime(1,1,1,$month,1,$year));
	$daylast = date("w",mktime(1,1,1,$month,$days,$year));
	$middleday = intval(($days-1)/2);

	//checking the hijri month on beginning of gregorian calendar
	$date_hijri = date("$year-$month-1");
	list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
	$smon_hijridone = $mname[$HMonths-1];
	$syear_hijridone = $HYear;

	//checking the hijri month on end of gregorian calendar
	$date_hijri = date("$year-$month-$days");
	list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
	$smon_hijridlast = $mname[$HMonths-1];
	$syear_hijridlast = $HYear;


	//checking the hijri month on middle of gregorian calendar
	$date_hijri = date("$year-$month-$middleday");
	list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
	$smon_hijridmiddle = $mname[$HMonths-1];
	$syear_hijridmiddle = $HYear;

	// checking if there's a span of a year
	if ($syear_hijridone == $syear_hijridlast) {
	$syear_hijridone = "";
	}

	//checking if span of month is only one or two or three hijri months


	if (($smon_hijridone == $smon_hijridmiddle) AND ($smon_hijridmiddle == $smon_hijridlast)) {
	$smon_hijri = "<font color=red>".$smon_hijridone."&nbsp;".$syear_hijridlast."</font>";
	}

	if (($smon_hijridone == $smon_hijridmiddle) AND ($smon_hijridmiddle != $smon_hijridlast)) {
	$smon_hijri = "<font color=red>".$smon_hijridone."&nbsp;".$syear_hijridone."-".$smon_hijridlast."&nbsp;".$syear_hijridlast."</font>";
	}


	if (($smon_hijridone != $smon_hijridmiddle) AND ($smon_hijridmiddle == $smon_hijridlast)) {
	$smon_hijri = "<font color=red>".$smon_hijridone."&nbsp;".$syear_hijridone."-".$smon_hijridlast."&nbsp;".$syear_hijridlast."</font>";
	}

	if (($smon_hijridone != $smon_hijridmiddle) AND ($smon_hijridmiddle != $smon_hijridlast)) {
	$smon_hijri = "<font color=red>".$smon_hijridone."&nbsp;".$syear_hijridone."-"."-".$smon_hijridmiddle."-".$smon_hijridlast."&nbsp;".$syear_hijridlast."</font>";
	}
	// next part of code generates calendar
	?>
	<div align="center">
	<center>

	<table border="0" cellpadding="0" cellspacing="1" width="100%"
	bgcolor='black'>
	<tr>
	<td valign="top" align="center">

    <?php
	if($month==$cur_month)
	 echo "<a name='today'></a>";
	?>

    <table border="1" cellpadding="0" cellspacing="0" width="100%"
	bgcolor='white'
	valign='top'>
	<tr>
	<td bgcolor="#C6D4E5" colspan="7" align="center"><font color="<?php echo
	$monthcolor ?>" face="Verdana" size="2"><b><?PHP echo
	$textmonth."&nbsp;".$year."<br />".$smon_hijri
	?></b></font></td>
	</tr>
	<tr>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="15%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Sunday </b></font></td>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="14%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Monday </b></font></td>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="14%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Tuesday </b></font></td>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="14%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Wednesday </b></font></td>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="14%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Thursday </b></font></td>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="14%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Friday </b></font></td>
	<td bgcolor="<?PHP echo $defaultwbgcolor ?>" valign="middle" align="center"
	width="15%"><font face="<?PHP echo $fontfamily ?>"
	size="1"><b> Saturday </b></font></td>
	</tr>
	<?php

	if($dayone != 0)
	 $span1 = $dayone;
	if(6 - $daylast != 0)
	 $span2 = 6 - $daylast;

	for($i = 1; $i <= $days; $i++):
	$dayofweek = date("w",mktime(1,1,1,$month,$i,$year));
	$width = "14%";

	if($dayofweek == 0 || $dayofweek == 6)
	$width = "15%";

	if(($i == $today) and ($month==$cur_month)):
	$fontcolor = $todayfontcolor;
	$bgcellcolor = $todaybgcolor;
	endif;
	if($i != $today):
	$fontcolor = $defaultfontcolor;
	$bgcellcolor = $defaultbgcolor;
	endif;


	$x = strlen($i);
	if ($x == 1){ $b = "0".$i;}
	if ($x == 2){ $b = $i;}

	$x = strlen($month);
	if ($x == 1){ $c = "0".$month;}
	if ($x == 2){ $c = $month;}
	$data=$year."-".$c."-".$b;

	if($i == 1 || $dayofweek == 0):
	echo " <tr bgcolor=\"$defaultbgcolor\">\n";
	if(isset($span1) > 0 && $i == 1)
	echo " <td align=\"left\" bgcolor=\"#999999\"
	colspan=\"$span1\"><font face=\"null\" size=\"1\">&nbsp;</font></td>\n";
	endif;
	?>
	<td bgcolor="<?=$bgcellcolor ?>" valign="middle" align="center"
	width="<?=$width ?>">
	<?PHP
	?><font color="<?PHP echo $fontcolor ?>" face="<?=$fontfamily ?>" size="1"><?



		$date_hijri = date("$year-$month-$i");

		list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);

		$HDays += $adj;
		if($HDays>30) $HDays=1;

		if ($HDays == 30) {
				$i = $i + 1;
				$date_hijri = date("$year-$month-$i");

			list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
				   if ($HDays == 2) {
				   $HDays = 1;
				   }
				   else {
				   $HDays = 30;
				   }
				$i = $i - 1;
			}

			if($HDays<1) $HDays=30;


			$sday_hijri = $i."<br/><font color=red>".$HDays."</font>";
	// display data
	echo $sday_hijri;
	?>
	</td>
	<?PHP
	if($i == $days):
	if(isset($span2) > 0)
	echo "<td align=\"left\" bgcolor=\"#999999\"
	colspan=\"$span2\"><font face=\"null\" size=\"1\">&nbsp;</font></td>\n";
	endif;
	if($dayofweek == 6 || $i == $days):
	echo " </tr>\n";
	endif;
	endfor;


	$ano = str_replace("20", "", $year);

	$x = strlen($today);
	if ($x == 1){ $b = "0".$today;}
	if ($x == 2){ $b = $today;}
	//echo $b;
	$x = strlen($month);
	if ($x == 1){ $c = "0".$month;}
	if ($x == 2){ $c = $month;}
	//echo $c;

	$data=$year.$c.$b;
	?>
	</table>
	</td>
	</tr>

	</td></tr>

	</table>
	<br />
<?php
 }
?>
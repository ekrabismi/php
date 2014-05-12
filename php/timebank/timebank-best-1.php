<?php
$userid=100;
$timelimit=10; //second
if(!isset($_COOKIE["timebank_$userid"]))
{
 setcookie("timebank_$userid",1); //1 day
}
 $lifetime = $timelimit - $_COOKIE["timebank_$userid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Time Bank</title>



</head>

<body>
<h1>Testing time bank..........</h1>

<div id="target" style="display:none">
    target
</div>

My Time Bank: <?= $_COOKIE["timebank_$userid"] ?> <br />

<a href="mylogout.php">Logout</a>
</body>
<script>

var target,
    allotedTimeForWork='<?= $lifetime ?>';
var handler = setTimeout(function(){
      if(!target)
      {
          target=document.getElementById('target');
      }
    target.style.display="block";
    startTicker();
}, allotedTimeForWork);

function startTicker()
{
    var counter='<?= $lifetime ?>';
	var totaltime ='<?= $timelimit ?>';
	
    var tickerHandler= window.setInterval(function(){
          if(counter>0)
          {
              //cache target
              target.innerHTML="you have "+counter +" seconds left";
			  counter--;
			  var mylife = totaltime - counter;
			  document.cookie = "timebank_<?= $userid ?>="+mylife;
          }
        else
        {
            target.innerHTML="time over";
			document.cookie = "timebank_<?= $userid ?>="+totaltime;
			alert('Your time has been up.');
            window.location.href='mylogout.php';
            clearInterval(tickerHandler);
        }
    },1000); //update after 1 sec.         
}
</script>
</html>
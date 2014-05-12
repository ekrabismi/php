<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Time Bank</title>

<?php
$timelimit=20; //second
$timebank=0;
?>

</head>

<body>
<h1>Testing time bank..........</h1>

<div id="target" style="display:none">
    target
</div>
</body>
<script>

var target,
    allotedTimeForWork='<?= $timelimit ?>';
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
    var counter='<?= $timelimit ?>';;
    var tickerHandler= window.setInterval(function(){
          if(counter>0)
          {
              //cache target
              target.innerHTML="you have "+counter +" seconds left";
              counter--;
          }
        else
        {
            target.innerHTML="time over";
            clearInterval(tickerHandler);
        }
    },1000); //update after 1 sec.         
}
</script>
</html>
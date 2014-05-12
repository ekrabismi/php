<?php 
session_start(); //starting session

unset($_SESSION['myuser']); //clearing cache
setcookie("username",$username,0);
echo "<script>window.location='index.php';</script>"; //redirecting to index page
?>
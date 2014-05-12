<?php 
session_start(); //starting session

unset($_SESSION['myuser']); //clearing cache

echo "<script>window.location='index.php';</script>"; //redirecting to index page
?>
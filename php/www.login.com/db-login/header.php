<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jesses Club house</title>

<script src="myscript.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">

</head>

<body>


<?php 

if($_SERVER['HTTP_HOST']=='localhost')
{
	$rootpath = "http://localhost/project/Client/TommyGunn/www.jessesclubhouse.com/";
}
else
{
	$rootpath = "http://www.jessesclubhouse.com/";
}
?>
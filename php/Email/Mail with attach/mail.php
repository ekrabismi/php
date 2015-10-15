<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="style.css" />

<title>Upload Application and Pay</title>

</head>

<body>



<div class="mybody">

<h1 class="myh1">Thanks for the payment.</h1>
<br />

<div class="info">

<?php

 include("class.phpmailer.php");
 
 if(isset($_REQUEST['filename']))
 {
	$filename = "http://360carstuff.com/weebly/".$_REQUEST['filename'];
	
	$subject = "New Application has been registered!";
	
	$to = "abdulmomin300715@gmail.com";
	
	$from = "admin@weebly.com";
	
	$body = "Hi Admin,
	
	A new application has been registered. With a file link $filename";
    
	
	$email = new PHPMailer();
	$email->From      = $from;
	$email->FromName  = 'Anthony';
	$email->Subject   = $subject;
	$email->Body      = $body;
	$email->AddAddress( $to );
	
	$file_to_attach = $filename;
	
	$email->AddAttachment( $file_to_attach , 'New Application' );
		
    if ($email->Send()) {
        echo '<h2>Thanks for the payment we will get back to you soon.</h2>';
    } else {
        echo "<h2>Email sending failed</h2>";
    }
	
	
 }
 else
 {
	 echo  '<h2>There no application has been found!</h2>';
 }

?>

</div>


</div>

</body>

</html>
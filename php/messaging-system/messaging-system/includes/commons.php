<?php

	@session_start();
	
	// check if signed-in
	if(!isset($_SESSION['user_login']) || $_SESSION['user_login'] == '') {
		
		header('Location: index.php');
		exit;
	}
	
	require_once('functions.php');
	
	// connect to database
	db_connect();
	
	$username = decrypt($_SESSION['user_login']);

	// check if user exists in the system
	$result_check_username = mysql_query('SELECT COUNT(1) AS count FROM user WHERE username = "'.$username.'"');
	$row_check_username = mysql_fetch_assoc($result_check_username);
	if($row_check_username['count'] == 0) {
		
		header('Location: index.php');
		exit;
	}
	
	// change your timezone
	date_default_timezone_set('America/Chicago');
	
	if(isset($_SESSION['notification_array'])) {
		$notification_array = $_SESSION['notification_array'];
		$notification_status = $_SESSION['notification_status'];
	} else {
		$notification_array = array();
		$notification_status = 'notification-error';
	}
	
?>
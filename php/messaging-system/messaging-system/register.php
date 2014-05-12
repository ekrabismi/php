<?php

	$notification_array = array();
	$notification_status = 'notification-error';

	$username = '';
	$password = '';
	$first_name = '';
	$last_name = '';

	if(isset($_POST['btnRegister'])) {
		
		@session_start();
	
		require_once('includes/functions.php');
		
		// connect to database
		db_connect();
	
		$username = sanitize($_POST['username']);
		$password = sanitize($_POST['password']);
		$password_confirm = sanitize($_POST['password_confirm']);
		$first_name = sanitize($_POST['first_name']);
		$last_name = sanitize($_POST['last_name']);
		
		if($username == '')
			array_push($notification_array, 'Username is required.');
		else if(user_exist($username))
			array_push($notification_array, 'Username is already registered. Please choose a different one.');
		else if(strlen($username) < 5)
			array_push($notification_array, 'Username must be at least 6 characters long.');
		else if(preg_match('/^(\.[a-zA-Z0-9_-]+)$/', $username))
			array_push($notification_array, 'Username can only contains alphanumeric, dot (.), underscore (_), and hyphen (-) characters.');	
		
		if($password == '')
			array_push($notification_array, 'Password is required.');
		else if($password !== $password_confirm)
			array_push($notification_array, 'Password is not confirmed.');
		if($first_name == '')
			array_push($notification_array, 'First Name is required.');
		if($last_name == '')
			array_push($notification_array, 'Last Name is required.');
		
		
		if(count($notification_array) == 0) {
			
			$query_insert_user = 'INSERT INTO user (username, password, first_name, last_name) VALUES ';
			$query_insert_user .= '("'.$username.'", "'.md5($password).'", "'.$first_name.'", "'.$last_name.'")';
			
			$result_insert_user = mysql_query($query_insert_user);
			
			if(mysql_affected_rows() > 0) {
				
				array_push($notification_array, 'Your account has been registered successfully. You can now sign-in to the Control Panel with the username and password.');
				$notification_status = 'notification-success';
				
				$_SESSION['notification_status'] = $notification_status;
				$_SESSION['notification_array'] = $notification_array;
				
				header('Location: index.php');
				exit;
			} else {
				array_push($notification_array, 'Account cannot be registered at this time. Please try again later or contact administrator if problem persists.');
			}
		}
		
		$username = unsanitize($username);
		$first_name = unsanitize($first_name);
		$last_name = unsanitize($last_name);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Messaging System - Account Registration</title>
<link type="text/css" rel="stylesheet" href="css/login.css" />
</head>

<body>

<div id="container">
	<h1>Registration</h1>
	<?php if(isset($notification_array) && count($notification_array) > 0) {
		?><div class="notification <?php echo $notification_status; ?>">
			<?php
			
			$notification_array_count = count($notification_array);
			
			if($notification_array_count == 1) {
				?><p><?php echo $notification_array[0]; ?></a></p><?php
			} else {
				
				?><ul><?php
				
				for($i = 0; $i < $notification_array_count; $i++) {
						
					?><li><?php echo $notification_array[$i]; ?></li><?php
				}
				
				?></ul><?php
			}
			
		?></div><?php
	} ?>
	
	<form name="sign-in" action="register.php" method="post">
		<label><span class="required">*</span> Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>" />
		
		<label><span class="required">*</span> Password</label>
		<input type="password" name="password" value="" />
		
		<label><span class="required">*</span> Confirm Password</label>
		<input type="password" name="password_confirm" value="" />
		
		<label><span class="required">*</span> First Name</label>
		<input type="text" name="first_name" value="<?php echo $first_name; ?>" />
		
		<label><span class="required">*</span> Last Name</label>
		<input type="text" name="last_name" value="<?php echo $last_name; ?>" />
		
		<input type="submit" name="btnRegister" value="Register" />
		<input type="button" name="btnCancel" value="Cancel" onclick="window.location = 'index.php'" />
	</form>
</div>

</body>
</html>
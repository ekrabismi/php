<?php
	
	@session_start();

	$notification_array = array();
	$notification_status = 'notification-error';

	$username = '';
	
	if(isset($_SESSION['notification_array']) && count($_SESSION['notification_array']) > 0) {
		
		$notification_array = $_SESSION['notification_array'];
		$notification_status = $_SESSION['notification_status'];
	}
	
	if(isset($_POST['btnSignIn'])) {
		
		require_once('includes/functions.php');
		
		db_connect();
	
		$username = sanitize($_POST['username']);
		$password = sanitize($_POST['password']);
		
		if($username == '')
			array_push($notification_array, 'Username is required.');
		else if(!user_exist($username))
			array_push($notification_array, 'Username does not exist.');
		if($password == '')
			array_push($notification_array, 'Password is required.');
			
		if(count($notification_array) == 0 && !validate_user($username, md5($password)))
			array_push($notification_array, 'Username and/or password is incorrect.');
			
		if(count($notification_array) == 0) {
			
			$_SESSION['user_login'] = encrypt($username);
			
			header('Location: home.php');
			exit;
		}
		
		$username = unsanitize($_POST['username']);
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Messaging System - Control Panel</title>
<link type="text/css" rel="stylesheet" href="css/login.css" />
</head>

<body>

<div id="container">
	<h1>Control Panel Sign In</h1>
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
	} 
	
	if(isset($_SESSION['notification_array']) && count($_SESSION['notification_array']) > 0) {
		
		unset($_SESSION['notification_array']);
		unset($_SESSION['notification_status']);
	}
	
	?>
	<form name="sign-in" action="index.php" method="post">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>" />
		
		<label>Password</label>
		<input type="password" name="password" value="" />
		
		<input type="submit" name="btnSignIn" value="Sign In" />
	</form>
	<div id="info"><a href="register.php" title="Register">Create New Account</a></div>
</div>
</body>
</html>

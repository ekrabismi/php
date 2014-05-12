<?php

	require_once('includes/commons.php');
	
	if(isset($_POST['btnUpdate'])) {
		
		$first_name = sanitize($_POST['first_name']);
		$last_name = sanitize($_POST['last_name']);
		$password = sanitize($_POST['password']);
		$password_confirm = sanitize($_POST['password_confirm']);
		
		if($first_name == '')
			array_push($notification_array, 'First Name is required.');
		if($last_name == '')
			array_push($notification_array, 'Last Name is required.');
		if($password !== $password_confirm)
			array_push($notification_array, 'Password is not confirmed.');
		
		if(count($notification_array) == 0) {
			
			$query_update_profile = 'UPDATE user SET first_name = "'.$first_name.'", last_name = "'.$last_name.'" ';
			
			if($password != '')
				$query_update_profile .= ', password = "'.md5($password).'" ';
				
			$query_update_profile .= 'WHERE username = "'.$username.'"';
			
			$result_update_profile = mysql_query($query_update_profile);
			
			if($result_update_profile && mysql_affected_rows() >= 0) {
				
				$notification_status = 'notification-success';
				array_push($notification_array, 'Your profile has been updated successfully.');
				
				$_SESSION['notification_status'] = $notification_status;
				$_SESSION['notification_array'] = $notification_array;
				
				header('Location: '.$_SESSION['last_page']);
				exit;
			} else {
				array_push($notification_array, 'Your profile cannot be updated at this time. Please try again later or contact administrator if problem persists.');
			}
		}
		
		$first_name = unsanitize($_POST['first_name']);
		$last_name = unsanitize($_POST['last_name']);
		
	} else {
		$result_get_info = mysql_query('SELECT * FROM user WHERE username = "'.$username.'"');
		$row_get_info = mysql_fetch_assoc($result_get_info);
		
		$first_name = $row_get_info['first_name'];
		$last_name = $row_get_info['last_name'];
	}

	require_once('includes/header.php');
	
?>

<div class="content">
	<div class="content-header">
		<h2>My Profile</h2>
	</div>
	
	<div class="content-body">
		<p><em>* Leave password fields blank if you do not wish to change password.</em></p>
	
		<form name="update-profile-form" method="post" action="profile.php" class="form1">
			<label><span class="required">*</span> First Name</label>
			<input name="first_name" class="large" type="text" value="<?php echo $first_name; ?>" />
			
			<label><span class="required">*</span> Last Name</label>
			<input name="last_name" class="large" type="text" value="<?php echo $last_name; ?>" />
			
			<label>Password</label>
			<input name="password" class="large" type="password" value="" />
			
			<label>Confirm Password</label>
			<input name="password_confirm" class="large" type="password" value="" />
			
			<br /><br />
			<input name="btnUpdate" type="submit" class="button" value="Update Profile" />
			<input name="btnCancel" type="button" class="button" value="Cancel" alt="<?php echo $_SESSION['last_page']; ?>" />
		</form>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>
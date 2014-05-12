<?php

	require_once('includes/commons.php');
	
	$first_name = '';
	$last_name = '';
	$recipient = '';
	$mode = 'a';
	
	if(isset($_GET['r']) && $_GET['r'] != '') {
		
		$recipient = sanitize(decrypt($_GET['r']));
		
		// check if recipient exists in address book
		if(recipient_exist_address_book($username, $recipient)) {
			
			$mode = 'e';
			if(!isset($_POST['btnSave'])) {
				$result_check_recipient = mysql_query('SELECT * FROM address_book WHERE username = "'.$username.'" AND recipient = "'.$recipient.'"');
				$row_check_recipient = mysql_fetch_assoc($result_check_recipient);
				
				$first_name = unsanitize($row_check_recipient['first_name']);
				$last_name = unsanitize($row_check_recipient['last_name']);
			}
		}
	}
	
	if(isset($_POST['btnSave'])) {
		
		// filter input
		$first_name = sanitize($_POST['first_name']);
		$last_name = sanitize($_POST['last_name']);
		
		if($mode == 'a')
			$recipient = sanitize($_POST['recipient']);
		
		if($first_name == '')
			array_push($notification_array, 'First name is required.');
		if($last_name == '')
			array_push($notification_array, 'Last name is required.');
		if($recipient == '' && $mode == 'a')
			array_push($notification_array, 'Username is required.');
		else if($recipient != '') {
			if(strlen($recipient) < 5)
				array_push($notification_array, 'The username must be at least 6 characters long.');
			else if(preg_match('/^(\.[a-zA-Z0-9_-]+)$/', $recipient))
				array_push($notification_array, 'The username can only contains alphanumeric, dot (.), underscore (_), and hyphen (-) characters.');
			else if($recipient === unsanitize($username))
				array_push($notification_array, 'You cannot add yourself to the address book.');
			else {
				// check if recipient exist
				if(user_exist($recipient)) {
					if($mode == 'a') {
						// check if recipient exist in address book
						if(recipient_exist_address_book($username, $recipient))
							array_push($notification_array, 'Username already exist in address book.');
					}
				} else {
					array_push($notification_array, 'Username cannot be found in the system. Please try a different one.');
				}
			}
		}
				
		if(count($notification_array) == 0) {
			
			if($mode == 'a') {
				$query_insert_update_contact = 'INSERT INTO address_book ';
				$query_insert_update_contact .= '(username, recipient, first_name, last_name) VALUES ';
				$query_insert_update_contact .= '("'.$username.'", "'.$recipient.'", "'.$first_name.'", "'.$last_name.'")';
			}
			else if($mode == 'e') {
				$query_insert_update_contact = 'UPDATE address_book ';
				$query_insert_update_contact .= 'SET first_name = "'.$first_name.'", last_name = "'.$last_name.'" ';
				$query_insert_update_contact .= 'WHERE recipient = "'.$recipient.'" AND username = "'.$username.'"';
			}
			
			$result_insert_update_contact = mysql_query($query_insert_update_contact);
			$affected_rows = mysql_affected_rows();
			
			if($result_insert_update_contact && ($affected_rows > 0 || ($mode == 'e' && $affected_rows >= 0))) {
				
				$notification_status = 'notification-success';
				
				if($affected_rows == 0) {
					array_push($notification_array, 'No changes made to the contact information.');
					$notification_status = 'notification-warning';
				} else {
					if($mode == 'a')
						array_push($notification_array, 'The contact has been added to your address book successfully.');
					else if($mode == 'e')
						array_push($notification_array, 'The contact has been updated successfully.');
				}
				
				$_SESSION['notification_array'] = $notification_array;
				$_SESSION['notification_status'] = $notification_status;
				
				header('Location: '.$_SESSION['last_page']);
				exit;
			}
		}	// END - if(count($notification_array) == 0)
		
		$first_name = unsanitize($first_name);
		$last_name = unsanitize($last_name);
		$recipient = unsanitize($recipient);
		
	}	// END - if(isset($_POST['btnSave']))
	 
	require_once('includes/header.php');
	
?>
	
<div class="content">
	<div class="content-header">
		<h2>New Contact</h2>
	</div>
	
	<div class="content-body"><form name="contact-form" method="post" action="address-book-manage.php<?php echo ($mode == 'e') ? '?r='.encrypt($recipient) : ''; ?>" class="form1">
		<?php
		if($mode == 'a') {
			?><label><span class="required">*</span> Username</label>
			<input name="recipient" class="small" type="text" length="255" value="<?php echo $recipient; ?>" /><?php
		}
		else if($mode == 'e') {
			?><label>Username</label><?php
			echo $recipient;
		}
		
		?>
				
		<label><span class="required">*</span> First Name</label>
		<input name="first_name" class="small" type="text" length="255" value="<?php echo $first_name; ?>" />
		
		<label><span class="required">*</span> Last Name</label>
		<input name="last_name" class="small" type="text" length="255" value="<?php echo $last_name; ?>" />
		
		<br /><br />
		<input name="btnSave" type="submit" class="button" value="Save Contact" />
		<input name="btnCancel" type="button" class="button" value="Cancel" alt="<?php echo $_SESSION['last_page']; ?>" />
	</form></div>
</div>

<?php require_once('includes/footer.php'); ?>

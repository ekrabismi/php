<?php

	require_once('includes/commons.php');
	
	$recipient = '';
	$subject = '';
	$message = '';
	
	$action = 'compose.php';
	
	if(!isset($_POST['btnSend']) && !isset($_POST['btnSave'])) {
		if(isset($_GET['r']) && $_GET['r'] != '') {
			
			$action = 'compose.php?r='.$_GET['r'];
			$recipient = decrypt($_GET['r']);
		}
		
		if(isset($_GET['m']) && $_GET['m'] != '') {
			
			$message_id = decrypt($_GET['m']);
			
			// check if message exists
			$query_get_message = 'SELECT * FROM message, message_sender WHERE message.message_id = '.$message_id.' AND message_sender.message_id = message.message_id';
			$result_get_message = mysql_query($query_get_message);
			if(mysql_num_rows($result_get_message) > 0) {
				if($action == 'compose.php')
					$action .= '?';
				else
					$action .= '&';
				$action .= 'm='.$_GET['m'];
							
				$row_get_message = mysql_fetch_assoc($result_get_message);
			
				if($row_get_message['status'] == 'draft') {
					$subject = unsanitize($row_get_message['subject']);
					$message = html_entity_decode($row_get_message['message']);
	
					$result_get_recipient = mysql_query('SELECT recipient FROM message_recipient WHERE message_id = '.$message_id);
					while($row_get_recipient = mysql_fetch_assoc($result_get_recipient)) {
						if($recipient != '')
							$recipient .= ',';
							
						$recipient .= unsanitize($row_get_recipient['recipient']);
					}
				} else if($row_get_message['status'] == 'sent') {
					$action = 'compose.php';
					if($recipient == '') {
						// forward
						$subject = 'FW: '.$row_get_message['subject'];
					} else {
						// reply
						$subject = 'RE: '.$row_get_message['subject'];
					}
					$message = '<br><br><br>---------- PREVIOUS MESSAGE ----------<br>';
					$message .= unsanitize($row_get_message['sender']).' wrote:<br><br>';
					$message .= html_entity_decode($row_get_message['message']);
				} else {
					array_push($notification_array, 'You cannot edit this message.');
					
					$_SESSION['notification_array'] = $notification_array;
					$_SESSION['notification_status'] = $notification_status;
					
					header('Location: message.php');
					exit;
				}
			}
		}
	}
	
	if(isset($_POST['btnSend']) || isset($_POST['btnSave'])) {
		
		$save = true;
		$send = false;
		if(isset($_POST['btnSend'])) {
			$save = false;
			$send = true;
		}
	
		$recipient = sanitize($_POST['recipient']);
		$subject = sanitize($_POST['subject']);
		$message = htmlentities($_POST['message']);
	
		$recipient_count = 0;
		$recipient_array = array();
		
		if($send && $recipient == '')
			array_push($notification_array, 'Username is required.');
		else {
			$recipient_array = explode(',', $recipient);
			$recipient_count = count($recipient_array);
			
			for($i = 0; $i < $recipient_count; $i++) {
			
				$recipient_array[$i] = sanitize($recipient_array[$i]);
				
				if($recipient_array[$i] != '') {
					// check if username exists
					if(!user_exist($recipient_array[$i]))
						array_push($notification_array, 'Username "'.$recipient_array[$i].'" does not exists in the system');
				}
			}
		}

		if($subject == '')
			array_push($notification_array, 'Subject is required.');
		if($send && $message == '')
			array_push($notification_array, 'Message is required.');
		
		$message_id = 0;
		$new_message = true;
		if(isset($_GET['m']) && $_GET['m'] != '') {
			
			$message_id = decrypt($_GET['m']);
			$new_message = false;
			
			$query_check_message = 'SELECT COUNT(1) AS count FROM message, message_sender WHERE message.message_id = '.$message_id.' AND message.message_id = message_sender.message_id AND message.sender = "'.$username.'"';

			$result_check_message = mysql_query($query_check_message);
			$row_check_message = mysql_fetch_assoc($result_check_message);
			
			if($row_check_message == 0)
				array_push($notification_array, 'You have no privilege to modify this message. Please contact administrator for any question.');
		}
			
		if(count($notification_array) == 0) {
			
			$delete_message = false;
			$delete_message_sender = false;
			$delete_message_recipient = false;
			$sent_recipient = array();
			$query_message_id = '';
		
			// store message
			if($new_message) {
				$query_insert_update_message = 'INSERT INTO message ';
				$query_insert_update_message .= '(subject, message, sender, message_date) VALUES ';
				$query_insert_update_message .= '("'.$subject.'", "'.$message.'", "'.$username.'", "'.date('Y-m-d H:i:s').'")';
			} else {
				$query_insert_update_message = 'UPDATE message SET subject = "'.$subject.'", message = "'.$message.'", message_date = "'.date('Y-m-d H:i:s').'" ';
				$query_insert_update_message .= 'WHERE message_id = '.$message_id;
			}
			
			$result_insert_update_message = mysql_query($query_insert_update_message);
			
			if($result_insert_update_message && mysql_affected_rows() >= 0) {
				
				if($new_message)
					$message_id = mysql_insert_id();
				$query_insert_update_message_sender = '';
				
				// save the sender
				if($new_message) {
					if($send) {
						$query_insert_update_message_sender = 'INSERT INTO message_sender ';
						$query_insert_update_message_sender .= '(message_id, sender) VALUES ';
						$query_insert_update_message_sender .= '('.$message_id.', "'.$username.'")';
					} else if($save) {
						$query_insert_update_message_sender = 'INSERT INTO message_sender ';
						$query_insert_update_message_sender .= '(message_id, sender, status) VALUES ';
						$query_insert_update_message_sender .= '('.$message_id.', "'.$username.'", "draft")';
					}
				} else {
					if($send) {
						$query_insert_update_message_sender = 'UPDATE message_sender SET status = "sent" WHERE message_id = '.$message_id;
					} else {
						$query_insert_update_message_sender = 'UPDATE message_sender SET status = "draft" WHERE message_id = '.$message_id;
					}
				}
				
				$result_insert_update_message_sender = mysql_query($query_insert_update_message_sender);
				
				if($result_insert_update_message_sender && mysql_affected_rows() >= 0) {
					
					// delete all recipients first
					if(!$new_message) {
						$result_delete_message_recipient = mysql_query('DELETE FROM message_recipient WHERE message_id = '.$message_id);
					}
					
					for ($i = 0; $i < $recipient_count; $i++) {
						
						if($send) {
							$query_insert_update_message_recipient = 'INSERT INTO message_recipient ';
							$query_insert_update_message_recipient .= '(message_id, recipient) VALUES ';
							$query_insert_update_message_recipient .= '('.$message_id.', "'.$recipient_array[$i].'")';
						} else if($save) {
							$query_insert_update_message_recipient = 'INSERT INTO message_recipient ';
							$query_insert_update_message_recipient .= '(message_id, recipient, status) VALUES ';
							$query_insert_update_message_recipient .= '('.$message_id.', "'.$recipient_array[$i].'", "draft")';
						}
						
						$result_insert_update_message_recipient = mysql_query($query_insert_update_message_recipient);
						
						if(mysql_affected_rows() > 0) {
							array_push($sent_recipient, $recipient_array[$i]);
						} else {
							if($send)
								array_push($notification_array, 'Your message cannot be sent at this time. Please try again later or contact administrator if problem persists.');
							else if($save)
								array_push($notification_array, 'Your message cannot be saved at this time. Please try again later or contact administrator if problem persists.');	
							
							$delete_message = true;
							$delete_message_sender = true;
							$delete_message_recipient = true;
						}
					}
					
					// message sent successfully
					if(count($notification_array) == 0) {
						if($send)
							array_push($notification_array, 'Your message has been sent successfully.');
						else if($save)
							array_push($notification_array, 'Your message has been saved.');
					
						$notification_status = 'notification-success';
						
						$_SESSION['notification_array'] = $notification_array;
						$_SESSION['notification_status'] = $notification_status;
						
						header('Location: '.$_SESSION['last_page']);
						exit;
					}
				} else {
					if($send)
						array_push($notification_array, 'Your message cannot be sent at this time. Please try again later or contact administrator if problem persists.');
					else if($save)
						array_push($notification_array, 'Your message cannot be saved at this time. Please try again later or contact administrator if problem persists.');
					$delete_message = true;		
				}
			} else {
				if($send)
					array_push($notification_array, 'Your message cannot be sent at this time. Please try again later or contact administrator if problem persists.');
				else if($save)
					array_push($notification_array, 'Your message cannot be saved at this time. Please try again later or contact administrator if problem persists.');
			}
			
			// delete records in case sending message is failed
			if($delete_message) {
				$query_delete_message = 'DELETE FROM message WHERE message_id = '.$message_id;
				$result_delete_message = mysql_query($query_delete_message);
			}
			
			if($delete_message_sender) {
				$query_delete_message_sender = 'DELETE FROM message_sender WHERE message_id = '.$message_id.' AND sender = "'.$username.'"';
				$result_delete_message_sender = mysql_query($query_delete_message_sender);
			}
			
			if($delete_message_recipient) {
				for($i = 0; $i < count($sent_recipient); $i++) {
					$query_delete_message_recipient = 'DELETE FROM message_recipient WHERE message_id = '.$message_id.' AND recipient = "'.$sent_recipient[$i].'"';
					$result_delete_message_recipient = mysql_query($query_delete_message_recipient);
				}
			}
		}
		
		$subject = unsanitize($subject);
		$message = html_entity_decode($message);
	}

	require_once('includes/header.php');
	
?>

<div class="content">
	<div class="content-header">
		<h2>New Message</h2>
	</div>
	
	<div class="content-body"><form name="new-message-form" method="post" action="<?php echo $action; ?>" class="form1">
		<label><span class="required">*</span> Recipient (separated by comma)
			<a href="address-book-view.php" rel="facebox" title="View Address Book"><img src="images/address-book.png" title="View Address Book" class="ttTipsy" /></a>
		</label>
		<input name="recipient" class="large" type="text" value="<?php echo $recipient; ?>" />
		
		<label><span class="required">*</span> Subject</label>
		<input name="subject" class="large" type="text" value="<?php echo $subject; ?>" />
		
		<label><span class="required">*</span> Message</label>
		<textarea name="message" id="wysiwyg"><?php echo $message; ?></textarea>
		
		<br />
		<input name="btnSend" type="submit" class="button" value="Send Message" />
		<input name="btnSave" type="submit" class="button" value="Save as Draft" />
		<input name="btnCancel" type="button" class="button" value="Cancel" alt="<?php echo $_SESSION['last_page']; ?>" />
	</form></div>
</div>

<?php require_once('includes/footer.php'); ?>
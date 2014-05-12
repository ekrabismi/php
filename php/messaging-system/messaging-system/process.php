<?php

	require_once('includes/commons.php');
	
	$target = decrypt($_GET['t']);

	if($target == 'address_book') {
		
		if(isset($_GET['r']) && $_GET['r'] != '') {
		
			$recipient = sanitize(decrypt($_GET['r']));
			
			// check if recipient exists in address book
			if(recipient_exist_address_book($username, $recipient)) {
			
				// delete recipient from address book
				$result_delete_recipient = mysql_query('DELETE FROM address_book WHERE username = "'.$username.'" AND recipient = "'.$recipient.'"');
				if(mysql_affected_rows() > 0) {
					array_push($notification_array, 'The contact has been deleted from your address book.');
					$notification_status = 'notification-success';
				} else {
					array_push($notification_array, 'The contact cannot be delete from your address book at this time. Please try again later or contact administrator if problem persists.');
				}
			} else {
				array_push($notification_array, 'The contact cannot be found in your address book. Please refresh and if the contact is still in your address book, contact administrator.');
			}
		}  else {
				array_push($notification_array, 'The contact cannot be deleted at this time. Please try again later or contact administrator if problem persists.');
		}
	}	// END - if($target == 'address_book')
	else if($target == 'message' || $target == 'message_trash') {
		
		if(isset($_GET['m']) && $_GET['m'] != '') {
		
			$message_id = sanitize(decrypt($_GET['m']));

			// check if message_id exists
			if(message_exist($message_id, 'message_recipient', 'recipient', $username)) {
			
				// delete message
				$query_delete_message = '';
				if($target == 'message_trash') {
					$query_delete_message = 'UPDATE message_recipient SET status = "" WHERE message_id = '.$message_id.' AND recipient = "'.$username.'"';
				} else {
					$result_get_message_status = mysql_query('SELECT status FROM message_recipient WHERE message_id = '.$message_id.' AND recipient = "'.$username.'"');
					$row_get_message_status = mysql_fetch_assoc($result_get_message_status);
				
					$status = $row_get_message_status['status'];
					$status .= '_deleted';
				
					$query_delete_message = 'UPDATE message_recipient SET status = "'.$status.'" WHERE message_id = '.$message_id.' AND recipient = "'.$username.'"';
				}
				
				$result_delete_message_sender = mysql_query($query_delete_message);
				if(mysql_affected_rows() > 0) {
					array_push($notification_array, 'The message has been deleted successfully.');
					$notification_status = 'notification-success';
				} else {
					array_push($notification_array, 'The message cannot be deleted at this time. Please try again later or contact administrator if problem persists.');
				}
			} else {
				array_push($notification_array, 'The message has been deleted before. Please refresh and if the message is still in your outbox, please contact administrator.');
			}
		}  else {
				array_push($notification_array, 'The message cannot be deleted at this time. Please try again later or contact administrator if problem persists.');
		}
	}	// END - else if($target == 'message' || $target == 'message_trash')
	else if($target == 'message_sent' || $target == 'message_draft' || $target == 'message_sent_trash' || $target == 'message_draft_trash') {
		
		if(isset($_GET['m']) && $_GET['m'] != '') {
		
			$message_id = sanitize(decrypt($_GET['m']));

			// check if message_id exists
			$result_check_message = mysql_query('SELECT COUNT(1) AS count FROM message_sender WHERE message_id = '.$message_id.' AND sender = "'.$username.'"');
			$row_check_message = mysql_fetch_assoc($result_check_message);
			if(message_exist($message_id, 'message_sender', 'sender', $username)) {
			
				// delete message
				if($target == 'message_sent_trash') {
					$query_delete_message = 'UPDATE message_sender SET status = "" WHERE message_id = '.$message_id;
				}
				else if($target == 'message_draft_trash') {
					$query_delete_message = 'DELETE message, message_sender, message_recipient FROM message, message_sender, message_recipient WHERE message.message_id = '.$message_id.' AND message_sender.message_id = '.$message_id.' AND message_recipient.message_id = '.$message_id;
				}
				else if($target == 'message_sent')
					$query_delete_message = 'UPDATE message_sender SET status = "sent_deleted" WHERE message_id = '.$message_id;
				else if($target == 'message_draft')
					$query_delete_message = 'UPDATE message_sender SET status = "draft_deleted" WHERE message_id = '.$message_id;
					
				$result_delete_message_sender = mysql_query($query_delete_message);
				if(mysql_affected_rows() > 0) {
					array_push($notification_array, 'The message has been deleted successfully.');
					$notification_status = 'notification-success';
				} else {
					array_push($notification_array, 'The message cannot be deleted at this time. Please try again later or contact administrator if problem persists.');
				}
			} else {
				array_push($notification_array, 'The message has been deleted before. Please refresh and if the message is still in your outbox, please contact administrator.');
			}
		}  else {
				array_push($notification_array, 'The message cannot be deleted at this time. Please try again later or contact administrator if problem persists.');
		}
	}	// END - else if($target == 'message_sent' || $target == 'message_draft' || $target == 'message_sent_trash' || $target == 'message_draft_trash')
	else if($target == 'message_undelete') {
		
		if(isset($_GET['m']) && $_GET['m'] != '') {
		
			$message_id = sanitize(decrypt($_GET['m']));
			$query_get_message_status = '';
			$target_type = '';
			
			// check if message_id exists
			if(message_exist($message_id, 'message_recipient', 'recipient', $username)) {
				
				$query_get_message_status = 'SELECT status FROM message_recipient WHERE message_id = '.$message_id.' AND recipient = "'.$username.'"';
				$target_type = 'recipient';
			}
			else if(message_exist($message_id, 'message_sender', 'sender', $username)) {
				
				$query_get_message_status = 'SELECT status FROM message_sender WHERE message_id = '.$message_id.' AND sender = "'.$username.'"';
				$target_type = 'sender';
			}
			else {
				array_push($notification_array, 'The message cannot be recovered at this time. Please try again later or contact administrator if problem persists.');
			}
			
			if($target_type != '' && $query_get_message_status != '') {
				$result_get_message_status = mysql_query($query_get_message_status);
				$row_get_message_status = mysql_fetch_assoc($result_get_message_status);
				
				$status = str_replace('_deleted', '', $row_get_message_status['status']);
				
				if(strpos($status, '_deleted') === false) {
					$query_undelete_message = 'UPDATE message_'.$target_type.' SET status = "'.$status.'" WHERE message_id = '.$message_id.' AND '.$target_type.' = "'.$username.'"';
					$result_undelete_message = mysql_query($query_undelete_message);
					
					if(mysql_affected_rows() > 0) {
						array_push($notification_array, 'The message has been recovered successfully.');
						$notification_status = 'notification-success';
					} else {
						array_push($notification_array, 'The message has been recovered before. Please refresh and if message is not recovered, please contact administrator.');
						$notification_status = 'notification-warning';
					}
				} else {
					array_push($notification_array, 'The message cannot be recovered at this time. Please try again later or contact administrator if problem persists.');
				}
			}
		} else {
			array_push($notification_array, 'The message cannot be recovered at this time. Please try again later or contact administrator if problem persists.');
		}
	}	// END - else if($target == 'message_undelete')
	$_SESSION['notification_array'] = $notification_array;
	$_SESSION['notification_status'] = $notification_status;
	
	header('Location: '.$_SESSION['last_page']);
	exit;

?>
<?php

	require_once('includes/commons.php');

	$_SESSION['last_page'] = 'message-trash.php';
	
	require_once('includes/header.php');
	
	$message_header_title = 'Deleted Messages';
	
	$query_get_deleted_message = 'SELECT DISTINCT message.* FROM message, message_sender, message_recipient WHERE (message.message_id = message_sender.message_id AND message_sender.sender = "'.$username.'" AND (message_sender.status = "sent_deleted" OR message_sender.status = "draft_deleted")) OR (message.message_id = message_recipient.message_id AND message_recipient.recipient = "'.$username.'" AND (message_recipient.status = "read_deleted" OR message_recipient.status = "unread_deleted")) ORDER BY message_date DESC';
	
	$result_get_deleted_message = mysql_query($query_get_deleted_message);
	$deleted_message_count = mysql_num_rows($result_get_deleted_message);
?>

<div class="content">
	
	<?php require_once('includes/message-header.php'); ?>
	
	<div class="content-body"><?php

		if($deleted_message_count > 0) {
			?><table class="table-grid1">
				<thead>
					<tr>
						<th style="width:15%;">Date</th>
						<th style="width:20%;">Sender</th>
						<th style="width:30%;">To</th>
						<th style="width:30%;">Subject</th>
						<th style="width:5%;">Action</th>
					</tr>
				</thead>
				
				<tbody><?php
					while($row_get_deleted_message = mysql_fetch_assoc($result_get_deleted_message)) {
						
						$recipient = 'You';
						$sent = true;
						$target = '';
						$message_id_encrypted = encrypt($row_get_deleted_message['message_id']);
						
						$target = '';
						if($row_get_deleted_message['sender'] !== $username) {
							$sent = false;
							$target = encrypt('message_trash');
						} else {
							$result_check_message_status = mysql_query('SELECT status FROM message_sender WHERE message_id = '.$row_get_deleted_message['message_id'].' AND sender = "'.$row_get_deleted_message['sender'].'"');
							$row_check_message_status = mysql_fetch_Assoc($result_check_message_status);

							if($row_check_message_status['status'] == 'draft_deleted')
								$target = encrypt('message_draft_trash');
							else if($row_check_message_status['status'] == 'sent_deleted')
								$target = encrypt('message_sent_trash');
						}
							
						if($sent) {
							$recipient = '';
							$result_get_recipient = mysql_query('SELECT recipient FROM message_recipient WHERE message_id = '.$row_get_deleted_message['message_id']);
							
							while($row_get_recipient = mysql_fetch_assoc($result_get_recipient)) {
								if($recipient != '')
									$recipient .= ', ';
									
								$result_check_address_book = mysql_query('SELECT * FROM address_book WHERE username = "'.$username.'" AND recipient = "'.$row_get_recipient['recipient'].'"');
								
								if(mysql_num_rows($result_check_address_book) > 0) {
									$row_check_address_book = mysql_fetch_assoc($result_check_address_book);
									$row_check_address_book = unsanitize($row_check_address_book);
									
									$recipient .= $row_check_address_book['first_name'].' '.$row_check_address_book['last_name'].' &lt;'.unsanitize($row_get_recipient['recipient']).'&gt;';
								} else {
									$recipient .= unsanitize($row_get_recipient['recipient']);
								}
							}
						}
						
						?><tr>
							<td><?php echo date('m/d/Y h:i A', strtotime($row_get_deleted_message['message_date'])); ?></td>
							<td><?php echo $row_get_deleted_message['sender']; ?></td>
							<td><?php echo $recipient; ?></td>
							<td><a href="#message-<?php echo $message_id_encrypted; ?>" rel="facebox" title="View Message" class="ttTipsy"><?php echo unsanitize($row_get_deleted_message['subject']); ?></a></td>
							<td><a href="process.php?t=<?php echo encrypt('message_undelete'); ?>&m=<?php echo $message_id_encrypted; ?>" title="Undelete Message"><img src="images/message-undelete.png" title="Undelete Message" class="ttTipsy" /></a> <a href="process.php?t=<?php echo $target; ?>&m=<?php echo $message_id_encrypted; ?>" title="Delete Forever"><img src="images/message-delete.png" title="Delete Forever" class="ttTipsy" /></a></td>
						</tr>
						
						<tr class="hidden">
							<td colspan="4"><div id="message-<?php echo $message_id_encrypted; ?>"><?php echo html_entity_decode($row_get_deleted_message['message']); ?></div></td>
						</tr>
						<?php
					}
					
				?></tbody>
			</table><?php
			
		} else {
		
			?><p>You have no messages in the trash.</p><?php
		
		}
	?></div>
</div>

<?php require_once('includes/footer.php'); ?>
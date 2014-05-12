<?php

	require_once('includes/commons.php');

	$_SESSION['last_page'] = 'message.php';
	
	require_once('includes/header.php');
	
	$message_header_title = 'Incoming Messages';
	
	$query_get_message = 'SELECT message.*, status FROM message, message_recipient WHERE message.message_id = message_recipient.message_id AND recipient = "'.$username.'" AND (message_recipient.status = "unread" OR message_recipient.status = "read") ORDER BY message_date DESC';
	$result_get_message = mysql_query($query_get_message);
	$message_count = mysql_num_rows($result_get_message);
	
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('a[name=message]').click(function() {
			var parent = $(this).parent().parent();
			
			if(parent.hasClass('new-message')) {
				parent.removeClass('new-message');

				$.post('includes/ajax-handler.php', {ajax_object: '0dKm5tSbzJLMkuXKxqKVxdE', id: $(this).attr('href')}, function(data) {
					return true;
				});
				return false;
			}
		});
	});
</script>
<div class="content">

	<?php require_once('includes/message-header.php'); ?>
	
	<div class="content-body"><?php

		if($message_count > 0) {
			?><table class="table-grid1">
				<thead>
					<tr>
						<th style="width:15%;">Date</th>
						<th style="width:30%;">Sender</th>
						<th style="width:45%;">Subject</th>
						<th>Action</th>
					</tr>
				</thead>
				
				<tbody><?php
				
					while($row_get_message = mysql_fetch_assoc($result_get_message)) {
						
						$message_id_encrypted = encrypt($row_get_message['message_id']);
						$sender = '';
						$result_check_address_book = mysql_query('SELECT * FROM address_book WHERE username = "'.$username.'" AND recipient = "'.$row_get_message['sender'].'"');
						if(mysql_num_rows($result_check_address_book) > 0) {
							$row_check_address_book = mysql_fetch_assoc($result_check_address_book);
							$row_check_address_book = unsanitize($row_check_address_book);
							
							$sender .= $row_check_address_book['first_name'].' '.$row_check_address_book['last_name'].' &lt;'.unsanitize($row_get_message['sender']).'&gt;';
						} else {
							$sender .= unsanitize($row_get_message['sender']);
						}

						?><tr<?php echo ($row_get_message['status'] == 'unread') ? ' class="new-message"' : ''; ?>>
							<td><?php echo date('m/d/Y h:i A', strtotime($row_get_message['message_date'])); ?></td>
							<td><?php echo $sender; ?></td>
							<td><a name="message" href="#message-<?php echo $message_id_encrypted; ?>" rel="facebox" title="View Message" class="ttTipsy"><?php echo unsanitize($row_get_message['subject']); ?></a></td>
							<td><a href="compose.php?r=<?php echo encrypt($row_get_message['sender']); ?>&m=<?php echo $message_id_encrypted; ?>" title="Reply Message"><img src="images/message-reply.png" title="Reply Message" class="ttTipsy" /></a> <a href="compose.php?m=<?php echo $message_id_encrypted; ?>" title="Forward Message"><img src="images/message-forward.png" title="Forward Message" class="ttTipsy" /></a> <a href="process.php?t=<?php echo encrypt('message'); ?>&m=<?php echo $message_id_encrypted; ?>" title="Delete Message"><img src="images/message-delete.png" title="Delete Message" class="ttTipsy" /></a></td>
						</tr>
						
						<tr class="hidden">
							<td colspan="4"><div id="message-<?php echo $message_id_encrypted; ?>"><?php echo html_entity_decode($row_get_message['message']); ?></div></td>
						</tr>
						<?php
					}
					
				?></tbody>
			</table><?php
			
		} else {
		
			?><p>You have no new messages.</p><?php
		
		}
	?></div>
</div>

<?php require_once('includes/footer.php'); ?>
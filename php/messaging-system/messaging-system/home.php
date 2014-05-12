<?php

	require_once('includes/commons.php');

	$_SESSION['last_page'] = 'home.php';

	require_once('includes/header.php');
	
	// get name
	$result_get_name = mysql_query('SELECT first_name, last_name FROM user WHERE username = "'.$username.'"');
	$row_get_name = mysql_fetch_assoc($result_get_name);
	
	$query_get_message = 'SELECT COUNT(1) AS count FROM message, message_recipient WHERE message.message_id = message_recipient.message_id AND recipient = "'.$username.'" AND message_recipient.status = "unread"';
	$result_get_message = mysql_query($query_get_message);
	$row_get_message = mysql_fetch_assoc($result_get_message);
	
?>

<div class="content">
	<div class="content-header">
		<h2>Dashboard</h2>
	</div>
	
	<div class="content-body">
		<p>Welcome <?php echo $row_get_name['first_name'].' '.$row_get_name['last_name']; ?>,</p>
		<p>You currently have <strong><?php echo $row_get_message['count']; ?></strong> new messages. Please click on "My Messages" on the top to access these new messages.</p>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>
<?php

	require_once('functions.php');

	$current_page = get_current_page_name();
	
	if(isset($_POST['search'])) {
	}
	
	// inbox
	$result_get_inbox = mysql_query('SELECT COUNT(1) AS count FROM message, message_recipient WHERE message.message_id = message_recipient.message_id AND message_recipient.recipient = "'.$username.'" AND (message_recipient.status = "read" OR message_recipient.status = "unread")');
	$row_get_inbox = mysql_fetch_assoc($result_get_inbox);
	
	// draft
	$result_get_draft = mysql_query('SELECT COUNT(1) AS count FROM message, message_sender WHERE message.message_id = message_sender.message_id AND message_sender.sender = "'.$username.'" AND message_sender.status = "draft"');
	$row_get_draft = mysql_fetch_assoc($result_get_draft);
	
	// sent
	$result_get_sent = mysql_query('SELECT COUNT(1) AS count FROM message, message_sender WHERE message.message_id = message_sender.message_id AND message_sender.sender = "'.$username.'" AND message_sender.status = "sent"');
	$row_get_sent = mysql_fetch_assoc($result_get_sent);
	
	// trash
	$result_get_deleted_message_sender = mysql_query('SELECT COUNT(1) AS count FROM message, message_sender WHERE message.message_id = message_sender.message_id AND message_sender.sender = "'.$username.'" AND (message_sender.status = "sent_deleted" OR message_sender.status = "draft_deleted")');
	$row_get_deleted_message_sender = mysql_fetch_assoc($result_get_deleted_message_sender);

	$result_get_deleted_message_recipient = mysql_query('SELECT COUNT(1) AS count FROM message, message_recipient WHERE message.message_id = message_recipient.message_id AND message_recipient.recipient = "'.$username.'" AND (message_recipient.status = "read_deleted" OR message_recipient.status = "unread_deleted")');
	$row_get_deleted_message_recipient = mysql_fetch_assoc($result_get_deleted_message_recipient);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Messaging System - Control Panel</title>
<!-- stylesheets -->
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/facebox.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />
<link type="text/css" rel="stylesheet" href="css/tipsy.css" />
<!-- END - stylesheets -->

<!-- javascripts -->
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/facebox.js"></script>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- END - javascripts -->
</head>

<body>

<div class="header">
	<ul class="navigation">
		<li><a href="home.php"<?php echo ($current_page === 'home.php') ? ' class="current"' : ''; ?> title="Dashboard">Dashboard</a></li>
		<li><a href="address-book.php"<?php echo ($current_page === 'address-book.php' || $current_page === 'address-book-manage.php') ? ' class="current"' : ''; ?> title="Address Book">Address Book</a>
			<ul class="subnav">
				<li><a href="address-book-manage.php" title="Add New Contact">New Contact</a></li>
			</ul>
		</li>
		<li><a href="message.php"<?php echo ($current_page === 'message.php' || $current_page === 'compose.php' || $current_page === 'message-sent.php' || $current_page === 'message-draft.php' || $current_page === 'message-trash.php') ? ' class="current"' : ''; ?> title="My Messages">My Messages</a>
			<ul class="subnav">
				<li><a href="message.php" title="View Inbox">Inbox (<?php echo $row_get_inbox['count']; ?>)</a></li>
				<li><a href="message-draft.php" title="View Draft Messages">Draft (<?php echo $row_get_draft['count']; ?>)</a></li>
				<li><a href="message-sent.php" title="View Sent Messages">Sent (<?php echo $row_get_sent['count']; ?>)</a></li>
				<li><a href="message-trash.php" title="View Deleted Messages">Trash (<?php echo ($row_get_deleted_message_sender['count'] + $row_get_deleted_message_recipient['count']); ?>)</a></li>
			</ul>
		</li>
	</ul>
	<span><a href="profile.php" title="My Profile">My Profile</a> | <a href="signout.php" title="Sign Out">Sign Out</a></span>
</div>

<div id="container">
	<?php require_once('notification.php'); ?>
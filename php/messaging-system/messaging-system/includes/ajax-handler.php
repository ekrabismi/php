<?php

	require_once('commons.php');
	
	$notification_array = array();
	$notification_status = 'notification-error';
	$ajax_object = '';
	$method = 'p';
	
	if(isset($_POST['ajax_object'])) {
		$ajax_object = decrypt($_POST['ajax_object']);
	}
	else if(isset($_GET['ajax_object'])) {
		$ajax_object = decrypt($_GET['ajax_object']);
		$method = 'g';
	}
	
	if($ajax_object == 'message_mark_read') {
		if($method == 'p')
			$id = $_POST['id'];
		else
			$id = $_GET['id'];
		
		$id = explode('-', $id);
		$message_id = sanitize(decrypt($id[1]));
		
		// check if message_id exists
		if(message_exist($message_id, 'message_recipient', 'recipient', $username)) {
		
			$result_set_message_read = mysql_query('UPDATE message_recipient SET status = "read" WHERE recipient = "'.$username.'" AND message_id = '.$message_id);
		}
		exit;
	}
	else if($ajax_object == 'get_recipient') {
		
		$temp = array();
		$temp['test'] = 'test';
		$temp['computer'] = 'computer';
		
		header('Content-type: application/json');
		echo json_encode($temp);
		exit;
	}	// END - if($ajax_object == 'get_recipient')
	
?>
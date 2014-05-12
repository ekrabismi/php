<?php

	// ================ ALL FUNCTIONS BELOW ARE HELPER FUNCTIONS THAT USED THROUGHOUT THE APPLICATION ================
	// ================ CHANGE THEM AT YOUR OWN RISK ================
	// ================ CHECK THE DOCUMENTATION PAGE FOR IN-DEPTH EXPLANATION ================

	/* Connect to database */
	function db_connect() {
		
		/* database credentials */
		$hostname = '';
		$db_user = '';
		$db_password = '';
		$db_name = '';
		/* END - database credentials */
		
		$conn = @mysql_connect($hostname, $db_user, $db_password) or die('Unable to connect to database server. Please contact administrator.');
		
		@mysql_select_db($db_name, $conn) or die('Unable to select database. Please contact administrator');
	}

	/* Get current page name */
	function get_current_page_name() {
	
		$filename = $_SERVER['PHP_SELF'];
		
		$filename_array = explode('/', $filename);
		
		$filename = $filename_array[count($filename_array) - 1];
		
		return $filename;
	}
	
	/**
	 * Sanitize input for SQL injection
	 *
	 * Input may be a string or array
	 */
	function sanitize($input) {
	
		if(is_array($input)) {
			$input_count = count($input);
			
			foreach($input as $key => $val) {
				
				$input[$key] = sanitize($val);
			}
		} else {
			$input = mysql_real_escape_string(trim($input));
		}
		
		return $input;
	}
	
	/**
	 * Unsanitize variables to be displayed on screen for end-user
	 *
	 * Input may be a string or array
	 */
	function unsanitize($input) {
		
		if(is_array($input)) {
			$input_count = count($input);
			
			foreach($input as $key => $val) {
				
				$input[$key] = unsanitize($val);
			}
		} else {
			$input = stripslashes($input);
		}
		
		return $input;
	}
	
	/**
	 * Encrypt function
	 *
	 * Key - your unique key to generate the encryption value
	 */
	function encrypt($str, $key = 'YOUR_KEY') { 
	
		$output = ''; 
		for($i = 0; $i < strlen($str); $i++) {
			
		  $single_char = substr($str, $i, 1); 
		  $single_char_encrypted = substr($key, ($i % strlen($key)) - 1, 1); 
		  $single_char = chr(ord($single_char) + ord($single_char_encrypted)); 
		  $output .= $single_char; 
		}
		return str_replace('=', '', strtr(base64_encode($output), '+/', '-_'));
	} 

	/**
	 * Decrypt function
	 *
	 * Key - your unique key to generate the decryption value
	 */
	function decrypt($str, $key = 'YOUR_KEY') { 
	
		$output = ''; 
		$str = base64_decode(strtr($str, '-_', '+/').'==');
		
		for($i = 0; $i < strlen($str); $i++) {
			
			$single_char = substr($str, $i, 1); 
			$single_char_encrypted = substr($key, ($i % strlen($key)) - 1, 1); 
			$single_char = chr(ord($single_char) - ord($single_char_encrypted)); 
			$output .= $single_char; 
		} 
		return $output; 
	}
	
	/**
	 * Check if user exists in database
	 *
	 */
	function user_exist($username) {
		
		// check if username exist
		$result_check_username = mysql_query('SELECT COUNT(1) AS count FROM user WHERE username = "'.$username.'"');
		$row_check_username = mysql_fetch_assoc($result_check_username);
		if($row_check_username['count'] > 0)
			return true;
		
		return false;
	}
	
	/**
	 * Validate username with the password
	 *
	 */
	function validate_user($username, $password) {
		
		if(user_exist($username)) {
			// check if username exist
			$result_validate_username = mysql_query('SELECT COUNT(1) AS count FROM user WHERE username = "'.$username.'" AND password = "'.$password.'"');
			$row_validate_username = mysql_fetch_assoc($result_validate_username);
			if($row_validate_username['count'] > 0)
				return true;
		}
		
		return false;
	}
	
	/**
	 * Check if a message exist in database
	 *
	 */
	function message_exist($message_id, $from = '', $target_type = '', $target_username = '') {
		
		$query_check_message = 'SELECT COUNT(1) AS count FROM '.$from.' WHERE message_id = '.$message_id;
		if($target_type != '' && $target_username != '') {
			$query_check_message .= ' AND '.$target_type.' = "'.$target_username.'"';
		}
		
		$result_check_message = mysql_query($query_check_message);
		$row_check_message = mysql_fetch_assoc($result_check_message);
		if($row_check_message['count'] > 0)
			return true;
		
		return false;
	}
	
	/**
	 * Check if username exists in the address book
	 *
	 */
	function recipient_exist_address_book($username, $recipient) {
		
		$result_check_recipient = mysql_query('SELECT COUNT(1) AS count FROM address_book WHERE username = "'.$username.'" AND recipient = "'.$recipient.'"');
		$row_check_recipient = mysql_fetch_assoc($result_check_recipient);
		if($row_check_recipient['count'] > 0)
			return true;
			
		return false;
	}

?>
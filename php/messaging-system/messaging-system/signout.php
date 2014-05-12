<?php

	@session_start();
	
	unset($_SESSION['last_page']);
	unset($_SESSION['user_login']);
	
	header('Location: index.php');
	exit;

?>
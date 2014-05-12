<?php

	require_once('includes/commons.php');

	$_SESSION['last_page'] = 'address-book.php';
	
	require_once('includes/header.php');
	
	if(isset($_POST['search'])) {
		$keyword = sanitize($_POST['search']);
		$query_address_book = 'SELECT * FROM address_book WHERE username = "%'.$keyword.'%" OR first_name = "%'.$keyword.'%" OR last_name = "%'.$keyword.'%" ORDER BY first_name ASC, last_name ASC, username ASC';
		$result_address_book = mysql_query($query_address_book);
	} else {
		$query_address_book = 'SELECT * FROM address_book WHERE username = "'.$username.'" ORDER BY first_name ASC, last_name ASC, username ASC';
		$result_address_book = mysql_query($query_address_book);
	}
?>
	
<div class="content">
	<div class="content-header">
		<h2>Address Book</h2>
		<div>
			<a href="address-book-manage.php" title="Add New Contact"><img src="images/address-book-add.png" title="Add New Contact" class="ttTipsy" /></a>
		</div>
	</div>
	
	<div class="content-body"><?php
		
		if(mysql_num_rows($result_address_book) > 0) {
			
			?><table class="table-grid2">
				<thead>
					<tr>
						<th>Name</th>
						<th>Username</th>
						<th>Action</th>
					</tr>
				</thead>
				
				<tbody><?php
					
					while($row_address_book = mysql_fetch_assoc($result_address_book)) {
						
						unsanitize($row_address_book);
						
						$username_encrypted = encrypt($row_address_book['recipient']);
						
						?><tr>
							<td><?php echo $row_address_book['first_name'].' '.$row_address_book['last_name']; ?></td>
							<td><?php echo $row_address_book['recipient']; ?></td>
							<td><a href="address-book-manage.php?r=<?php echo $username_encrypted; ?>" title="Edit Contact Information"><img src="images/address-book-edit.png" title="Edit Contact Information" class="ttTipsy" /></a> <a href="process.php?t=<?php echo encrypt('address_book'); ?>&r=<?php echo $username_encrypted; ?>" title="Delete Contact"><img src="images/address-book-delete.png" title="Delete Contact" class="ttTipsy" /></a> <a href="compose.php?r=<?php echo $username_encrypted; ?>" title="Send Message"><img src="images/message-send.png" title="Send Message" class="ttTipsy" /></a></td>
						</tr><?php
					}
					
				?></tbody>
			</table><?php
		} else {
			?><p>There are no contacts in your address book. Please <a href="address-book-manage.php" title="Add New Contact">click here</a> to add a new contact to your address book.</p><?php	
		}
		
		?></div>
</div>

<?php require_once('includes/footer.php'); ?>

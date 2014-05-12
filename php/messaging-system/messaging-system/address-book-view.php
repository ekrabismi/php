<?php

	require_once('includes/commons.php');

	$query_get_addresses = 'SELECT * FROM address_book WHERE username = "'.$username.'" ORDER BY first_name ASC, last_name ASC, username ASC';
	$result_get_addresses = mysql_query($query_get_addresses);
	$addresses_count = mysql_num_rows($result_get_addresses);

?>
<script>



	$(document).ready(function() {
		// initialize
		var recipient = $('input[name=recipient]').val();
		var recipient_array = new Array();
		if(recipient != '') {
			recipient_array = recipient.split(',');
			for(var i = 0; i < recipient_array.length; i++) {
				recipient_array[i] = $.trim(recipient_array[i]);
				
				if(recipient_array[i] == '')
					recipient_array.splice(i, 1);
			}
			
			$('input[type=checkbox]').each(function() {
				if($.inArray(this.value, recipient_array) >= 0) {
					$(this).attr('checked', true);
				}
			});
		}
		// add and/or remove
		$('input[type=checkbox]').click(function() {
			var recipient_list = '';
			
			$('input[type=checkbox]').each(function() {
				var index = $.inArray(this.value, recipient_array);
				if(this.checked) {
					if(index < 0)
						recipient_array.push(this.value);
				}
				else {
					if(index >= 0) {
						recipient_array.splice(index, 1);
					}
				}
			});
			
			$('input[name=recipient]').val(recipient_array);
		});
	});
</script>
<h2>Select Recipients</h2>
<div><?php
	
	if($addresses_count > 0) {
		
		?><form name="select-recipient-form"><ul><?php
		
			while($row_get_addresses = mysql_fetch_assoc($result_get_addresses)) {
				$row_get_addresses = unsanitize($row_get_addresses);
				
				?><li><input type="checkbox" name="recipient[]" id="recipient-1" value="<?php echo $row_get_addresses['recipient']; ?>" /><label for="recipient-1"><?php echo $row_get_addresses['first_name'].' '.$row_get_addresses['last_name'].' &lt;'.$row_get_addresses['recipient'].'&gt;'; ?></label></li><?php
			}
			
		?></ul>
		</form><br /><?php
		
	} else {
	
		?><p>You currently have no contact in your address book.</p><?php
	}

	?>
</div>
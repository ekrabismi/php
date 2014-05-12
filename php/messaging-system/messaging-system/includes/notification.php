<?php

	if(isset($notification_array) && count($notification_array) > 0) {
		?><div class="notification <?php echo $notification_status; ?>">
			<a href="javascript:;" class="close" title="Close Notification">close</a><?php
			
			$notification_array_count = count($notification_array);
			
			if($notification_array_count == 1) {
				?><p><?php echo $notification_array[0]; ?></a></p><?php
			} else {
				
				?><ul><?php
				
				for($i = 0; $i < $notification_array_count; $i++) {
						
					?><li><?php echo $notification_array[$i]; ?></li><?php
				}
				
				?></ul><?php
			}
			
		?></div><?php
	}
	
?>
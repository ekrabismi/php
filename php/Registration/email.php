<?php
$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"

                       ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"

                       ."\.([a-z]{2,}){1}$";     
					   
					   if(!eregi($regex,$email))

			{

			  print '<br>Please enter a valid email address.';     

			}

?>
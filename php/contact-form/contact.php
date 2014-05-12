<?php

function isValidEmail($email)
{
	$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"

                       ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"

                       ."\.([a-z]{2,}){1}$";     
					   
	if(eregi($regex,$email)) return true;
	else return false;
}

if(isset($_POST['contact']) == true)
	{
	 	$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$comments = $_POST['comments'];
		
		if($fname==false)
		{
		 $err ="Please enter your first name";
		}
		else if($email==false)
		{
		 $err ="Please enter your Email address";
		}
		else if(!isValidEmail($email))
		{
		$err ="Please Enter Valid Email address"; 
		}
		
		if(!$err)
			{
					
					$to_mail = $email;
					$subject = "Thank you for contacting BA Apartment Rental";
					$body 	 = "Thanks for contacting us.";
					$from_mail = "info@myhost.com";
					$headers = "From: ".$from_mail;
					mail($to_mail,$subject,$body,$headers);
						
			}
			else
			{
				echo $err;
			}
		
		
	}

?>
<form action="" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="0" align="center">
  <tr>
    <td align="right"><span style="color:red">*</span> First Name</td>
    <td><input type="text" name="fname" value="<?= $_POST['fname'];?>" /></td>
  </tr>
  <tr>
    <td align="right">Last Name</td>
    <td><input type="text" name="lname" value="<?= $_POST['lname'];?>" /></td>
  </tr>
  <tr>
    <td align="right"><span style="color:red">*</span> Email</td>
    <td><input type="text" name="email" value="<?= $_POST['email'];?>" /></td>
  </tr>
  <tr>
    <td align="right">Phone No</td>
    <td><input type="text" name="phone" value="<?= $_POST['phone'];?>" /></td>
  </tr>
  <tr>
    <td align="right">Comments</td>
    <td><textarea name="comments" rows="4" cols="30"><?= $_POST['comments'];?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="contact" value="Send" /></td>
  </tr>
</table>
</form>
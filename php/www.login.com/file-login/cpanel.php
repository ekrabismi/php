<?php
if(isset($_POST['save']))
{
	
	$adminuser = $_POST['adminuser'];
	$adminpass = $_POST['adminpass'];
	$oauth_access_token = $_POST['oauth_access_token'];
	$oauth_access_token_secret = $_POST['oauth_access_token_secret'];
	$consumer_key = $_POST['consumer_key'];
	$consumer_secret = $_POST['consumer_secret'];
	$oauth_callback = $_POST['oauth_callback'];
	
    
	$fp2 = fopen("config.ini","w");
    
	fwrite($fp2, "adminuser\n",1024);
	fwrite($fp2,"$adminuser\n",1024);
	
	fwrite($fp2, "adminpass\n",1024);
	fwrite($fp2,"$adminpass\n",1024);
	
	fwrite($fp2, "oauth_access_token\n",1024);
	fwrite($fp2,"$oauth_access_token\n",1024);
	
	fwrite($fp2, "oauth_access_token_secret\n",1024);
	fwrite($fp2,"$oauth_access_token_secret\n",1024);
	
	fwrite($fp2, "consumer_key \n",1024);
	fwrite($fp2,"$consumer_key \n",1024);
	
	fwrite($fp2, "consumer_secret\n",1024);
	fwrite($fp2,"$consumer_secret\n",1024);
	
	fwrite($fp2, "oauth_callback\n",1024);
	fwrite($fp2,"$oauth_callback",1024);
	
	
	$msg = "Data have been saved successfully.";

	fclose($fp2);

}

include("header.php");

if(!isset($_SESSION['myuser'])) echo "<script>window.location='login.php';</script>";
$username = $_SESSION['myuser'];
?>
<h2 align="center"><strong>Welcome to Visitors Control Panel</strong>. </h2>
<form action="" method="post">
<table border="1" id='tbl1'>
  <tr>
    <td width="25%">Welcome <b><?= $username ?></b></td>
    <td width="50%" align="center"><input type="button" class="button1" value="Back to Home" onclick="javascript: window.location.href='index.php';"  /> <input type="submit" name="save" value="Save Setting" class="button1" /></td>
    <td width="25%" align="right">
    <input type="button" class="button1" value="Log Off" onclick="javascript: window.location.href='logout.php';"  />
    
    </td>
  </tr>
</table>



<table border="0" id='tbl1'>

<tr>
 <td colspan="3">&nbsp;</td>
</tr>
<tr>

 <td align="right"> Admin User </td>
 <td> : </td>
 <td> <input type="text" size="70" value="<?= $config['adminuser'] ?>" name="adminuser" class="button1" /></td>
</tr>

<tr>
 <td align="right"> Admin Password </td>
 <td> : </td>
 <td> <input type="text" size="70" value="<?= $config['adminpass'] ?>"  name="adminpass" class="button1" /></td>
</tr>

<tr>
 <td align="right"> OAuth Access Token </td>
 <td> : </td>
 <td> <input type="text" size="70"  value="<?= $config['oauth_access_token'] ?>" name="oauth_access_token" class="button1" /></td>
</tr>

<tr>
 <td align="right"> OAuth Access Token Secret </td>
 <td> : </td>
 <td> <input type="text" size="70"  value="<?= $config['oauth_access_token_secret']  ?>" name="oauth_access_token_secret" class="button1" /></td>
</tr>

<tr>
 <td align="right"> Consumer Key </td>
 <td> : </td>
 <td> <input type="text" size="70" value="<?= $config['consumer_key'] ?>"  name="consumer_key" class="button1" /></td>
</tr>

<tr>
 <td align="right"> Consumer Secret </td>
 <td> : </td>
 <td> <input type="text" size="70" value="<?= $config['consumer_secret'] ?>"  name="consumer_secret" class="button1" /></td>
</tr>

<tr>
 <td align="right"> OAuth Callback URL </td>
 <td> : </td>
 <td> <input type="text" size="70" value="<?= $config['oauth_callback'] ?>"  name="oauth_callback" class="button1" /></td>
</tr>

<tr>
 <td colspan="3">&nbsp;</td>
</tr>
<tr>

</table>

</form>


<?php

if(!empty($msg))
 echo "<div class='error'>$msg</div>";

include("footer.php");

?>
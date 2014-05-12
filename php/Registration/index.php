<td valign="top">
<table width="560" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td height="5">&nbsp;</td>
<td height="5"><h1 align="center">Welcome to Celsius Bar`s</h1>
  <h2 align="center">Grand for a Band Competition<br />
  166 Hoe st., Walthamstow, E17 5BH. </h2>
  <p>&nbsp;</p>
  </td><td height="5">&nbsp;</td>
</tr>
<tr><td background="images/BG_contentleft.gif">&nbsp;</td>
<td width="100%">

<h2 align="center"><img width="642" height="66" src="index_clip_image001.gif" alt="Text Box: REGISTER NOW FOR BAND COMPITITION" /></h2>
<br>
<h3 align="center"> &nbsp;&nbsp;&nbsp;&nbsp;Registration Form</h3>

  <?php
if (!isset($_POST['submit'])) {
//<form action="booking.php" method="post" > 
//echo <<<ETD
?>
<br>
<form action="" method="post" >
  <table width="563" height="536" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td width="176">Name of the Band*</td>
      <td width="5"><strong>:</strong></td>
      <td width="322">
	  <input name="bname" type="text" id="bname"" size="50" />
	  
	  </td>
    </tr>
    <tr>
      <td>Contact Person Name*</td>
      <td><strong>:</strong></td>
      <td><input name="pname" type="text" id="pname" size="50" /></td>
    </tr>
    <tr>
      <td>Contact Number (Home Tel)</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="cnt" size="50" /></td>
    </tr>
    <tr>
      <td>Contact Number (Mobile)*</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="cnm" size="50" /></td>
    </tr>
    <tr>
      <td>Email*</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="email" size="50" /></td>
    </tr>
    <tr>
      <td>Style of Music*</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="music" size="50" /></td>
    </tr>
    <tr>
      <td>Members in Group*</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="mg" size="50" /></td>
    </tr>
    <tr>
      <td>No. Of senior</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="ns" size="50" /></td>
    </tr>
    <tr>
      <td>No. Of juniors</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="nj" size="50" /></td>
    </tr>
    <tr>
      <td valign="top">Additional Info</td>
      <td valign=top><strong>:</strong></td>
      <td valing=top><textarea name="comment" cols="38" rows="8"></textarea></td>
    </tr>
  </table>
  <p align="left"><input type="checkbox" name="term" value="term">
    <a href="terms.php">  Terms & Conditions </a>
   <p align="left"> By checking this box, I confirm that I have read, understand, and agree to all terms and conditions of Argentina Tango. Additionally, I confirm that all information provided above is accurate.</p>
    
    
    <div align="center"><br>
      <br>
      <input type="submit" name="submit" value="Submit">
        </p>
      </div>
</form>
<?php
//ETD;
}

else {
	    $bname = $_POST['bname'];	 
        $email = $_POST['email'];	
        $personname = $_POST['pname'];
        $cnm = $_POST['cnm'];
        $music = $_POST['music'];
		$mg = $_POST['mg'];
		$term = $_POST['term'];	
        		
	if(!$term)
	{
	 print "You should accept terms and condition.
	 <a href=\"javascript:history.go(-1)\"> Go Back</a>";
	}
	elseif (($email=="")or($bname=="")or(pname=="")or($cnm=="")or($mg=="")or($music=="")) 
	echo ' (*) Required field are missing.<a href="javascript:history.go(-1)"> Go Back</a>';
	else {
		
		$bname = $_POST['bname'];
		$pname = $_POST['pname'];	 
        $cnt = $_POST['cnt'];
		$cnm = $_POST['cnm'];
		$email = $_POST['email'];	
        $music = $_POST['music'];
		$mg = $_POST['mg'];
		$ns = $_POST['ns'];
		$nj = $_POST['nj'];
		$comment = $_POST['comment'];
		
		
		print "“Thank you for registering for the Band Competition, You will be contacted shortly. So good luck and get rehearsing. Regards, Celsius Bar” <br><br>";
		//print "<a href = 'booking.php'>Make your payment now.</a>";
			
		
$message = "Name of the Band: $bname

Contact Person Name: $pname  

Contact Number (Home Tel) : $cnt

Contact Number (Mobile): $cnm

Email: $email

Style of Music: $music

Members in Group: $mg

No. Of senior: $ns

No. Of juniors: $nj

Additional Info: $comment";


mail("neil@celsiusbar.co.uk","Registration Form", $message, "From: me\r\nTo: neil@celsiusbar.co.uk\r\n");
	
mail("neilcurran@ntlworld.com","Registration Form", $message, "From: me\r\nTo: neilcurran@ntlworld.com\r\n");

       //print "<script>";
		//print "window.location.href='booking.php';";
		//print "< /script>";
			
	}
	

}
?>
  <br>
    <br>
    <br>
</p>
<div align="right"><br>
</div></td>
<td background="images/BG_contentright.gif">&nbsp;</td>
</tr></table>
</td>


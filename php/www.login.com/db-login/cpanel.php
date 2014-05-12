<?php
include("header.php");
include("db.php");
include("user.php");

if(!isset($_SESSION['myuser'])) echo "<script>window.location='index.php';</script>";

$username = $_SESSION['myuser'];
$userid = $_SESSION['userid'];
$parentid = $userid;

?>
<h2 align="center"><strong>Welcome to Jesses Club house Parents Control panel</strong>. </h2>


<table border="1" id='tbl1'>
  <tr>
    <td width="393">Welcome <b><?= $username ?></b></td>
    <td width="393">&nbsp;</td>
    <td width="478">
    <input type="button" class="button1" value="Log Off" onclick="javascript: window.location.href='logout.php';"  />
    
    </td>
  </tr>
</table>

<table height="1505" border="1"  id='tbl1'>
  <tr >
    <td colspan="4">
    
    <h1>Photo Upload Approval</h1>
<?php


if (isset($_POST['photo_app_submit'])) //photo section
{
 $photo_app = explode(":",$_POST['photo_app_yn']);
 $uid = $photo_app[1]; 
  //print_r($photo_app);
  
 if(!$photo_app[0]) //photo published permission activate
 {
	$sql = 'UPDATE ' . $prefix.'users SET activation = 1 WHERE id = '.$uid;

	$result = mysql_query($sql,$link) or die(mysql_error()); 
 }
 else //photo published permission deactivate
 {
	$sql = 'UPDATE ' . $prefix.'users SET activation = 0 WHERE id = '.$uid;

	$result = mysql_query($sql,$link) or die(mysql_error());
 }
	
}

if (isset($_POST['photosubmit'])) //published/unpublished photo
{
	
	$uid = $_POST['uid'];
	$tf=0;
	
 if(isset($_POST["yes_photo_$uid"])) //published a photo
	 {
		$photoarr = $_POST["yes_photo_$uid"];
		foreach($photoarr as $key=>$value)
		{
			//echo "$value<br>";
			$sql = 'UPDATE ' . $prefix.'community_photos SET published = 1 WHERE id = '.$value;
			$tf=1;

			$result = mysql_query($sql,$link) or die(mysql_error());
		}
	 }

if(isset($_POST["no_photo_$uid"])) //unpublished a photo
	 {
		$photoarr = $_POST["no_photo_$uid"];
		foreach($photoarr as $key=>$value)
		{
			//echo "$value<br>";
			$sql = 'UPDATE ' . $prefix.'community_photos SET published = 0 WHERE id = '.$value;

             $tf=1;
			$result = mysql_query($sql,$link) or die(mysql_error());
		}
	 }
if($tf==0)
	  echo "<script>alert('Please select at least one photo.');</script>";


}
					echo "<table  border='1' id='tbl2'>";
					echo "<tr align='center'><td>User Name</td><td>Action</td><td>Photos</td>";
					
					echo "<td rowspan='2'> By selecting yes you can approve photo your child has upload. <br />
  Photo will not appear to public until you approve or disapprove pending photos.<br /> 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Or if you select No your child can upload photos immediately without your permission.<br /> 
  Default is No.</td></tr>";
  
  $userarr = getuserlist($parentid);
  $userthumb_arr =  getuserthumb($parentid);
  //print_r($userthumb_arr);
  							
					foreach($userarr as $key=>$userlist)
					{
					    				
						$username = $userlist['name'];
						$photoapproved = $userlist['activation'];
						$uid = $userlist['id'];
						$uname = $userlist['username'];
						$upath = $rootpath. "index.php?option=com_community&view=profile&userid=$uid";

				        $userimg = $userthumb_arr["$key"];
						
						echo '<form action="" method="post" name="photoform">';
					      
					      echo "<tr><td>";
						  //echo "db value : $photoapproved<br>";
						?>
                        
                        <p>Needs Approval </p>
                           <select name="photo_app_yn">
                         	<option <?php if($photoapproved) echo "selected='selected'"; ?> value="0:<?= $uid ?>">No</option>
                         	<option  <?php if(!$photoapproved) echo "selected='selected'"; ?> value="1:<?= $uid ?>">Yes</option>
                          </select>
                          <br /><br />
                        <input type="submit" name="photo_app_submit" class="button1"  value="Done" />
                         <br /><br />
                        
                        <?php  
						  echo "photo Uploads for " ;
						  
						  echo "<div>
						  <a href='$upath' target='_blank'>
						  <img src='$userimg' alt='photo' /><br>$username</a></div>";
												  
						  echo "</td>";
						  
						  echo "<td nowrap='nowrap'>";
						  ?>
                 
                          <span class="selbox" >
<input type="radio" name="allphoto" onchange="selallyes(this.value)"   value="<?= $uid ?>" />
Approve All</span>
<br /><br />
 <span class="selbox" >
<input type="radio" name="allphoto" onchange="selallno(this.value)"  value="<?= $uid ?>" /> 
Disapprove All</span>
<br /><br />
<input type="hidden" name="uid" value="<?= $uid ?>" />
                          
                        <input type="submit" name="photosubmit" class="button1" value="Done" />
                        

						  <?php
						  echo "</td>";
						  
						  echo "<td>";
						  
						$sql2 = 'select * from ' . $prefix.'community_photos WHERE albumid >0 and creator = ' . $userlist['id'];

						$result2 = mysql_query($sql2,$link) or die(mysql_error());
 
						 $myrow = mysql_affected_rows();
						  
						  if($myrow>0)
						  {
							  
							  echo "<div style='width:110%;height:500px;overflow:auto;'>"; 
							  
							  echo "<table border='1'>";
							  
							  echo "<tr  align='center'>
							  <td>Photos</td>
							  <td>Status</td>
							  <tr>";
							  
							
							
							  
							  while($photo = mysql_fetch_array($result2))
							  {
								  echo "<tr  align='center'>";
								  //print_r($photo);
								  echo "<td> <img alt='img' src='../" .
								  $photo[7]. "' /><br>" ;
								  echo "<span class='selbox'>";
								  							  
								  echo "<input type='checkbox' onclick='" . "delno(this.value, $uid)" . "'name='yes_photo_" . $uid . "[]' value='" . $photo[0] . "'  />"  . 'Aprove'  ;
								  
								  echo "<input type='checkbox' onclick='" . "delyes(this.value, $uid)" . "' name='no_photo_" . $uid . "[]' value='" . $photo[0] . "'  />"  . 'Disaprove'  ;
								  
								  echo "</span>";
								  
								  echo  "</td>";
								  					  
								  echo "<td>";
								  
								  echo ($photo[3])?'Published':'Unpublished' ;
											  
								  
								  echo "</td></tr>";
							  }
							  echo "</table>";
						echo "</div>";
					}
							  echo "</td></tr>";
				
				  echo "</form>";
						  
						 }
	
					
						echo "</table>";
			
				
			?>
    
    </td>
    
  </tr>
  
      <tr >
    <td colspan="4">
    <h1>Friends Request Approval</h1>
			<?php

if (isset($_POST['friend_app_submit']))  //friend request permission 
{
 $friend_app = explode(":",$_POST['friend_app_yn']);
 $uid = $friend_app[1]; 
  //print_r($friend_app);
 if(!$friend_app[0]) //friend request permission set
 {
	$sql = 'UPDATE ' . $prefix.'users SET sendemail = 1 WHERE id = '.$uid;

	$result = mysql_query($sql,$link) or die(mysql_error()); 
 }
 else //friend request permission unset
 {
	$sql = 'UPDATE ' . $prefix.'users SET sendemail = 0 WHERE id = '.$uid;

	$result = mysql_query($sql,$link) or die(mysql_error());
 }
	
}
	
if (isset($_POST['frdsubmit']))
{
 $frdyn = explode(":",$_POST['frdyn']);
 $uid = $frdyn[1]; 
 // print_r($frdyn);
 if(!$frdyn[0])
 {
	 if(isset($_POST["frd_$uid"])) //accepting a friend request
	 {
		$frdarr = $_POST["frd_$uid"];
		foreach($frdarr as $key=>$value)
		{
			//echo "$value<br>";
			$sql = 'delete from ' . $prefix.'community_connection WHERE connection_id = '.$value ;

				$result = mysql_query($sql,$link) or die(mysql_error());
		}
	 }
	 else
	  echo "<script>alert('Please select at least one user.');</script>";
 }
else
 {
	 if(isset($_POST["frd_$uid"]))
	 {
		$frdarr = $_POST["frd_$uid"];
		foreach($frdarr as $key=>$value)
		{
			//echo "$value<br>";
					
				$sql = 'UPDATE ' . $prefix.'community_connection SET status = 1 WHERE connection_id = '.$value ;

				$result = mysql_query($sql,$link) or die(mysql_error());
		}
	 }
	 else
	  echo "<script>alert('Please select at least one user.');</script>";
 }


}
	
			
			
			if(isset($_REQUEST['friendno']))  //canceling a friend request
			{
				$frid  = $_REQUEST['friendno'];
						
				$sql = 'UPDATE ' . $prefix.'community_connection SET status = 1 WHERE connect_to = '.$frid ;

				$result = mysql_query($sql,$link) or die(mysql_error());
			}
			
			if(isset($_REQUEST['friendyes']))
			{
				$frid  = $_REQUEST['friendyes'];
						
				$sql = 'UPDATE ' . $prefix.'community_connection SET status = 0 WHERE connect_to = '.$frid ;

				$result = mysql_query($sql,$link) or die(mysql_error());
			}
						      
					
				echo "<table border='1'  id='tbl3' >";
				echo "<tr align='center'><td>User Name</td><td>Action</td><td>Request From</td>";		
				echo "<td rowspan='2'>People who want to be friends with your child.<br>

If select Yes you can screen them first then approve or disaprove friendship.<br>

&nbsp;&nbsp;&nbsp;&nbsp;If you select No you child can accept or not accept friendship immediately without your permission.<br>

Default is Yes.</td></tr>";		  					
					//$userarr = getuserlist($parentid);
					foreach($userarr as $key=>$userlist)
					{
						$username = $userlist['name'];
						$uid = $userlist['id'];
						$friend_approved = $userlist['sendEmail'];
						
						$uname = $userlist['username'];
						$upath = $rootpath. "index.php?option=com_community&view=profile&userid=$uid";
				        $userimg = $userthumb_arr["$key"];
						
						echo '<form action="" method="post" name="frdform">';
						
						echo '<tr><td>';
					?>
                    
					<p>Needs Approval </p>
                           <select name="friend_app_yn">
                         	<option <?php if($friend_approved) echo "selected='selected'"; ?> value="0:<?= $uid ?>">No</option>
                         	<option  <?php if(!$friend_approved) echo "selected='selected'"; ?> value="1:<?= $uid ?>">Yes</option>
                          </select>
                          <br /><br />
                        <input type="submit" name="friend_app_submit" class="button1"  value="Done" />
                         <br /><br />	
					
                    <?php	
						
					   echo "Friends request for ";
					   
					   echo "<div>
						  <a href='$upath' target='_blank'>
						  <img src='$userimg' alt='photo' /><br>$username</a></div>";
					   
					   echo "</td>";
						  
						echo "<td nowrap='nowrap'>";
						  
												
						
						  ?>
						   <select name="frdyn">
                         	<option value="0:<?= $uid ?>">Ignore</option>
                         	<option value="1:<?= $uid ?>">Confirm</option>
                          </select>
                          <br /><br />
                        <input type="submit" name="frdsubmit" class="button1"  value="Done" />
                           <br /><br />
<span class="selbox">
<input type="checkbox" name="allfrd" onchange="selallfrd(this.value)" value="<?= $uid ?>" /> Select All Request</span>
						  <?php
						  echo "</td>";
						  
						  echo "<td>"; 
						
						
						$sql2 = 'select * from ' . $prefix.'community_connection WHERE connect_to = ' . $userlist['id'] . ' and status =0';

						$result2 = mysql_query($sql2,$link) or die(mysql_error());
						
						$myrow = mysql_affected_rows();
						 $uid = $userlist['id']; 
						  if($myrow>0)
						  {
							echo "<div id='scrdiv'>";   
							echo "<table border='1' >";
							  
							  echo "<tr  align='center'>
							  <td>Request From</td>
							  <td>Status</td>
							  </tr>";
							  
							while($data = mysql_fetch_array($result2))
							  {
							
							$sql3 = 'select name from ' . $prefix.'users WHERE id = ' . $data[1];
	
							$result3 = mysql_query($sql3,$link) or die(mysql_error());
							
							$data3 = mysql_fetch_array($result3);
							
							$rqtuser  = $data3['name'];
										  
								$url_rqt_u = $rootpath . "index.php?option=com_community&view=profile&userid=" . $data[1];
								  
								  echo "<tr  align='center'>";
								  echo "<td>";
								  
								  echo "<span class='selbox'>";
								  echo "<input type='checkbox' name='frd_" . $uid  . "[]' value='" . $data[0] . "'  />" ;
								  echo "</span>"; 
								  echo "<a target='_blank' href='" . $url_rqt_u . "' >"  . $rqtuser  . "</a></td><td>";
								  
								  echo ($data[3])?'Confirmed':'Never Confirm' ;
								  
								  echo "</td>";
								  
								  
								echo "</tr>";  
								  
								  
							  }
	
							
								  
							echo "</table>"; 
							echo "</div>";
						  }
						  
					   echo "</td></tr>";
					   echo "</form>";
					}
					echo "</table>";
			?>
    
    </td>
  </tr>
    

     <tr >
    <td colspan="4">
    
      <h1>User Time Bank</h1>
     
     <?php 
	 
	 if(isset($_REQUEST['limit'])) //setting time limit for a user
			{
				$timebank  = 0;
				$today = date("Y-m-d",time());
				$timelimit = $_REQUEST['limit'];
				$id = $_REQUEST['id'];
						
				$sql = 'UPDATE ' . $prefix.'users 
				
				SET timelimit = '. $timelimit
				 .' WHERE id = '.$id ;
				 
				 $_COOKIE["timebank_$id"] = 0;

				$result = mysql_query($sql,$link) or die(mysql_error());
			}
	 

					echo "<table border='1' id='tbl2' >
     
     <tr align='center'><td>User Name</td><td>Time Limit</td><td>Status</td>";
	 
	 echo "<td rowspan='2'>You can select how much time your child can spend on line per day.<br>

By selecting limited your child can login multiple times per day till the alloted time runs out.<br>

When your chid runs out of time it will give the child a 1 min warning before loging the child off.<br>

And will not reset till the next day cycle.<br>

Default is unlimited.</td></tr>";
	 				//$userarr = getuserlist($parentid);	
					foreach($userarr as $key=>$userlist)
					{
						
						$username = $userlist['name'];
						$uid = $userlist['id'];
						$uname = $userlist['username'];
						$upath = $rootpath. "index.php?option=com_community&view=profile&userid=$uid";
				        $userimg = $userthumb_arr["$key"];
					  
					 echo " <tr align='center'>
     
					 <td>How long Can ";
					 
					 echo "<div>
						  <a href='$upath' target='_blank'>
						  <img src='$userimg' alt='photo' /><br>$username</a></div>";
					 
					 echo "Be online for per day.</td>
				
					 <td>";
					
						  ?>
                       
         
                         Please set the time limit<br /><br />
                          <select name='optlimit' onChange="applimit(this.value,<?= $userlist['id'] ?>)">
                         <option value='99999'>Unlimited</option>
                          <option value='15' <?php if($userlist['timelimit']==15) echo " selected='selected'"; ?>>15 mins</option>
                          <option value='30' <?php if($userlist['timelimit']==30) echo " selected='selected'"; ?>>30 mins</option>
                          <option value='60' <?php if($userlist['timelimit']==60) echo " selected='selected'"; ?>>1 hour</option>
                          <option value='120' <?php if($userlist['timelimit']==120) echo " selected='selected'"; ?>>2 hours</option>
                          <option value='180' <?php if($userlist['timelimit']==180) echo " selected='selected'"; ?>>3 hours</option>
                          <option value='240' <?php if($userlist['timelimit']==240) echo " selected='selected'"; ?>>4 hours</option>
                          <option value='300' <?php if($userlist['timelimit']==300) echo " selected='selected'"; ?>>5 hours</option>
                          <option value='360' <?php if($userlist['timelimit']==360) echo " selected='selected'"; ?>>6 hours</option>
                          <option value='420' <?php if($userlist['timelimit']==420) echo " selected='selected'"; ?>>7 hours</option>
                          <option value='480' <?php if($userlist['timelimit']==480) echo " selected='selected'"; ?>>8 hours</option>
                          
                         </select>
    </td>
     
     <td>
     
     <?php 
    $tid =  $userlist['id'];
	$timelimit = ($userlist['timelimit'])? $userlist['timelimit']: '99999'; //demo
	$timebank = ($_COOKIE["timebank_$tid"])? $_COOKIE["timebank_$tid"] : '0'; //demo
	$lifetime = $timelimit - $timebank;
	
	//echo "<pre>";
	//print_r($_COOKIE);
	
	
if($timelimit=='99999')
{
	echo "<b>$username</b> has unlimited access.";
}
else
	{
		echo "You set time limit for <b>$username</b>: " . $timelimit . " minutes.<br>";
		if($lifetime>=1)
		 echo "Time left for todays: $lifetime minutes.<br>";
		else
		 echo "The user has been finished his time for today.<br>"; 

	}
?>
     
    

     </td>
     
     </tr>

<?php
					}
?>
     
     </table>
    
    </td>
    
    </tr>
    
    
     <tr >
    <td colspan="4">
     <h1>User Suspension</h1>
   
     <?php 
	 
	 if(isset($_REQUEST['suspend']))  //setting user suspension
			{
				$suspend  = $_REQUEST['suspend'];
				$id = $_REQUEST['id'];
						
				$sql = 'UPDATE ' . $prefix.'users 
				
				SET block = ' . $suspend.' WHERE id = '.$id ;

				$result = mysql_query($sql,$link) or die(mysql_error());
			}
		
					
					echo "<table border='1' id='tbl3'>
     
     <tr align='center'><td>User Name</td><td>Time Limit</td><td>Status</td>";
	 echo "<td rowspan='2'>In case you have to suspend your child account for any reason.<br>

The childs account will be intact but they will not be able to access or login Till you unsuspend.<br>

Default is unsuspend.</td></tr>";
                       //$userarr = getuserlist($parentid);
					   foreach($userarr as $key=>$userlist)
						{
						
 					    $username = $userlist['name'];
						$uid = $userlist['id'];
						$uname = $userlist['username'];
						$upath = $rootpath. "index.php?option=com_community&view=profile&userid=$uid";
				        $userimg = $userthumb_arr["$key"];
						  
						 echo " <tr align='center'>
		 
						 <td>Suspend ";
						 
						 echo "<div>
						  <a href='$upath' target='_blank'>
						  <img src='$userimg' alt='photo' /><br>$username</a></div>";
						 
						 echo "
					
						</td>
					
						 <td>";
						
							  ?>
				  
						   Suspend this user? <br /><br />
		 <select name='usersuspend' onChange="appsuspend(this.value,<?= $userlist['id'] ?>)">
		  <option value='0'>No</option>
		  <option value='1' <?php if($userlist['block']) echo " selected='selected'"; ?>>Yes</option>
		  
		 </select> 
							  
		</td>
		 
		 <td>
		 
		 <?php 
		 if($userlist['block'])
		 {
			 echo "Suspended User";
		 }
		 else
		 {
		   echo "Active User";
		 }
		
		 ?>
		 
		
	
		 </td>
		 
		 
		 </tr>

<?php					 
					}//foreach
?>
  
     </table>
    
    </td>
    
    </tr>
    
<tr >
    <td colspan="4">
     
     <h1>Parents Password</h1>
     
     <?php
	 if(isset($_POST['changepass']))  //changing password
	 {
		 $pass1 = $_POST['pass1'];
		 $pass2 = $_POST['pass2'];
			
			if($pass1==$pass2)
			 {
			 	//echo "Password valid.";
  			    
				  $salt = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 32);
				  $pass = md5($pass1.$salt) . ":" . $salt;			
				//echo "Pass: " . $pass . "len: " . strlen($salt);					
				
				$username = $_SESSION['myuser'];

				$sql= 'update ' . $prefix.'users set password = "' . $pass . '" WHERE username = "' . $username . '"';
        
			    $result = mysql_query($sql,$link) or die(mysql_error());
				if($result)
				 echo "Your password has been updated.";
			 }
			  else
			 {
				 echo "Password does not match.";
			 }

	 }
	 ?>
     
     <form action="" method="post">
     <table border="1" id="tbl4">
     <tr>
     
         <td>New password: <input required='required' type="password" class="pass1" name="pass1" size="25" /></td>
         <td>Please confirm new password: <input required='required'  type="password" class="pass2" name="pass2" size="25" /> <input type="submit" name="changepass" class="button1" value="Confirm" /></td>
         
         <td>In case you have to change your password for any reason.</td>
     </tr>
     </table>
     </form>
	</td>

</tr>        

   
  
</table>


<?php
include("footer.php");

?>
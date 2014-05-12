<?php include("includes/header.php"); 

 if(isset($_COOKIE['username']))
 {
  $_SESSION['myuser'] = $_COOKIE['username'];
  echo "<script>window.location='index.php';</script>";
 }
?>

<title>Project Manager</title>

<div style="margin-left: 2%" align="center">

    <div class='info' align="center">
        <?php 
         
        if(isset($_POST['login']))  //checking login information
        {
            
			$username = $_POST['username'];
            $password = md5($_POST['password']);
            
            //echo "$username : $password";
			
			$sql= 'select * from ' . ' admin WHERE username = "' . $username . '"';
        
			$result = mysql_query($sql,$link) or die(mysql_error());
									
			$data = mysql_fetch_array($result);
		    $dbpass = $data['password'];
			
						  
			  if (!$data['password']){
				  echo 'Invalid User Name!';
			  }else{

				if( $dbpass == $password ){
					
					if(isset($_POST['remember']))
						{
							$remember = $_POST['remember'];
							$username = $_POST['username'];
							setcookie("username",$username,time()+360*60*60);
							//echo $_COOKIE['username'];
						}	

				  $_SESSION['myuser'] = $username;
				  echo "<script>window.location='index.php';</script>";

				}else{
				  echo "Invalid password for $username.";
				}
			  }
			  
		}
	
        
        ?>
    </div><br />
<!-- Login from -->
    <form name="login" action="" method="post">
        <table>
        <tr>
         <td><b>User Name</b></td> <td>:</td>
         <td><input type="text" name="username" required='required'  size="30" /></td>
        </tr>
        
        <tr>
         <td><b>Password</b></td> <td>:</td>
         <td><input type="password" name="password" required='required'  size="30" /></td>
        </tr>
        
        <tr>
         <td></td> <td></td>
         <td><input type="checkbox" name="remember" /> <b>Remember Me</b></td>
        </tr>
        
        <tr align="center"><td colspan="3"><input type="submit" class="button1" name="login" value="Login" />
        </td></tr>
       </table> 
        </form> 
</div>


<?php include("includes/footer.php"); ?>
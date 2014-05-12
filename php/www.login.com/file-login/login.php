<?php 
include("header.php");
?>
<div style="margin-top: 13%; margin-left: 2%" align="center">

    <div class='error' align="center">
        <?php 
         
        if(isset($_POST['login']))  //checking login information
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
			
            $user = $config['adminuser'];
            $pass = $config['adminpass'];
			
			if($username != $user)
			 echo "Invalid user name!";
			else if ($password != $pass)
			 echo "Invalid password for admin!";
			else
			 {
				$_SESSION['myuser'] = $user;
				 echo "<script>window.location='cpanel.php';</script>";
			 }
 
		}
	
        
        ?>
    </div><br />
<!-- Login from -->
    <form name="login" action="" method="post">
        <table>
        <tr>
         <td>User Name</td> <td>:</td>
         <td><input type="text" name="username" size="30" /></td>
        </tr>
        
        <tr>
         <td>Password</td> <td>:</td>
         <td><input type="password" name="password" size="30" /></td>
        </tr>
        
        <tr align="center"><td colspan="3"><input type="submit" class="button1" name="login" value="Login" />
<input type="button" class="button1" value="Back" onclick="javascript: window.location.href='index.php';"  />
        </td></tr>
       </table> 
        </form> 
</div>
<?php 
include("footer.php");
?>
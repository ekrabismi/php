    <div id="profile_info">
    
    </div>  
    
     <a onclick="javascript: remavatar();" href="#">Remove Avatar</a>
     
 <form action="" method="post" enctype="multipart/form-data">

    <input type="submit" value="Change Avatar" name="ca" />
        
    <input type="file" name="avatar" />
    
   
 </form>
 
  <script>
  function remavatar()
  {
	  yn = confirm("Do you really want to remove this avatar?");
	  
	  if(yn)
	  {
		  window.location.href='?remove=avatar';
	  }
  }
 </script>
        
<?php 
 
 $user = $_SESSION['benuser'];
 $myroot = "http://localhost/project/client/Ben/www.speakserve.com/";
 
  if($_REQUEST['remove']=='avatar')
 {
   $des = "workspace/images/users/$user.png";
   if(file_exists($des))
   {
    unlink($des);
    $des = $myroot."myprofile/";
	echo "<script>window.location.href='" . $des . "';</script>";
   }
 }
 
 if($_POST['ca'])
 {
		 $des = "workspace/images/users/$user.png";
		 
		 $ftype = $_FILES['avatar']['type'];
		 
		 $ftype = explode("/",$ftype);
		 //$ftype[1] is file extention
		 if($ftype[0]!='image')
		 {
			 echo "<script>alert('Please select a image file.');</script>";
		 }
		 else
		 {
			copy($_FILES['avatar']['tmp_name'],$des); 
		 }
		 //echo "<h1>"; echo $ftype[0]; echo "</h1>";
 }
 
 
 $imgpath = "workspace/images/users/$user.png";
 
 if(file_exists($imgpath))
  $imgpath = $myroot. "workspace/images/users/$user.png";
 else 
  $imgpath = $myroot. "workspace/images/users/nophoto.png";
 
 $myhtml = "";
		 
 $myhtml .= "<img src='" . $imgpath . "' alt='user image' />";
 
 echo '<script>document.getElementById("profile_info").innerHTML = "' . $myhtml . '";</script>';
		 
?>        
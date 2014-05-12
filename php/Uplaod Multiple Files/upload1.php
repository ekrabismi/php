<form enctype="multipart/form-data" action="" method="POST">

   Upload Your Resume Here:<br />
            
            <input name="uploadedfile[]" type="file"/><br />
            <input name="uploadedfile[]" type="file"/><br />
            <input name="uploadedfile[]" type="file"/><br />
            <input name="uploadedfile[]" type="file"/><br />
            <input name="uploadedfile[]" type="file"/><br />
<input type="submit" value="Upload Now" name="submit" />
        </form>

         	
			<?php if($_REQUEST['submit'] == "Upload Now") {
			
			$target_path = "resume";
		
			if ($handle = opendir($target_path)) {
			$i=-1;
			while (readdir($handle)) 
			{
			 $i++;
			}
				//echo "number of dir: $i";		
			}
			else {
			echo "<h3 style='text-transform: capitalize; margin: 2px 0pt 10px; padding: 4px; color: #CC0000; background-color: #FFFFE8; display: inline-block; border: #CCC 1px solid; -moz-border-radius: 5px'>Error reading dir resume</h3>";
			}
						
			$target_path = "resume/$i";
			 if (is_dir($target_path)) 
			  {
			    
			  }
			  else
			  {
			   mkdir($target_path);
			   chmod($target_path, 0777); //set permission to rwx
			  }
	       
		  		   
		   $target_path = "resume/$i/" . basename( $_FILES['uploadedfile']['name'][0]);
		   
		   if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'][0], $target_path)) {
		   
		    echo "<h3 style='text-transform: capitalize; margin: 2px 0pt 10px; padding: 4px; color: #CC0000; background-color: #FFFFE8; display: inline-block; border: #CCC 1px solid; -moz-border-radius: 5px'>Your file has been uploaded.</h3>";
            
			 $_SESSION['resumeid']=$i;
			 }
			 
			else {
		   
		    echo "<h3 style='text-transform: capitalize; margin: 2px 0pt 10px; padding: 4px; color: #CC0000; background-color: #FFFFE8; display: inline-block; border: #CCC 1px solid; -moz-border-radius: 5px'>Error Uploading File.</h3>";
            
			 }
		
		$target_path = "resume/$i/" . basename( $_FILES['uploadedfile']['name'][1]);
		move_uploaded_file($_FILES['uploadedfile']['tmp_name'][1], $target_path);
		
		$target_path = "resume/$i/" . basename( $_FILES['uploadedfile']['name'][2]);
		move_uploaded_file($_FILES['uploadedfile']['tmp_name'][2], $target_path);
		
		$target_path = "resume/$i/" . basename( $_FILES['uploadedfile']['name'][3]);
		move_uploaded_file($_FILES['uploadedfile']['tmp_name'][3], $target_path);
		
		$target_path = "resume/$i/" . basename( $_FILES['uploadedfile']['name'][4]);
		move_uploaded_file($_FILES['uploadedfile']['tmp_name'][4], $target_path);

            }
			
			?>
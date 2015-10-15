<?php

$destination = "file/video/";
if (isset($_POST['submit']))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists($destination . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $destination . $_FILES["file"]["name"]);
      echo "Stored in: " . $destination . $_FILES["file"]["name"];
      }
    }
  }

?>

<form action="" method="post" enctype="multipart/form-data">
<label for="file"><span>Upload a video:</span></label>
<input type="file" name="file" accept="video/*" id="file" /> 
<br />
<input type="submit" name="submit" value="Upload" />
</form>
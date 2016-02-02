<?php

 session_start();

?>
<html>
<head>
  <title>Securimage Test Form</title>
</head>

<body>

<?php
if (empty($_POST)) { ?>
<form method="POST">


<!-- pass a session id to the query string of the script to prevent ie caching -->
<img id="image" src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>">
<a href="#" onclick="document.getElementById('image').src = 'securimage_show.php?sid=' + Math.random(); return false"><img src="images/refresh.gif" alt="Refresh" /></a>
<br />
<input type="text" name="code" /><br />

<input type="submit" value="Submit Form" />
</form>

<?php
} else { //form is posted
  include("securimage.php");
  $img = new Securimage();
  $valid = $img->check($_POST['code']);

  if($valid == true) {
    echo "<center>Thanks, you entered the correct code.</center>";
  } else {
    echo "<center>Sorry, the code you entered was invalid.  <a href=\"javascript:history.go(-1)\">Go back</a> to try again.</center>";
  }
}

?>

</body>
</html>

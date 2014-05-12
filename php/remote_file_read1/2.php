<?php // make sure the remote file is successfully opened before doing anything else
if ($fp = fopen('http://www.google.com', 'r')) {
   $content = '';
   // keep reading until there's nothing left
   while ($line = fgets($fp, 1024)) {
      $content .= $line;
	  
   }

   // do something with the content here
   // ...
    print $content;
} else {
   
   
   print 'Can\'t open the Google site.';
   // an error occured when trying to open the specified url
}
?>
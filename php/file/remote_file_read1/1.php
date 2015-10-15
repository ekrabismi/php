<?php // make sure the remote file is successfully opened before doing anything else
if ($fp = fopen('http://www.google.com.bd/', 'r')) {
   $content = '';
   // keep reading until there's nothing left
   while ($line = fread($fp, 1024)) {
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
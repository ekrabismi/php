<?php // make sure the remote file is successfully opened before doing anything else

//$content = file_get_contents('http://www.google.com/');
$content = file_get_contents('http://www.prothom-alo.net');
if ($content !== false) {
   // do something with the content
   print 'Successfully coplete the reading process.<br>';
   print $content;
} else {
   // an error happened
   print 'Can\'t open the Google site.';
}


?>
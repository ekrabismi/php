<?php // make sure the remote file is successfully opened before doing anything else

// make sure curl is installed
if (function_exists('curl_init')) {
   // initialize a new curl resource
   $ch = curl_init();

   // set the url to fetch
   curl_setopt($ch, CURLOPT_URL, 'http://www.google.com');

   // don't give me the headers just the content
   curl_setopt($ch, CURLOPT_HEADER, 0);

   // return the value instead of printing the response to browser
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

   // use a user agent to mimic a browser
   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

   $content = curl_exec($ch);

   // remember to always close the session and free all resources
   curl_close($ch);
} else {
   print 'Sorry curl not enabled.';
   // curl library is not installed so we better use something else
} 

?>
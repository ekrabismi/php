<?php
// JDR: who you are, and how many results you want
$myGooglePlusUser = "100982371482679333374";
$myGooglePlusMaxResults = 20;

// JDR: get your Google API key from the APIs Console: https://code.google.com/apis/console#access
$myGoogleAPIkey = "AIzaSyA6YCVmsHnO4RnDyx49iY-3BVmtiCQVIVE";
$myGooglePlusQuery = "https://www.googleapis.com/plus/v1/people/" . $myGooglePlusUser . "/activities/public?alt=json&maxResults=" . $myGooglePlusMaxResults . "&pp=1&key=" . $myGoogleAPIkey;

$myCacheFile = "me.json"; // JDR: name the cache file whatever you like
$myCacheCycle = "600"; // JDR: in seconds

// JDR: technically we don't need this really, but if you ever need other header info, this is the way
$setContextOptions = array(
'http'=> array(
'method'=>"GET"
)
);
$createContext = stream_context_create($setContextOptions);

// JDR: let's get our cache file, returns false if file does not exist
$getCacheFileModTime = @filemtime( $myCacheFile );

if ( !$getCacheFileModTime || ( time() - $getCacheFileModTime >= $myCacheCycle) )
{
// JDR: go get me some json, returns false if error
$getGooglePlusData = file_get_contents($myGooglePlusQuery, false, $createContext);
if ($getGooglePlusData) {
// write the JSON to file, return it to the caller
file_put_contents( $myCacheFile, $getGooglePlusData );
$outputJSON = $getGooglePlusData;
}
else {
// JDR: uh oh, we have a problem, write some simple error json to tell us on the frontend
$errorArray = array('error' => 'There was a problem getting data from the Google API, please try again.');
$outputJSON = json_encode($errorArray);
}
}
else
{
// JDR: get the cache file
$outputJSON = file_get_contents($myCacheFile);
}

// JDR: gzip it if we can
//ob_start('ob_gzhandler');
//header('Content-type: application/json');
$myarr = json_decode($outputJSON);
//echo "<pre>";
//print_r($myarr);
foreach($myarr->items as $arr)
{
	echo $arr->object->content . $arr->published;
	echo "<br>";
}

?>
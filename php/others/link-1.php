<?php
$html = '<p style="color: #38761d; font-family: verdana, sans-serif; font-size: 12.8000001907349px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; background-color: #ffffff;"><br class="Apple-interchange-newline" /></p>
<p style="color: #38761d; font-family: verdana, sans-serif; font-size: 12.8000001907349px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; background-color: #ffffff;">&nbsp;</p>
<div style="color: #38761d; font-family: verdana, sans-serif; font-size: 12.8000001907349px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; background-color: #ffffff;"><a style="color: #1155cc;" href="http://www.techjuice.pk/social-innovation-lab-maryam-mohiuddin/" target="_blank">
<div><img class="CToWUd" title="How one brave woman is changing the Social Enterprise game in Pakistan!" src="https://ci6.googleusercontent.com/proxy/Y0BUgwnFW86gEvz7tyzoSadst6Ots_TvU2OGQYg9XIJP2Md3Pk_lnSG3ZMmpRdzsENxNHvk7dDloVzkdiHeSJxLR9U5Hy7c7okeVWs9AF1XWgdDJ3YESDsThjhHuyjiwqx5gNQDQIxlJfSJAr6EfyQw=s0-d-e1-ft#http://images.outbrain.com/imageserver/v2/s/MUOe/n/14InGI/abc/10Ym4R/14InGI-SNp-109x109.jpg" alt="How one brave woman is changing the Social Enterprise game in Pakistan!" width="109" height="109" /></div>
<div>
<div>How one brave woman is changing the Social Enterprise game in Pakistan!</div>
<div><span>&nbsp;</span></div>
</div>
</a></div>
<p style="color: #38761d; font-family: verdana, sans-serif; font-size: 12.8000001907349px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; background-color: #ffffff;">&nbsp;</p>
<div style="color: #38761d; font-family: verdana, sans-serif; font-size: 12.8000001907349px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; background-color: #ffffff;"><a style="color: #1155cc;" href="http://www.techjuice.pk/cyber-crime-law-of-pakistan-mythbusting-the-prevention-of-electronic-crimes-act-2015-copy/" target="_blank">
<div><img class="CToWUd" title="Cyber Crime Law of Pakistan &ndash; Mythbusting the Prevention of Electronic Crimes Act 2015" src="https://ci4.googleusercontent.com/proxy/HO-JGbfY0IuKNvlSMxdR9h9608Y0HMa4qpkpWUCJLciRfSK8uWWlWaKq4N500T9uz1bsthBEoeOsCPx-4smf2lnLOF4oE_3PboGre-3fldDdQU0-SOo0V_kbuOU1TdTzElGh4po-KnVmrnj_clQAiUU=s0-d-e1-ft#http://images.outbrain.com/imageserver/v2/s/MUOe/n/14TeUh/abc/10Yn1s/14TeUh-SNp-109x109.jpg" alt="Cyber Crime Law of Pakistan &ndash; Mythbusting the Prevention of Electronic Crimes Act 2015" width="109" height="109" /></div>
<div>
<div>Cyber Crime Law of Pakistan &ndash; Mythbusting the Prevention of Electronic Crimes Act 2015</div>
</div>
</a></div><a href="http://homeshopping.pk" ><b>homeshopping.pk</b></a>
and 2nd is
<a href="http://whatmobile.com.pk" ><div>whatmobile</div></a>
 but panel automatically remove both links.';


//removing target

$html = str_replace('target="_blank"',"",$html);
$html = str_replace('target="_parent"',"",$html);
$html = str_replace('target="_self"',"",$html);
$html = str_replace('target="_top"',"",$html);
$html = str_replace('target="new"',"",$html);

//Finding the href

    $matched = array();

    $dom = new DOMDocument();
    @$dom->loadHtml($html);

    $length = $dom->getElementsByTagName('a')->length;

    for($i=0;$i<$length;$i++){
		
		$link = $dom->getElementsByTagName("a")->item($i)->getAttribute('href');
		$mask = 'homeshopping.pk';
        $found = strpos($link,$mask);
        
		if($found)
		{
		 //found homeshopping
		}
		else
		{
		 $matched[] = $link;
		}

    }

//echo "<pre>";
//print_r($matched);

//disabling the href

foreach ($matched as $key=>$value)
{
	$html = str_replace($value,"",$html);
}

//echo '<textarea role="30" cols="60">';

//removing empty href
$html = str_replace('href=""',"",$html);

echo $html;

//echo '</textarea>';

?>
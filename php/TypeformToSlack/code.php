<?php 

    date_default_timezone_set('America/Los_Angeles');
    mb_internal_encoding("UTF-8");

    $typeformApiKey='1f4c15d5cf00492226271e200c7a1d272a016440';
    $typeformFormId='sOUF1I';
    $typeformEmailField='email_19696215';
    $typeformNameField='textfield_19696213';
    $previouslyInvitedEmailsFile=__DIR__.'/previouslyInvitedEmails.json';

    // your slack team/host name 
    $slackHostName='wavfn';

    // find this when checking the post at  https://nomadslack.slack.com/admin/invites/full
    $slackAutoJoinChannels='C0HUVHC9J,C0HJCQ0V9,C0H2SJ9J8,C0HC39GD9,C0HSFUP2A,C0HC6B80N,C0H9Q3BEV,C0H2XMUAW,C0H2YC4C8,C0H2XP2QJ,C0H9PDL3V,C0HC26F6Z,C0H2XKMBL,C0SUNTZ2P,C0HQ3G76W';
    // generate token at https://api.slack.com/
    $slackAuthToken='xoxp-17095692357-31328824355-31347210211-53d48ad9b8';
	
	
	if(@!file_get_contents($previouslyInvitedEmailsFile)) {
        $previouslyInvitedEmails=array();
    }
    else {
        $previouslyInvitedEmails=json_decode(file_get_contents($previouslyInvitedEmailsFile),true);
    }
    $offset=count($previouslyInvitedEmails);

    $typeformApiUrl='https://api.typeform.com/v0/form/'.$typeformFormId.'?key='.$typeformApiKey.'&completed=true&offset='.$offset;

    if(!$typeformApiResponse=file_get_contents($typeformApiUrl)) {
        echo "Sorry, can't access API";
        exit;
    }

    $typeformData=json_decode($typeformApiResponse,true);

    $usersToInvite=array();
    foreach($typeformData['responses'] as $response) {
        $user['email']=$response['answers'][$typeformEmailField];
        $user['name']=$response['answers'][$typeformNameField];
        if(!in_array($user['email'],$previouslyInvitedEmails)) {
            array_push($usersToInvite,$user);
        }
    }
	
	
	//echo "<pre>";
	//print_r($user);
	
	$slackInviteUrl='https://'.$slackHostName.'.slack.com/api/users.admin.invite?t='.time();

    $i=1;
    foreach($usersToInvite as $user) {
        echo date('c').' - '.$i.' - '."\"".$user['name']."\" <".$user['email']."> - Inviting to ".$slackHostName." Slack<br />";

        // 
            $fields = array(
                'email' => urlencode($user['email']),
                'channels' => urlencode($slackAutoJoinChannels),
                'first_name' => urlencode($user['name']),
                'token' => $slackAuthToken,
                'set_active' => urlencode('true'),
                '_attempts' => '1'
            );

            // url-ify the data for the POST
                $fields_string='';
                foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                rtrim($fields_string, '&');

            // open connection
                $ch = curl_init();

            // set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $slackInviteUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

            // exec
                $replyRaw = curl_exec($ch);
                $reply=json_decode($replyRaw,true);
                if($reply['ok']==false) {
                    echo date('c').' - '.$i.' - '."\"".$user['name']."\" <".$user['email']."> - ".'Error: '.$reply['error']."<br />";
                }
                else {
                    echo date('c').' - '.$i.' - '."\"".$user['name']."\" <".$user['email']."> - ".'Invited successfully'."<br />";
                }

            // close connection
                curl_close($ch);

                array_push($previouslyInvitedEmails,$user['email']);

        // 
        $i++;
    }
	
	

?>
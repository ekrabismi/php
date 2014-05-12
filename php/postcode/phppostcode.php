<?php
/*==============================================================================
Application:   Utility Function
Author:        John Gardner

Version:       V1.0
Date:          25th December 2004
Description:   Used to check the validity of a UK postcode

Version:       V2.0
Date:          8th March 2005
Description:   BFPO postcodes implemented.
               The rules concerning which alphabetic characters are alllowed in 
               which part of the postcode were more stringently implementd.
  
Version:       V3.0
Date:          8th August 2005
Description:   Support for Overseas Territories added            
  
Version:       V3.1
Date:          23rd March 2008
Description:   Problem corrected whereby valid postcode not returned, and 
							 'BD23 DX' was invalidly treated as 'BD2 3DX' (thanks Peter 
               Graves)              
  
Version:       V4.0
Date:          7th October 2009
Description:   Character 3 extended to allow 'pmnrvxy' (thanks to Jaco de Groot)            
  
Parameters:    $postcode - postcode to be checked. This is returned reformatted 
               if valid.

This function checks the value of the parameter for a valid postcode format. The 
space between the inward part and the outward part is optional, although is 
inserted if not there as it is part of the official postcode.

The functions returns a value of false if the postcode is in an invalid format, 
and a value of true if it is in a valid format. If the postcode is valid, the 
parameter is loaded up with the postcode in capitals, and a space between the 
outward and the inward code to conform to the correct format.
  
Example call:
  
    if (!checkPostcode ($postcode) ) {
      echo 'Invalid postcode <br>';
    }
                    
------------------------------------------------------------------------------*/
function checkPostcode (&$toCheck) {

  // Permitted letters depend upon their position in the postcode.
  $alpha1 = "[abcdefghijklmnoprstuwyz]";                          // Character 1
  $alpha2 = "[abcdefghklmnopqrstuvwxy]";                          // Character 2
  $alpha3 = "[abcdefghjkpmnrstuvwxy]";                            // Character 3
  $alpha4 = "[abehmnprvwxy]";                                     // Character 4
  $alpha5 = "[abdefghjlnpqrstuwxyz]";                             // Character 5
  
  // Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
  $pcexp[0] = '^('.$alpha1.'{1}'.$alpha2.'{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';

  // Expression for postcodes: ANA NAA
  $pcexp[1] =  '^('.$alpha1.'{1}[0-9]{1}'.$alpha3.'{1})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';

  // Expression for postcodes: AANA NAA
  $pcexp[2] =  '^('.$alpha1.'{1}'.$alpha2.'{1}[0-9]{1}'.$alpha4.')([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';
  
  // Exception for the special postcode GIR 0AA
  $pcexp[3] =  '^(gir)(0aa)$';
  
  // Standard BFPO numbers
  $pcexp[4] = '^(bfpo)([0-9]{1,4})$';
  
  // c/o BFPO numbers
  $pcexp[5] = '^(bfpo)(c\/o[0-9]{1,3})$';
  
  // Overseas Territories
  $pcexp[6] = '^([a-z]{4})(1zz)$/i';

  // Load up the string to check, converting into lowercase
  $postcode = strtolower($toCheck);

  // Assume we are not going to find a valid postcode
  $valid = false;
  
  // Check the string against the six types of postcodes
  foreach ($pcexp as $regexp) {
  
    if (ereg($regexp,$postcode, $matches)) {
			
      // Load new postcode back into the form element  
		  $postcode = strtoupper ($matches[1] . ' ' . $matches [3]);
			
      // Take account of the special BFPO c/o format
      $postcode = ereg_replace ('C\/O', 'c/o ', $postcode);
      
      // Remember that we have found that the code is valid and break from loop
      $valid = true;
      break;
    }
  }
    
  // Return with the reformatted valid postcode in uppercase if the postcode was 
  // valid
  if ($valid){
	  $toCheck = $postcode; 
		return true;
	} 
	else return false;
}
?>
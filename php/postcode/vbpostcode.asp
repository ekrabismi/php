<%
'=============================================================================='

' Application:   Utility Function
' Author:        John Gardner
' Date:          20th December 2004
' Description:   Used to check the validity of a postcode
' QueryString:   None
' Version:       V1.0

' Version:       V2.0
' Date:          8th March 2005
' Description:   BFPO postcodes implemented.
'                The rules concerning which alphabetic characters are alllowed  
'                in which part of the postcode were more stringently implementd.
  
' Version:       V3.0
' Date:          8th August 2005
' Description:   Support for Overseas Territories added            
  
' Version:       V3.1
' Date:          15th January 2009
' Description:   Problem corrected whereby valid postcode not returned, and 
'							   'BD23 DX' was invalidly treated as 'BD2 3DX' (thanks Peter 
'                Graves)            
  
' Version:       V4.0
' Date:          7th October 2009
' Description:   Character 3 extended to allow 'pmnrvxy' (thanks Jaco de Groot)         

' Required routines:          None

' This routine checks the value of the form element specified by the parameter
' for a valid postcode.

' If the element is a valid postcode, the function value is returned as TRUE
' and the postcode is returned in uppercase with the separating space in the 
' right place.
                    
'------------------------------------------------------------------------------'

function Check_Postcode (byRef strPostcode)

  Dim strPostcodeRegExp(6)   ' holds the regular expressions for valid postcodes
  Dim intCount               ' For loop counter
  Dim strPostcodeCopy        ' Copy of postcode
  
  ' Variables used to hold regular expression object		
  Dim objRegExp, objMatches, objMatch
  
  ' Variables to hold list of valid letterrs for various parts of the post code.
  Dim strAlpha1, strAlpha2, strAlpha3, strAlpha4, strAlpha5
  
  ' Set up letters valid in thge various postcode positions
  strAlpha1 = "[abcdefghijklmnoprstuwyz]"                          ' Character 1
  strAlpha2 = "[abcdefghklmnopqrstuvwxy]"                          ' Character 2
  strAlpha3 = "[abcdefghjkpmnrstuvwxy]"                            ' Character 3
  strAlpha4 = "[abehmnprvwxy]"                                     ' Character 4
  strAlpha5 = "[abdefghjlnpqrstuwxyz]"                             ' Character 5
  
  ' Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA
  strPostcodeRegExp(0) = "^(" + strAlpha1 + "{1}" + strAlpha2 + "{0,1}[0-9]{1,2})([0-9]{1}" + strAlpha5 + "{2})$"

  ' Expression for postcodes: ANA NAA
  strPostcodeRegExp(1) = "^(" + strAlpha1 + "{1}[0-9]{1}" + strAlpha3 + "{1})([0-9]{1}" + strAlpha5 + "{2})$"

  ' Expression for postcodes: AANA  NAA
  strPostcodeRegExp(2) = "^(" + strAlpha1 + "{1}" + strAlpha2 + "{1}[0-9]{1}" + strAlpha4 + "{1})([0-9]{1}" + strAlpha5 + "{2})$"
  
  ' Exception for the special postcode GIR 0AA
  strPostcodeRegExp(3) = "^(gir)(0aa)$"
  
  ' Standard BFPO numbers
  strPostcodeRegExp(4) = "^(bfpo)([0-9]{1,4})$"
  
  ' c/o BFPO numbers
  strPostcodeRegExp(5) = "^(bfpo)(c\/o[0-9]{1,3})$"
  
  ' Overseas territories
  strPostcodeRegExp(6) = "^([A-Z]{4})(1ZZ)$"

  ' Copy the parameter and convert into lowercase
  strPostcodeCopy = Lcase(strPostCode)
  
  ' Assume we're not going to find a valid postcode
  Check_Postcode = false
  
  ' Strip out spaces
  strPostcodeCopy = Replace (strPostcodeCopy, " ", "")
  Check_Postcode = False
  
  Set objRegExp = New RegExp
  
  ' Check the string against valid types of post codes
  For intCount = 0 to Ubound(strPostCodeRegExp)
  
    ' Check next pattern in list
    objRegExp.Pattern =  strPostcodeRegExp(intCount) 
    If objRegExp.Test (strPostcodeCopy) Then
    
      ' Post code found. Ensure input parameter is in correct format.
      Set objMatches = objRegExp.Execute (strPostcodeCopy)
      Set objMatch = objMatches(0)
      strPostcodeCopy = Ucase (objMatch.subMatches (0)) & " " &  Ucase (objMatch.subMatches (1))
      
      ' Take account of the special BFPO c/o format
      strPostcodeCopy = Replace (strPostcodeCopy, "C/O", "c/o ")
      
      ' Show that we have found the postcode
      Check_Postcode = True
    End if
  Next
  
  ' Ensure that the uppercase postcode gets returned if valid
  If Check_Postcode Then strPostcode = strPostcodeCopy
  
End Function
%>

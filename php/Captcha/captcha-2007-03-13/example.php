<?php

  /******************************************************************

   Projectname:   CAPTCHA class
   Version:       2.0
   Author:        Pascal Rehfeldt <Pascal@Pascal-Rehfeldt.com>
   Last modified: 15. January 2006

   * GNU General Public License (Version 2, June 1991)
   *
   * This program is free software; you can redistribute
   * it and/or modify it under the terms of the GNU
   * General Public License as published by the Free
   * Software Foundation; either version 2 of the License,
   * or (at your option) any later version.
   *
   * This program is distributed in the hope that it will
   * be useful, but WITHOUT ANY WARRANTY; without even the
   * implied warranty of MERCHANTABILITY or FITNESS FOR A
   * PARTICULAR PURPOSE. See the GNU General Public License
   * for more details.

   Description:
   Testsuit for the CAPTCHA Class

  ******************************************************************/

  session_start();

  $goto = $_GET['goto'];

  if (isset($goto) == FALSE)
  {

    $goto = 'form';

  }

echo '<?xml version="1.0"?>';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

    <title>Test for the CAPTCHA Class</title>

  </head>

  <body>

    <?php

      if ($goto == 'form')
      {

        //Formular

        ?>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?goto=login" method="post">

            <img src="./captcha.php?.png" alt="CAPTCHA" />

            <br />

            <input type="text" name="captchastring" size="30" /> (cAse SeNSItivE!)

            <br />

            <input type="submit" value="Compare" />

          </form>

        <?php

      }
      else if ($goto == 'login')
      {

        //Check if userinput and CAPTCHA String are equal

        if ($_SESSION['CAPTCHAString'] == $_POST['captchastring'])
        {

          echo 'Strings are equal.';

        }
        else
        {

          echo 'Strings are not equal.';

        }

      }
      else
      {

        echo 'Unknown target: ' . $goto;

      }

    ?>

  </body>

</html>
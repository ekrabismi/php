{\rtf1\ansi\ansicpg1252\cocoartf1038\cocoasubrtf320
{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
\margl1440\margr1440\vieww18060\viewh9640\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\ql\qnatural\pardirnatural

\f0\fs24 \cf0 \
Messaging System\
Version 1.1\
Developed by Hartanto Thio - http://www.hartantothio.com/\
\
\
CHANGELOG\
=================================\
\
version 1.1 (07/06/2010)\
- Fixed messages not in "Trash" after being deleted.\
\
\
INTRODUCTION\
=================================\
\
Messaging System was created with "Simple and Easy Integration" in mind. What this mean is that you can easily integrate this application into your existing website. With version 1.0, I have included all the features that I believe are necessary for the Messaging System application. Following are some highlights of the features of the application:\
\
1. Address Book\
2. Multiple recipients\
3. Rich Text Editor (WYSIWYG)\
4. Saving message as draft\
5. Trash for deleted messages. Once in trash, users can choose to delete completely or recover the messages.\
6. Forwarding and Replying messages\
7. User Registration\
\
In the future, the will be more functionalities added to the application to enhance the user experience. Aside from these features, there are other "hidden features" that have been embedded into the application:\
\
1. Extra layer of security\
2. All our pages are validated through W3C for XHTML/CSS, which means you can use this application "as is"\
3. Packaged with Simple and Yet nice admin template.\
\
With the purchase, I have included a page to edit user's profile. This page is not available in the demo page.\
\
REQUIREMENTS\
=================================\
- Server that supports PHP and MySQL.\
- Client's browser must support JavaScript to take advantage of the great user experience\
\
\
INSTALLATION INSTRUCTIONS\
=================================\
1. Unzip the zip file and upload it to your web server\
2. Run the SQL command found in the db folder. Use phpMyAdmin to easily create the database structures\
3. The application comes with 2 default accounts.\
     - username: johndoe, password: 12341234\
     - username: janedoe, password: 12341234\
4. Before you can start using the application, 2 more changes you need to make. No worry, I'll show you what they are.\
     - In the "includes" folder, open the "functions.php" file (you can use a notepad to do this). Once opened, find the lines that has the following:\
	$hostname = '';\
	$db_user = '';\
	$db_password = '';\
	$db_name = '';\
\
	Please edit these four lines based on your database information.\
\
	After you make changes to the database credentials, scroll down to find the following lines:\
\
	function encrypt($str, $key = 'YOUR_KEY')\
	and\
	function decrypt($str, $key = 'YOUR_KEY')\
\
	Please change "YOUR_KEY" to your own unique key to for encryption purposes. You should not share this key with other people.\
\
	NOTE: The key must match for both functions or application will not work as it should.\
  \
     - In the "includes" folder, open the "commons.php" file. Find the following line:\
	date_default_timezone_set('America/Chicago');\
\
	Please change the timezone to your server timezone. You can view list of supported timezone here: http://php.net/manual/en/timezones.php\
5. You are ready to use the application\
6. Contact or leave comment if you have any questions\
\
\
IN-DEPTH PHP EXPLANATION\
=================================\
I have included the documentation file in the documentation folder. If you want to get a more in-depth information on some of the functionalities, you can check the documentation file. Please feel free to email me for any questions that you may have.}
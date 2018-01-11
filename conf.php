<?

	//configuration file for sign-in sheet 

   $host="localhost"; //name of the database host
   $usernamw="root"; //database username
   $password=""; //password
   
   //database name: give the name of the database where u created entry_detail table
   $dbname="signindb"; //databasename

   define(ENTRY_TABLE,"entry_detail");
   
   //set this variable to FALSE if you want to display only a certain number of entries of sign in sheet.
   
   $display_single_page=FALSE; 
		//if above variable is FALSE following number of entries will be displayed at once.
		$display=5;

	
	//admin login and password for deleting entries required for page admin.php
  $admin_login="admin";
  $admin_password="admin";

?>

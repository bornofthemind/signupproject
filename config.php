<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=signindb", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

 define(ENTRY_TABLE,"entry_detail");
   
   //set this variable to FALSE if you want to display only a certain number of entries of sign in sheet.
   
   $display_single_page=FALSE; 
		//if above variable is FALSE following number of entries will be displayed at once.
		$display=5;

	
	//admin login and password for deleting entries required for page admin.php
  $admin_login="admin";
  $admin_password="admin";

?>
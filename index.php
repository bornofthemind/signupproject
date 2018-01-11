<?php
	
	require_once("conf.php");
	require_once("signin.php");
	require_once("db.class.php");
    $ss="signin";

function display_navigation($start,$num_pages) {
	// this function is used to display navigation bar to navigate to different pages if display_single_page is set to FALSE in configuration file
	print "<div class='page_nav'>\n";
	print "<div class='total'>Total Entries: ".$GLOBALS['gb']->total."</div>";
	print "		<div class='page'> Pages:&nbsp;&nbsp;&nbsp;</div>\n";
	print"		<div class='page_no'>";
				if($start > 1  && $start <=$num_pages)
	print"			<a href='".$_SERVER['PHP_SELF']."?start=".($start-1)."' class='pages'>Prev&lt;&lt;</a>&nbsp;&nbsp;\n";
				for($j=1;$j<=$num_pages;$j++) {
					if($start==$j)
	print"			<a href='".$_SERVER['PHP_SELF']."?start=".$j."' class='current'>".($j)."</a>&nbsp;&nbsp;\n";
					else
	print"			<a href='".$_SERVER['PHP_SELF']."?start=".$j."' class='pages'>".($j)."</a>&nbsp;&nbsp;\n";
				 }
				 if(!isset($start) || $start <=0)
					$l=1;
				else
					$l=$start+1;
				if($l<=$num_pages)
	print"			<a href='".$_SERVER['PHP_SELF']."?start=".$l."' class='pages'>&gt;&gt;Next</a>&nbsp;\n";
	print"			</div>\n";
	print"</div>\n";
	}



print <<<HTML_HEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<link rel="stylesheet" href="{$ss}.css" type="text/css">
		<title>Sign-in Sheet</title>
	</head>
	<body>

		<div class='top_nav'>
    		<div class='gb_title'>Sign-in Sheet</div>
		    	<div class='top_nav_link'>
		        	<div class='title_link'><a href='{$_SERVER['PHP_SELF']}' class='title_link'>View Visitor</a>&nbsp;&nbsp;| &nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?action=add' class='title_link'>Sign-in</a>
					</div>
		        </div>
		     </div>

HTML_HEADER;


	global $db;
	$db=new db($dbname,$host,$username,$password);
	$ss=new SignInSheet();
	if(!isset($_GET['start']))
		$start=1;
    else
	   $start=$_GET['start'];

	$action=$_GET['action'];
	$submit=$_POST['submit'];
	if(($submit=="submit") || ($submit=="Submit"))  {
		$error="";
		$ok=true;
		if(trim($_POST['entry_name'])==""){
			$ok=false;
			$error .="Enter your name <br>";
		}
		if(trim($_POST['entry_email'])==""){
			$ok=false;
			$error .="Enter your email address <br>";
		}
		if(trim($_POST['entry_comments'])==""){
			$ok=false;
			$error .="Enter comments/suggestions <br>";
		}
		$ss->entry_dob=$_POST['entry_dob'];
			$ss->entry_location=$_POST['entry_location'];
			$ss->entry_author=$_POST['entry_name'];
			$ss->entry_email=$_POST['entry_email'];
			$ss->entry_url=$_POST['entry_website'];
			$ss->entry_comments=$_POST['entry_comments'];
			$ss->referer=$_POST['entry_referer'];
			$ss->entry_ip=$_SERVER['REMOTE_ADDR'];
		if($ok) {
			$ss->entry_id=$ss->next_id();
			//$this->entry_title=$_POST[''];
			
			$ss->add_entry();
			$ss->update_total();
			$action='list';
		 } else {
			$action='add';

		 }


	}

	
		switch($action) {
	
			case "add":
					  
					  $ss->display_add_form($error);
					  break;
			
			case "s":
					$id=$_GET['id'];
					if($ss->retrieve_entry($id)) {
						$ss->display_entry();

					} else {
						print" No Such Entry Exists";

					}
					break;
			case "d":
				    $id=$_GET['id'];
					if($ss->delete_entry($id)) 
						print"Entry Deleted Succefully";
					else
						print"unable to delete Entry";
			case "list":
			default:
				   if($ss->total > 0) { 
						if(!$display_single_page) {
						/* if(display_single_page is set to False calculate total number of pages to display
							$display number of  entries on a single page 
						*/
                        
				         // calculate total number of pages
						 if ($ss->total > $display) {// More than 1 page.
							$num_pages = ceil ($ss->total/$display);
						 } else {	
							$num_pages = 1;
						 }
	 					 
						 display_navigation($start,$num_pages);

					     if(!isset($start) || $start <=0)
					         $start=1;
							 $s=($start-1)*$display;
							 if($s>$ss->total) 
							     $s=0;
						  	$ss->display_n_entries($s,$display);
							display_navigation($start,$num_pages);
						 } else {
						
							$ss->display_n_entries(-1,-1);

					     }
			       } else {
						print"<div class='message'>The Sign-in sheet is empty.</div>";	
                   }
					break;



		}
	

print <<<FOOTER

</body>
</HTML>
FOOTER;






?>

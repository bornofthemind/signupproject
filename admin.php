<?php


	require_once("config.php");
	require_once("signin.php");
	require_once("db.class.php");
	//session_save_path("../tmp/");
	@session_start();
	
	function admin_header() {
	 print"<html>\n";
                print"<head><title>Sign-in Sheet Admin</title>\n";
                print"<link rel=\"stylesheet\" href=\"signin.css\" type=\"text/css\">\n";
                print"</head>\n";
                print"<body>\n";
	 
	 print "
	<table  border='0' cellspacing='0' cellpadding='0' align='center' class='top_nav_admin' width='100%'>
    <tr>
        <td class='title'><div align='center'>Administration Page </div></td>
    </tr>
    <tr aign='center'>
        <td align='center'><a href='admin.php' class='title_link'>Home</a> &nbsp;&nbsp;|
        &nbsp;&nbsp;<a href='admin.php?action=logout' class='title_link'>Logout</a> </div></td>
        
    </tr>
</table>

   ";
	    
	    
	}
	$action=$_GET['action'];
	
    //session_save_path("tmp/");
    if($action=='logout') {
        unset($login);
        session_unregister('login');
        session_destroy();
        
    }
	
	$message="";
    if(isset($_SESSION['login']))
    {
          admin_header();
		  $db=new db($database,$host,$user,$password); 
		  $admin_gb=new GuestBook();
		  if($action=="edit") {
				  
			      
			      $id=$HTTP_GET_VARS['edit'];
			      $admin_gb->retrieve_entry($id);
				  print "<form ACTION='".$_SERVER['PHP_SELF']."' METHOD='POST'>\n";
				  print "<table BORDER=0 CELLSPACING=1 CELLPADDING=1 width='60%' CLASS='edit_entry'>\n";
		          print "<caption><div class='small1black'>Edit Entry</div></caption>\n";
				  print "<tr bgcolor='#FFFFFF'>\n";
				  print "   <td ALIGN='RIGHT' class='datablack' width='20%'><strong>Name</strong></td>\n";
	              print "   <td align='left'> <input class='text' NAME='entry_author' TYPE='TEXT'  VALUE='".$admin_gb->entry_author."'";
                  print " CLASS='text'></td>\n";
                  print "</tr>\n";
                  print "<tr bgcolor='#FFFFFF' >\n";
                  print "   <td ALIGN='RIGHT' class='datablack'> <strong>Email</strong> </td>\n";
                  print "   <td align='left'> <input class='text' NAME='entry_email' TYPE='TEXT' VALUE='".$admin_gb->entry_email."'";
                  print " CLASS='text'></td>\n";
                  print "</tr>\n";
                  print "<tr bgcolor='#FFFFFF'>\n";
                  print "   <td ALIGN='RIGHT' class='datablack'><strong>Referrer</strong></td>\n";
                  print "   <td align='left'> <input class='text' NAME='entry_referer' TYPE='TEXT'  VALUE='".$admin_gb->referer."'";
                  print " CLASS='text'></td>\n";
                  print "</tr>\n";
                  print "<tr bgcolor='#FFFFFF'>\n";
                  print "    <td ALIGN='RIGHT' class='datablack'><strong>Birth Date</strong></td>\n";
                  print "    <td align='left'><input class='text' NAME='entry_dob' TYPE='TEXT'  VALUE='".$admin_gb->entry_dob."'";
                  print " CLASS='text'></td>\n";
                  print "</tr>\n";
                  print "<tr bgcolor='#FFFFFF'>\n";
                  print "   <td ALIGN='RIGHT' class='datablack'><strong>Location</strong> </td>\n";
                  print "    <td align='left'><input class='text' NAME='entry_location' TYPE='TEXT'  VALUE='".$admin_gb->entry_location."'";
                  print " CLASS='text'></td>\n";
                  print "</tr>\n";
                  
                  print "<tr bgcolor='#FFFFFF'>\n";
                  print "   <td ALIGN='RIGHT' class='datablack'><strong>Website</strong> </td>\n";
                  print "    <td align='left'><input class='text' NAME='entry_website' TYPE='TEXT'  VALUE='".$admin_gb->entry_url."'";
                  print " CLASS='text'></td>\n";
                  print "</tr>\n";
                  print "<tr bgcolor='#FFFFFF'>\n";
                  print "   <td ALIGN='RIGHT' class='datablack'><strong>Comments</strong> </td>\n";
                  print "    <td align='left'><textarea  class='text' name='entry_comments' cols='25' rows='5'>".$admin_gb->entry_comments."</textarea>";
                  print " </td>\n";
                  print "</tr>\n";
          
          
          
          
          print "</table>\n";
	      print "<input NAME='id' TYPE='HIDDEN' VALUE='".$admin_gb->entry_id."'>\n";
          print "<input NAME='submit' TYPE='SUBMIT' VALUE='Update' CLASS='btn1'>\n";
	     
	      print "<input NAME='submit' TYPE='SUBMIT' VALUE='Cancel' CLASS='btn1'>\n";
          print "</form>\n";
		  unset($edit);
	    } 
		 $submit=$_POST['submit'];
		 switch(strtolower($submit)) {
			case "update":
				
 				$admin_gb->entry_id=$_POST['id'];
 		     		$admin_gb->entry_dob=$_POST['entry_dob'];
             		        $admin_gb->entry_location=$_POST['entry_location'];
				$admin_gb->entry_author=$_POST['entry_author'];
				$admin_gb->entry_email=$_POST['entry_email'];
				$admin_gb->entry_url=$_POST['entry_website'];
				$admin_gb->entry_comments=$_POST['entry_comments'];
				$admin_gb->referer=$_POST['entry_referer'];
				if($admin_gb->modify_entry()) {
					$message="Selected Entry Modified Succesfully";

				} else {
					$message="Error while updating selected Entry";
				}
				break;
			case "delete":
					$ids=$_POST['entryids'];
					for($i=0;$i<sizeof($ids);$i++) {
						print"<br>Deleting .".$ids[$i]."<br>";
						$admin_gb->delete_entry($ids[$i]);
					}
					$message="Selected Entries Deleted Succesfully";
				    break;
			default:
			}
			



		
		
	$sql = "Select * from ".ENTRY_TABLE." 	order by entry_date DESC";
	$result=$db->query($sql);
	
	  if($admin_gb->total >0)
		           {
				        
						print "<form action='admin.php' method='post'>\n";
						print "<table BORDER=0 CELLSPACING=1 CELLPADDING=3 class='admin_list'>\n";
		                print "    <tr class='admin_list_top'><!-- header -->\n";
			            print "       <td ALIGN='CENTER' >&nbsp;</td>\n";
				        print "       <td ALIGN='CENTER' NOWRAP>&nbsp;</td>\n";
						print "       <td>Name</td>\n";
			            print "       <td>Email</td>\n";
			            print "       <td >Location</td>\n";
			            print "       <td ALIGN='CENTER' NOWRAP >Date Signed</td>\n";
				        print "       <td>Comments</td>\n";
						print "       <td> IP Address</td>\n";
		                print "    </tr>\n";
				        while($data=mysql_fetch_object($result)) {
						 
							print "    <tr class='admin_list_data'>\n";
							print "       <td  ALIGN='CENTER'>\n";
							print "           <input NAME='entryids[]' TYPE='CHECKBOX' VALUE='".$data->entry_id."'>\n";
		                    print "       </td>\n";
				            print "       <td  ALIGN='CENTER' VALIGN='middle' NOWRAP>\n";
						    print "          <a HREF='".$_SERVER['PHP_SELF']."?action=edit&edit=".$data->entry_id."' class='small1'>Edit</a>\n";
		                    print "       </td>\n";
				            print "       <td NOWRAP class='datablack'>\n";
                            print($data->entry_author);
						 	print "  	 </td>\n";
  							print "       <td   class='datablack'>\n";
	                        print($data->entry_email); 
			                print "       </td>\n";
				          	print "       <td   ALIGN='CENTER' VALIGN='TOP' NOWRAP class='datablack'>\n";
	                        print($data->entry_location); 
						    print "       </td>\n";
			                print "       <td ALIGN='CENTER' VALIGN='TOP' NOWRAP class='datablack'>\n";
	                        print($data->entry_date);
				            print " 	     </td>\n";
 						    print "       <td  class='datablack' >\n";
	                        print($data->entry_comments);
		 	                print "       </td>\n";
			                print "       <td class='datablack' >\n";
                            print($data->entry_ip);
					        print "       </td>\n";
				            print "    </tr>\n";
					    }  
		                print "</table>\n";
				        print "<input type='submit' value='Delete' name='submit' class='btn1'>\n";
						print "</form>\n";
                
					}else {
						//if there is no entry in the Sheet
						print "<div class='error'>The Sheet is empty.";
         		    }  
               
		       } else {
            
            
			if($HTTP_POST_VARS['submit']=="Login") {
			    $login=$HTTP_POST_VARS['login'];
                $password=$HTTP_POST_VARS['password'];
                if($login==$admin_login && $password==$admin_password) { 
                    @session_start();
		            $_SESSION['login']="$login";
		            header("Location:admin.php?code=1");
                 } else { 
				     header("Location:admin.php?code=4");
				 }
                
                
        }  else {
                
				
                admin_header();
				if(isset($code) && $code==4)
					print("<font color='red'><b>Invalid Id/Password </b></font>");
				print "<form action='admin.php' method='post'>\n";
                print "    <table BORDER=0 CELLSPACING=0 CELLPADDING=3 CLASS='tbl2' align='left'>\n";
                print "    <caption><font SIZE=-1>Sign In To Administration</font></caption>\n";
                print "    <tr>\n";
	            print "        <td><font SIZE=-2>USER ID:</font></td>\n";
	            print "        <td><input NAME='login' TYPE='TEXT'></td>\n";
	            print "    </tr>\n";
	            print "    <tr>\n";
	            print "        <td><font SIZE=-2>PASSWORD:</font></td>\n";
	            print "        <td><input NAME='password' TYPE='PASSWORD'></td>\n";
	            print "    </tr>\n";
	            print "    <tr>\n";
	            print "        <td>&nbsp;</td>\n";
	            print "        <td><input NAME='submit' TYPE='SUBMIT' VALUE='Login' CLASS='btn'></td>\n";
	            print "    </tr>\n";
	            print "    </table>\n";
                print "</form>\n";
            }
            
        }

        
print "</body></html>";        
?>    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

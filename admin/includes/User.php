<?php
/**
 * Heurex Rental 0.0
 * User.php
 * 03.05.2012
 */         
class User{
	var $id;
	var $user_id;
	var $username;
	var $username0;
	var $password;
	var $password0;
	var $password1;
	var $password2;
	var $name;
	var $email;
	var $oikeustaso;
	var $tunniste;
	var $location;
	var $locationname;
	var $project;
	var $phone;
	var $information;
	var $location_name;
	var $project_name;
	var $cadmin_name;
	var $test;
	
	public function User(){
		$this->id = "";
		$this->username = "";
		$this->password0 = "";
		$this->password1 = "";
		$this->password2 = "";
		$this->name = "";
		$this->email = "";
		$this->oikeustaso = 0;
		$this->tunniste = $_SESSION["kayttajatunniste"];
		$this->location = "";
		$this->aktivointi ="";
		$this->locationname = "";
		$this->project = "";
		$this->phone = "";
		$this->information = "";
  		$this->cadmin = "0";
  		$this->changeday = time();
  		$this->location_name = "";
		$this->project_name = "";
		$this->cadmin_name = "";
	}
	
	public function TestAll(){
		$ok = 1;
		if (!isset($_SESSION['Search']))
			$_SESSION['Search'] = new Search();
			
		if($_SESSION['Search']->TestText($this->username)=="1"){
			$ok = 0;
		}	
		return $ok;
	}
	
	/**
	 * Read user name
	 */
	public function GetUserName($in_id){
		$this->ReadUser($in_id);
		$output = $this->name;    
		return $output;
	}
	public function ReadUser($in_id){
		if (!isset($db))
 			$db = new Database();
 			
 		$this->id = $in_id;
 		
 		$sql = "SELECT * FROM users WHERE id = '$this->id'";
 		
		if ($this->id != ""){
			$haku = $db->AskSQL($sql);
		
			$rows = mysql_num_rows($haku);
			$rivi = mysql_fetch_row ($haku);
			
			if (mysql_num_rows($haku) > 0){
				$this->id = $rivi[0];
				$this->user_id = $rivi[0];
				$this->username = stripslashes(nl2br($rivi[1]));
				$this->username0 = stripslashes(nl2br($rivi[1]));
				$this->password = $rivi[2];
				$this->password0 = $rivi[2];
				$this->password1 = $rivi[2];
				$this->password2 = $rivi[2];
				$this->name = stripslashes(nl2br($rivi[3]));
				$this->email = stripslashes(nl2br($rivi[4]));
				$this->oikeustaso = $rivi[5];
				$this->tunniste = $rivi[6];
				$this->location = $rivi[7];
				$this->aktivointi = $rivi[8];
				$this->project = $rivi[9];
				$this->phone = stripslashes(nl2br($rivi[10]));
				$this->information = stripslashes(nl2br($rivi[11]));
				$this->cadmin = $rivi[12];
				$this->changeday = $rivi[13];
				$this->location_name = $rivi[14];
				$this->project_name = $rivi[15];
				$this->cadmin_name = $rivi[16];
			}		
		}
		
		$this->information = str_replace("<br />", "", $this->information);
		
		$this->TestAll();
			
		$output = "";
				
		return $tulos;
	}
	
	/**
	 * Test print user information
	 */
	public function PrintUser(){
		print "id: $this->id<br>\n";
		print "username: $this->username<br>\n";
		print "password0: $this->password0<br>\n";
		print "password1: $this->password1<br>\n";
		print "password2: $this->password2<br>\n";
		print "name: $this->name<br>\n";
		print "email: $this->email<br>\n";
		print "oikeustaso: $this->oikeustaso<br>\n";
		print "location: $this->location<br>\n";
		print "aktivointi: $this->aktivointi<br>\n";
		print "project: $this->project<br>\n";
		print "phone: $this->phone<br>\n";
		print "information: $this->information<br>\n";		
		print "cadmin: $this->cadmin<br>\n";
		print "changeday: $this->changeday<br>\n";		
		print "location_name: $this->location_name<br>\n";
		print "project_name: $this->project_name<br>\n";
		print "cadmin_name: $this->cadmin_name<br>\n";
	}
	
	/**
	 * user dropdawn
	 */
	public function UserDropDown($user_id,$cname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
 		$output = "<select name=\"$cname\">\n";
		$sql = "SELECT * FROM `users` ORDER BY username";
		//print "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($user_id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[3]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[3]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}	
	
	/**
	 * Activation status
	 */
	public function ActivationDropDown($aktivointi){
 		
 		$output = "<select name=\"aktivointi\">\n";
		if ($aktivointi == 100){
			$output = $output . "<option value =\"0\">Not activated</option>\n";
			$output = $output . "<option value =\"100\" selected>Activated</option>\n";
		} else {
			$output = $output . "<option value =\"0\" selected>Not activated</option>\n";
			$output = $output . "<option value =\"100\">Activated</option>\n";
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}

	public function ShowUsers($location, $locationname){
		
		if (!isset($db))
			$db = new Database();
			
		if (!isset($project))
			$projects = new Projects();
				
		if (!isset($locations))
			$locations = new Location();
			
		$page2 = $_SESSION['Search']->page2;	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if ($page2 == "searchform"){
			$sql = $_SESSION['Search']->sql_user;
		} else {	
			$sql = "SELECT * FROM users ORDER BY location, username";
			       
			if ($oikeus < 99)
				$sql = "SELECT * FROM users WHERE location = $location ORDER BY location, username";
		}
			
		//print "$page2 $sql<br>";
		
		if($locationname=="All"){
			$output2 = "User list";
		} else {
			$output2 = "$locationname users";
		}
		
		$tmp_user="<a href=\"index.php?page=user&page2=searchform&product=user&order_user=";
		
		
		$output = "<table width=\"850\"><tr><td colspan=\"9\" class=\"td_phonelistheader\">";
		$output = $output . "<a href=\"classes/excel.php?name=$output2&cols=6&col1=0&col2=3&col3=4&col4=5&col5=14&col6=15&";
		$output = $output . "coln1=ID&coln2=Name&coln3=E-mail address&coln4=User rights&coln5=Location&coln6=Project&sql=$sql\">";
		$output = $output . "<img src=\"pictures/excel.gif\" border=\"0\" title=\"Excel\"></a>&nbsp;";	
		$output = $output . "$output2</td></tr>\n";
		$output = $output . "<tr><td class=\"td_phonelistheader\" colspan=\"1\">" . $tmp_user . "name\">Name</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_user . "email,username\">E-mail address</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_user . "oikeustaso,username\">User rights</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_user . "location_name,username\">Location</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_user . "project_name,username\">Project</a></td>";
		
		if ($oikeus > "1"){
			$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">Edit</td>";
		}
		
		$output = $output . "</tr>\n";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0)
     	{
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				$row = $rivi[5];
				
				if ($row == 1)
					$status = "Normal";
				
				if ($row == 0){
					$status = "Not activated useraccount";
				} else {
					if ($row > 1 && $row < 99)	{
						$loc = $locations->ReadLocation($row);
						$status = "$loc admistrator";
						$location = "$row";
					}
					if ($row == 99)
						$status = "Admin";
						//$status = "System administrator";
				}
				
				/*
				if (($rivi[8] != 100) && ($rivi[1] != "")){
					if (($oikeus > "1") || (isset($_SESSION["LogInUser"]->location) == $rivi[7])){
						$aktivointi = "<a href=\"index.php?page=user&user_id=$rivi[0]&activation=1\"><img src=\"pictures/aktivoi.gif\" border=\"0\"></a>\n";
					} else {
						$aktivointi = "<img src=\"pictures/eiaktivoitu.gif\" border=\"0\">";
					}		
				}
				
				
				if (($rivi[8] == 100) && ($rivi[1] != ""))
					$aktivointi = "<img src=\"pictures/aktivoitu.gif\" border=\"0\">";
				*/	
				$kayttajapoisto = "";
				$kayttajapaivitys = "";
				$username = $rivi[1];
				if (($oikeus > "1") || (isset($_SESSION["LogInUser"]->location) == $rivi[7])){
					if ($oikeus > "1"){
						$kayttajapoisto = "<a onclick=\"return confirmSubmitUSER()\" href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&delete=1\"><img src=\"pictures/poista2.gif\" border=\"0\" title=\"Delete user\"></a>";
						$toiminnot = "<a href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&edit=1\"><img src=\"pictures/update2.gif\" border=\"0\" title=\"Update information\"></a>&nbsp;$kayttajapoisto\n";
					} else {
						$kayttajapoisto = "";
						$toiminnot = "Not shown";		
					}
					
					if ($this->id == $rivi[0])
						$kayttajapoisto = "";		
				}
			
				//$temp = $projects->ReadProject($rivi[9]);
				$temp = "<a href=\"index.php?page=project&id=$rivi[9]&project_id=$rivi[9]&show=1\">$rivi[15]</a>";	
				//$temp2 = $locations->ReadLocation($rivi[7]);
				$temp2 = "<td class=\"td_phonelistrow\" colspan=\"1\"><a href=\"index.php?page=location&id=$rivi[7]&location_id=$rivi[7]&show=1\">$rivi[14]</a>&nbsp;</td>";			

				if ($rivi[1] != NULL)
					$output = $output . "<tr><td class=\"td_phonelistrow\">&nbsp;<a href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&show=1\">$rivi[3]</a>&nbsp;</td><td class=\"td_phonelistrow\"><a href=\"mailto:$rivi[4]\">$rivi[4]&nbsp;</a></td>";
					//<td class=\"td_phonelistrow\">$rivi[10]&nbsp;</td>
					$output = $output . "<td class=\"td_phonelistrow\">$status</td>$temp2<td class=\"td_phonelistrow\">$temp&nbsp;</td>\n";
				
				if ($oikeus > "1")
					$output = $output . "<td class=\"td_editdellistrow\">$toiminnot</td>";
				
				$output = $output . "</tr>";
			}
		} else {
			$output = $output . "<tr><td colspan=\"6\" class=\"td_phonelistrow\">No users!</td></tr>";
		}
		
		$output = $output . "</table>";
		/*
		if ($oikeus > "1"){
			$output = $output . "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
			$output = $output . "<td class=\"tab\"><a href=\"index.php?page=user&id=''&location=$location&new=1\">&nbsp;New&nbsp;</a></td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "</tr></table>\n";
		}
		*/
		print "$output";
	}
	
	/**
	 * Register
	 */
	public function NewUserAccount(){
		
		if (!isset($project))
			$projects = new Projects();
					
		if (!isset($locations))
			$locations = new Location();
				 	
		$this->username0 = $_POST["username0"];
		$this->password1 = $_POST["password1"];
		$this->password2 = $_POST["password2"];
		$this->name = $_POST["name"];
		$this->email = $_POST["email"];
		$this->location = "";
		$this->changeday = date("Y-m-d H:i:s",time());
		
		if ($this->location == "")
			$this->location = 1;
			
		print "Lang" & $lang;
		
		print "<table width=\"850\"><tr><td colspan=\"6\"><center><img src=\"" . DIR_PICTURES . "/registration.gif\" border=\"0\"><br><br>\n";
		print "By filling this form you can register yourself to Tila-Autot.com,<br>the lending system, which keeps cars information globally in Tila-Autot.Com.</td></tr></table>\n";
		print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\" width=\"850\">";
		print "<form action=\"index.php\" method=\"post\" name=\"register\">\n" .
		"<input type=\"hidden\" name=\"password\" value=\"\">\n" .
		"<input type=\"hidden\" name=\"newregister\" value=\"1\">\n" .
		"<input type=\"hidden\" name=\"aktivointi\" value=\"100\">\n" .
		"<input type=\"hidden\" name=\"oikeustaso\" value=\"1\">\n" .
		"<input type=\"hidden\" name=\"page\" value=\"user\">\n" .
		"<input type=\"hidden\" name=\"page2\" value=\"registration\">\n" .
		"<input type=\"hidden\" name=\"save\" value=\"1\">\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Loging name:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"username0\" size=\"50\" value=\"$this->username0\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Full name:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"name\" size=\"50\" value=\"$this->name\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Password:</td><td class=\"tab2\" colspan=\"2\"><input type=\"password\" name=\"password1\" size=\"50\" value=\"$this->password1\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Password again:</td><td class=\"tab2\" colspan=\"2\"><input type=\"password\" name=\"password2\" size=\"50\" value=\"$this->password2\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Address:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"address\" size=\"50\" value=\"$this->address\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Post office:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"postoffice\" size=\"50\" value=\"$this->postoffice\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Phone 1:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"phone1\" size=\"50\" value=\"$this->phone1\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Phone 2:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"phone2\" size=\"50\" value=\"$this->phone2\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">E-mail address:</td><td class=\"tab2\" colspan=\"2\"><input type=\"text\" name=\"email\" size=\"50\" value=\"$this->email\">\n";
		print "</td></tr>\n";
		print "<tr><td class=\"tab1\" colspan=\"1\">Lending location:</td><td class=\"tab2\" colspan=\"2\">\n";
		print $locations->LocationDropDown("$this->location");
		print "</td></tr></table>\n";
		print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\" width=\"850\">\n<tr>\n";
		print "<td class=\"tab\" colspan=\"1\">";
		print "<div><input type=\"submit\" value=\"Talleta\" id=\"el09\"></div></td><td><a href=\"index.php\"><img src=\"" . DIR_PICTURES . "/logo01.gif\" border=\"0\"></a></td>\n";
		print "<td class=\"tab\" colspan=\"1\">&nbsp;</td>\n";
		print "</form>";
		print "</tr></table>";
	}
	
	/**
	 * Edit User
	 */
	public function EditUser($in_id, $location2, $thing){

		$this->id = $in_id;
		$this->user_id = $in_id;
		$this->location2 = $location2;
		$this->thing = $thing;
		
		if (!isset($project))
			$projects = new Projects();
					
		if (!isset($locations))
			$locations = new Location();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		if (!isset($user2))
			$user2 = new User();	
				 	
	 	$this->location = $_GET["location"];
	 		 	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;

		
		//print "$this->id, $this->location2, $this->thing<br>";

		if (isset($_GET["ed"])=="1"){
			//$this->$id = $in_id;
			$this->username = $_POST["username0"];
			$this->password0 = $_POST["password0"];
			$this->password1 = $_POST["password1"];
			$this->password2 = $_POST["password2"];
			$this->name = $_POST["name"];
			$this->email = $_POST["email"];
			$this->oikeustaso = $_POST["oikeustaso"];
			$this->tunniste = $_POST["tunniste"];
			$this->location = $_POST["location"];
			$this->aktivointi = $_POST["aktivointi"];
			$this->locationname = $_POST["locationname"];
			$this->project = $_POST["project"];
			$this->phone = $_POST["phone"];
			$this->information = $_POST["information"];
			$this->cadmin = $_SESSION["LogInUser"]->id;
			
		} else {
			$this->ReadUser($this->id);
		}
		
		//$this->changeday = date("Y-m-d H:i:s",$this->changeday);
		
		//print "$this->id<br>";
		
		if (isset($_GET["copy2new"])=="1"){
			$this->id = "";
			$thing = "new";
			$this->location ="";
			$this->project = "";
			//$this->cadmin = $_SESSION["LogInUser"]->id;
			//$this->changeday = date("Y-m-d H:i:s",time());																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																															$in_id, 
		}
		
		if (($thing == "edit") || ($thing == "new")){
			$this->changeday = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
		}
		
		//$this->PrintUser();
		
		/**
		 * Activated?
		 */
		if (($this->aktivointi != 100) && ($this->username != "")){
			if (($oikeus == $this->oikeustaso) || ($oikeus == 99) || (isset($_SESSION["LogInUser"]->location) == $this->location)){
				$aktivointi = "<img src=\"pictures/" + $lang + "aktivoi.gif\" border=\"0\">\n";
			} else {
				$aktivointi = "<img src=\"pictures/" + $lang + "eiaktivoitu.gif\" border=\"0\">\n";
			}		
		}
		
		if (($this->aktivointi == 100) && ($this->username != ""))
			$aktivointi = "<img src=\"pictures/" + $lang + "aktivoitu.gif\" border=\"0\">";
					
			print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">";
			
			if ($thing == "edit"){
				print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Edit user</td></tr>";
				print "<form action=\"index.php\" method=\"post\" name=\"updateuser\">\n";
				print "<input type=\"hidden\" name=\"page2\" value=\"updateuser\">\n";
				print "<input type=\"hidden\" name=\"id\" value=\"$this->id\">";
				print "<input type=\"hidden\" name=\"user_id\" value=\"$this->id\">";
			}
		
			if ($thing == "new"){
				print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Add user</td></tr>";
				print "<form action=\"index.php\" method=\"post\" name=\"newuser\">\n";
				print "<input type=\"hidden\" name=\"page2\" value=\"newuser\">\n";
			}
			
			if ($thing != "edit" && $thing != "new"){
				print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">User info</td></tr>";
			} else {
				print "<input type=\"hidden\" name=\"page\" value=\"user\">\n";
				print "<input type=\"hidden\" name=\"location\" value=\"$this->location\">";
				print "<input type=\"hidden\" name=\"password0\" value=\"$this->password0\">";
			}
			
			//print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">";
			
			if ($this->id != ""){
				print "<tr><td class=\"tab1\" colspan=\"1\">User id number:</td><td class=\"tab2\" colspan=\"2\">$this->id</td></tr>\n";
			}
			
			print "<tr><td class=\"tab1\" colspan=\"1\">Name:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<input type=\"text\" name=\"name\" size=\"40\" value=\"$this->name\">";
			} else {
				print "$this->name&nbsp;";
			}
					
			print "</td></tr>\n";
			
			print "<tr><td class=\"tab1\" colspan=\"1\">User id:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<input type=\"text\" name=\"username0\" size=\"40\" value=\"$this->username\">";
			} else {
				print "$this->username&nbsp;";
			}
			
			print "</td></tr>\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<tr><td class=\"tab1\" colspan=\"1\">Password:</td><td class=\"tab2\" colspan=\"2\">\n";
				print "<input type=\"password\" name=\"password1\" size=\"40\" value=\"\"><br>";
			} else {
				print "<tr><td class=\"tab1\" colspan=\"1\">Password:</td><td class=\"tab2\" colspan=\"2\">\n";
				print "*******************";
			}
			
			print "</td></tr>\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<tr><td class=\"tab1\" colspan=\"1\">Password again:</td><td class=\"tab2\" colspan=\"2\">\n";
				print "<input type=\"password\" name=\"password2\" size=\"40\" value=\"\">";
				print "</td></tr>\n";
			}
	
			print "<tr><td class=\"tab1\" colspan=\"1\">E-mail address:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<input type=\"text\" name=\"email\" size=\"40\" value=\"$this->email\">";
			} else {
				print "$this->email&nbsp;";
			}
					
			print "</td></tr>\n";
			
			print "<tr><td class=\"tab1\" colspan=\"1\">Phone number:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<input type=\"text\" name=\"phone\" size=\"40\" value=\"$this->phone\">";
			} else {
				print "$this->phone&nbsp;";
			}
					
			print "</td></tr>\n";
			
			print "<tr><td class=\"tab1\" colspan=\"1\">User rights:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				if ($oikeus > "1"){
					print $this->AdminRightsDropDown($this->oikeustaso,"1");
				} else {
					print "<input type=\"hidden\" name=\"oikeustaso\" size=\"40\" value=\"$this->oikeustaso\">";
					print $this->AdminRightsDropDown($this->oikeustaso,"0");	
				}
			} else {
				print $this->AdminRightsDropDown($this->oikeustaso,"0") . "&nbsp;";
				print "<input type=\"hidden\" name=\"oikeustaso\" size=\"40\" value=\"$this->oikeustaso\">";
			}
			
			print "</td></tr>\n";
			print "<tr><td class=\"tab1\" colspan=\"1\">Location:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print $locations->LocationDropDown($this->location);
				print "</td></tr>\n";
			} else {
				print $this->location_name . "&nbsp;"; //$locations->ReadLocation($this->location) . "&nbsp;";
			}
			
			print "</td></tr>\n";
			print "<tr><td class=\"tab1\" colspan=\"1\">Project:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print $projects->ProjectDropDown($this->project, "");
			} else {
				print "$this->project $this->project_name&nbsp;";
			}
			
			print "</td></tr>\n";
			
			print "<tr><td class=\"tab1\" colspan=\"1\">Information:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (($thing == "edit") || ($thing == "new")){
				print "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>";
			} else {
				print "$this->information&nbsp;";
			}
			
			print "</td></tr>\n";
			
			print "<tr><td class=\"tab1\" colspan=\"1\">Last change:</td><td class=\"tab2\" colspan=\"2\">\n";
			
			if (!isset($user2))
				$user2 = new User();
				
			$this->changeday = $fixdate->ReturnDate($this->changeday);
			$temp = date("Y-m-d",$this->changeday);
			print "$this->cadmin_name $temp";
	
			if (($thing == "edit") || ($thing == "new")){
				print "</td></tr></table>";
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				print "<td class=\"tab\" colspan=\"1\">";
				
				print "<div><input type=\"submit\" value=\"Submit\" id=\"el09\"></div></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				
				print "<td class=\"tab\" colspan=\"1\"></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n</tr>\n";
				print "</form>";
				print "</td></tr></table>";
			} else {
				print "</td></tr></table>";
				if (($_SESSION['LogInUser']->id==$this->id)||($oikeus > "1")) {
					print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
					print "<td class=\"tab\"><a href=\"index.php?page=user&id=$this->id&user_id=$this->id&edit=1\">&nbsp;Edit&nbsp;</a></td>\n";

					if ($oikeus > "1"){
						print "<td class=\"tab\">&nbsp;</td>\n";
						print "<td class=\"tab\">&nbsp;</td>\n";
						print "<td class=\"tab\">";
						print "</td>\n";
						print "<td class=\"tab\"><a onclick=\"return confirmSubmitUSER()\" href=\"index.php?page=user&id=$this->id&user_id=$this->id&delete=1\">&nbsp;Delete&nbsp;</a></td>\n";
	
					} else {
						print "<td class=\"tab\" colspan=\"4\">&nbsp;</td>\n";
					}
					print "</tr></table>\n";
				}
			}		
	}
	
	/**
 	 * Activate user
 	 */
	public function UserActivate($id){
		if (!isset($db))
			$db = new Database();
			
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$sql = "SELECT * FROM users WHERE id = '$id' AND aktivointi < '100'";
		$haku = $db->AskSQL("$sql");
		$tulos = mysql_fetch_row($haku);
		
		//print "$sql<br>$oikeus = $tulos[5]<br>";
		
		if (($oikeus == $tulos[5]) || ($oikeus == 99) || (isset($_SESSION['LogInUser']->location) == $tulos[7])){	

			if (mysql_num_rows($haku) > 0){
				$sql = "UPDATE users SET aktivointi = '100', oikeustaso = '1' WHERE id = '$id'";
				//print "$sql<br>";
				$db->UseSQL("$sql");
				$output = 0;
			}
			
			if (mysql_num_rows($haku) < 1){
				$output = "1";
			}
		} else {
			$output = "2";
		}
		return $output;
	}

	/**
	 * User rights dropdown
	 */
	public function AdminRightsDropDown($oikeustaso,$show){
		 		
		if ($show == "1"){
			$i1 = "<option value =\"1\">Normal user</option>\n";
 			$i2 = "<option value =\"99\">Administrator</option>\n";
 			
			if ($this->oikeustaso == 1)
				$i1 = "<option value =\"1\" selected>Normal user</option>\n";
			
			if ($this->oikeustaso == 99)
				$i2 = "<option value =\"99\" selected>Administrator</option>\n";
					
 			$output = "<select name=\"oikeustaso\">\n";
		
  			$output = $output . "$i1 $i2";  
		
			$output = $output . "</select>\n";
			
		} else {
			
			if ($this->oikeustaso == 1)
				$output = "Normal user\n";
			
			if ($this->oikeustaso == 99)
				$output = "Administrator\n";	
		}
		return $output;
	}
		
	/**
	 * Check user data
	 */
	public function CheckUser(){
		$output = 0;
		//print "username "; 
		
		if (!preg_match("/^[a-öA-Ö0-9_]{1,254}$/",$this->username)) { 
			$output = "10";
			return $output;
    	}
    	
		//print "password1 "; 	
		if ($this->password1!="" && $_SESSION['Search']->CheckText($this->password1,11) == 11) { 
			$output = "11";
			return $output;
		}	
		
		//print "password2 "; 	
		if ($this->password2!="" && $_SESSION['Search']->CheckText($this->password2,12) == 12) { 
			$output = "12";
			return $output;
		}	
		
		//print "name "; 
		if ($_SESSION['Search']->CheckText($this->name,13) == 13) { 
			$output = "13";
			return $output;
		}

		//print "Email "; 
		$pattern = "^([a-öA-Ö0-9\.|-|_]{1,60})([@])";
		$pattern .="([a-öA-Ö0-9\.|-|_]{1,60})(\.)([A-Za-z]{2,3})$";
		
		if ($this->email!="" && ereg($pattern,$this->email)) { 
	  	} else {
	    	$output = "14"; 
	    	return $output;
    	}
    	
		if ($this->phone!="" && !preg_match("/^([0-9+\-\+]{0,30})$/",$this->phone)) { 
			$output = "15";
			return $output;
    	}
		
 		if ($this->information!="" && $_SESSION['Search']->CheckText($this->information,16) == 16) { 
			$output = "16";
			return $output;
		}	
		
	 	if ($this->location == "0" || $this->location == "") { 
			$output = "17";
			return $output;
		}	
		return $output;
	}
	
	/**
	 * Get names
	 */
	public function GetNames(){
			
		if (!isset($locations2))
			$locations2 = new Location();
			
		if (!isset($project2))
			$projects2 = new Projects();
			
		if (!isset($user2))
			$user2 = new User();
			
		$this->location_name = $locations2->ReadLocation($this->location);
		$this->project_name = $projects2->ReadProject($this->project);
		$user2->ReadUser($this->cadmin);	
		$this->cadmin_name = $user2->name;	
	}
	
	/**
	 * Add new user to database
	 */
	public function AddUser(){
		if (!isset($db))
			$db = new Database();
			
		/**
		 * Checks and makes admin user
		 */
		$this->MakeAdminUser();
		
		$_POST["aktivointi"] = "100";
			
		if ($_POST["oikeustaso"]=="" || $_POST["oikeustaso"]=="0")
			$_POST["oikeustaso"]="1";
					
		$this->username = mysql_real_escape_string($_POST["username0"]);
		$this->password0 = $_POST["password0"];
		$this->password1 = $_POST["password1"];
		$this->password2 = $_POST["password2"];
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->email = mysql_real_escape_string($_POST["email"]);
		$this->oikeustaso = $_POST["oikeustaso"];
		$this->tunniste = $_POST["tunniste"];
		$this->location = $_POST["location"];
		$this->aktivointi = $_POST["aktivointi"];
		$this->locationname = mysql_real_escape_string($_POST["locationname"]);
		$this->project = $_POST["project"];
		$this->phone = mysql_real_escape_string($_POST["phone"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());
		
		$this->GetNames();
		
		$check_user = $this->CheckUser();
		if ($check_user!=0){
			return $check_user;
		}
	   
		$sql = "SELECT * FROM users WHERE username = '$this->username'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "4";
			return $output;
		}
		
		$sql = "SELECT * FROM users WHERE email = '$this->email'";
		$haku = $db->AskSQL("$sql");
				
		if (mysql_num_rows($haku) > 0){
			$output = "1";
			return $output;
		}
		
		if (($this->password1 == "") || ($this->password2 == "") || ($this->username == "") || ($this->name == "") || ($this->email == "") || ($this->location == "")){
			$output = "2";
			return $output;
		}
		
		if ($this->password1 != $this->password2){
			$output = "3";
			return $output;
		}
		
		$this->password = md5($this->password1);
		
		$sql = "INSERT INTO users (username, password, name, email, oikeustaso, " .
		"location, aktivointi, project, phone, information, cadmin, changeday, location_name, project_name, cadmin_name) " .
		"VALUES ('$this->username' , '$this->password', '$this->name', '$this->email', " .
		"'$this->oikeustaso', '$this->location', '$this->aktivointi', '$this->project', " .
		"'$this->phone', '$this->information', '$this->cadmin', NOW(), '$this->location_name', '$this->project_name', '$this->cadmin_name')";
			
		$tulos = $db->UseSQL($sql);
		$this->SearchNewst();
		$output = "0";
		
		return $output;
	}
	
	/**
	 * Search the newst
	 */
	public function SearchNewst(){
		if (!isset($db))
			$db = new Database(); 
		$db->Database();
 		
		$output = "";
		$sql = "SELECT MAX(id) FROM `users`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
		}
	}
		
	public function UpdateUser($in_id){
		if (!isset($db))
			$db = new Database();
			
		$this->id = $in_id;
		$this->user_id = $in_id;
		$this->username = mysql_real_escape_string($_POST["username0"]);
		$this->password0 = $_POST["password0"];
		$this->password1 = $_POST["password1"];
		$this->password2 = $_POST["password2"];
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->email = mysql_real_escape_string($_POST["email"]);
		$this->oikeustaso = $_POST["oikeustaso"];
		$this->tunniste = $_POST["tunniste"];
		$this->location = $_POST["location"];
		$this->aktivointi = $_POST["aktivointi"];
		$this->locationname = mysql_real_escape_string($_POST["locationname"]);
		$this->project = $_POST["project"];
		$this->phone = mysql_real_escape_string($_POST["phone"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());
		$this->GetNames();

		$check_user = $this->CheckUser();
		if ($check_user!=0){
			return $check_user;
		}
		
		if (($this->password1 !="" || $this->password2 !="") && $this->password1 != $this->password2){
			$output = "3";
			return $output;
		}
			
		if ($this->password1 !="" && $this->password2 !=""){	
			$this->password1 = md5($this->password1);
			$this->password2 = md5($this->password2);
		}
		
		$sql = "SELECT * FROM users WHERE username = '$this->username' AND id NOT LIKE '$this->id'";
		
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "4";
			return $output;
		}
		
		$sql = "SELECT * FROM users WHERE email = '$this->email' AND id NOT LIKE '$this->id'";
			
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "1";
			return $output;
		}
		
		if (($this->username == "") || ($this->name == "") || ($this->email == ""))	{
			$output = "2";
			return $output;
		}
		
		if ($this->password1 != ""){			
			$sql = "UPDATE users SET username = '$this->username', password = '$this->password1', name = '$this->name', email = '$this->email', oikeustaso = '$this->oikeustaso', " .
			"tunniste = '$this->tunniste', location = '$this->location', project = '$this->project', phone = '$this->phone', " .
			"information = '$this->information', cadmin = '$this->cadmin', changeday = '$this->changeday', location_name='$this->location_name', " .
			"project_name='$this->project_name', cadmin_name='$this->cadmin_name' WHERE id = '$this->id'";
		}	
		
		if ($this->password1 == ""){
			$sql = "UPDATE users SET username = '$this->username', name = '$this->name', email = '$this->email', oikeustaso = '$this->oikeustaso', " .
			"tunniste = '$this->tunniste', location = '$this->location', project = '$this->project', phone = '$this->phone', " .
			"information = '$this->information', cadmin = '$this->cadmin', changeday = '$this->changeday', location_name='$this->location_name', " .
			"project_name='$this->project_name', cadmin_name='$this->cadmin_name'  WHERE id = '$this->id'";
		}
		
		$tulos = $db->UseSQL($sql);
	
		$output = "0";
		return $output;
	}
	
	/**
	 * Delete user
	 */ 
	public function DeleteUser($id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
 		$output = $this->CheckBeforeDelete($id);
 		if($output=="0"){
			/**
		 	* Copy to deleted
		 	*/
			$this->DeletedUser($id);	
		
			$sql = "DELETE FROM users WHERE id = '$id'";
			$db->UseSQL("$sql");
		}
		return $output;
	}
	
	/**
	 * Copy user to deleted
	 */
	public function DeletedUser($in_id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
 		$this->ReadUser($in_id);
		
		if ($id != ""){
		    /**
		 	 * Delete user from database
		 	 */
			$sql = "INSERT INTO deleted_users (id, username, password, name, email, oikeustaso, location, " .
			"project, phone, information, cadmin, changeday, location_name, project_name, cadmin_name) VALUES ('$this->id', '$this->username', " .
			"'$this->password', '$this->name', '$this->email', '$this->oikeustaso', '$this->location', " .
			"'$this->project', '$this->phone', '$this->information', '$this->cadmin', '$this->changeday', " .
			"'$this->location_name', '$this->project_name', '$this->cadmin_name')";
				
			$tulos = $db->UseSQL($sql);		
		}		
	}
	
	/**
	 * Search the newst
	 */
	public function CheckBeforeDelete($in_user){
		if (!isset($db))
			$db = new Database(); 
			
		$db->Database();
						
		$sql = "SELECT * FROM projects WHERE manager = '$in_user'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = $rivi[2];
			return "10";
		}
		
		$sql = "SELECT * FROM phones WHERE iperson = '$in_user'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id: " . $rivi[0]." " . $rivi[1] ." " . $rivi[2];
			return "11";
		}
		
		$sql = "SELECT * FROM sims WHERE iperson = '$in_user'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id: " . $rivi[0]." " . $rivi[1] ." " . $rivi[2];
			return "12";
		}
		
		$sql = "SELECT * FROM accessories WHERE iperson = '$in_user'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id: " . $rivi[0]." " . $rivi[2] ." " . $rivi[3];
			return "13";
		}
		
		$sql = "SELECT * FROM flash_adapters WHERE iperson = '$in_user'"; // OR cadmin = '$in_user'
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id: " . $rivi[0]." " . $rivi[1] ." " . $rivi[2];
			return "14";
		}
					
		return 0;
	}
	
	public function UpdateOtherUser($username, $name, $email, $location, $oikeustaso, $id, $project, $phone, $information){
		$haku = $db->AskSQL("SELECT * FROM users WHERE username = '$username' AND id NOT LIKE '$id'");
		if (mysql_num_rows($haku) > 0){
			$output = "The option you choose a username <b> $username </ b> have already been registered! Choose a different user name and try again";
			return $output;
		}
		
		$haku = $db->AskSQL("SELECT * FROM users WHERE email = '$email' AND id NOT LIKE '$id'");
		
		if (mysql_num_rows($haku) > 0){
			$output = "Your e-mail address <b> $email </ b> have already been registered! Choose another e-mail address and try again";
			return $output;
		}
				
		if (($username == "") || ($name == "") || ($email == "") || ($location == "") || ($oikeustaso == "")){
			$output = "Update didn't success! <br><br>You didn't put all needed information. Add needed information and try again.";
			return $output;
		}

		$db->UseSQL("UPDATE users SET username = '$username', name = '$name', email = '$email', oikeustaso = '$oikeustaso', location = '$location', project = '$project', phone = '$phone', information = '$information' WHERE id = '$id'");		
		
		$output = "User information update successfully!";
		
		return $output;
	}

	public function SendForgetPassword($username, $email){
		if (($username == "") && ($email != ""))
			$username = "ABCDEFGHIJKLMNOPQR";
			
		if (($username != "") && ($email == ""))
			$email = "ABCDEFGHIJKLMNOPQR";	
			
		$haku = $db->AskSQL("SELECT * FROM users WHERE username = '$username' OR email = '$email'");
		$tulos = mysql_fetch_row($haku);
		
		if (mysql_num_rows($haku) > 0){
			$kayttaja_ID = $tulos[0];
			srand((double)microtime()*1234567);
			$satunnaisluku = rand(100000,999999);
			$randompassu = "$satunnaisluku";
			$uusipassword = md5($randompassu);
			$db->UseSQL("UPDATE users set password = '$uusipassword' WHERE id = '$kayttaja_ID'");
			$headers = "MIME-Version: 1.0\r\n".
   		  	"Content-type: text/plain; charset=utf-8\r\n".
			"From: \"Plenware telephone booking system\" <myynti@heurex.fi>\r\n".
			"Subject: password vaihdettu\r\n";
			$message = "Moi!\n\nIn your username $tulos[1] has been invited to a new password.\n\nThe new password is: $randompassu\n\nYou can log with your username $tulos[1] and a new password telephone booking system.\nYou can change your password Personal information on page.\n\nRegards,\nPlenware telephone booking system";
			mail($tulos[4], 'password changed', $message, $headers);
			$output = "New password sent to e-mail address $tulos[4]. Sign in to a new password, after which you can change your password Personal information on page.";
		}
		
		if (mysql_num_rows($haku) < 1){
			$output = "By entering a username and/or e-mail address is not found in your user data. Please check your spelling and try again.";
		}
		
		return $output;
	}

	/**
	 * Makes admin user if there is none
	 */
	public function MakeAdminUser(){
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		
		$sql = "SELECT * FROM users WHERE username = 'admin'";
		
		$haku = $db->AskSQL("$sql");
		$tulos = mysql_fetch_row($haku);
		
		if (mysql_num_rows($haku) == 0){
			$this->username = "admin";
			$this->password = md5("nimda");
			$this->name = "Administrator";
			$this->email = "myynti@heurex.fi";
			$this->oikeustaso = "99";
			$this->tunniste = "";
			$this->location = "";
			$this->locationname = "Tampere, Finland";
			$this->project = "";
			$this->phone = "";
			$this->information = "Administrator";
			
			$sql = "INSERT INTO users (username, password, name, email, oikeustaso, location, aktivointi, project, phone, information, cadmin, changeday) VALUES ('$this->username' , '$this->password', '$this->name', '$this->email', '$this->oikeustaso', '$this->location', '$this->aktivointi', '$this->project', '$this->phone', '$this->information', '$this->cadmin', NOW())";
			$tulos = $db->UseSQL($sql);
			
		}
	}
	
	/**
	 * Log user in
	 */
	public function LogUserIn($in_username, $in_password){
		
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		
		/**
		 * Checks and makes admin user
		 */
		$this->MakeAdminUser();
			
		$this->username = $in_username;
		$password = md5($in_password);	

		$sql = "SELECT * FROM users WHERE username = '$this->username' AND password = '$password'";
		
		$haku = $db->AskSQL("$sql");
		$tulos = mysql_fetch_row($haku);
		$this->user_id = $tulos[0];
		$this->username = $tulos[1];
		$this->password = $tulos[2];
		$this->location = $tulos[7];
		
		$sql = "SELECT * FROM location WHERE id = '$this->location'";
		$haku2 = $db->AskSQL("$sql");
		$tulos2 = mysql_fetch_row($haku2);
		
		if ($tulos[8] == 1){
			$output = "User account has not yet activated!<br><br>Yeo can use this system then when your account is activated by administrator.<br>Saat ilmoituksen sÃ¤hkÃ¶postilla, kun tunnuksesi on aktivoitu.";
			return $output;
		}
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $tulos[0];
			$this->username = $tulos[1];
			$this->password = $tulos[2];
			$this->name = $tulos[3];
			$this->email = $tulos[4];
			$this->oikeustaso = $tulos[5];
			$this->tunniste = $tulos[6];
			$this->location = $tulos[7];
			$this->locationname = $tulos2[1];
			$this->project = $tulos[9];
			$this->phone = $tulos[10];
			$this->information = $tulos[11];
		
			$output = "Sign-up complete!";
			/**
			print "id:$this->id<br>";
			print "username:$this->username<br>";
			print "password:$this->password<br>";
			print "name:$this->name<br>";
			print "email:$this->email<br>";
			print "oikeustaso:$this->oikeustaso<br>";
			print "tunniste:$this->tunniste<br>";
			print "location:$this->location<br>";
			print "locationname:$this->locationname<br>";
			print "project:$this->project<br>";
			print "phone:$this->phone<br>";
			print "information:$this->information<br>";
			*/
			return $output;
		}	


			
		if (mysql_num_rows($haku) < 1){
			$this->id = "";
	    	$this->username = "";
        	$this->password = "";
          	$this->name = "";
	      	$this->email = "";
        	$this->oikeustaso = 0;
          	$this->tunniste = $sessio_id;
			$this->location = "";
			$this->locationname = "";
			$this->project = "";
			$this->phone = "";
			$this->information = "";
			
			$output = "Sign up did not work! <br> Check the ID and password for your spelling!";
			return $output;
		}
	}
	
	public function LogOutUser(){
		$this->id = "";
	 	$this->username = "";
    	$this->password = "";
      	$this->name = "";
	 	$this->email = "";
    	$this->oikeustaso = 0;
     	$this->tunniste = $sessio_id;
		$this->location = "";
		$this->project = "";
		$this->phone = "";
		$this->information = "";
		
		$output = "You are now logout from system!";
		return $output;
	}

	public function HaeKayttajanOikeustaso(){
		if ($this->oikeustaso == 1)
			return "Normal user";
		
		if ($this->oikeustaso == 99)
			return "Administrator";
					
		return "$places($this->oikeustaso) admin";

	}
			
	/**
 	 * Testing user
 	 */
	public function TestUser($location){
		$output = 0;

		if (($this->oikeustaso == $location) || ($this->oikeustaso == 99)){
			$output = 1;
		}

		return $output;
	}

	/**
	 * Password
	 */
	public function NewPassword(){
		$annettutunnus = $_POST["sstunnus"];
		$annettuemail = $_POST["ssemail"];
		print "$pagestart$logo</td></tr>\n";
		print "<tr><td><form action=\"index.php\" method=\"post\" name=\"salasanavaihto\"><input type=\"hidden\" name=\"salasanavaihto\" value=\"1\">";
		print "This form you can send new password to yourself if you have forget old one.<br><br>Add your username <b>or</b> email to below.<br><br>Username:<br><input type=\"text\" name=\"sstunnus\" size=\"20\" value=\"$annettutunnus\">\n";
		print "<br><br>Email: <br><input type=\"text\" name=\"ssemail\" size=\"20\" value=\"$annettuemail\">\n";
		print "<br><br><input type=\"submit\" value=\"Give me new password\"> <input type=\"reset\" value=\"Clear\"></form>";
		print "</table>";
	}

	/**
	 * Get own information
	 */
	public function OwnInformation(){
		$annettutunnus = $user->tunnus;
		$annettunimi = $user->nimi;
		$annettuemail = $user->email;
		$annettusijainti = $_POST["uusisijainti"];
		
		print "$pagestart$logo</td></tr>\n";
		print "<tr><td><img src=\"pictures/" + $lang + "profile_iso.gif\" border=\"0\"><form action=\"index.php\" method=\"post\" name=\"profiilipaivitys\"><input type=\"hidden\" name=\"profiilipaivitys\" value=\"1\">";
		print "This form you can update your information and change password. <br>Let password empty if you want to keep old password.<br><br>User name<br><input type=\"text\" name=\"uusitunnus\" size=\"20\" value=\"$annettutunnus\">\n";
		print "<br><br>New password: <br><input type=\"password\" name=\"uusisalasana1\" size=\"20\">\n";
		print "<br><br>New password again: <br><input type=\"password\" name=\"uusisalasana2\" size=\"20\">\n";
		print "<br><br>Name: <br><input type=\"text\" name=\"uusinimi\" size=\"20\" value=\"$annettunimi\">\n";
		print "<br><br>Email: <br><input type=\"text\" name=\"uusiemail\" size=\"20\" value=\"$annettuemail\">\n";
		print "<br><br><input type=\"submit\" value=\"Update\"></form>";
		print "</table>";
	}

	/**
	 * Update profile
	 */
	public function UpdateUserInformation($id){
		$tietue = $user->HaeKayttajanTiedot($id);
		$annettunimi = "$tietue[3]";
		$annettutunnus = "$tietue[1]";
		$annettuemail = "$tietue[4]";
		$annettusijainti = "$tietue[7]";
		$annettuoikeustaso = "$tietue[5]";
		$annettuid = "$tietue[0]";
		
		print "$pagestart$logo</td></tr>\n";
		print "<tr><td><img src=\"pictures/" + $lang + "kayttajapaivitys.gif\" border=\"0\"><form action=\"index.php\" method=\"post\" name=\"kayttajapaivitys\"><input type=\"hidden\" name=\"kayttajapaivitys\" value=\"1\"><input type=\"hidden\" name=\"kayttajaid\" value=\"$annettuid\">";
		print "With this form you can update user information. <br><br>User name:<br><input type=\"text\" name=\"uusitunnus\" size=\"20\" value=\"$annettutunnus\">\n";
		print "<br><br>Name: <br><input type=\"text\" name=\"uusinimi\" size=\"20\" value=\"$annettunimi\">\n";
		print "<br><br>Email: <br><input type=\"text\" name=\"uusiemail\" size=\"20\" value=\"$annettuemail\">\n";
		print "<br><br>Location:<br><select name=\"uusisijainti\">";
	
		for ($i = 2; $i <= 13; $i++){	
			$valittu = " ";
			
			if ($i <> 4){
				if ($annettusijainti == $i)
					$valittu = " SELECTED";
					
				if (($user->oikeustaso == $i) || ($user->oikeustaso == 99))	{
					print "<option value=\"$i\" $valittu>$places[$i]</option>\n";
				}
			}	
		}	
		
		print "</select><br><br>Oikeustaso:<br><select name=\"uusioikeustaso\">";
		
		$valittu = " ";
		
		if ($annettuoikeustaso == 1)
			$valittu = " SELECTED";
				
		if (($user->oikeustaso > 1) || ($user->oikeustaso == 99)){
			print "<option value=\"1\" $valittu>Normal user</option>\n";
		}
		
		for ($i = 2; $i <= 13; $i++){	
			$valittu = " ";
			
			if ($i <> 4){
				if ($annettusijainti == $i)
					$valittu = " SELECTED";
					
				if (($user->oikeustaso == $i) || ($user->oikeustaso == 99)){
					print "<option value=\"$i\" $valittu>$places[$i] administrator</option>\n"; }
			}	
		}	
	
		if (($user->oikeustaso == 99)){
			$valittu = " ";
			if ($annettuoikeustaso == 99)
				$valittu = " SELECTED";
			
			print "<option value=\"99\" $valittu>Administrator</option>\n";
		}
		
		print "</select>";
		print "<br><br><input type=\"submit\" value=\"Update\"></form>";
		print "</table>";
	}

	/**
	 * Show Users
	 */
	public function ShowUsersxxx(){
		print "$pagestart$logo</td></tr>\n";
		print "<tr><td><img src=\"pictures/" + $lang + "addnewuser.gif\" border=\"0\"><form action=\"index.php\" method=\"post\" name=\"puhelinlisays\"><input type=\"hidden\" name=\"kayttajalisays\" value=\"1\">";
		print "Add new user to system:<br><br>Username:<br><input type=\"text\" name=\"uusitunnus\" size=\"20\">\n";
		print "<br><br>Password: <br><input type=\"text\" name=\"uusisalasana\" size=\"20\">\n";
		print "<br><br>Name: <br><input type=\"text\" name=\"uusinimi\" size=\"20\">\n";
		print "<br><br>Email address: <br><input type=\"text\" name=\"uusiemail\" size=\"20\">\n";
		print "<br><br>Location:<br><select name=\"uusisijainti\">";
		
		for ($i = 2; $i <= 13; $i++){	
			if ($i <> 4){
				if (($this->oikeustaso == $i) || ($this->oikeustaso == 99)){
					print "<option value=\"$i\">$places[$i]</option>\n";
				}	
			}	
		}			
		
		print "</select><br><br>Rights:<br><select name=\"uusioikeustaso\">";
		if (($this->oikeustaso > 1) || ($this->oikeustaso == 99))
		{
			print "<option value=\"1\">Normal user</option>\n";
		}
		
		for ($i = 2; $i <= 13; $i++){	
			if ($i <> 4){
				if (($this->oikeustaso == $i) || ($this->oikeustaso == 99)){
					print "<option value=\"$i\">$places[$i] admin</option>\n";
				}	
			}	
		}
	
		if (($this->oikeustaso == 99)){
			print "<option value=\"99\">System administrator</option>\n";
		}
		
		print "</select><br><br><input type=\"submit\" value=\"Add user\"> <input type=\"reset\" value=\"Clear form\"></form>";
		print "</table>";
		print "$tablenormal";
		print "<td class=\"td_phonelistheader\">Username</td><td class=\"td_phonelistheader\">Name</td><td class=\"td_phonelistheader\">Email address</td><td class=\"td_phonelistheader\">Admin rights</td><td class=\"td_phonelistheader\">Location</td><td class=\"td_phonelistheader\">State</td></tr>";
		$action = $this->NaytaKayttajataulukko();
		print "$action";
		print "</table>";	
	}
}

?>

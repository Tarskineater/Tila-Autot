<?php

/**
 * Inventory Tool 0.7
 * Location.php
 * 07.04.2008
 */

class Location{
	var $id;
	var $name;
	var $country;
	var $information;
	var $show;
	var $cadmin;
 	var $changeday;
	var $cadmin_name;
	
	/**
	 * Start location
	 */
	public function Location(){
		$this->id = "";
		$this->name = "";
		$this->country = "";
		$this->information = "";
		$this->show = "1";
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = time();
	}

	/**
	 * Show locations if there is any
	 */
			
/*
INSERT INTO `location` (`id`, `name`, `country`, `information`, `show`) VALUES
(1, 'Tampere', 'Finland', 'Administrator', 1),
(2, 'Tampere', 'Finland', 'Pääpaikka', 1),
(3, 'Espoo', 'Finland', 'Espoo', 1),
(4, 'Testi', 'Finland', 'Saa laittaa minkä haluaa', 0),
(5, 'Turku', 'Finland', 'Turku', 1),
(6, 'Testi2', 'Finland', 'Add what you want', 0),
(7, 'Helsinki', 'Finland', 'Helsinki', 1),
(8, 'Hyvinkää', 'Finland', 'Hyvinkää', 1),
(9, 'Rauma', 'Finland', 'Rauma', 1),
(10, 'Chengdu', 'China', 'Chengdu', 1),
(11, 'Beijing', 'China', 'Beijing', 1),
(12, 'Cluj Napoca', 'Romania', 'Cluj Napoca', 1),
(13, 'Tartu', 'Viro', 'Tartu', 1);
		*/
		
   	/**
	 * Read Location
	 */
	public function ReadLocation($in_id){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		$this->id = $in_id;
		$output = "";
		$sql = "SELECT * FROM `location` WHERE id = '$this->id'";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		/**
		 * read location information
		 */
		if (mysql_num_rows($haku) > 0){
			$this->name = stripslashes(nl2br($rivi[1]));
			$this->country = stripslashes(nl2br($rivi[2]));
			$this->information = stripslashes(nl2br($rivi[3]));
			$this->show = $rivi[4];
			$this->cadmin = $rivi[5];
			$this->changeday = $rivi[6];
			$this->cadmin_name = $rivi[7];
		}
		
		/*if ($this->name == "")
			$this->name = "Check name!";
			
		if ($this->country == "")	
			$this->country = "Finland";
		*/	
		if ($this->information == "")
			$this->information = "";
			
		$this->information = str_replace("<br />", "", $this->information);
		
		if ($this->show == "")
			$this->show = "1";
		
		if ($this->acc_cadmin == "")
			$this->acc_cadmin = $_SESSION['LogInUser']->id;
			
		if ($this->acc_changeday == "")
			$this->acc_changeday = time();
		
		if ($this->name!="" && $this->country!=""){
			$output = $this->name . ", " . $this->country;
		} else {
			$output = $this->name . $this->country;
		}
		
		return $output;
	}
	
	/**
	 * Test print location information
	 */
	public function PrintLocation(){
		print "id: $this->id<br>\n";
		print "name: $this->name<br>\n";
		print "country: $this->country<br>\n";
		print "information: $this->information<br>\n";
		print "showme: $this->show<br>\n";
		print "cadmin: $this->cadmin<br>\n";
		print "changeday: $this->changeday<br>\n";	
		print "cadmin_name: $this->cadmin_name<br>\n";
	}
	
	public function LocationDropDown($id)
	{
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
		$tp_loc = "0";
 		$output = "<select name=\"location\">\n";
 		
		$sql = "SELECT * FROM `location` ORDER BY name, country";
		//print "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);

		if ($rows > 0){
			for ($laskuri = 0; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				//$tmp = $tmp . "$rivi[0]<br>";
				if ($rivi[0]<>0){
					if ($id == $rivi[0]){
  						$output2 = $output2 . "<option value =\"$rivi[0]\" selected>&nbsp;$rivi[1], $rivi[2]</option>\n";  
  						$tp_loc = $rivi[0];
					} else {
						$output2 = $output2 . "<option value =\"$rivi[0]\">&nbsp;$rivi[1], $rivi[2]</option>\n";  
					}
				}
			}
			
			if ($tp_loc!="0"){
				$output = $output . "<option value =\"\">&nbsp;- Location -&nbsp;</option>\n";
			} else {
				$output = $output . "<option value =\"\" selected>&nbsp;- Location -&nbsp;</option>\n";
			}
		}
		
		$output = $output . $output2 . "</select>\n";
		
		return $output;
	}
	
	public function ShowLocations($location, $locationname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		/*
 		if (isset($_GET["location"]) == "") {
 			$_GET["location"] = 2;
	 	}
	 	
	 	$this->location = $_GET["location"];
	 	*/
	 	$page2 = $_SESSION['Search']->page2;
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$l = 3;
		if ($oikeus > "1"){
			$l = 4;
		}
		
		if ($page2 == "searchform"){
			$sql = $_SESSION['Search']->sql_location;
		} else {	
			$sql = "SELECT * FROM location ORDER BY name, country";
		}
		
		//print "$sql<br>";
		
		if($locationname=="All"){
			$output2 = "Location list";
		} else {
			$output2 = "$locationname location";
		}
		
		$tmp_location="<a href=\"index.php?page=location&page2=searchform&product=location&order_location=";
		
		$output = $output . "<table width=\"950\"><tr><td colspan=\"$l\" class=\"td_phonelistheader\">";
		$output = $output . "<a href=\"classes/excel.php?name=$output2&cols=4&col1=0&col2=1&col3=2&col4=3&";
		$output = $output . "coln1=ID&coln2=City&coln3=Country&coln4=Information&sql=$sql\">";
		$output = $output . "<img src=\"pictures/excel.gif\" border=\"0\" title=\"Excel\"></a>&nbsp;";	
		$output = $output . "$output2</td></tr>";
		$output = $output . "<tr><td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_location . "name, country\">City</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_location . "country, name\">Country</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_location . "information, country, name\">Information</a></td>";
		
		if ($oikeus > "1"){
			$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">Edit</td>";
		}
		
		$output = $output . "</tr>\n";
		
		$haku = $db->AskSQL($sql);
			
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 0; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($oikeus > "1"){
					$toiminnot = "<td class=\"td_editdellistrow\"><a href=\"index.php?page=location&id=$rivi[0]&location_id=$rivi[0]&edit=1\"><img src=\"pictures/update2.gif\" border=\"0\" title=\"Update information\"></a>&nbsp;<a onclick=\"return confirmSubmitLOCATION()\" href=\"index.php?page=location&id=$rivi[0]&location_id=$rivi[0]&delete=1\"><img src=\"pictures/poista2.gif\" border=\"0\" title=\"Delete location\"></a></td>\n";
				}
				/*
				if ($rivi[4] == "1"){
					$show = "<img src=\"pictures/show.gif\" border=\"0\" title=\"Show\">\n";
				} else {
					$show = "<img src=\"pictures/noshow.gif\" border=\"0\" title=\"No show\">\n";
				}
				*/
				$output = $output . "<tr><td class=\"td_phonelistrow\"><a href=\"index.php?page=location&id=$rivi[0]&location_id=$rivi[0]&show=1\">$rivi[1]</a>&nbsp;</td><td class=\"td_phonelistrow\">$rivi[2]&nbsp;</td><td class=\"td_phonelistrow\" colspan=\"1\">$rivi[3]&nbsp;</td>";
				
				if ($oikeus > "1"){
					$output = $output .  "$toiminnot";
				}
				
				$output = $output . "</tr>\n";
			}
		} else {
			$output = $output . "<tr><td colspan=\"5\" class=\"td_phonelistrow\">No locations!</td></tr>";
		}
		

			
		$output = $output . "</table>";
		/*
		if ($oikeus > "1"){
			$output = $output . "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
			$output = $output . "<td class=\"tab\"><a href=\"index.php?page=location&id=''&location=$location&new=1\">&nbsp;New&nbsp;</a></td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "</tr></table>\n";
		}
		*/
		print "$output";
	}

	public function ListLocations($page){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 	
 		if (isset($_GET["location"]) == "") {
 			$_GET["location"] = 2;
	 	}
 		
 		$toimi2 = "";
 		$toimi = 0;
		$haku = $db->AskSQL("SELECT * FROM location ORDER BY country, name");
		$toimi2 = "<table id=\"locmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
		
		$rows = mysql_num_rows($haku);

		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){ 
				
				if (($rivi[4] == "1")){
					if ($toimi == 5){
						$toimi2 = $toimi2 . "</tr><tr>\n";
						$toimi = 0;				
					}
					
					$l0 = "";
					
					if (isset($_GET["location"]) == $rivi[0]){
					 	$l0 = " id=\"selectedtab\"";
				 	}
					 
					$output = $output . "<a href=\"index.php?page=$page&id=$rivi[0]&location_id=$rivi[0]\"><img src=\"pictures/place_$rivi[0].gif\" border=\"0\" title=\"$rivi[2], $rivi[1] $rivi[3]\"></a>\n";	
					$toimi2 = $toimi2 . "<td class=\"tab\"$l0><a href=\"index.php?page=$page&id=$rivi[0]&location_id=$rivi[0]\">$rivi[1]</a></td>\n";
					$toimi = $toimi + 1;
				}

			}
		}
		/**
		 * If there is no locations then show information to user
		 */
		if ($rows < 1){
			$output = "No locations!";
			$toimi2 = $toimi2 . "<tr><td>$output</td></tr>";
			//$output = "<img src=\"pictures/uc.gif\" border=\"0\" title=\"Testing\">";
		}
		
		$toimi2 = $toimi2 . "</tr></table>\n";
		$output = $toimi2;
		//print "$toimi2\n";
		
		return $output;
	}

	/**
	 * Edit Location
	 */
	public function EditLocation($in_id, $location2, $thing)
	{
		if (!isset($user))
			$user = new User();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
	 	//$this->location = $_GET["location"];
	 	
		if ($in_id!="")
			$this->id = $in_id;
		
		$this->location_id = $this->id;
				 	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if (isset($_GET["location_id"])!=""){
			$this->id = $_GET["location_id"];
			$this->location_id = $this->id;
		}
		
		if (isset($_GET["ed"])=="1"){
			$this->name = $_POST["name"];
			$this->country = $_POST["country"];
			$this->information = $_POST["information"];
			$this->show = $_POST["show"];
			$this->cadmin = $_SESSION['LogInUser']->id;
			//$this->changeday = time();			
		} else {
			$this->ReadLocation($in_id);
		}
		
		if (isset($_GET["copy2new"])=="1"){
			$this->id = "";
			$thing = "new";
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = time();
		}
		
		if (($thing == "edit") || ($thing == "new")){
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
		}
		
//$this->PrintLocation();

		print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">";
		
		if ($thing == "edit"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Edit location</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"updatelocation\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"updatelocation\">\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$this->id\">\n";
			print "<input type=\"hidden\" name=\"location_id\" value=\"$this->id\">\n";
			print "<input type=\"hidden\" name=\"show\" value=\"1\">\n";
		}
		
		if ($thing == "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Add location</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"newlocation\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"newlocation\">\n";
			print "<input type=\"hidden\" name=\"show\" value=\"1\">\n";
		}
			
		if ($thing != "edit" && $thing != "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Location info</td></tr>";
		} else {
			print "<input type=\"hidden\" name=\"page\" value=\"location\">\n";
		}
			
		if ($this->id != ""){
			print "<tr><td class=\"tab1\" colspan=\"1\">Location id number:</td><td class=\"tab2\" colspan=\"2\">$this->id</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">City:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"name\" size=\"40\" value=\"$this->name\">\n";
		} else {
			print "$this->name&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Country:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"country\" size=\"40\" value=\"$this->country\">\n";
		} else {
			print "$this->country&nbsp;";
		}
				
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Information:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>\n";
		} else {
			print "$this->information&nbsp;";
		}
		
		print "</td></tr>\n";
		
		/*
		print "<tr><td class=\"tab1\" colspan=\"1\">Shown:</td><td class=\"tab2\" colspan=\"2\">\n";

		if (($thing == "edit") || ($thing == "new")){
			print "<select name=\"show\">\n";
			if ($this->show == "0"){
					print "<option value =\"0\" selected>Do not show   </option>\n";  
					print "<option value =\"1\">Show me   </option>\n";  
			} else {
				print "<option value =\"0\">Do not show   </option>\n"; 
				print "<option value =\"1\" selected>Show me   </option>\n";  
			}
			print "</select>\n";
		} else {
			if ($this->show == "0"){
				print "Do not show\n";  
			} else {
				print "Show me\n";  
			}
		}
		
		print "</td></tr>\n";
		*/
		print "<tr><td class=\"tab1\" colspan=\"1\">Last change:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		//$lastadmin = $user->GetUserName($this->cadmin);
		$this->changeday = $fixdate->ReturnDate($this->changeday);
		$temp = date("Y-m-d",$this->changeday);
		print "$this->cadmin_name $temp";
							
		print "</td></tr></table>\n";

		if ($oikeus > "1"){	
			if (($thing == "edit") || ($thing == "new")){
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				//print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\" colspan=\"1\">\n";
				print "<div><input type=\"submit\" value=\"Submit\" id=\"el09\"></div></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\" colspan=\"1\"></td>\n";
				//print "<div><input type=\"reset\" value=\"Clear\" id=\"el09\"></div></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n</tr>\n";
				print "</td></tr></table>";
				print "</form>";
			} else {
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				print "<td class=\"tab\"><a href=\"index.php?page=location&id=$this->id&location_id=$this->id&edit=1\">&nbsp;Edit&nbsp;</a></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\"><a onclick=\"return confirmSubmitLOCATION()\" href=\"index.php?page=location&id=$id&location_id=$this->id&delete=1\">&nbsp;Delete&nbsp;</a></td>\n";
				print "</tr></table>\n";
			}	
		}	
	}
	
	/**
	 * Check Location data
	 */
	public function CheckLocation(){
		$output = 0;
		
		if ($this->name == "" || $_SESSION['Search']->CheckText($this->name,10) == 10) { 
			$output = "10";
			return $output;
		}	
		if ($this->country == "" && $_SESSION['Search']->CheckText($this->country,11) == 11) { 
			$output = "11";
			return $output;
		}	
				
 		if ($this->information != "" && $_SESSION['Search']->CheckText($this->information,12) == 12) { 
			$output = "12";
			return $output;
		}	
					
		return $output;
	}
	
	/**
	 * Get names
	 */
	public function GetNames(){			
		if (!isset($user2))
			$user2 = new User();
			
		$user2->ReadUser($this->cadmin);	
		$this->cadmin_name = $user2->name;	
	}
	/**
	 * Add new location to database
	 */
	public function AddLocation(){
		if (!isset($db))
			$db = new Database();
					
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->country = mysql_real_escape_string($_POST["country"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->show = $_POST["show"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());	
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		/**
		 * Test print phone information (only test!)
	 	 */	
		//$this->PrintLocation();
		
		$check_location = $this->CheckLocation();

		if ($check_location!=0)
			return $check_location;
			
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->name == "") || ($this->country == "")){
			$output = "3";
			return $output;
		}
		
		/**
		 * Check if there is location allready
		 * Adding location not successfully! Database has allready location with same name in same country.
		 */
		$sql = "SELECT * FROM location WHERE name = '$name' and country ='$country'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "1";
			return $output;
		}
						
		/**
		 * Insert location to database
		 */
		$sql = "INSERT INTO `location` (name, country, information, showme, cadmin, changeday, cadmin_name)" .
 		" VALUES ('$this->name', '$this->country', '$this->information', '$this->show', " .
 		"'$this->cadmin', '$this->changeday', '$this->cadmin_name')";
				
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
		$sql = "SELECT MAX(id) FROM `location`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
		}
	}
	
	/**
	 * Update Location
	 */
	public function UpdateLocation(){
		if (!isset($db))
			$db = new Database();
			
		$this->id = $_POST["location_id"];
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->country = mysql_real_escape_string($_POST["country"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->show = $_POST["show"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());
					
		if ($this->show == "")
			$this->show = "1";
		
		if ($this->cadmin == "")
			$this->cadmin = $_SESSION['LogInUser']->id;

		/**
		 * Get names
		 */
		$this->GetNames();
		
		//$this->PrintLocation();
			
		$check_location = $this->CheckLocation();

		if ($check_location!=0)
			return $check_location;
		
		/**
		 * If empty then give error
		 */
		if (($this->name == "") || ($this->country == "")){
			$output = "3";
			return $output;
		}
		
		/**
		 * Check if there is location allready
		 * Adding location not successfully! Database has all ready location with same name in same country.
		 */
		 
		$sql = "SELECT * FROM location WHERE id <> '$this->id' AND name = '$this->name' and country ='$this->country'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "1";
			return $output;
		}
		
		/**
		 * Make update and give user that information
		 */
		$sql = "UPDATE `location` SET name = '$this->name', country = '$this->country', information = '$this->information', " .
		"showme = '$this->show', cadmin = '$this->cadmin', changeday = '$this->changeday', " .
		"cadmin_name='$this->cadmin_name' WHERE id = '$this->id'";
		
		//print "$sql<br>";
		$db->UseSQL("$sql");
		
		$output = "0";
		return $output;
	}

	/**
	 * Delete location and give info to user
	 */
	public function DeleteLocation($location_id){
		if (!isset($db))
			$db = new Database();
			
		$output = $this->CheckBeforeDelete("$location_id");
		
		if ($output=="0"){	
			$sql = "DELETE FROM `location` WHERE id = '$location_id'";
			$db->UseSQL("$sql");
		}
		
		return $output;
	}
	
	/**
	 * Search the newst
	 */
	public function CheckBeforeDelete($in_location){
		if (!isset($db))
			$db = new Database(); 
			
		$db->Database();
				
		$_GET["loc_del_err"] = $this->ReadLocation($in_location);
		
		$sql = "SELECT * FROM phones WHERE location = '$in_location'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			return "10";
		}
		
		$sql = "SELECT * FROM sims WHERE location = '$in_location'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			return "11";
		}
		
		$sql = "SELECT * FROM accessories WHERE location = '$in_location'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			return "12";
		}
		
		$sql = "SELECT * FROM flash_adapters WHERE location = '$in_location'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			return "13";
		}	
		
		$sql = "SELECT * FROM `projects` WHERE location='$in_location'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			return "14";
		}
		
		$sql = "SELECT * FROM `users` WHERE location='$in_location'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			return "15";
		}	
		
		return 0;	 
	}
	
}
?>
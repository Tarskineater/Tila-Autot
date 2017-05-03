<?php
/**
 * Heurex Rental 0.0
 * Location.php
 * 24.10.2012
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
	var $output;
	var $output2;
	
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
			
		if (isset($_SESSION['LogInUser']))
			$this->acc_cadmin = $_SESSION['LogInUser']->id;
			
		if (isset($this->acc_changeday))
			$this->acc_changeday = time();
		
		if ($this->name!="" && $this->country!=""){
			$output = $this->name . ", " . $this->country;
		} else {
			$output = $this->name . $this->country;
		}
		
		return $output;
	}
	
	/**
	 * Test echo location information
	 */
	public function PrintLocation(){
		echo "id: $this->id<br>\n";
		echo "name: $this->name<br>\n";
		echo "country: $this->country<br>\n";
		echo "information: $this->information<br>\n";
		echo "showme: $this->show<br>\n";
		echo "cadmin: $this->cadmin<br>\n";
		echo "changeday: $this->changeday<br>\n";	
		echo "cadmin_name: $this->cadmin_name<br>\n";
	}
	
	/*
	 * Country lista
	 */
	public function CountryDropDown($show, $contry){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
		
		$output = "";
		
		if ($show == "1"){
			$output = "<select name=\"country\">\n";
			$haku = $db->AskSQL("SELECT * FROM country ORDER BY country");
		} else {
			$haku = $db->AskSQL("SELECT * FROM country WHERE short = '$contry'");
		}
				
		$rows = mysql_num_rows($haku);

		if ($rows > 0){
			for ($laskuri = 0; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				
				if ($show == "1"){
		 			
					if ($contry == $rivi[1]){
						$output = $output . "<option value =\"$rivi[1]\" selected>$rivi[2]</option>\n";
					} else {
						$output = $output . "<option value =\"$rivi[1]\">$rivi[2]</option>\n";
					}
					
				} else {
					$output = "$rivi[2]\n";
				}
			}
		}
			
		if ($show == "1"){
			$output = $output . "</select>\n";
		}
		
		return $output;
	}

	public function LocationDropDown($inname,$id)
	{
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
		$tp_loc = "0";
		if ($inname == ""){
			$inname = "location";
		}
		
		if ($id == ""){
			$id = "1";
		}
		
 		$this->output = "<select name=\"$inname\">\n";
 		
		$sql = "SELECT * FROM `location` ORDER BY name, country";
		//echo "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);

		if ($rows > 0){
			for ($laskuri = 0; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				//$tmp = $tmp . "$rivi[0]<br>";
				if ($rivi[0]<>0){
					if ($id == $rivi[0]){
  						$this->output2 = $this->output2 . "<option value =\"$rivi[0]\" selected>&nbsp;$rivi[1], $rivi[2]</option>\n";  
  						$tp_loc = $rivi[0];
					} else {
						$this->output2 = $this->output2 . "<option value =\"$rivi[0]\">&nbsp;$rivi[1], $rivi[2]</option>\n";  
					}
				}
			}
			
			if ($tp_loc!="0"){
				$this->output = $this->output . "<option value =\"\">&nbsp;- Kaupunki -&nbsp;</option>\n";
			} else {
				$this->output = $this->output . "<option value =\"\" selected>&nbsp;- Kaupunki -&nbsp;</option>\n";
			}
		}
		
		$this->output = $this->output . $this->output2 . "</select>\n";
		
		return $this->output;
	}
	
	public function ShowLocations($location, $locationname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
		
	 	$page2 = $_SESSION['Search']->page2;
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$l = 3;
		if ($oikeus > "1"){
			$l = 4;
		}
		
		//if ($page2 == "searchform"){
			$sql = $_SESSION['Search']->sql_location;
		//} else {	
			$sql = "SELECT * FROM location ORDER BY name, country";
		//}
		
		//echo "$sql<br>";
		
		if($locationname=="All"){
			$this->output2 = "Location list";
		} else {
			$this->output2 = "$locationname location";
		}
		
		$tmp_location="<a href=\"index.php?page=location&page2=searchform&product=location&order_location=";
		$tmp_new = "<td class=\"td_button\">";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr>";
		echo "<td>". $tmp_location . "name, country\" class=\"stylish-button\">City</a></td>";
		echo "<td>". $tmp_location . "country, name\" class=\"stylish-button\">Country</a></td>";
		echo "<td>". $tmp_location . "information, country, name\" class=\"stylish-button\">Information</a></td>";
		
		echo "<td height=\"28\">";
		echo "<a href=\"classes/excel.php?name=$this->output2&cols=4&col1=0&col2=1&col3=2&col4=3&";
		echo "coln1=ID&coln2=City&coln3=Country&coln4=Information&sql=$sql\" class=\"stylish-button\">Exel&nbsp;</a>&nbsp;";	
		echo "<a href=\"index.php?page=location&id=&location_id=&new=1\" class=\"stylish-button\">Uusi</a>";
		echo "</td></tr>\n";
		
		$haku = $db->AskSQL($sql);
			
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 0; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				$toiminnot = "<td><a href=\"index.php?page=location&id=$rivi[0]&location_id=$rivi[0]&edit=1\"class=\"stylish-button\">Muokkaa</a>&nbsp;</td>\n";
				echo "<tr><td class=\"stylish-cRows\" width =\"400\"><a href=\"index.php?page=location&id=$rivi[0]&location_id=$rivi[0]&show=1\" class=\"stylish-cRows\">$rivi[1]</a>&nbsp;</td><td class=\"stylish-cRows\">$rivi[2]&nbsp;</td><td class=\"stylish-cRows\" colspan=\"1\" width =\"400\">$rivi[3]&nbsp;</td>";		
				echo  "$toiminnot";	
				echo "</tr>\n";
			}
		} else {
			echo "<tr><td colspan=\"5\" class=\"td_listrow\">No locations!</td></tr>";
		}
		
		echo "</table>";
		echo "</td></tr></table>";
		/*
		if ($oikeus > "1"){
			$output = $output . "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
			$output = $output . "<td class=\"tab\"><a href=\"index.php?page=location&id=''&location=$location&new=1\">&nbsp;New&nbsp;</a></td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "</tr></table>\n";
		}
		*/

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
					 
					$this->output = $this->output . "<a href=\"index.php?page=$page&id=$rivi[0]&location_id=$rivi[0]\"><img src=\"pictures/place_$rivi[0].gif\" border=\"0\" title=\"$rivi[2], $rivi[1] $rivi[3]\"></a>\n";	
					$toimi2 = $toimi2 . "<td class=\"tab\"$l0><a href=\"index.php?page=$page&id=$rivi[0]&location_id=$rivi[0]\">$rivi[1]</a></td>\n";
					$toimi = $toimi + 1;
				}

			}
		}
		/**
		 * If there is no locations then show information to user
		 */
		if ($rows < 1){
			$this->output = "No locations!";
			$toimi2 = $toimi2 . "<tr><td>$output</td></tr>";
			//$output = "<img src=\"pictures/uc.gif\" border=\"0\" title=\"Testing\">";
		}
		
		$toimi2 = $toimi2 . "</tr></table>\n";
		$this->output = $toimi2;
		//echo "$toimi2\n";
		
		return $this->output;
	}

	/**
	 * Edit Location
	 */
	public function EditLocation($in_id, $location2, $thing){
		$border_now = 0;
		$this->thing = $thing;
		$this->oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if (!isset($user))
			$user = new User();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
	 	
		if ($in_id!="")
			$this->id = $in_id;
		
		$this->location_id = $this->id;
		
		if (isset($_GET["location_id"])!=""){
			$this->id = $_GET["location_id"];
			$this->location_id = $this->id;
		}
		
		if (isset($_GET["ed"])=="1"){
			$this->ReadPost();
			$this->cadmin = $_SESSION['LogInUser']->id;
			//$this->changeday = time();			
		} else {
			$this->ReadLocation($in_id);
		}
		
		if (isset($_GET["copy2new"])=="1"){
			$this->ReadLocation($in_id);
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
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "<center><img src=\"" . DIR_PICTURES  . LANG ."/location_edit.gif\" border=\"0\">";
		echo "</td></tr></table></td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\">";
		
		if ($thing == "edit"){
			echo "<form action=\"index.php\" method=\"post\" name=\"updatelocation\">\n";
			echo "<input type=\"hidden\" name=\"page2\" value=\"updatelocation\">\n";
			echo "<input type=\"hidden\" name=\"id\" value=\"$this->id\">\n";
			echo "<input type=\"hidden\" name=\"location_id\" value=\"$this->id\">\n";
			echo "<input type=\"hidden\" name=\"show\" value=\"1\">\n";
		}
		
		if ($thing == "new"){
			echo "<form action=\"index.php\" method=\"post\" name=\"newlocation\">\n";
			echo "<input type=\"hidden\" name=\"page2\" value=\"newlocation\">\n";
			echo "<input type=\"hidden\" name=\"show\" value=\"1\">\n";
		}
		
		echo "<input type=\"hidden\" name=\"page\" value=\"location\">\n";
			
		if ($this->id != ""){
			echo "<tr><td class=\"stylish-button\">Kohteen numero:&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
			echo "$this->id</td></tr>\n";
		}
		
		echo "<tr><td class=\"stylish-button\">Kaupunki:&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"name\" size=\"40\" value=\"$this->name\">\n";
		} else {
			echo "$this->name&nbsp;";
		}
		
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Maa:&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"country\" size=\"40\" value=\"$this->country\">\n";
		} else {
			echo "$this->country&nbsp;";
		}
				
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Tietoa:&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>\n";
		} else {
			echo "$this->information&nbsp;";
		}
		
		echo "</td></tr>\n";
		
		/*
		echo "<tr><td class=\"tab1\" colspan=\"1\">Shown:</td><td class=\"tab2\" colspan=\"2\">\n";

		if (($thing == "edit") || ($thing == "new")){
			echo "<select name=\"show\">\n";
			if ($this->show == "0"){
					echo "<option value =\"0\" selected>Do not show   </option>\n";  
					echo "<option value =\"1\">Show me   </option>\n";  
			} else {
				echo "<option value =\"0\">Do not show   </option>\n"; 
				echo "<option value =\"1\" selected>Show me   </option>\n";  
			}
			echo "</select>\n";
		} else {
			if ($this->show == "0"){
				echo "Do not show\n";  
			} else {
				echo "Show me\n";  
			}
		}
		
		echo "</td></tr>\n";
		*/
		echo "<tr><td class=\"stylish-button\">Last change:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		$this->changeday = $fixdate->ReturnDate($this->changeday);
		$temp = date("Y-m-d",$this->changeday);
		echo "$this->cadmin_name $temp</td></tr>";
							
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td>";
		
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<div><input type=\"submit\" value=\"Submit\" id=\"el09\"></div></td>\n";
			echo "</form>";
			echo "</td></tr></table>";
		} else {
			echo "</td></tr></table>";
			if (($_SESSION['LogInUser']->id==$this->id)||($this->oikeus > "1")) {
				echo "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				echo "<a href=\"index.php?page=location&id=$this->id&location_id=$this->id&edit=1\"><img src=\"" . DIR_PICTURES  . LANG ."/small_edit.gif\" border=\"0\"></a>\n";
				
				if ($this->oikeus > "1"){
					echo "<td class=\"tab\"><a onclick=\"return confirmSubmitLOCATION()\" href=\"index.php?page=location&id=$this->id&location_id=$this->id&delete=1\"><img src=\"" . DIR_PICTURES  . LANG ."/small_delete.gif\" border=\"0\"></a></td>\n";
				} else {
					echo "<td class=\"tab\" colspan=\"4\">&nbsp;</td>\n";
				}
				
				echo "</tr></table>\n";
			}
		}	
		echo "<center><br><a href=\"index.php\"><img src=\"" . DIR_PICTURES . LANG . "/logo01.gif\" border=\"0\"></a>";
		echo "</td></tr></table>";
	}
	
	/**
	 * Check Location data
	 */
	public function CheckLocation(){
		$output = 0;
		
		if ($this->name == "" || $_SESSION['Search']->CheckText($this->name,10) == 10) { 
			$this->output = "10";
			return $this->output;
		}	
		if ($this->country == "" && $_SESSION['Search']->CheckText($this->country,11) == 11) { 
			$this->output = "11";
			return $this->output;
		}	
				
 		if ($this->information != "" && $_SESSION['Search']->CheckText($this->information,12) == 12) { 
			$this->output = "12";
			return $this->output;
		}	
					
		return $this->output;
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
	 * Read Post
	 */
	 public function ReadPost(){
		if (isset($_POST["location_id"]))
			$this->id  = $_POST["location_id"];
			
		if (isset($_POST["name"]))
			$this->name = mysql_real_escape_string($_POST["name"]);
	
		if (isset($_POST["country"]))
			$this->country = mysql_real_escape_string($_POST["country"]);
			
		if (isset($_POST["information"]))
			$this->information = mysql_real_escape_string($_POST["information"]);
			
		if (isset($_POST["show"]))
			$this->show = $_POST["show"];
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
		 * Test echo phone information (only test!)
	 	 */	
		//$this->echoLocation();
		
		$check_location = $this->CheckLocation();

		if ($check_location!=0)
			return $check_location;
			
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->name == "") || ($this->country == "")){
			$this->output = "3";
			return $this->output;
		}
		
		/**
		 * Check if there is location allready
		 * Adding location not successfully! Database has allready location with same name in same country.
		 */
		$sql = "SELECT * FROM location WHERE name = '$name' and country ='$country'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$this->output = "1";
			return $this->output;
		}
						
		/**
		 * Insert location to database
		 */
		$sql = "INSERT INTO `location` (name, country, information, showme, cadmin, changeday, cadmin_name)" .
 		" VALUES ('$this->name', '$this->country', '$this->information', '$this->show', " .
 		"'$this->cadmin', '$this->changeday', '$this->cadmin_name')";
				
		$tulos = $db->UseSQL($sql);
			
		$this->SearchNewst();
		$this->output = "0";
		
		return $this->output;
	}
	
	/**
	 * Search the newst
	 */
	public function SearchNewst(){
		if (!isset($db))
			$db = new Database(); 
		$db->Database();
 		
		$this->output = "";
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
		
		//$this->echoLocation();
			
		$check_location = $this->CheckLocation();

		if ($check_location!=0)
			return $check_location;
		
		/**
		 * If empty then give error
		 */
		if (($this->name == "") || ($this->country == "")){
			$this->output = "3";
			return $this->output;
		}
		
		/**
		 * Check if there is location allready
		 * Adding location not successfully! Database has all ready location with same name in same country.
		 */
		 
		$sql = "SELECT * FROM location WHERE id <> '$this->id' AND name = '$this->name' and country ='$this->country'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$this->output = "1";
			return $this->output;
		}
		
		/**
		 * Make update and give user that information
		 */
		$sql = "UPDATE `location` SET name = '$this->name', country = '$this->country', information = '$this->information', " .
		"showme = '$this->show', cadmin = '$this->cadmin', changeday = '$this->changeday', " .
		"cadmin_name='$this->cadmin_name' WHERE id = '$this->id'";
		
		//echo "$sql<br>";
		$db->UseSQL("$sql");
		
		$this->output = "0";
		return $this->output;
	}

	/**
	 * Delete location and give info to user
	 */
	public function DeleteLocation($location_id){
		if (!isset($db))
			$db = new Database();
			
		$this->output = $this->CheckBeforeDelete("$location_id");
		
		if ($this->output=="0"){	
			$sql = "DELETE FROM `location` WHERE id = '$location_id'";
			$db->UseSQL("$sql");
		}
		
		return $this->output;
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
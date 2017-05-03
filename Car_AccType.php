<?php
/**
 * Heurex Rental 0.0
 * Car_AccType.php
 * 29.05.2012
 */ 
class Car_AccType
{
	var $id;
	var $name;
	var $picture;
  	var $cadmin;
   	var $changeday;
	var $cadmin_name;
	var $information;
 	 	
   	/**
	 * Read Car_AccType
	 */
	public function ReadCarAccType($in_id){
		if (!isset($db))
 			$db = new Database();
			
 		$db->Database();
 		
		$output = "";
		$sql = "SELECT * FROM `car_acctype` WHERE id = '$in_id'";
		
		//$this->id = $in_id;
		
		if ($in_id != ""){
				
			$haku = $db->AskSQL($sql);
		
			$rows = mysql_num_rows($haku);
			$rivi = mysql_fetch_row ($haku);
			
			//print "$sql<br>";

			if (mysql_num_rows($haku) > 0){
				$this->id = $rivi[0];
				$this->name = $rivi[1];	
				$this->picture = $rivi[2];
				$this->cadmin = $rivi[3];
				$this->changeday = $rivi[4];	
				$this->cadmin_name = $rivi[5];
				$this->information = $rivi[6];
			}		
		}			
		
		//$tmp = $this->PrintAccType;
			
		if ($this->picture == "")
			$this->picture = "acc_1.gif";
			
		if ($this->cadmin == "")
			$this->cadmin = $_SESSION['LogInUser']->id;
			
		if ($this->changeday == "")
			$this->changeday = time();
			
		if ($this->cadmin_name == "")
			$this->cadmin_name = "Administrator";
			
		$output = $this->name;
	
		return $output;
	}
	
	/**
	 * Test print Accessory type information
	 */
	public function PrintCarAccType(){
		print "id: $this->id<br>\n";
		print "name: $this->name<br>\n";
		print "picture: $this->picture<br>\n";
		print "cadmin: $this->cadmin<br>\n";
		print "changeday: $this->changeday<br>\n";
		print "cadmin_name: $this->cadmin_name<br>\n";
		print "information: $this->information<br>\n";
	}
	
    public function ShowCarAccTypes($location, $locationname){
		if (!isset($db))
			$db = new Database();
			
		$page2 = $_SESSION['Search']->page2;
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if ($page2 == "searchform"){
			$sql = $_SESSION['Search']->sql_acctype;
		} else {	
			$sql = "SELECT id,name,picture,cadmin,changeday,";
			$sql = $sql . "cadmin_name FROM car_acctype";
			$sql = $sql . " ORDER BY id";
		}
		
		$l = 2;
		if ($oikeus > "1"){
			$l = 3;
		}
		
		//print "$sql<br>";
		
		$tmp_acctype="<a href=\"index.php?page=car_acctype&page2=searchform&product=acctype&order_acctype=";
		
		$output2 ="Lis‰varusteet";
		
		$output = "<table width=\"950\"><tr><td colspan=\"$l\" class=\"td_phonelistheader\">";
		$output = $output . "<a href=\"classes/excel.php?name=$output2&cols=2&col1=0&col2=1&coln1=ID&coln2=Name&sql=$sql\"><img src=\"pictures/excel.gif\" border=\"0\" title=\"Excel\"></a>&nbsp;";
		$output = $output . "$output2</td></tr><tr>";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_acctype . "id\">Id</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_acctype . "name\">name</a></td>";
		
		if ($oikeus > "1"){
			$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">Edit</td>";
		}
		
		$output = $output . "</tr>\n";
		//print "$page2 -> $sql<br>";	

		$haku = $db->AskSQL($sql);
	
		if (mysql_num_rows($haku) > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
							
				$output = $output . "<tr>";
				$toiminnot = "";
				if ($oikeus > "1"){
					$toiminnot = "<a href=\"index.php?page=acctype&id=$rivi[0]&acctype_id=$rivi[0]&edit=1\"><img src=\"pictures/update2.gif\" border=\"0\" title=\"Update accessory type\"></a>";
					$toiminnot = $toiminnot . "&nbsp;<a onclick=\"return confirmSubmitACCTYPE()\" href=\"index.php?page=acctype&id=$rivi[0]&acctype_id=$rivi[0]&delete=1\"><img src=\"pictures/poista2.gif\" border=\"0\" title=\"Delete accessory type\"></a>";
					$toiminnot = "<td class=\"td_editdellistrow\">$toiminnot</td>";
				}
				
				$output = $output . "<td class=\"td_phonelistrow\"><a href=\"index.php?page=acctype&id=$rivi[0]&acctype_id=$rivi[0]&show=1\">$rivi[0]</a>&nbsp;</td><td class=\"td_phonelistrow\"><a href=\"index.php?page=acctype&id=$rivi[0]&acctype_id=$rivi[0]&show=1\">$rivi[1]</a>&nbsp;</td>$toiminnot\n";
				
				$output = $output . "</tr>";
			}
		} else {
			$output = $output . "<tr><td colspan=\"3\" class=\"td_phonelistrow\">No accessory types!</td></tr>";
		}
				
		$output = $output . "</table>";
		/*
		if ($oikeus > "1"){
			$output = $output . "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
			$output = $output . "<td class=\"tab\"><a href=\"index.php?page=accessory&id=''&location=$location&new=1\">&nbsp;New&nbsp;</a></td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "</tr></table>\n";
		}
		*/
		print "$output";
	}
	
	/**
	 * Edit Car Accessory type
	 */
	public function EditCarAccType($in_id, $location2, $thing){				
		if (!isset($user))
			$user = new User();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		if ($in_id!="")
			$this->id = $in_id;	
			
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if (isset($_GET["ed"])=="1"){
			$this->id = $rivi[0];
			$this->name = $_POST["name"];
			$this->picture = $_POST["picture"];
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = $_POST["changeday"];	
			$this->cadmin_name = $_POST["cadmin_name"];
			$this->information = $_POST["information"];		
		} else {
			$this->ReadCarAccType($in_id);
		}
		
		$tmp = $this->ReadCarAccType($this->type);
		
		//$this->PrintAccessory();
		
		if (isset($_GET["copy2new"])=="1"){
			$this->id = "";
			$thing = "new";
			$this->cadmin = $_SESSION['LogInUser']->id;
		}
		
		if (($thing == "edit") || ($thing == "new")){
			$this->changeday = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
		}
		
		//$this->PrintCarAccType();
		
		print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">";
				
		if ($thing == "edit"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Edit accessory type</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"updateacctype\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"updateacctype\">\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$this->id\">\n";
			print "<input type=\"hidden\" name=\"acctype_id\" value=\"$this->id\">\n";
		}
		
		if ($thing == "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Add accessory type</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"newacctype\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"newacctype\">\n";
			$this->iperson = $_SESSION['LogInUser']->id;
		}
		
		print "<input type=\"hidden\" name=\"page\" value=\"acctype\">\n";
		print "<input type=\"hidden\" name=\"picture\" value=\"acc_1.gif\">\n";
		
		if ($thing != "edit" && $thing != "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Accessory type info</td></tr>";
		}
			
		if ($this->id != ""){
			print "<tr><td class=\"tab1\" colspan=\"1\">Accessory type id number:</td><td class=\"tab2\" colspan=\"2\">$this->id</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Name:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"name\" size=\"40\" value=\"$this->name\">";
		} else {
			print "$this->name&nbsp;";
		}
		
		print "</td></tr>\n";
		
		/*
		print "<tr><td class=\"tab1\" colspan=\"1\">picture:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"picture\" size=\"40\" value=\"$this->picture\">";
		} else {
			print "$this->picture&nbsp;";
		}
		
		print "</td></tr>\n";
		*/

		print "<tr><td class=\"tab1\" colspan=\"1\">Information:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>";
		} else {
			print "$this->information&nbsp;";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Last change:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		//$lastadmin = $user->GetUserName($this->cadmin);
		$this->changeday = $fixdate->ReturnDate($this->changeday);
		$temp = date("Y-m-d",$this->changeday);
		print "$this->cadmin_name $temp";
		
		print "</td></tr></table>";
		
		if ($oikeus > "1"){			
			if (($thing == "edit") || ($thing == "new")){
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				//print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\" colspan=\"1\">";
				print "<div><input type=\"submit\" value=\"Submit\" id=\"el09\"></div></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\" colspan=\"1\"></td>\n";
				//print "<div><input type=\"reset\" value=\"Clear\" id=\"el09\"></div></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n</tr>\n";
				print "</form>";
				print "</td></tr></table>";
			} else {
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				print "<td class=\"tab\"><a href=\"index.php?page=acctype&id=$this->id&acctype_id=$this->id&edit=1\">&nbsp;Edit&nbsp;</a></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\"><a onclick=\"return confirmSubmitACCTYPE()\" href=\"index.php?page=acctype&id=$this->id&acctype_id=$this->id&delete=1\">&nbsp;Delete&nbsp;</a></td>\n";
				print "</tr></table>\n";
			}		
		}
	}
	
	
	/**
	 * Check Car accessory data
	 */
	public function CheckCarAccType(){
		$output = 0;
				
		$t = "/^[a-‰A-÷0-9:-@\£\Ä%&#! ;\-_\[\]\.\,\/\\(\)\<\>\|\+\*\?]{1,40}$/";
    	
		if ($this->name == "" || !preg_match("$t",$this->name)) { 
			$output = "10";
			return $output;
		}	
    	/*
		if ($_SESSION['Search']->CheckText($this->picture,11) == 11) { 
			$output = "11";
			return $output;
		}	
		*/			
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
	 * Add new Car accessory type to database
	 */
	public function AddCarAccType(){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->picture = mysql_real_escape_string($_POST["picture"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());	
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		$check_acctype = $this->CheckAccType();
		if ($check_acctype!=0)
			return $check_acctype;
				
		/**
		 * Test Print Acc Type information (only test!)
	 	 */	
		//$this->PrintAccType();
		
		/**
		 * Check if all nessessary things are filled
		 */
		if (($this->name == "") || ($this->picture == "")){
			$output = "3";
			return $output;
		}
		
				
		/**
		 * Insert accessory type to database
		 */
		$sql = "INSERT INTO `car_acctype` (name, picture, cadmin, changeday, cadmin_name, information)" .
 		" VALUES ('$this->name', '$this->picture', '$this->cadmin', '$this->changeday', " .
 		"'$this->cadmin_name','$this->information')";		
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
		$sql = "SELECT MAX(id) FROM `car_acctype`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
		}
	}	

	/**
	 * Update caraccessory to database
	 */
	public function UpdateCarAccType(){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$this->id = $_POST["id"];
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->picture = mysql_real_escape_string($_POST["picture"]);
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());	
		$this->information = mysql_real_escape_string($_POST["information"]);
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		$check_acctype = $this->CheckCarAccType();
		if ($check_acctype!=0)
			return $check_acctype;
					
		/**
		 * Test print Acc type information (only test!)
	 	 */	
		//$this->PrintAccType();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->name == "") || ($this->picture == "")){
			$output = "3";
			return $output;
		}
					
		/**
		 * update accessory to database
		 */
		$sql = "UPDATE `car_acctype` SET name='$this->name', picture='$this->picture', cadmin='$this->cadmin', changeday='$this->changeday', cadmin_name='$this->cadmin_name', information='$this->information' " .
		"WHERE id='$this->id'";
				
		//print "$sql<br>\n";	
		$tulos = $db->UseSQL($sql);
	
		$output = "0";
		
		return $output;
	}	

	/**
	 * Remove Car acctype
	 */
	public function DeleteCarAccType($acctype_id){
		if (!isset($db))
			$db = new Database();
		//print "$acctype_id<br>";
		/**
		 * Copy to deleted
		 */
		//$this->DeletedAccType($acctype_id);	
		$output = $this->CheckBeforeDelete($acctype_id);
		
		//print "$output<br>";
		
 		if($output=="0"){
			$sql = "DELETE FROM `car_acctype` WHERE id = '$acctype_id'";
			$db->UseSQL("$sql");
			$output = "0";
		}

		return $output;
	}
	
	/**
	 * Check Before Delete
	 */
	public function CheckBeforeDelete($in_acctype){
		if (!isset($db))
			$db = new Database(); 
			
		$db->Database();
						
		$sql = "SELECT * FROM accessories WHERE typea = '$in_acctype'";
		//print "$sql<br>";
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id:" . $rivi[0] . " " . $rivi[2] . " " . $rivi[3];
			return "10";
		} else {
			return 0;
		}
	}
	
	/**
	 * Copy Car accessories to deleted
	 */
	public function DeletedCarAccType($acctype_id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		 		
 		$this->ReadCarAccType($acctype_id);
 		
		/**
		 * Insert Car Accessory type to database
		 */
		if ($id != ""){	
			$sql = "INSERT INTO `deleted_car_acctype` (id, name, picture, cadmin, changeday, cadmin_name, information)" .
 			" VALUES ('$this->id', '$this->name', '$this->picture', '$this->cadmin', '$this->changeday', " .
 			"'$this->cadmin_name','$this->information')";		
 		
			$tulos = $db->UseSQL($sql);
		}		
	}
			
}

?>

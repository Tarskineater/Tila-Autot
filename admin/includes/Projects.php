<?php
/**
 * Inventory Tool 0.7
 * Projects.php
 * 07.04.2008
 */
/**
 * Projects
 */

class Projects{
	var $id;
	var $number;
	var $name;
	var $status;
	var $location;
	var $information;
	var $show;
	var $cadmin;
 	var $changeday;
	var $manager;
 	var $location2;
 	var $thing;
	var $location_name;
	var $manager_name;
	var $cadmin_name;
	
	public function Project($name_id){
		$this->name = $project;
	}
	
	/*
 	public static item($item){
  		return $this->places[$item];
 	}
*/
   	/**
	 * Read Project
	 */
	public function ReadProject($id){
		
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
		$output = "";
	
		$sql = "SELECT * FROM `projects` WHERE id='$id'";
		//print "$id $sql\n";
		
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		/**
		 * read project information to 
		 */
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
			$this->number = stripslashes(nl2br($rivi[1]));
			$this->name = stripslashes(nl2br($rivi[2]));
			$this->status = $rivi[3];
			$this->location = $rivi[4];
			$this->information = stripslashes(nl2br($rivi[5]));
			$this->show = $rivi[6];
			$this->cadmin = $rivi[7];
			$this->changeday = $rivi[8];
			$this->manager = $rivi[9];
			$this->location_name = $rivi[10];
			$this->manager_name = $rivi[11];
			$this->cadmin_name = $rivi[12];
			$output = $this->name;	
			//$this->information = $this->FixThisfknText($this->information);
		}
		
		$this->information = str_replace("<br />", "", $this->information);
		
		/**
		if ($this->manager == ""){
			$this->PrintProject();
			$this->manager = "";
		}	
		*/
		/**
		 * If there is no projects then show information to user
		 */
		if (mysql_num_rows($haku) < 1){
			$this->id = "";
			$this->number = "";
			$this->name = "";
			$this->status = "";
			$this->location = "";
			$this->information = "";
			$this->show = "1";
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = time();
			$this->manager = "";
			$output = "No project";
		}
		
		//$this->PrintProject();
		return $output;
	}
	
	/**
	 * Test print location information
	 */
	public function PrintProject(){
		print "id: $this->id<br>\n";
		print "number: $this->number<br>\n";
		print "name: $this->name<br>\n";
		print "status: $this->status<br>\n";
		print "manager: $this->manager<br>\n";	
		print "location: $this->location<br>\n";
		print "information: $this->information<br>\n";
		print "showme: $this->show<br>\n";
		print "cadmin: $this->cadmin<br>\n";
		print "changeday: $this->changeday<br>\n";	
		print "location_name: $this->location_name<br>\n";
		print "manager_name: $this->manager_name<br>\n";
		print "cadmin_name: $this->cadmin_name<br>\n";
	}
	
	public function ProjectDropDown($in_id, $in_location){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
 		$this->id = $in_id;
 		$this->location = $in_location;
 		 
 		if ($this->location==""){
			$sql = "SELECT * FROM `projects` ORDER BY number";
		}else {
			$sql = "SELECT * FROM `projects` WHERE location=$this->location ORDER BY number";
		}
		
		//print "$sql<br>";
 		$output = "<select name=\"project\">\n";
		$output = $output . "<option value =\"\">&nbsp;- Project -&nbsp;</option>\n";  
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($this->id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>&nbsp;$rivi[1] $rivi[2]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">&nbsp;$rivi[1] $rivi[2]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}
	

  	/**
	 * ShowProjects
	 */
	public function ShowProjects($ulocation, $ulocationname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		if (isset($_GET["location"]) == "") {
 			$_GET["location"] = 2;
	 	}
	 	
		if (!isset($user))
			$user = new User();
			
		if (!isset($locations))
			$locations = new Location();
			
	 	$this->location = $_GET["location"];
	 	$this->search = " ";
	 	if ($this->location!="1")
	 		$this->search = "WHERE projects.location='$this->location' ";
	 	
	 	$page2 = $_SESSION['Search']->page2;
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$l = 7;
		if ($oikeus > "1"){
			$l = 8;
		}

		/**	
		$sql = "SELECT projects.id, projects.number, projects.name, projects.status, projects.location, ";
		$sql = $sql . "projects.information, projects.showme, location.id, location.name, location.country ";
		$sql = $sql . "FROM projects JOIN location ON projects.location = location.id $this->search";
		$sql = $sql . "ORDER BY projects.location, projects.name";
		*/
		
		$sql = "SELECT * FROM projects $this->search ";
		$sql = $sql . "ORDER BY location, name";
		
		if ($page2 == "searchform"){
			$sql = $_SESSION['Search']->sql_project;
			/**
			} else {	
			$sql = "SELECT projects.id, projects.number, projects.name, projects.status, projects.location, ";
			$sql = $sql . "projects.information, projects.showme, location.id, location.name, location.country ";
			$sql = $sql . "FROM projects JOIN location ON projects.location = location.id $this->search";
			$sql = $sql . "ORDER BY projects.location, projects.name";
			*/
		}
		
		//print "$ulocationname$sql<br>\n";
		
		if($ulocationname=="All"){
			$output2 = "Project list"; 
		} else {
			$output2 = "$ulocationname projects"; 
		}
		
		$tmp_project="<a href=\"index.php?page=project&page2=searchform&product=project&order_project=";
		
		$output = "<table width=\"950\"><tr><td colspan=\"$l\" class=\"td_phonelistheader\">";
		$output = $output . "<a href=\"classes/excel.php?name=$output2&cols=4&col1=0&col2=2&col3=11&col4=10&";
		$output = $output . "coln1=ID&coln2=Name&coln3=Manager&coln4=Location&sql=$sql\">";
		$output = $output . "<img src=\"pictures/excel.gif\" border=\"0\" title=\"Excel\"></a>&nbsp;";		
		$output = $output . "$output2</td></tr><tr>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_project . "name\">Name</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_project . "manager_name, name\">Manager</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_project . "location_name, name\">Location</a></td>"; //<td class=\"td_phonelistheader\" colspan=\"1\">Activity</td>";
		
		if ($oikeus > "1"){
			$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">Edit</td>";
		}
		
		$output = $output . "</tr>\n";

		$haku = $db->AskSQL($sql);
				
		$rows = mysql_num_rows($haku);
	
		$x = 0;
		/**
		 * If there is project then show them
		 */
		if (mysql_num_rows($haku) > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				$tmp_loc = "&nbsp;";
				/*
				if ($rivi[4]!="0" || $rivi[4]!=""){
					$sql2 = "SELECT * FROM `location` WHERE id = '" . $rivi[4] . "' ORDER BY name, country";
					$haku2 = $db->AskSQL($sql2);
					$rivi2 = mysql_fetch_row ($haku2);
					if ($rivi2[1] !="" || $rivi2[2]!="")
						$tmp_loc = $rivi2[1] . ",<br>" . $rivi2[2] . "$tmp_loc";
				}
				*/
				//$temp2 = $locations->ReadLocation($rivi[4]);
				$temp2 = "<td class=\"td_phonelistrow\" colspan=\"1\"><a href=\"index.php?page=location&id=$rivi[4]&location_id=$rivi[4]&show=1\">$rivi[10]</a>&nbsp;</td>";					
				
				$temp3 = $user->GetUserName($rivi[9]);
				$temp3 = "<td class=\"td_phonelistrow\">$temp3&nbsp;</td>";
				/**
			 	* Show edit buttons
			 	*/
				$x = $x + 1;
				if (($oikeus == $ulocation) || ($oikeus == 99)){
 					$toiminnot = "<td class=\"td_editdellistrow\"><a href=\"index.php?page=project&id=$rivi[0]&project_id=$rivi[0]&edit=1\"><img src=\"pictures/update2.gif\" border=\"0\" title=\"Update information\"></a>&nbsp;<a onclick=\"return confirmSubmitPROJECT()\" href=\"index.php?page=project&id=$rivi[0]&project_id=$rivi[0]&delete=1\"><img src=\"pictures/poista2.gif\" border=\"0\" title=\"Delete project\"></a></td>";
				}
				/*
				if ($rivi[6] == 1){
					$show = "<img src=\"pictures/show.gif\" border=\"0\" title=\"Show\">\n";
				} else {
					$show = "<img src=\"pictures/noshow.gif\" border=\"0\" title=\"No show\">\n";
				}
				*/
				/*
				if ($rivi[3] == 1){
  					$status = "In use\n";  
				} else {
					$status = "Not in use\n";  
				}
				*/
				/**
			 	 * Print phone informations
			  	 */
				$output = $output . "<tr><td class=\"td_phonelistrow\"><a href=\"index.php?page=project&id=$rivi[0]&project_id=$rivi[0]&show=1\">$rivi[2]</a>&nbsp;</td>$temp3$temp2"; //<td class=\"td_phonelistrow\">$status</td>";
				
				if ($oikeus > "1"){
					$output = $output .  "$toiminnot";
				}
				
				$output = $output . "</tr>\n";
			}
		}
		
		/**
		 * No projects
		 */
		if ($x < 1){
			$output = $output . "<tr><td colspan=\"9\" class=\"td_phonelistrow\">No projects!</td></tr>";
		}
		
		$output = $output . "</table>";
		/*
		if ($oikeus > "1"){
			$output = $output . "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
			$output = $output . "<td class=\"tab\"><a href=\"index.php?page=project&id=''&location=$location&new=1\">&nbsp;New&nbsp;</a></td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
			$output = $output . "</tr></table>\n";
		}
		*/
		print "$output";
		
		return $output;
	}

	/**
	 * Edit Project
	 */
	public function EditProject($in_id, $location2, $thing){
		if ($in_id != ""){
			$this->id = $in_id;
		}
	
		$this->location2 = $location2;
		$this->thing = $thing;
		
		if (!isset($user))
			$user = new User();
		
		if (!isset($locations))
			$locations = new Location();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
				 	
	 	$this->location = $_GET["location"];
	 	if ($this->location =="")
	 	 	$this->location= $_SESSION['LogInUser']->location;
	 	 	 	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if (isset($_GET["ed"])=="1"){
			$this->number = $_POST["number"];
			$this->name = $_POST["name"];
			$this->status = $_POST["status"];
			$this->manager = $_POST["manager"];
			$this->location = $_POST["location"];
			$this->information = $_POST["information"];
			$this->show = $_POST["showme"];	
			$this->changeday = time();	
		} else {
			$this->ReadProject($this->id);
			$this->changeday = time();
		}
		
		/*
		if (isset($_GET["copy2new"])=="1"){
			$this->id = "";
			$thing = "new";																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														$in_id, 
		}
		*/
		if (($thing == "edit") || ($thing == "new")){
			$this->changeday = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
		}

		print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">\n";

		if ($thing == "edit"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Edit project</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"updateproject\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"updateproject\">\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$this->id\">";
			print "<input type=\"hidden\" name=\"project_id\" value=\"$this->id\">";
		}
		
		if ($thing == "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Add project</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"newproject\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"newproject\">\n";
		}
			
		if ($thing != "edit" && $thing != "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Project info</td></tr>";
		} else {
			print "<input type=\"hidden\" name=\"page\" value=\"project\">\n";
			print "<input type=\"hidden\" name=\"showme\" value=\"1\">\n";
			print "<input type=\"hidden\" name=\"status\" value=\"1\">\n";
		}
				
		if ($this->id != ""){
			print "<tr><td class=\"tab1\" colspan=\"1\">Project id number:</td><td class=\"tab2\" colspan=\"2\">$this->id</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Number:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"number\" size=\"40\" value=\"$this->number\">";
		} else {
			print "$this->number&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Name:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"name\" size=\"40\" value=\"$this->name\">";
		} else {
			print "$this->name&nbsp;";
		}
		
		print "</td></tr>\n";
	/**	
		print "<tr><td class=\"tab1\" colspan=\"1\">Status:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if ($this->status == ""){
			$this->status = 1;
		}
		
		if (($thing == "edit") || ($thing == "new")){
			print "<select name=\"status\">\n";
			if ($this->status == 0){
					print "<option value =\"0\" selected>Not in use</option>\n";  
					print "<option value =\"1\">In use</option>\n";  
			} else {
				print "<option value =\"0\">Not in use</option>\n";  
					print "<option value =\"1\" selected>In use</option>\n";   
			}
			print "<select>\n";
		} else {
			
			if ($this->status == 0){
					print "Not in use\n";  
			} else {
					print "In use\n";   
			}
		}
		
		print "</td></tr>\n";
*/
		print "<tr><td class=\"tab1\" colspan=\"1\">Manager:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if ((($thing == "edit") || ($thing == "new")) && $this->manager == "")
			$this->manager = $_SESSION['LogInUser']->id;
		
		//$ipersonname = $user->GetUserName($this->manager);
		
		if (($thing == "edit") || ($thing == "new")){
			print $user->UserDropDown($this->manager,"manager");
		} else {
			print "$this->manager_name&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Location:</td><td class=\"tab2\" colspan=\"2\">\n";
		/*
		if ($this->location == ""){
			$this->location = $_GET["location"];
		}
		*/
		if (($thing == "edit") || ($thing == "new")){
			print $locations->LocationDropDown($this->location);
			//print "<input type=\"text\" name=\"location\" size=\"40\" value=\"$this->location $location\">";
			print "</td></tr>\n";
		} else {
			print "$this->location_name&nbsp;"; //$locations->ReadLocation($this->location) . "&nbsp;";
		}
		
		print "</td></tr>\n";
		
				
		//print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Information:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>";
		} else {
			print "$this->information&nbsp;";
		}
		
		print "</td></tr>\n";
		/**
		print "<tr><td class=\"tab1\" colspan=\"1\">Shown:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<select name=\"showme\">\n";
			if ($this->show == "0"){
					print "<option value =\"0\" selected>Do not show   </option>\n";  
					print "<option value =\"1\">Show me   </option>\n";  
			} else {
				print "<option value =\"0\">Do not show   </option>\n"; 
				print "<option value =\"1\" selected>Show me   </option>\n";  
			}
			$output = $output . "<select>\n";
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
				print "</td></tr></table>";
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
				print "</td></tr></table>";
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				print "<td class=\"tab\"><a href=\"index.php?page=project&id=$this->id&project_id=$this->id&edit=1\">&nbsp;Edit&nbsp;</a></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\"><a onclick=\"return confirmSubmitPROJECT()\" href=\"index.php?page=project&id=$id&project_id=$this->id&delete=1\">&nbsp;Delete&nbsp;</a></td>\n";
				print "</tr></table>\n";
			}		
		}
	}
		
	/**
	 * Check project data
	 */
	public function CheckProject(){
		$output = 0;
				
		if ($this->number == "" || !preg_match("/^[0-9]{1,254}$/",$this->number)) { 
			$output = "10";
			return $output;
		}	
		
		if ($this->name == "" || $_SESSION['Search']->CheckText($this->name,11) == 11) { 
			$output = "11";
			return $output;
		}	
		
 		if ($this->location == "0" || $this->location == "") { 
			$output = "12";
			return $output;
		}
				
 		if ($this->information != "" && $_SESSION['Search']->CheckText($this->information,13) == 13) { 
			$output = "13";
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
			
		if (!isset($user2))
			$user2 = new User();
			
		$this->location_name = $locations2->ReadLocation($this->location);
		$user2->ReadUser($this->manager);
		$this->manager_name = $user2->name;
		$user2->ReadUser($this->cadmin);	
		$this->cadmin_name = $user2->name;	
	}
	
	/**
	 * Add new project to database
	 */
	public function AddProject(){
		if (!isset($db))
			$db = new Database();
					
		//$this->$id = $in_id;
		$this->number = mysql_real_escape_string($_POST["number"]);
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->status = $_POST["status"];
		$this->manager = $_POST["manager"];
		$this->location = $_POST["location"];
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->show = $_POST["showme"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i", time());
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		/**
		 * Test print project information (only test!)
	 	 */	
		//$this->PrintProject();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->name == "") || ($this->number == "") ||($this->location == "")){
			$output = "2";
			return $output;
		}
		
		/**
		 * Check if there is location allready
		 * Adding location not successfully! Database has allready location with same name in same country.
		 */
		$sql = "SELECT * FROM `projects` WHERE number ='$number'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "1";
			return $output;
		}
						
		/**
		 * Insert projects to database
		 */
		$sql = "INSERT INTO `projects` (number, name, status, manager, location, information, " .
		"showme, cadmin, changeday, location_name, manager_name, cadmin_name)" .
 		" VALUES ('$this->number', '$this->name', '$this->status', '$this->manager', " .
 		"'$this->location', '$this->information', '$this->show', '$this->cadmin', " .
 		"'$this->changeday', '$this->location_name', '$this->manager_name', '$this->cadmin_name')";
 		
		//print "$sql<br>";		
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
		$sql = "SELECT MAX(id) FROM `projects`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
		}
	}

	/**
	 * Update project to database
	 */
	public function UpdateProject(){
		if (!isset($db))
			$db = new Database();
			
		$this->id = $_POST["id"];
		$this->number = mysql_real_escape_string($_POST["number"]);
		$this->name = mysql_real_escape_string($_POST["name"]);
		$this->status = $_POST["status"];
		$this->manager = $_POST["manager"];
		$this->location = $_POST["location"];
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->show = $_POST["showme"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i", time());
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		$check_project = $this->CheckProject();
		
		$this->information = $_SESSION['Search']->FixThisfknText($this->information);
		if ($check_project!=0)
			return $check_project;
			
		/**
		 * Test print project information (only test!)
	 	 */	
		//$this->PrintProject();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->name == "") || ($this->number == "")){
			$output = "2";
			return $output;
		}
		
		$this->information = $_SESSION['Search']->FixThisfknText($this->information);	
			
		/**
		 * update project to database
		 */
		$sql = "UPDATE `projects` SET number='$this->number', name='$this->name', status='$this->status', " .
		"manager='$this->manager', location='$this->location', information='$this->information', " .
		"location='$this->location', showme='$this->show', cadmin='$this->cadmin', changeday='$this->changeday', " .
		"location_name='$this->location_name', manager_name='$this->manager_name', cadmin_name='$this->cadmin_name' WHERE id='$this->id'";
		//print "$sql<br>\n";	
		$tulos = $db->UseSQL($sql);
		//print "$tulos<br>\n";		
		$output = "0";
		$_POST["id"] = $this->id;
		return $output;
	}

	/**
	 * Remove project
	 */
	public function DeleteProject($project_id){
		if (!isset($db))
			$db = new Database();
			
		/**
		 * Copy to deleted
		 */
		$this->DeletedProjects($project_id);
		
		$sql = "DELETE FROM `projects` WHERE id = '$project_id'";
		
		$db->UseSQL("$sql");
		
		$output = "Project is deleted from database!";
		return $output;
	}
	
	/**
	 * Copy project to deleted
	 */
	public function DeletedProjects($project_id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		 		
 		$this->ReadProject($project_id);
 		
		/**
		 * Insert Project to database
		 */
		if ($id != ""){			
			$sql = "INSERT INTO `deleted_projects` (id, number, name, status, manager, location, " .
			"information, showme, cadmin, changeday, location_name, manager_name, cadmin_name)";
 			$sql = $sql . " VALUES ('$this->id', '$this->number', '$this->name', '$this->status', " .
 			"'$this->manager', '$this->location', '$this->information', '$this->show', '$this->cadmin', " .
 			"'$this->changeday', '$this->location_name', '$this->manager_name', '$this->cadmin_name')";

			$tulos = $db->UseSQL($sql);
		}		
	}
}
?>
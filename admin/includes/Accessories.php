<?php
/**
 * Inventory Tool 0.7
 * Accessories.php
 * 07.04.2008
 */
class Accessories
{
	var $id;
	var $project;
	var $manufactor;
	var $model;
	var $status;
	var $location;
	var $information;
	var $reserve_id;
	var $type;
  	var $cadmin;
  	var $changeday;
	var $classa;
	var $proto;
	var $rdate;
	var $sdate;
	var $idate;
	var $iperson;
	var $owner;
	var $location_name;
	var $project_name;
	var $iperson_name;
	var $cadmin_name;
	var $acctype_name;
  	/**
  	 * Type
  	 */
  	var $acc_id;
  	var $acc_name;	
  	var $acc_picture;
  	var $acc_cadmin;
  	var $acc_changeday;	
		
  	/**
  	 * Project
  	 */		
  	var $pro_id;
  	var $pro_number;
  	var $pro_name;
  	
 	/**public static item($item){
  		return $this->acctype[$item];
 	}
 	 */
 	 	
   	/**
	 * Read Accessory
	 */
	public function ReadAccessory($in_id){
		if (!isset($db))
 			$db = new Database();
 			
		if (!isset($project))
			$project = new Projects();
			
 		$db->Database();
 		
		$output = "";
		$sql = "SELECT accessories.id, accessories.project, accessories.manufactor, accessories.model, " .
		"accessories.statusa, accessories.location, accessories.information, accessories.reserve_id, " .
		"accessories.typea, accessories.cadmin, accessories.changeday, accessories.classa, accessories.proto, " .
		"accessories.rdate, accessories.sdate, accessories.idate, accessories.iperson, accessories.owner, accessories.location_name, accessories.project_name, accessories.iperson_name, accessories.cadmin_name, accessories.acctype_name " .
		"FROM accessories WHERE accessories.id = '$in_id'";
		
	//print "$in_id<br>$sql <br>";
		
		if ($in_id != ""){
				
			$haku = $db->AskSQL($sql);
		
			$rows = mysql_num_rows($haku);
			$rivi = mysql_fetch_row ($haku);
			
			//print "$sql<br>";

			if (mysql_num_rows($haku) > 0){
				$this->id = $rivi[0];
				$this->project = $rivi[1];	
				$this->manufactor = stripslashes(nl2br($rivi[2]));
				$this->model = stripslashes(nl2br($rivi[3]));
				$this->status = stripslashes(nl2br($rivi[4]));
				$this->location = $rivi[5];
				$this->information = stripslashes(nl2br($rivi[6]));	
				$this->reserve_id = $rivi[7];
				$this->type = stripslashes(nl2br($rivi[8]));				
				$this->cadmin = $rivi[9];
				$this->changeday = $rivi[10];	
				$this->classa = stripslashes(nl2br($rivi[11]));
				$this->proto = stripslashes(nl2br($rivi[12]));
				$this->rdate = $rivi[13];
				$this->sdate = $rivi[14];
				$this->idate = $rivi[15];
				$this->iperson = $rivi[16];
				$this->owner = stripslashes(nl2br($rivi[17]));	
				$this->location_name = $rivi[18];
				$this->project_name = $rivi[19];
				$this->iperson_name = $rivi[20];
				$this->cadmin_name = $rivi[21];
				$this->acctype_name = $rivi[22];
				/*	
				$this->acc_id = $rivi[18];
				$this->acc_name = $rivi[19];	
				$this->acc_picture = $rivi[20];
				$this->acc_cadmin = $rivi[21];
				$this->acc_changeday = $rivi[22];
*/
				//$tmp = $this->PrintAccessory;
				if ($this->project != ""){
									
					$sql2 = "SELECT * FROM `projects` WHERE id='$this->project'";
				
					$haku2 = $db->AskSQL($sql2);
					//print "$sql2 <br>";
					$rows2 = mysql_num_rows($haku2);
					$rivi2 = mysql_fetch_row ($haku2);
		
					$this->pro_id = $rivi2[0];	
					$this->pro_number = $rivi2[1];	
					$this->pro_name = $rivi2[2];
				}	
				/**
				 * Read acc type
				 */
				$tmp = $this->ReadAccessoryType($this->type);
			}		
		}			
		
		//$tmp = $this->PrintAccessory;
		
		if ($this->project == "")
			$this->project = "1";
			
		if ($this->manufactor == "")
			$this->manufactor = "Nokia";
			
		if ($this->model == "")
			$this->model = "";
			
		if ($this->status == "")
			$this->status = "";
			
		if ($this->location == "")
			$this->location = "2";
		
		if ($this->information == "")
			$this->information = "";
			
		$this->information = str_replace("<br />", "", $this->information);
		
		if ($this->reserve_id == "")
			$this->reserve_id = "0";
			
		if ($this->type == "")
			$this->type = "";
			
		if ($this->cadmin == "")
			$this->cadmin = $_SESSION['LogInUser']->id;
			
		if ($this->changeday == "")
			$this->changeday = time();
			
		if ($this->classa == "")
			$this->classa = "PROTO";
				
		if ($this->proto == "")
			$this->proto = "B1";
				
		if ($this->rdate == "")
			$this->rdate = time();
				
		if ($this->sdate == "")
			$this->sdate = "";

		if ($this->idate == "")
			$this->idate = time();
				
		if ($this->iperson == "")
			$this->iperson = "";
				
		if ($this->owner == "")
			$this->owner = "Plenware";
		
		if ($this->pro_id == "")
			$this->pro_id = "0";
			
		if ($this->pro_number == "")
			$this->pro_number = "";
			
		if ($this->pro_name == "")
			$this->pro_name = "";
			
		$output = $this->manufactor . " " . $this->model;
	
		return $output;
	}

  	/**
	 * Read AccessoryType
	 */
	public function ReadAccessoryType($acc_id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
		$output = "";
		$sql = "SELECT * FROM `acctype` WHERE id = '$acc_id'";
		
		if ($acc_id != ""){
			$haku = $db->AskSQL($sql);
			$rows = mysql_num_rows($haku);
			$rivi = mysql_fetch_row ($haku);
		}
		
		/**
		 * read accessory type information
		 */
		if ($acc_id != ""){
			if (mysql_num_rows($haku) > 0){
				$this->acc_id = $rivi[0];
				$this->acc_name = $rivi[1];	
				$this->acc_picture = $rivi[2];
				$this->acc_cadmin = $rivi[3];
				$this->acc_changeday = $rivi[4];	
			}		
		}		
		
		if ($this->acc_name == "")
			$this->acc_name = "Handsfree 2 Change NAME!";
			
		if ($this->acc_picture == "")
			$this->acc_picture = "acc_1.gif";
			
		if ($this->acc_cadmin == "")
			$this->acc_cadmin = $_SESSION['LogInUser']->id;
			
		if ($this->acc_changeday == "")
			$this->acc_changeday = "Today";
		
		$output = $this->acc_name;
		
		return $output;
	}
	
	/**
	 * Test print Accessory information
	 */
	public function PrintAccessory(){
		print "id: $this->id<br>\n";
		print "project: $this->project<br>\n";
		print "manufactor: $this->manufactor<br>\n";
		print "model: $this->model<br>\n";
		print "status: $this->status<br>\n";
		print "location: $this->location<br>\n";
		print "information: $this->information<br>\n";
		print "reserve_id: $this->reserve_id<br>\n";
		print "type: $this->type<br>\n";
		print "cadmin: $this->cadmin<br>\n";
		print "changeday: $this->changeday<br>\n";	
		print "ClassA: $this->classa<br>\n";		
		print "Proto: $this->proto<br>\n";	
		print "RDate: $this->rdate<br>\n";
		print "SDate: $this->sdate<br>\n";
		print "IDate: $this->idate<br>\n";	
		print "IPerson: $this->iperson<br>\n";		
		print "Owner: $this->owner<br>\n";
		print "location_name: $this->location_name<br>\n";
		print "project_name: $this->project_name<br>\n";
		print "iperson_name: $this->iperson_name<br>\n";
		print "cadmin_name: $this->cadmin_name<br>\n";
		print "acctype_name: $this->acctype_name<br>\n";
		print "acc_id: $this->acc_id<br>\n";
		print "acc_name: $this->acc_name<br>\n";	
		print "acc_picture: $this->acc_picture<br>\n";
		print "acc_cadmin: $this->acc_cadmin<br>\n";
		print "acc_changeday: $this->acc_changeday<br>\n";
		print "pro_id: $this->pro_id<br>\n";
		print "pro_number: $this->pro_number<br>\n";
		print "pro_name: $this->pro_name<br>\n";			
	}
	
    public function ShowAccessories($location, $locationname){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($reserve))
			$reserve = new Reserve();
			
		if (!isset($project))
			$projects = new Projects();
			
		if (!isset($locations))
			$locations = new Location();
			
		$page2 = $_SESSION['Search']->page2;
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$this->sendback = $_SESSION['Search']->send;
		
		if ($page2 == "searchform"){
			$sql = $_SESSION['Search']->sql_accessory;
		} else {	
			$sql = "SELECT * FROM accessories ";
			$sql = $sql . "WHERE location = '$location' ORDER BY typea, manufactor, model";
			/*
			$sql = "SELECT accessories.id,accessories.project,accessories.manufactor,accessories.model,accessories.statusa,";
			$sql = $sql . "accessories.location,accessories.information,accessories.reserve_id,accessories.typea,";
			$sql = $sql . "acctype.name, acctype.picture, ";
			$sql = $sql . "accessories.location_name, accessories.project_name, accessories.iperson_name, accessories.cadmin_name, ";
			$sql = $sql . "FROM accessories JOIN acctype ON accessories.typea = acctype.id ";
			$sql = $sql . "WHERE location = '$location' ORDER BY typea, manufactor, model";
			*/
			if ($location =="1"){
				$sql = "SELECT * FROM accessories ";
				$sql = $sql . "ORDER BY typea, manufactor, model"; 
		
				/*
				$sql = "SELECT accessories.id,accessories.project,accessories.manufactor,accessories.model,accessories.statusa,";
				$sql = $sql . "accessories.location,accessories.information,accessories.reserve_id,accessories.typea,";
				$sql = $sql . "acctype.name, acctype.picture FROM accessories JOIN acctype ON accessories.typea = acctype.id ";
				$sql = $sql . "ORDER BY typea, manufactor, model"; 
				*/
			}	
		}
		
		$l = 5;
		if ($oikeus > "1"){
			$l = 6;
		}
		
		if($locationname=="All"){
			$output2 = "Accessory list"; 
		} else {
			$output2 = "$locationname accessories"; 
		}
		
		$tmp_accessories="<a href=\"index.php?page=accessory&page2=searchform&product=accessory&sendback=$this->sendback&order_accessory=";
		
		$output = "<table width=\"950\"><tr><td colspan=\"$l\" class=\"td_phonelistheader\">";	
		$output = $output . "<a href=\"classes/excel.php?name=$output2&sendback=$this->sendback&cols=5&col1=0&col2=22&col3=2&col4=18&col5=19&";
		$output = $output . "coln1=ID&coln2=Type&coln3=Manufacturer&coln4=Location&coln5=Project&sql=$sql\">";
		$output = $output . "<img src=\"pictures/excel.gif\" border=\"0\" title=\"Excel\"></a>&nbsp;";
		$output = $output . "$output2</td></tr><tr>";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_accessories . "id, acctype_name, manufactor, model\">Id</a></td>\n";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_accessories . "acctype_name, manufactor, model\">Type</a></td>\n";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_accessories . "manufactor, model\">Manufacturer</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\">". $tmp_accessories . "location_name, manufactor, model\">Location</a></td>";
		$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">". $tmp_accessories . "project_name, manufactor, model\">Project</a></td>";
		
		if ($oikeus > "1"){
			$output = $output . "<td class=\"td_phonelistheader\" colspan=\"1\">Edit</td>";
		}
		
		$output = $output . "</tr>\n";
		//print "$page2 -> $sql<br>";	

		$haku = $db->AskSQL($sql);
	
		if (mysql_num_rows($haku) > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				
				//$tila = $reserve->CheckReservationCondition("0", "", $rivi[0], "", "");	
				$typename = $acctype[$rivi[13]];
				
				//$temp = $projects->ReadProject($rivi[1]);
				$temp = "<a href=\"index.php?page=project&id=$rivi[1]&project_id=$rivi[1]&show=1\">$rivi[19]</a>";
				//$temp2 = $locations->ReadLocation($rivi[5]);
				$temp2 = "<td class=\"td_phonelistrow\" colspan=\"1\"><a href=\"index.php?page=location&id=$rivi[5]&location_id=$rivi[5]&show=1\">$rivi[18]</a>&nbsp;</td>";			
				
				//print "$temp<br>";
				$output = $output . "<tr>";
				
				$output = $output . "<td class=\"td_phonelistrow\"><a href=\"index.php?page=accessory&id=$rivi[0]&accessory_id=$rivi[0]&show=1\">$rivi[0]</a>&nbsp;</td><td class=\"td_phonelistrow\"><a href=\"index.php?page=accessory&id=$rivi[0]&accessory_id=$rivi[0]&show=1\">$rivi[22]</a>&nbsp;</td>";
				$output = $output . "<td class=\"td_phonelistrow\" colspan=\"1\">$rivi[2]&nbsp;</td>$temp2<td class=\"td_phonelistrow\" colspan=\"1\">$temp&nbsp;</td>\n";
				
				if ($oikeus > "1"){
					$toiminnot = "<a href=\"index.php?page=accessory&id=$rivi[0]&accessory_id=$rivi[0]&edit=1\"><img src=\"pictures/update2.gif\" border=\"0\" title=\"Update accessory\"></a>";
					$toiminnot = $toiminnot . "&nbsp;<a onclick=\"return confirmSubmitACCESSORY()\" href=\"index.php?page=accessory&id=$rivi[0]&accessory_id=$rivi[0]&delete=1\"><img src=\"pictures/poista2.gif\" border=\"0\" title=\"Delete accessory\"></a>";
					$toiminnot = "<td class=\"td_editdellistrow\">$toiminnot</td>";
					$output = $output . $toiminnot;
				}
				
				$output = $output . "</tr>";
			}
		} else {
			$output = $output . "<tr><td colspan=\"7\" class=\"td_phonelistrow\">No accessories!</td></tr>";
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
	
	public function AccessoryTypeDropDown($id)
	{
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
 		$output = "<select name=\"type\">\n";
		$sql = "SELECT * FROM `acctype` ORDER BY name";
		//print "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[1]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[1]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}
	
	/**
	 * Edit Accessory
	 */
	public function EditAccessory($in_id, $location2, $thing)
	{
		
		if (!isset($project))
			$projects = new Projects();
			
		if (!isset($locations))
			$locations = new Location();
			
		if (!isset($user))
			$user = new User();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		if ($in_id!="")
			$this->id = $in_id;	
			
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if (isset($_GET["ed"])=="1"){
			$this->project = $_POST["project"];
			$this->manufactor = $_POST["manufactor"];
			$this->model = $_POST["model"];
			$this->status = $_POST["status"];
			$this->location = $_POST["location"];
			$this->information = $_POST["information"];
			$this->reserve_id = $_POST["reserve_id"];
			$this->type = $_POST["type"];		
			$this->cadmin = $_SESSION['LogInUser']->id;
			//$this->changeday = time();	
			$this->classa = $_POST["classa"];
			$this->proto = $_POST["proto"];
			$this->rdate = $fixdate->MakeDate("rdate");
			$this->sdate = $fixdate->MakeDate("sdate");
			$this->idate = $fixdate->MakeDate("idate");
			$this->iperson = $_POST["iperson"];
			$this->owner = $_POST["owner"];	
		} else {
			$this->ReadAccessory($in_id);
		}
		
		//$tmp = $this->ReadAccessoryType($this->type);
		
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
		
		//$this->PrintAccessory();
		
		print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">";
				
		if ($thing == "edit"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Edit accessory</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"updateaccessory\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"updateaccessory\">\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$this->id\">\n";
			print "<input type=\"hidden\" name=\"accessory_id\" value=\"$this->id\">\n";
			print "<input type=\"hidden\" name=\"status\" value=\"$this->status\">\n";	
		}
		
		if ($thing == "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Add accessory</td></tr>";
			print "<form action=\"index.php\" method=\"post\" name=\"newaccessory\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"newaccessory\">\n";
			$this->iperson = $_SESSION['LogInUser']->id;
		}
		
		print "<input type=\"hidden\" name=\"page\" value=\"accessory\">\n";
		
		if ($thing != "edit" && $thing != "new"){
			print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Accessory info</td></tr>";
		} else {
			//print "<input type=\"hidden\" name=\"model\" value=\"$this->model\">";
			print "<input type=\"hidden\" name=\"classa\" value=\"$this->classa\">";
			print "<input type=\"hidden\" name=\"proto\" value=\"$this->proto\">";
		}
			
		if ($this->id != ""){
			print "<tr><td class=\"tab1\" colspan=\"1\">Accessory id number:</td><td class=\"tab2\" colspan=\"2\">$this->id</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Type:</td><td class=\"tab2\" colspan=\"2\">\n";
					
		if (($thing == "edit") || ($thing == "new")){
			print $this->AccessoryTypeDropDown($this->type);
		} else {
			print "$this->acctype_name&nbsp;"; //"$this->acc_name&nbsp;";
		}
					
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Manufacturer:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"manufactor\" size=\"40\" value=\"$this->manufactor\">";
		} else {
			print "$this->manufactor&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Model:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"model\" size=\"40\" value=\"$this->model\">";
		} else {
			print "$this->model&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Location:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print $locations->LocationDropDown($this->location);
			//print "<input type=\"text\" name=\"location\" size=\"40\" value=\"$this->location $location\">";
			print "</td></tr>\n";
		} else {
			print $this->location_name . "&nbsp"; // $locations->ReadLocation($this->location) . "&nbsp";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Project:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print $projects->ProjectDropDown($this->project,"");
		} else {
			//$projects->ReadProject($this->project);
			print "$this->project $this->project_name&nbsp;"; //"$projects->number $projects->name&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Owner:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"owner\" size=\"40\" value=\"$this->owner\">";
		} else {

			print "$this->owner&nbsp;";
		}
		
		print "</td></tr>\n";

		/*
		print "<tr><td class=\"tab1\" colspan=\"1\">Status:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"status\" size=\"40\" value=\"$this->status\">";
		} else {
			print "$this->status";
		}
					
		print "</td></tr>\n";

	
		if ($this->reserve_id>0){
			print "<tr><td class=\"tab1\" colspan=\"1\">Reserve id:</td><td class=\"tab2\" colspan=\"2\">\n";
		
			print "<a href=\"index.php?page=reserve&location=$this->location&reserve_id=$this->reserve_id&accessory_id=$this->id&show=1\">$this->reserve_id</a>";
		
			print "</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Class:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"classa\" size=\"40\" value=\"$this->classa\">";
		} else {
			print "$this->classa&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Proto:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<input type=\"text\" name=\"proto\" size=\"40\" value=\"$this->proto\">";
		} else {
			print "$this->proto&nbsp;";
		}
		
		print "</td></tr>\n";
*/
		print "<tr><td class=\"tab1\" colspan=\"1\">Receiving date:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		$temp = "&nbsp;";
		if ($this->rdate!="0000-00-00 00:00:00" && $this->rdate!=""){
			$this->rdate = $fixdate->ReturnDate($this->rdate);
			$temp = date("Y-m-d",$this->rdate);
		}
			
		if (($thing == "edit") || ($thing == "new")){
			$fixdate->DateShow("rdate", "$this->rdate");
		} else {
			print "$temp&nbsp;";
		}
		
		print "</td></tr>\n";

		print "<tr><td class=\"tab1\" colspan=\"1\">Sendback day:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		$temp = "&nbsp;";
		if ($this->sdate!="0000-00-00 00:00:00" && $this->sdate!=""){
			$this->sdate = $fixdate->ReturnDate($this->sdate);
			$temp = date("Y-m-d",$this->sdate);
		}
						
		if (($thing == "edit") || ($thing == "new")){
			if ($this->sdate=="")
				$this->sdate="0000-00-00 00:00:00";
			
				$fixdate->DateShow("sdate", "$this->sdate");
				
		} else {
			print "$temp&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Inventory person:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		//$ipersonname = $user->GetUserName($this->iperson);
		
		if (($thing == "edit") || ($thing == "new")){
			print $user->UserDropDown($this->iperson,"iperson");
		} else {
			print "$this->iperson_name&nbsp;"; //"$ipersonname&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Inventory date:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		$temp = "&nbsp;";
		if ($this->idate!="0000-00-00 00:00:00" && $this->idate!=""){
			$this->idate = $fixdate->ReturnDate($this->idate);
			$temp = date("Y-m-d",$this->idate);
		}
		
		if (($thing == "edit") || ($thing == "new")){
			$fixdate->DateShow("idate", "$this->idate");
		} else {
			print "$temp&nbsp;";
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
				print "<td class=\"tab\"><a href=\"index.php?page=accessory&id=$this->id&accessory_id=$this->id&location=$this->location&edit=1\">&nbsp;Edit&nbsp;</a></td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\">&nbsp;</td>\n";
				print "<td class=\"tab\"><a onclick=\"return confirmSubmitACCESSORY()\" href=\"index.php?page=accessory&id=$this->id&accessory_id=$this->id&location=$this->location&delete=1\">&nbsp;Delete&nbsp;</a></td>\n";
				print "</tr></table>\n";
			}		
		}
	}
	
	
	/**
	 * Check accessory data
	 */
	public function CheckAccessory(){
		$output = 0;
				
		if ($this->manufactor == "" || $_SESSION['Search']->CheckText($this->manufactor,10) == 10) { 
			$output = "10";
			return $output;
		}	
    	
		if ($_SESSION['Search']->CheckText($this->model,11) == 11) { 
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
		
 		if ($this->classa != "" && $_SESSION['Search']->CheckText($this->classa,14) == 14) { 
			$output = "14";
			return $output;
		}
		
 		if ($this->proto != "" && $_SESSION['Search']->CheckText($this->proto,15) == 15) { 
			$output = "15";
			return $output;
		}		
		
 		if ($this->owner != "" && $_SESSION['Search']->CheckText($this->owner,16) == 16) { 
			$output = "16";
			return $output;
		}	
					
		return $output;
	}
	
	/**
	 * Get names
	 */
	public function GetNames(){
		if (!isset($acctype2))
			$acctype2 = new AccType();
			
		if (!isset($locations2))
			$locations2 = new Location();
			
		if (!isset($project2))
			$projects2 = new Projects();
			
		if (!isset($user2))
			$user2 = new User();
		
		$this->acctype_name = $acctype2->ReadAccType($this->type);	
		$this->location_name = $locations2->ReadLocation($this->location);
		$this->project_name = $projects2->ReadProject($this->project);
		$user2->ReadUser($this->iperson);
		$this->iperson_name = $user2->name;
		$user2->ReadUser($this->cadmin);	
		$this->cadmin_name = $user2->name;	
	}
	
	/**
	 * Add new accessory to database
	 */
	public function AddAccessory(){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$this->project = mysql_real_escape_string($_POST["project"]);
		$this->manufactor = mysql_real_escape_string($_POST["manufactor"]);
		$this->model = mysql_real_escape_string($_POST["model"]);
		$this->status = mysql_real_escape_string($_POST["status"]);
		$this->location = mysql_real_escape_string($_POST["location"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->reserve_id = isset($_POST["reserve_id"]);
		$this->type = mysql_real_escape_string($_POST["type"]);		
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());	
		$this->classa = mysql_real_escape_string($_POST["classa"]);
		$this->proto = mysql_real_escape_string($_POST["proto"]);
		$this->rdate = $fixdate->MakeDate("rdate");
		$this->sdate = $fixdate->MakeDate("sdate");
		$this->idate = $fixdate->MakeDate("idate");
		
		if ($this->rdate!="")
			$this->rdate = date("Y-m-d H:i:s",$this->rdate);
		if ($this->rdate=="")
			$this->rdate="0000-00-00 00:00:00";
			
		if ($this->sdate!="")
			$this->sdate = date("Y-m-d H:i:s",$this->sdate);
			
		if ($this->sdate=="")
			$this->sdate="0000-00-00 00:00:00";
			
		if ($this->idate!="")
			$this->idate = date("Y-m-d H:i:s",$this->idate);
			
		if ($this->idate=="")
			$this->idate="0000-00-00 00:00:00";
			
		$this->iperson = $_POST["iperson"];
		$this->owner = $_POST["owner"];	
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		$check_accessory = $this->CheckAccessory();
		if ($check_accessory!=0)
			return $check_accessory;
				
		/**
		 * Test print phone information (only test!)
	 	 */	
		//$this->PrintAccessory();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->manufactor == "") || ($this->model == "") || ($this->location == "")){
			$output = "3";
			return $output;
		}
		
				
		/**
		 * Insert accessories to database
		 */
		$sql = "INSERT INTO `accessories` (project, manufactor, model, statusa, location, information, reserve_id, typea, cadmin, changeday, classa, proto, rdate, sdate, idate, iperson, owner, location_name, project_name, iperson_name, cadmin_name, acctype_name)" .
 		" VALUES ('$this->project', '$this->manufactor', '$this->model', '$this->status', " .
 		"'$this->location', '$this->information', '$this->reserve_id', '$this->type', " .
 		"'$this->cadmin', '$this->changeday', '$this->classa', '$this->proto', '$this->rdate', '$this->sdate', " .
		"'$this->idate', '$this->iperson', '$this->owner', '$this->location_name', '$this->project_name', '$this->iperson_name', '$this->cadmin_name', '$this->acctype_name')";		
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
		$sql = "SELECT MAX(id) FROM `accessories`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
		}
	}	

	/**
	 * Update accessory to database
	 */
	public function UpdateAccessory(){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$this->id = $_POST["id"];
		$this->project = mysql_real_escape_string($_POST["project"]);
		$this->manufactor = mysql_real_escape_string($_POST["manufactor"]);
		$this->model = mysql_real_escape_string($_POST["model"]);
		$this->status = mysql_real_escape_string($_POST["status"]);
		$this->location = mysql_real_escape_string($_POST["location"]);
		$this->information = mysql_real_escape_string($_POST["information"]);
		$this->reserve_id = $_POST["reserve_id"];
		$this->type = mysql_real_escape_string($_POST["type"]);		
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());	
		$this->classa = mysql_real_escape_string($_POST["classa"]);
		$this->proto = mysql_real_escape_string($_POST["proto"]);
		$this->rdate = $fixdate->MakeDate("rdate");
		$this->sdate = $fixdate->MakeDate("sdate");
		$this->idate = $fixdate->MakeDate("idate");
		
		if ($this->rdate!="")
			$this->rdate = date("Y-m-d H:i:s",$this->rdate);
			
		if ($this->rdate=="")
			$this->rdate="0000-00-00 00:00:00";
			
		if ($this->sdate!="")
			$this->sdate = date("Y-m-d H:i:s",$this->sdate);
			
		if ($this->sdate=="")
			$this->sdate="0000-00-00 00:00:00";
			
		if ($this->idate!="")
			$this->idate = date("Y-m-d H:i:s",$this->idate);
			
		if ($this->idate=="")
			$this->idate="0000-00-00 00:00:00";

		$this->iperson = $_POST["iperson"];
		$this->owner = $_POST["owner"];
		
		/**
		 * Get names
		 */
		$this->GetNames();
		
		$check_accessory = $this->CheckAccessory();
		if ($check_accessory!=0)
			return $check_accessory;
					
		/**
		 * Test print phone information (only test!)
	 	 */	
		//$this->PrintAccessory();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->manufactor == "") || ($this->model == "") || ($this->location == "")){
			$output = "3";
			return $output;
		}
					
		/**
		 * update accessory to database
		 */
		$sql = "UPDATE `accessories` SET project='$this->project', manufactor='$this->manufactor', " .
		"model='$this->model', statusa='$this->status', location='$this->location', " .
		"information='$this->information', reserve_id='$this->reserve_id', typea='$this->type', " .
		"cadmin='$this->cadmin', changeday='$this->changeday', " .
		"classa='$this->classa', proto='$this->proto', rdate='$this->rdate', sdate='$this->sdate', " .
		"idate='$this->idate', iperson='$this->iperson', owner='$this->owner', location_name='$this->location_name', project_name='$this->project_name', iperson_name='$this->iperson_name', cadmin_name='$this->cadmin_name', acctype_name='$this->acctype_name' " .
		"WHERE id='$this->id'";
				
		//print "$sql<br>\n";	
		$tulos = $db->UseSQL($sql);
	
		$output = "0";
		
		return $output;
	}	

	/**
	 * Remove accessories
	 */
	public function DeleteAccessories($accessory_id){
		if (!isset($db))
			$db = new Database();
		/**
		 * Copy to deleted
		 */
		$this->DeletedAccessories($accessory_id);	
		
		$sql = "DELETE FROM `accessories` WHERE id = '$accessory_id'";
		
		$db->UseSQL("$sql");
		
		$output = "Accessory is deleted from database!";
		return $output;
	}
	
	/**
	 * Copy accessories to deleted
	 */
	public function DeletedAccessories($accessory_id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		 		
 		$this->ReadAccessory($accessory_id);
 		
		/**
		 * Insert Accessories to database
		 */
		if ($id != ""){
			$sql = "INSERT INTO `deleted_accessories` (id, project, manufactor, model, statusa, location, " .
			"information, reserve_id, typea, cadmin, changeday, classa, proto, rdate, sdate, idate, iperson, owner, location_name, project_name, iperson_name, cadmin_name) " .
			"VALUES ('$this->id', '$this->project', '$this->manufactor', '$this->model', " .
			"'$this->status', '$this->location', '$this->information', '$this->reserve_id', " .
			"'$this->type', '$this->cadmin', '$this->changeday', " .
			"'$this->classa', '$this->proto', '$this->rdate', '$this->sdate', " .
			"'$this->idate', '$this->iperson', '$this->owner', '$this->location_name', '$this->project_name', '$this->iperson_name', '$this->cadmin_name')";
			$tulos = $db->UseSQL($sql);
		}		
	}
	
	/**
 	 * Get Accessories
 	 */
	public function GetAccessoriesInformation($id){
		$haku = $db->AskSQL("SELECT * FROM intra_accessories WHERE id = '$id'");
    	if (mysql_num_rows($haku) > 0){
        	for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
            	/**
				 *  Tarkistetaan onko puhelin varattu juuri nyt
				 */
				$varaustilanne = $_SESSION["varaus"]->TarkistaVaraustilanne($rivi[0]);
		
				/**
				 * Tulostetaan puhelimen tiedot taulukon yläreunaan
				 */
				$output = "<tr><td class=\"td_phonelistheader\" colspan=\"2\">$rivi[1] $rivi[2] ($rivi[4])</td>$varaustilanne</tr>";
    		}
      	}
      	
  		/**
	 	 * Jos tietokannasta ei löytynyt puhelimen tietoja, annetaan ilmoitus käyttäjälle
	 	 */
		if (mysql_num_rows($haku) < 1)	{
        	$output = "<tr><td colspan=\"6\" class=\"td_phonelistrow\">Phone information didn't found!</td></tr>";
     	}
  		return $output;
	}
	
	/**
	 * 
	 */
	public function GetAccessoriesInformationEmail($id){
		$haku = $db->AskSQL("SELECT * FROM intra_accessories WHERE id = '$id'");
    	if (mysql_num_rows($haku) > 0){
       		for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri)	{
          			$output = "$rivi[1] $rivi[2] (IMEI: $rivi[4])";
             	}
    	}
    	
		/**
	 	 * Jos tietokannasta ei löytynyt puhelimen tietoja, annetaan ilmoitus käyttäjälle
	 	 */
		if (mysql_num_rows($haku) < 1){
       		$output = "Phone information did not found!";
    	}
     	return $output;

	}
	
	/**
	 * 
	 */
	public function GetAccessoriesLocation($id){
		$haku = $db->AskQL("SELECT * FROM intra_accessories WHERE id = '$id'");
		$tulos = mysql_fetch_row($haku);
		return $tulos[5];
	}
	
	/**
	 * 
	 */
	public function GetAccessoriesInformatioToUpdate($id){
		$haku = $db->AskSQL("SELECT * FROM intra_accessories WHERE id = '$id'");
		$tulos = mysql_fetch_row($haku);
		return $tulos;
	}
	
	/**
	 * 
	 */
	public function GetAccessoriesSearchWord($hakusana){
		/**
		 * Jaetaan syöte kahdeksi eri hakusanaksi
		 */
		$sana = split(" ", $hakusana);
		
		/**
		 * Jos hakusanoja oli kaksi, tehdään haku molempien hakusanojen perusteella
		 */
		if ($sana[1] != ""){
			$haku = $db->AskSQL("SELECT * FROM intra_accessories WHERE merkki LIKE '$sana[0]%' AND malli LIKE '$sana[1]%' OR merkki LIKE '$sana[1]%' AND malli LIKE '$sana[0]%' ORDER BY sijainti, merkki, malli");
		}
		
		/**
		 * Jos hakusanoja oli vain yksi, tehdään haku vain tämän hakusanan perusteella
		 */
		if ($sana[1] == ""){
			$haku = $db->AskSQL("SELECT * FROM intra_accessories WHERE merkki LIKE '$sana[0]%' OR malli LIKE '$sana[0]%' ORDER BY sijainti, merkki, malli");
		}
		
		/**
		 * Jos puhelimia löytyi, tulostetaan ne näytölle
		 */
		if (mysql_num_rows($haku) > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){ 
				$sijainti = $places[$rivi[5]];
				
				/**
				 * Tarkistetaan onko kyseinen puhelin varattuna juuri nyt
				 */
				$tila = $_SESSION["varaus"]->TarkistaVaraustilanne($rivi[0]);
				$output = $output . "<tr><td class=\"td_phonelistrow\">$rivi[0]</td><td class=\"td_phonelistrow\">$rivi[1]</td><td class=\"td_phonelistrow\">$rivi[2]</td><td class=\"td_phonelistrow\">$rivi[3]</td><td class=\"td_phonelistrow\"><a href=\"index.php?sivu=varaukset&puhelin=$rivi[0]\">$rivi[4]</a></td><td class=\"td_phonelistrow\">$sijainti</td>$tila</tr>";
			}
		}
		
		/**
		 * Jos yhtään puhelinta ei löytänyt, annetaan siitä ilmoitus käyttäjälle
		 */
		if (mysql_num_rows($haku) < 1){
			$output = "<tr><td colspan=\"6\" class=\"td_phonelistrow\">Search didn't find any Accessories!</td></tr>";
		}
		
		return $output;	
	}
	
	/**
	 * Show Accessories
	 */
	public function ShowAccessoriesList($place){
		print "<tr><td colspan=\"7\" class=\"td_phonelistheader\">$places[$place] Accessories</td></tr>";
		print "<tr><td class=\"td_phonelistheader\" colspan=\"2\">Accessory type</td><td class=\"td_phonelistheader\" colspan=\"5\">Information</td></tr>";
		$acsearch = $$this->ShowAccessories($place);
		print "$acsearch";	
	}
			
}

?>

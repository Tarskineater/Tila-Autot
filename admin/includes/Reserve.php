<?php

class Reserve{
	var $reserve_id;
	var $phone_id;
	var $user_id;
	var $start_time;
	var $end_time;
	var $project;
	var $accessory_id;
	var $sim_id;			
	var $flash_id;	
	var $location; 
	var $information;
	var $location_name;
	var $project_name;
	var $iperson_name;
	var $cadmin_name;
	var $txtadd;

 	/**
	 * Read Simm
	 */
	public function ReadReservation($id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
 		$this->reserve_id = $id;
 		
		$output = "";
		
		$sql = "SELECT * FROM reservation WHERE reserve_id='$id'";
	
		//print "$sql<br>";
			
		if ($id != ""){
			$haku = $db->AskSQL($sql);
		
			$rows = mysql_num_rows($haku);
			$rivi = mysql_fetch_row ($haku);
		}
		
		/**
		 * read reserve information
		 */
		if ($id != ""){
			if (mysql_num_rows($haku) > 0){
				$this->reserve_id = $rivi[0];
				$this->phone_id =$rivi[1];
				$this->user_id = $rivi[2];
				$this->start_time =$rivi[3];
				$this->end_time =$rivi[4];
				$this->project = $rivi[5];
				$this->accessory_id =$rivi[6];
				$this->sim_id = $rivi[7];
				$this->flash_id = $rivi[8];
				$this->location = $rivi[9];
				$this->information = $rivi[10];
				$this->cadmin = $rivi[11];
				$this->changeday = $rivi[12];
				
				$this->start_time = date("Y-m-d H:i:s",$this->start_time);
				$this->end_time = date("Y-m-d H:i:s",$this->end_time);
			}		
		}		
		//print "Hei!<br>";
	//$this->PrintReservation();
		
		if ($this->reserve_id == "")
			$this->reserve_id = "";
			
		if ($this->phone_id == "")
			$this->phone_id = "0";
		
		if ($this->user_id == "")
			$this->user_id = "0";
		
		if ($this->start_time == "")
			$this->start_time = date("Y-m-d H:i:s",$this->start_time);
		
		if ($this->end_time == "")
			$this->end_time = date("Y-m-d H:i:s",$this->start_time);
		
		if ($this->information == "")
			$this->information = "";
		
		if ($this->project == "")
			$this->project = "1";
		
		if ($this->accessory_id == "")
			$this->accessory_id = "0";
			
		if ($this->sim_id == "")
			$this->sim_id = "0";
			
		if ($this->flash_id == "")
			$this->flash_id = "0";
			
		if ($this->location == "")
			$this->location = "2";
			
		if ($this->information == "")
			$this->information = "";
					
		if ($this->cadmin == "")
			$this->cadmin = $_SESSION['LogInUser']->id;
			
		if ($this->changeday == "" || $this->changeday == "Today")
			$this->changeday = time();

				
		$output = $this->reserve_id . " " . $this->project;
		
		return $output;
	}
	
	/**
	 * Test print reserve information
	 */
	public function PrintReservation(){
		print "id: $this->reserve_id<br>\n";
		print "phone_id: $this->phone_id<br>\n";
		print "user_id: $this->user_id<br>\n";
		print "start_time: $this->start_time<br>\n";
		print "end_time: $this->end_time<br>\n";
		print "project: $this->project<br>\n";
		print "accessory_id: $this->accessory_id<br>\n";
		print "sim_id: $this->sim_id<br>\n";
		print "flash_id: $this->flash_id<br>\n";
		print "location: $this->location<br>\n";
		print "information: $this->information<br>\n";
		print "cadmin: $this->cadmin<br>\n";
		print "changeday: $this->changeday<br>\n";			
	}
	
	public function ReservationTab($location){
				
		if (isset($_GET["search"]) == "")
			$_GET["search"] = "all";
			
		$xx = $_GET["search"];
		//print "$xx<br>";
		$xxx = " id=\"selectedtab\"";
			
		//print "$xx<br>";
		
		$x0 = "";
		if ($xx == "all"){
		 	$x0 = $xxx;
		}
		
		$x1 = "";	
		if ($xx == "phones"){
		 	$x1 = $xxx;
		}
		
		$x2 = "";	
		if ($xx == "sims"){
		 	$x2 = $xxx;
		}
	
		$x3 = "";	
		if ($xx == "accessories"){
		 	$x3 = $xxx;
		}
		
		$x4 = "";	
		if ($xx == "flash"){
		 	$x4 = $xxx;
		}
		
		print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
		print "<td colspan=\"8\" class=\"td_phonelistheader\">Search</td></tr>";
		print "<td class=\"tab\"$x0><a href=\"index.php?page=reservations&location=$location&search=all\">&nbsp;All&nbsp;</a></td>\n";
		print "<td class=\"tab\"$x1><a href=\"index.php?page=reservations&location=$location&search=phones\">&nbsp;Phones&nbsp;</a></td>\n";
		print "<td class=\"tab\"$x2><a href=\"index.php?page=reservations&location=$location&search=sims\">&nbsp;Sims&nbsp;</a></td>\n";
		print "<td class=\"tab\"$x3><a href=\"index.php?page=reservations&location=$location&search=accessories\">&nbsp;Accessories&nbsp;</a></td>\n";
		print "<td class=\"tab\"$x4><a href=\"index.php?page=reservations&location=$location&search=flash\">&nbsp;Flash_adap&nbsp;</a></td>\n";
		print "</tr></table>\n";
	}
	
	/**
	 * Check reservation
	 */
	public function CheckReservationCondition($reserve_id, $phone_id, $accessory_id, $sim_id, $flash_id){
	
		if (!isset($db))
			$db = new Database();
				
		$nyt = time();
		//print "HEI!$phone_id, $accessory_id, $sim_id, $flash_id<br>";
		if ($phone_id > 0){
			$sql = "SELECT * FROM reservation WHERE phone_id = '$phone_id' AND start_time < $nyt AND (end_time > $nyt)";
			$reserved = "Phone";
			$html = "phone_id=$phone_id&reserve=1";
			$return = "phone_id=$phone_id&location=$location&return=1\"><img src=\"pictures/return.gif\" border=\"0\" title=\"Return $reserved\"></a>";
		}
			
		if ($accessory_id > 0){
			$sql = "SELECT * FROM reservation WHERE accessory_id = '$accessory_id' AND start_time < $nyt AND (end_time > $nyt)";
			$reserved = "Accessory";
			$html = "accessory_id=$accessory_id&reserve=1";
			$return = "accessory_id=$accessory_id&location=$location&return=1\"><img src=\"pictures/return.gif\" border=\"0\" title=\"Return $reserved\"></a>";
		}
		
		if ($sim_id > 0){
			$sql = "SELECT * FROM reservation WHERE sim_id = '$sim_id' AND start_time < $nyt AND (end_time > $nyt)";
			$reserved = "Sim";
			$html = "sim_id=$sim_id&reserve=1";
			$return = "sim_id=$sim_id&location=$location&return=1\"><img src=\"pictures/return.gif\" border=\"0\" title=\"Return $reserved\"></a>";
		}
		
		
		if ($flash_id > 0){
			$sql = "SELECT * FROM reservation WHERE flash_id = '$flash_id' AND start_time < $nyt AND (end_time > $nyt)";
			$reserved = "Flash";
			$html = "flash_id=$flash_id&reserve=1";
			$return = "flash_id=$flash_id&location=$location&return=1\"><img src=\"pictures/return.gif\" border=\"0\" title=\"Return $reserved\"></a>";
		}
		
		//print "$sql<br>";

		$haku = $db->AskSQL("$sql");
 		//$tulos = mysql_fetch_row($haku);
 		
 		//print "$sql<br>";

  		/**
  		 * Reserved
  		 */
 		if (mysql_num_rows($haku) > 0){
		 	$rivi = mysql_fetch_row ($haku);
		 	$this->reserve_id = $rivi[0];
		 	//print mysql_num_rows($haku) . "  $rivi[0]  $rivi[1]  $rivi[2] $this->reserve_id<br>";
			$return = "<a onclick=\"return confirmSubmitRETURN()\" href=\"index.php?page=reservation&reserve_id=$this->reserve_id&" . $return;
			$output = "<td class=\"td_phonelistrow\"><img src=\"pictures/varattu.gif\" border=\"0\" title=\"$reserved is reserved\"><br>$return</td>";
			//print "$return<br>";
		}
		
		/**
		 * Free
		 */
		if (mysql_num_rows($haku) < 1){
			$output = "<td class=\"td_phonelistrow\"><img src=\"pictures/vapaa.gif\" border=\"0\" title=\"$reserved is free to reserve\"><br><a onclick=\"return confirmSubmitBOOK()\" href=\"index.php?page=reservation&$html\"><img src=\"pictures/varaa.gif\" border=\"0\" title=\"Make new reservation to item\"></a></td>";
		}
		
		return $output;
		
	}
	
public function ShowReservations($location, $locationname){
	if (!isset($db))
		$db = new Database();
		
	if (!isset($phone))
		$phone = new Phone();
		
	if (!isset($sim))
		$sim = new Sim();
		
	if (!isset($accessories))
		$accessories = new Accessories();
		
	if (!isset($flash))
		$flash = new Flash();
		
	if (!isset($locations))
		$locations = new Location();
			
	if (!isset($project))
		$projects = new Projects();
		
	if (!isset($search))
		$search = new Search();
		
	$page2 = $_SESSION['Search']->page2;				
	$oikeus = $_SESSION['LogInUser']->oikeustaso;
	
 	$this->location = $_GET["location"];
	
 	//print "$location $this->location<br>";
	
 	$this->search = " ";
 	if ($this->location!="1")
 		$this->search = "WHERE projects.location='$this->location' ";
		
	$this->ReservationTab($this->location);
		
	$nyt = time();
	
	if ($location == "1"){
		$loc = "";
	} else {
		$loc = "(location='$this->location' OR location='0' OR location='1') AND";
	}
	
	//print "$this->search $loc<br>";
	$nyt = "((start_time < $nyt AND end_time> $nyt) OR (start_time > $nyt))";
	
	print "\n<table width=\"950\"><tr><td colspan=\"9\" class=\"td_phonelistheader\">$locationname Reservations</td></tr>";
	print "<tr><td class=\"td_phonelistheader\" colspan=\"2\">Reservation</td><td class=\"td_phonelistheader\">Project</td><td class=\"td_phonelistheader\">Location</td><td class=\"td_phonelistheader\">Type & number</td><td class=\"td_phonelistheader\">Start time</td><td class=\"td_phonelistheader\">End time</td><td class=\"td_phonelistheader\" colspan=\"1\">Status</td></tr>\n"; //<td class=\"td_phonelistheader\" colspan=\"1\">Information</td>
	
	$xx = $_GET["search"];
	$user_id = $_SESSION['LogInUser']->id;
	
	//print "p$page2 s$xx<br>";
	
	if ($page2 == "searchform"){
		$sql = $_SESSION['Search']->sql_reservation;
	} else {	
		$sql = "SELECT * FROM reservation WHERE $loc $nyt ORDER BY start_time, end_time";
		
		if ($xx == "phones"){
		 	$sql = "SELECT * FROM reservation WHERE phone_id>0 AND $loc $nyt ORDER BY phone_id, start_time, end_time";
		}
	
		if ($xx == "sims"){
		 	$sql = "SELECT * FROM reservation WHERE sim_id>0 AND $loc $nyt ORDER BY sim_id, start_time, end_time";
		}
		
		if ($xx == "accessories"){
		 	$sql = "SELECT * FROM reservation WHERE accessory_id>0 AND $loc $nyt ORDER BY accessory_id, start_time, end_time";
		}
		
		if ($xx == "flash"){
			$sql = "SELECT * FROM reservation WHERE flash_id>0 AND $loc $nyt ORDER BY flash_id, start_time, end_time";
		}
	}
	//print "$user_id $sql<br>";
	$haku = $db->AskSQL($sql);
	if (mysql_num_rows($haku) > 0){

		for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
			//$tila = $reserve->CheckReservationCondition("", $rivi[0], "");	
			//$typename = $acctype[$rivi[8]];

			if (($oikeus == $location) || ($oikeus == 99) || ($rivi[2] == $user_id)){
				$out_editing= "<td class=\"td_phonelistrow\"><a onclick=\"return confirmSubmitRESERVATION()\" href=\"index.php?page=reservation&id=$rivi[0]&location=$location&delete=1\"><img src=\"pictures/poista2.gif\" border=\"0\" title=\"Delete reservation\"></a>";
				$out_editing = $out_editing . "<a href=\"index.php?page=reservation&id=$rivi[0]&location=$location&edit=1\"><img src=\"pictures/update2.gif\" border=\"0\" title=\"Update reservation\"></a></td>\n";
			} else {
				$out_editing = "<td class=\"td_phonelistrow\">No editing</td>";
			}
			
			$project ="Error in project!";
		
			//print "$rivi[5]<br>";
			if ($rivi[5]!="0")
				$project = $projects->ReadProject($rivi[5]);
			
			//print "$project $rivi[5]<br>";
			if ($rivi[1]>0){
				//print "tässä1 $rivi[1]<br>";
				$thingInfo = $phone->ReadPhone($rivi[1]);
				$txtadd = "<a href=\"index.php?page=phone&id=$rivi[1]&phone_id=$rivi[1]&show=1\">$thingInfo</a>";
				/**
				 * Tarkistetaan onko puhelin varattu juuri nyt
				 */
				 
				$tila = $this->CheckReservationCondition($rivi[0],$rivi[1],"","","");
			}

			if ($rivi[6]>0){
	
				$thingInfo = $accessories -> ReadAccessory($rivi[6]);
				$txtadd = "<a href=\"index.php?page=accessory&id=$rivi[6]&accessory_id=$rivi[6]&location=$location&show=1\">$thingInfo</a>";
				//print "tässä6 $rivi[6]<br>";
				$tila = $this->CheckReservationCondition($rivi[0],"",$rivi[6],"","");
			}
			
			if ($rivi[7]>0){
				//print "tässä7 $rivi[7]<br>";
				$thingInfo = $sim->ReadSimm($rivi[7]);
				//$thingInfo = "$phone->cardnumber $phone->phonenumber";
				
				$txtadd = "<a href=\"index.php?page=simm&id=$rivi[7]&sim_id=$rivi[7]&location=$location&show=1\">$thingInfo</a>";
				$tila = $this->CheckReservationCondition($rivi[0],"","",$rivi[7],"");
			}
			
			if ($rivi[8]>0){	
				$thingInfo = $flash->ReadFlash($rivi[8]);	
				$txtadd = "<a href=\"index.php?page=flash&id=$rivi[8]&flash_id=$rivi[8]&location=$location&show=1\">$thingInfo</a>";
				$tila = $this->CheckReservationCondition($rivi[0],"","","", $rivi[8]);
			}
			
			$start_time = date("d.m.Y - H:i", $rivi[3]);
			$end_time = date("d.m.Y - H:i", $rivi[4]);

			$out_project = "<td class=\"td_phonelistrow\" colspan=\"1\"><a href=\"index.php?page=project&id=$rivi[5]&phone_id=$rivi[0]&location=$location&show=1\">$project</a></td>";
			
			if($rivi[5] == "0"){
				$out_project ="<td class=\"td_phonelistrow\" colspan=\"1\">$project</td>";
			}
			
			if($rivi[9] == "0"){
				$out_location ="<td class=\"td_phonelistrow\" colspan=\"1\">Error in location!</td>";
			} else {
				$locations->ReadLocation($rivi[9]);
				$out_location ="<td class=\"td_phonelistrow\" colspan=\"1\"><a href=\"index.php?page=location&id=$rivi[9]&location=$location&show=1\">$locations->name, $locations->country</a></td>";
			}
		
			$output = $output . "<tr>$out_editing<td class=\"td_phonelistrow\"><a href=\"index.php?page=reservation&reserve_id=$rivi[0]&id=$rivi[0]&location=$location&show=1\">$rivi[0]</a></td>";
			$output = $output . "$out_project$out_location<td class=\"td_phonelistrow\" colspan=\"1\">$txtadd</td><td class=\"td_phonelistrow\" colspan=\"1\">$start_time</td><td class=\"td_phonelistrow\" colspan=\"1\">$end_time</td>$tila</tr>\n"; //<td class=\"td_phonelistrow\" colspan=\"1\">$rivi[6]</td>
		}
			
	} else {
		$output = "<tr><td colspan=\"9\" class=\"td_phonelistrow\">No reservations!</td></tr>";
	}
				
	$output = $output . "</table>";

	if ($oikeus > "1"){
		$output = $output . "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
		$output = $output . "<td class=\"tab\"><a href=\"index.php?page=reservation&id=''&location=$location&new=1\">&nbsp;New&nbsp;</a></td>\n";
		$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
		$output = $output . "<td class=\"tab\">&nbsp;</td>\n";
		$output = $output . "</tr></table>\n";
	}
	print "$output";
		   
}

	/**
	 * Edit Reservation
	 */
	public function EditReservation($id, $location2, $thing)
	{
		if (!isset($project))
			$projects = new Projects();
			
		if (!isset($locations))
			$locations = new Location();
			
		if (!isset($user))
			$user = new User();
			
		if (!isset($phone))
			$phone = new Phone();
			
		if (!isset($sim))
			$sim = new Sim();
			
		if (!isset($accessories))
			$accessories = new Accessories();
			
		if (!isset($flash))
			$flash = new Flash();
				
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$reserve = $_GET["reserve"];
		$return = $_GET["return"];
		
		$this->reserve_id = $id;
		
		$this->phone_id = $_GET["phone_id"];
		$this->accessory_id = $_GET["accessory_id"];	
		$this->sim_id = $_GET["sim_id"];
		$this->flash_id = $_GET["flash_id"];
		
		//print "ID:$this->reserve_id, $this->phone_id, $this->sim_id, $this->accessory_id<br>";
		
		//print "$id<br>";
		
		if ($reserve=="1"){
			$thing = "new";

			$this->start_time = $_GET["start_time"];
			$this->end_time = $_GET["end_time"];
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->start_time = time();
			$this->end_time = time() + 30;
			
			$this->changeday = time();
			$this->user_id= $this->cadmin;
		}
		
		/**
		 * If phone_id is there then read phone
		 */
		if ($this->reserve_id>0 && (isset($_GET["show"])=="1" || isset($_GET["edit"])=="1" || $return=="1")){
			$this->ReadReservation($this->reserve_id);
			//print "$this->phone_id, $this->sim_id, $this->accessory_id<br>";
		}
		
		if (isset($_GET["ed"])=="1"){	
			$this->reserve_id = $_POST["$id"];
			$this->phone_id = $_POST["phone_id"];
			$this->user_id = $_POST["user_id"];
			$this->start_time = $fixdate->MakeDate("start");
			$this->end_time = $fixdate->MakeDate("end");
			$this->project = $_POST["project"];
			$this->accessory_id = $_POST["accessory_id"];
			$this->sim_id = $_POST["sim_id"];
			$this->flash_id = $_POST["flash_id"];
			$this->location = $_POST["location"];
			$this->information = $_POST["information"];
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = time();
		} else {
			//print "Simm: $this->id<br>";
			if ($edit=="1" || $show=="1" || $return=="1")
				$this->ReadReservation($id);
		}
		
		if (isset($_GET["copy2new"])=="1"){
			$this->reserve_id = "";
			$thing = "new";
			$this->start_time = time();
			$this->end_time = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = time();
		}
		
		if ($return=="1"){
			$this->end_time = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
			$this->changeday = time();
				
			$this->start_time = $fixdate->ReturnDate($this->start_time);
			$this->end_time = $fixdate->ReturnDate($this->end_time);
		
			$this->Save();
		}
		
		if($this->project == ""){
			$this->project = $_SESSION['LogInUser']->project;
		}
		
		if($this->location == ""){
			$this->location = $_SESSION['LogInUser']->location;
		}
		
		if($thing == "new"){
			$this->user_id = $this->cadmin;
		}
		
		//if (($oikeus == $this->location) || ($oikeus == 99)){
		print "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\">\n";
		print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">$location2 Reservation editing</td></tr>\n";
		//print "<tr><td>\n";
		
		if ($thing == "edit"){
			print "<form action=\"index.php\" method=\"post\" name=\"updatereserve\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"updatereserve\">\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$this->reserve_id\">\n";
			print "<input type=\"hidden\" name=\"reserve_id\" value=\"$this->reserve_id\">\n";
		}
		
		if ($thing == "new"){
			print "<form action=\"index.php\" method=\"post\" name=\"newreserve\">\n";
			print "<input type=\"hidden\" name=\"page2\" value=\"newreserve\">\n";
		}
		
		print "<input type=\"hidden\" name=\"page\" value=\"reserve\">\n";
				
		if ($this->reserve_id != ""){
			print "<tr><td class=\"tab1\" colspan=\"1\">Reservation number:</td><td class=\"tab2\" colspan=\"2\">$this->reserve_id</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">User:</td><td class=\"tab2\" colspan=\"2\">\n";
			
		if (($thing == "edit") || ($thing == "new")){
			print $user->UserDropDown($this->user_id,"user_id");
			//print "<input type=\"text\" name=\"user_id\" size=\"40\" value=\"$this->user_id\">";
		} else {
			$temp = $user->GetUserName($this->user_id);
			print "$temp&nbsp;";
		}
		
		print "</td></tr>\n";
		
		if ($this->phone_id>0){
			$temp = $phone->ReadPhone($phone_id);
			print "<tr><td class=\"tab1\" colspan=\"1\">Phone id:</td><td class=\"tab2\" colspan=\"2\">\n";
			print "<input type=\"hidden\" name=\"phone_id\" size=\"40\" value=\"$this->phone_id\">\n";
			print "$this->phone_id $temp&nbsp;";
			print "</td></tr>\n";
		}
		
		if ($this->accessory_id>0){
			print "<tr><td class=\"tab1\" colspan=\"1\">Accessory id:</td><td class=\"tab2\" colspan=\"2\">\n";
			print "<input type=\"hidden\" name=\"accessory_id\" size=\"40\" value=\"$this->accessory_id\">\n";
			$temp = $accessories->ReadAccessory($this->accessory_id);
			print "$temp&nbsp;";		
			print "</td></tr>\n";
		}
		
		if ($this->sim_id>0){
			$temp = $sim->ReadSimm($this->sim_id);
			print "<tr><td class=\"tab1\" colspan=\"1\">Sim id:</td><td class=\"tab2\" colspan=\"2\">\n";
			print "<input type=\"hidden\" name=\"sim_id\" value=\"$this->sim_id\">";
			print "$temp&nbsp;";
			$this->project = $sim->project; 
			$this->location = $sim->location; 
			print "</td></tr>\n";
		}
		
		if ($this->flash_id>0){
			$temp = $flash->ReadFlash($this->flash_id);
			print "<tr><td class=\"tab1\" colspan=\"1\">Flash id:</td><td class=\"tab2\" colspan=\"2\">\n";
			print "<input type=\"hidden\" name=\"flash_id\" value=\"$this->flash_id\">";
			print "$temp&nbsp;";
			$this->project = $flash->project; 
			$this->location = $flash->location; 
			print "</td></tr>\n";
		}
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Start time:</td><td class=\"tab2\" colspan=\"2\">\n";
					
		if (strpos($this->start_time, "-")){
			$this->start_time = $fixdate->ReturnDate($this->start_time);
		}
		
		//print "$this->start_time<br>";
		$temp = date("d.m.Y - H:i", $this->start_time);
		
		//print "$this->start_time<br>";	
		if (($thing == "edit") || ($thing == "new")){
			//print "$this->start_time<br>";
			$this->start_time = $fixdate->ReturnDate($this->start_time);
			$fixdate->DateShow("start", "$this->start_time"); 
		} else {
			print "$temp&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">End time:</td><td class=\"tab2\" colspan=\"2\">\n";
	
		if ($thing=="new"){
			$this->end_time = $fixdate->AddMore($this->end_time,0,6,0);
		}
		
		if (strpos($this->end_time, "-")){
			$this->end_time = $fixdate->ReturnDate($this->end_time);
		}
		
		$temp = date("d.m.Y - H:i", $this->end_time);
		
		if (($thing == "edit") || ($thing == "new")){
			$fixdate->DateShow("end", "$this->end_time");
		} else {
			print "$temp&nbsp;";
		}	
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Project:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print $projects->ProjectDropDown($this->project,"");
		} else {
			$projects->ReadProject($this->project);
			print $projects->number . " " .$projects->name . "&nbsp;";
		}
		
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Location:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print $locations->LocationDropDown($this->location);
		} else {
			$locations->ReadLocation($this->location);
			print $locations->name . ", " . $locations->country . "&nbsp;";
		}
					
		print "</td></tr>\n";
			
		print "<tr><td class=\"tab1\" colspan=\"1\">Information:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			print "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>";

		} else {
			if ($this->information==""){
				print "&nbsp;";
			} else {
				print "$this->information&nbsp;";
			}
		}	
		print "</td></tr>\n";
		
		print "<tr><td class=\"tab1\" colspan=\"1\">Last change:</td><td class=\"tab2\" colspan=\"2\">\n";
		
		$lastadmin = $user->GetUserName($this->cadmin);
		
		if (strpos($this->changeday, "-")){
			//print "$this->changeday<br>";
			$this->changeday = $fixdate->ReturnDate($this->changeday);
			//print "$this->changeday<br>";
		}
		
		$lastday = "Today";
		if ($this->changeday!="")
			$lastday = date("d.m.Y - H:i", $this->changeday);
		
		print "$lastadmin<br>$lastday&nbsp;";
								
		print "</td></tr></table>\n";

		if (($oikeus > "1") || ($this->user_id == $_SESSION['LogInUser']->id)){
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
				print "</td></tr></table>\n";
			} else {	
				print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				print "<td class=\"tab\"><a href=\"index.php?page=reservation&id=$this->reserve_id&reserve_id=$this->reserve_id&location=$this->location&edit=1\">&nbsp;Edit&nbsp;</a></td>\n";
				if (($oikeus == $this->location) || ($oikeus == 99)){
					print "<td class=\"tab\"><a href=\"index.php?page=reservation&id=''&location=$this->location&new=1\">&nbsp;New&nbsp;</a></td>\n";
					print "<td class=\"tab\"><a href=\"index.php?page=reservation&id=$this->reserve_id&reserve_id=$this->reserve_id&location=$this->location&copy2new=1\">&nbsp;Copy2New&nbsp;</a></td>\n";
				} else {
					print "<td class=\"tab\">&nbsp;</td>\n";
				}
				if ($this->reserve_id!=""){
					print "<td class=\"tab\"><a onclick=\"return confirmSubmitRETURN()\" href=\"index.php?page=reservation&id=$this->reserve_id&reserve_id=$this->reserve_id&location=$this->location&return=1\">&nbsp;Return&nbsp;</a></td>\n";
				} else {
					print "<td class=\"tab\">&nbsp;</td>\n";
				}
				print "<td class=\"tab\"><a onclick=\"return confirmSubmitRESERVATION()\" href=\"index.php?page=reservation&id=$reserve_id&reserve_id=$this->reserve_id&location=$this->location&delete=1\">&nbsp;Delete&nbsp;</a>";
				print "</td></tr></table>\n";
			}
		}	

		
		/**
		 * New reservations
		 */	
		
		$temp = $this->ShowCommingReservations($this->phone_id, $this->sim_id, $this->accessory_id, $this->flash_id);
		
		/**
		 * old reservations
		 */	
		$temp = $this->ShowOldReservations($this->phone_id, $this->sim_id, $this->accessory_id, $this->flash_id);
	
	}
	
	//-------------------------------
	// Show comming reserves
	//-------------------------------
	public function ShowCommingReservations($phone_id, $sim_id, $accessory_id, $flash_id){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($user))
			$user = new User();
			
		//print "$this->phone_id, $this->sim_id, $this->accessory_id<br>";
		print "<table width=\"950\">\n";		
		print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Reservations</td></tr>\n";
		print "<tr><td class=\"td_phonelistheader\">Reservation starts</td><td class=\"td_phonelistheader\">Reservation ends</td>";
		print "<td class=\"td_phonelistheader\">Who has it</td></tr>";
			
		$nyt = time();
		
		if ($this->phone_id>0){
			$admore = "phone_id = '$phone_id'";
		}
		if ($this->sim_id>0){
			$admore = "sim_id = '$sim_id'";
		}
		if ($this->accessory_id>0){
			$admore = "accessory_id = '$accessory_id'";
		}
		
		if ($this->flash_id>0){
			$admore = "flash_id = '$flash_id'";
		}
		
        $sql = "SELECT * FROM reservation WHERE $admore AND ((start_time > $nyt) OR (start_time < $nyt AND end_time > $nyt)) ORDER BY start_time";
        
    	//print "$sql<br>";
        $haku = $db->AskSQL($sql);
        //$tulos = mysql_fetch_row($haku);
        if (mysql_num_rows($haku) > 0){
     		for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri)	{
          		if (($nyt >= $rivi[3]) && ($nyt <= $rivi[4])){
					$class = "td_phonelistrow2";	
				}
				
				if (($nyt < $rivi[3]) && ($nyt > $rivi[4]))	{
					$class = "td_phonelistrow";
				}
				
				if (($nyt < $rivi[3]) && ($nyt < $rivi[4])){
					$class = "td_phonelistrow";
				}
				
				$this->start_time =  date("d.m.Y - H:i", $rivi[3]);
          		$this->end_time = date("d.m.Y - H:i", $rivi[4]);		
          		$varaaja = $user->GetUserName($rivi[2]);
        		$output = $output . "<tr><td class=\"$class\">$this->start_time</td><td class=\"$class\">$this->end_time</td><td class=\"$class\">$varaaja</td></tr>";
       		}
        }
        
        if (mysql_num_rows($haku) < 1){
     		$output = "<tr><td colspan=\"5\" class=\"td_phonelistrow\">No reservations in this time periot!</td></tr>";
        }
        print $output;
        print "</table>";
        return $output;

	}
	
	//-------------------------------
	// Show old reservations
	//-------------------------------
	public function ShowOldReservations($phone_id, $sim_id, $accessory_id, $flash_id){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($user))
			$user = new User();
			
		if ($phone_id!=""){
			$admore = "phone_id = '$phone_id'";
		}
		if ($sim_id!=""){
			$admore = "sim_id = '$sim_id'";
		}
		if ($accessory_id!=""){
			$admore = "accessory_id = '$accessory_id'";
		}
		
		if ($flash_id!=""){
			$admore = "flash_id = '$flash_id'";
		}
		
		print "</table><table width=\"950\"><tr><td class=\"td_phonelistheader\" colspan=\"3\">Ended reservations (last five)</td></tr>";
		print "<tr><td class=\"td_phonelistheader\">Reservation start</td><td class=\"td_phonelistheader\">Reservation end</td>";
		print "<td class=\"td_phonelistheader\">Who had it</td></tr>";
			
		$nyt = time();
		
		$sql = "SELECT * FROM reservation WHERE $admore AND end_time < $nyt ORDER BY start_time DESC LIMIT 0,5";
		
		$haku = $db->AskSQL($sql);
        //$tulos = mysql_fetch_row($haku);
        if (mysql_num_rows($haku) > 0){
       		for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri)	{
	       		$this->start_time =  date("d.m.Y - H:i", $rivi[3]);
          		$this->end_time = date("d.m.Y - H:i", $rivi[4]);
				$varaaja = $user->GetUserName($rivi[2]);
				$output = $output . "<tr><td class=\"td_phonelistrow\">$this->start_time</td><td class=\"td_phonelistrow\">$this->end_time</td><td class=\"td_phonelistrow\">$varaaja</td></tr>";
         	}
        }
        
        if (mysql_num_rows($haku) < 1){
    		$output = "<tr><td colspan=\"5\" class=\"td_phonelistrow\">No previous reservations!</td></tr>";
        }
        
        print $output;
        print "</table>";
        return $output;
	}
			
	/**
	 * Add new reservation
	 */
	public function AddReservation(){
		if (!isset($db))
			$db = new Database();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$this->phone_id = $_POST["phone_id"];
		$this->user_id = $_POST["user_id"];       
		$this->start_time = $fixdate->MakeDate("start");
		$this->end_time = $fixdate->MakeDate("end");
		$this->project = $_POST["project"];
		$this->accessory_id = $_POST["accessory_id"];
		$this->sim_id = $_POST["sim_id"];
		$this->flash_id = $_POST["flash_id"];
		$this->location = $_POST["location"];
		$this->information = $_POST["information"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = time();
		
		$this->start_time = $fixdate->ReturnDate($this->start_time);
		$this->end_time = $fixdate->ReturnDate($this->end_time);
			
		if ($this->phone_id == "")
			$this->phone_id = "0";
				
		if ($this->accessory_id == "")
			$this->accessory_id = "0";
			
		if ($this->sim_id == "")
			$this->sim_id = "0";
			
		if ($this->flash_id == "")
			$this->flash_id = "0";
			
		/**
		 * Test print phone information (only test!)
	 	 */	
		//$this->PrintReservation();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->start_time == "") || ($this->end_time == "") ||($this->project == "") || ($this->location == "")){
			$output = "3";
			return $output;
		}
		
		/**
		 * Check if thing is allready reserved
		 */
		$nyt = time();
		
		if ($this->phone_id > 0){
			$sql = "SELECT * FROM reservation WHERE phone_id = '$this->phone_id' AND start_time < $nyt AND end_time > $nyt";
			$reserved = "Phone";
		} else {
			$this->phone_id = 0;
		}
			
		if ($this->accessory_id > 0){
			$sql = "SELECT * FROM reservation WHERE accessory_id = '$this->accessory_id' AND start_time < $nyt AND end_time > $nyt";
			$reserved = "Accessory";
		} else {
			$this->accessory_id = 0;
		}
		
		if ($this->sim_id > 0){
			$sql = "SELECT * FROM reservation WHERE sim_id = '$this->sim_id' AND start_time < $nyt AND end_time > $nyt";
			$reserved = "Sim";
		} else {
			$this->sim_id = 0;
		}
		
		if ($this->flash_id > 0){
			$sql = "SELECT * FROM reservation WHERE flash_id = '$this->flash_id' AND start_time < $nyt AND end_time > $nyt";
			$reserved = "Flash";
		} else {
			$this->flash_id = 0;
		}
		
		$haku = $db->AskSQL($sql);
		
		//print "$sql<br>\n";
		
		if (mysql_num_rows($haku) > 0){
			$output = "4";
			return $output;
		}
				
		/**
		 * Insert phone to database
		 */
		$sql = "INSERT INTO reservation ";
		$sql = $sql . "(phone_id, ";
		$sql = $sql . "user_id, ";
		$sql = $sql . "start_time, ";
		$sql = $sql . "end_time, ";
		$sql = $sql . "project, ";
		$sql = $sql . "accessory_id, ";
		$sql = $sql . "sim_id, ";
		$sql = $sql . "flash_id, ";
		$sql = $sql . "location, ";
		$sql = $sql . "information, ";
		$sql = $sql . "cadmin, ";
		$sql = $sql . "changeday)";
		$sql = $sql . " VALUES ";
		$sql = $sql . "($this->phone_id, ";
		$sql = $sql . "$this->user_id, ";
		$sql = $sql . "'$this->start_time', ";
		$sql = $sql . "'$this->end_time', ";
		$sql = $sql . "$this->project, ";
		$sql = $sql . "$this->accessory_id, ";
		$sql = $sql . "$this->sim_id, ";
		$sql = $sql . "$this->flash_id, ";
		$sql = $sql . "$this->location, ";
		$sql = $sql . "'$this->information', ";
		$sql = $sql . "$this->cadmin, ";
		$sql = $sql . "NOW())";
		
		//print "$sql<br>\n";
						
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
		$sql = "SELECT MAX(reserve_id) FROM `reservation`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->reserve_id = $rivi[0];
			$this->phone_id =$rivi[1];
			$this->user_id = $rivi[2];
			$this->start_time =$rivi[3];
			$this->end_time =$rivi[4];
			$this->project = $rivi[5];
			$this->accessory_id =$rivi[6];
			$this->sim_id = $rivi[7];
			$this->flash_id = $rivi[8];
			$this->location = $rivi[9];
			$this->information = $rivi[10];
			$this->cadmin = $rivi[11];
			$this->changeday = $rivi[12];
		}
	}
	
	/**
	 * Add new reservation
	 */
	public function UpdateReservation(){
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		$this->reserve_id = $_POST["reserve_id"];	
		$this->phone_id = $_POST["phone_id"];
		$this->user_id = $_POST["user_id"];
		$this->start_time = $fixdate->MakeDate("start");
		$this->end_time = $fixdate->MakeDate("end");
		$this->project = $_POST["project"];
		$this->accessory_id = $_POST["accessory_id"];
		$this->sim_id = $_POST["sim_id"];
		$this->flash_id = $_POST["flash_id"];
		$this->location = $_POST["location"];
		$this->information = $_POST["information"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = time();
				
		$this->start_time = $fixdate->ReturnDate($this->start_time);
		$this->end_time = $fixdate->ReturnDate($this->end_time);

		if ($this->phone_id == "")
			$this->phone_id = "0";
				
		if ($this->accessory_id == "")
			$this->accessory_id = "0";
			
		if ($this->sim_id == "")
			$this->sim_id = "0";
			
		if ($this->flash_id == "")
			$this->flash_id = "0";
			
			
		//print "$this->phone_id, $this->sim_id, $this->accessory_id<br>";
		/**
		 * Test print phone information (only test!)
	 	 */	
		//$this->PrintReservation();
		
		/**
		 * Check if all nessesary things are filled
		 */
		if (($this->start_time == "") || ($this->end_time == "") ||($this->project == "") || ($this->location == "")){
			$output = "3";
			return $output;
		}
		
		$this->Save();
		
		$output = "0";
		
		return $output;
	}
	
	/**
	 * Saving information
	 */
	public function Save(){
		if (!isset($db))
			$db = new Database();
			
		/**
		 * Update reservation to database
		 */
		$sql = "UPDATE `reservation` SET ";
		$sql = $sql . "phone_id = $this->phone_id, ";
		$sql = $sql . "user_id = $this->user_id, ";
		$sql = $sql . "start_time = $this->start_time, ";
		$sql = $sql . "end_time = $this->end_time, ";
		$sql = $sql . "project = $this->project, ";
		$sql = $sql . "accessory_id = $this->accessory_id, ";
		$sql = $sql . "sim_id = $this->sim_id, ";
		$sql = $sql . "flash_id = $this->flash_id, ";
		$sql = $sql . "location = $this->location, ";
		$sql = $sql . "information = '$this->information', ";
		$sql = $sql . "cadmin = $this->cadmin, ";
		$sql = $sql . "changeday = NOW() ";
		$sql = $sql . "WHERE reserve_id = $this->reserve_id";
			
		//print "$sql<br>";			
		$tulos = $db->UseSQL($sql);	
		
		$_GET["phone_id"] = $this->phone_id;
		$_GET["accessory_id"] = $this->accessory_id;
		$_GET["sim_id"] = $this->sim_id;
		$_GET["flash_id"] = $this->flash_id;
		
		$_POST["phone_id"] = $this->phone_id;
		$_POST["accessory_id"] = $this->accessory_id;
		$_POST["sim_id"] = $this->sim_id;
		$_POST["flash_id"] = $this->flash_id;
	}
			
	public function LisaaVaraus($phone_id, $app, $akk, $avv, $ahh, $amm, $lpp, $lkk, $lvv, $lhh, $lmm, $project, $accessory_id, $sim_id, $location, $information){
		$alkustamp = mktime($ahh, $amm, 0, $akk, $app, $avv);
		$loppustamp = mktime($lhh, $lmm, 0, $lkk, $lpp, $lvv);
		
		//return $loppustamp;
		//Onko varauksen start_time aiemmin varatulla aikavÃ¤lillÃ¤
		$haku = $db->AskSQL("SELECT * FROM intra_varaus WHERE phone_id = '$phone_id' AND end_time > $alkustamp AND start_time < $alkustamp ORDER BY start_time DESC");
		//$tulos = mysql_fetch_row($haku);
		
		if (mysql_num_rows($haku) > 0){
			return "Reservation didn't work. Phone is allready reservated in that time interval.";
		}
		
		$haku = $db->AskSQL("SELECT * FROM intra_varaus WHERE phone_id = '$phone_id' AND start_time = $alkustamp AND end_time = $loppustamp ORDER BY start_time DESC");
  		//$tulos = mysql_fetch_row($haku);
		if (mysql_num_rows($haku) > 0){
			return "Reservation didn't work. Phone is allready reservated in that time interval.";
		}
	
		if ($alkustamp >= $loppustamp)
			return "Reservation didn't work. Reservation start time must be before ending time.";
			
		//Onko varauksen end_time aiemmin varatulla aikavÃ¤lillÃ¤	
		$haku = $db->TeeKysely("SELECT * FROM intra_varaus WHERE phone_id = '$phone_id' AND start_time > $alkustamp AND start_time < $loppustamp ORDER BY start_time DESC");
		
		//$tulos = mysql_fetch_row($haku);
    	if (mysql_num_rows($haku) > 0){
			return "Reservation didn't work. Reservation start time must be before ending time.";
		}
		
		$user_id = $user->id;
		$db->UseQL("INSERT INTO intra_varaus (phone_id, user_id, start_time, end_time, project, accessory_id, sim_id, location, information) VALUES ('$phone_id', '$user_id', '$alkustamp', '$loppustamp', '$project', '$accessory_id', '$sim_id', '$location', '$information')"); 
		$start_time = date("d.m.Y - H:i", $alkustamp);
		$end_time = date("d.m.Y - H:i", $loppustamp);
		$email = $user->email;
		$nimi = $user->nimi;
		$puhelininfo = $phone->HaePuhelimenTiedotMeiliin($phone_id);
		$headers = "MIME-Version: 1.0\r\n".
   		  "Content-type: text/plain; charset=utf-8\r\n".
		  "From: \"Plenware Puhelinvaraukset\" <puhelinvaraus@wtest.almare.com>\r\n".
		  "Subject: Uusi puhelinvaraus tehty: $puhelininfo\r\n";
		$message = "Hi!\n\nYou have made the phone $puhelininfo a new reservation.\n\nReserve begins $start_time and ends $end_time.\n\nRegards,\nPlenware Puhelinvaraukset";
		mail($email, 'A new booking of telephone has been done: $puhelininfo', $message, $headers);
		return "Reservation successfull!";
	}
	
}

?>

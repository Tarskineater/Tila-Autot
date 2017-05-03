<?php
/**
 * Heurex Rental 0.0
 * Car.php
 * 18.03.2013
 */         
class Car{
	var $car_id;
	var $car_plate;
	var $car_gear;
	var $car_type;
	var $car_name;
	var $car_color;
	var $car_fuel;
	var $car_power;
	var $car_volume;
	var $car_year;
	var $car_doors;
	var $car_hitch;
	var $car_ppl;
	var $car_counter;
	var $car_summertires;
	var $car_summertiresalu;
	var $car_wintertires;
	var $car_wintertiresalu;
	var $car_tires;
	var $car_rental;
	var $car_sell;
	var $car_location_id;
	var $car_location;
	var $car_locationmore;
	var $car_surveyed;
	var $car_information;
	var $car_information2;
	var $car_status;
	var $car_status_txt;
	var $car_cadmin;
	var $car_changeday;
	var $cadmin_name;
	var $ip;
	var $car_ok_rent;
	var $car_ok_sell;
	var $pic_id;
	
  	var $ct_id;
	var $ct_vehiclebody;
	var $ct_type;
	var $car_str;
	
	public function Car(){
		$this->car_id = "";
		$this->car_plate = "";
		$this->car_gear = "";
		$this->car_type = "";
		$this->car_name = "";
		$this->car_color = "";
		$this->car_fuel = "";
		$this->car_power = "";
		$this->car_volume = "";
		$this->car_year = "";
		$this->car_doors = "";
		$this->car_hitch = "";
		$this->car_ppl = "";
		$this->car_counter = "";
		$this->car_summertires = "";
		$this->car_summertiresalu = "";
		$this->car_wintertires = "";
		$this->car_wintertiresalu = "";
		$this->car_tires = "";
		$this->car_rental = "";
		$this->car_sell = "";
		$this->car_location_id = "";
		$this->car_location = "";
		$this->car_locationmore = "";
		$this->car_surveyed = "";
		$this->car_information = "";
		$this->car_information2 = "";
		$this->car_status = "1";
		$this->car_status_txt = "";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->ct_id = "";
		$this->ct_vehiclebody = "";
		$this->ct_type = "";
		$this->ip = "";
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";
		$car_str = "";
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
	public function GetCarName($in_id){
		$this->ReadCar($in_id);
		$output = $this->car_name;    
		return $output;
	}
	
	public function  GetMaxCar(){
		if (!isset($db))
 			$db = new Database();
 		$sql = "SELECT MAX(car_id) FROM cars";
		$haku = $db->AskSQL($sql);
		$rivi = mysql_fetch_row ($haku);
		return $rivi[0];
	}
	
	public function ReadCar($in_id){
		//include 'Database.php';
		
		if (!isset($db))
 			$db = new Database();
 			
 		$this->DoAllCars();
		$this->car_id = $in_id;
 		$sql = "SELECT * FROM cars WHERE car_id = '$this->car_id'";
 		
		if ($this->car_id != ""){
			$haku = $db->AskSQL($sql);
		
			$rows = mysql_num_rows($haku);
			$rivi = mysql_fetch_row ($haku);
			
			if (mysql_num_rows($haku) > 0){
				$this->car_id = $rivi[0];
				$this->car_plate = $rivi[1];
				$this->car_gear = $rivi[2];
				$this->car_type = $rivi[3];
				$this->car_name = stripslashes(nl2br($rivi[4]));
				$this->car_color = $rivi[5];
				$this->car_fuel = $rivi[6];
				$this->car_power = $rivi[7];
				$this->car_volume = $rivi[8];
				$this->car_year = $rivi[9];
				$this->car_doors = $rivi[10];
				$this->car_hitch = $rivi[11];
				$this->car_ppl = $rivi[12];
				$this->car_counter = $rivi[13];
				$this->car_summertires = $rivi[14];
				$this->car_summertiresalu = $rivi[15];
				$this->car_wintertires = $rivi[16];
				$this->car_wintertiresalu = $rivi[17];
				$this->car_tires = $rivi[18];
				$this->car_rental = $rivi[19];
				$this->car_sell = $rivi[20];
				$this->car_location_id = $rivi[21];
				$this->car_location = $rivi[22];
				$this->car_locationmore = $rivi[23];
				$this->car_surveyed = $rivi[24];
				$this->car_information = $rivi[25];
				$this->car_information2 = $rivi[26];
				$this->car_status = $rivi[27];
				$this->car_cadmin = $rivi[28];
				$this->car_changeday = $rivi[29];
				$this->car_changeday = $rivi[29];
				$this->ip = $rivi[30];
				$this->car_ok_rent = $rivi[31];
				$this->car_ok_sell = $rivi[32];
				$this->car_color = $this->ReplaceFont($this->car_color);
				$this->car_information = $this->ReplaceFont($this->car_information);
				$this->car_information2 = $this->ReplaceFont($this->car_information2);
				$this->car_name = $this->ReplaceFont($this->car_name);
				
				$this->car_str = "car_id=" . $this->car_id .
				"&car_plate=" .$this->car_plate .
				"&car_gear=" .$this->car_gear  .
				"&car_type=" .$this->car_type  .
				"&car_name=" .$this->car_name  .
				"&car_color=" .$this->car_color  .
				"&car_fuel=" .$this->car_fuel  .
				"&car_power=" .$this->car_power  .
				"&car_volume=" .$this->car_volume  .
				"&car_year=" .$this->car_year  .
				"&car_doors=" .$this->car_doors .
				"&car_hitch=" .$this->car_hitch .
				"&car_ppl=" .$this->car_ppl .
				"&car_counter=" .$this->car_counter .
				"&car_summertires=" .$this->car_summertires .
				"&car_summertiresalu=" .$this->car_summertiresalu .
				"&car_wintertires=" .$this->car_wintertires .
				"&car_wintertiresalu=" .$this->car_wintertiresalu .
				"&car_tires=" .$this->car_tires .
				"&car_rental=" .$this->car_rental .
				"&car_sell=" .$this->car_sell .
				"&car_location_id=" .$this->car_location_id .
				"&car_location=" .$this->car_location .
				"&car_locationmore=" .$this->car_locationmore .
				"&car_surveyed=" .$this->car_surveyed .
				"&car_information=" .$this->car_information .
				"&car_information2=" .$this->car_information2 .
				"&car_status=" .$this->car_status .
				"&car_cadmin=" .$this->car_cadmin .
				"&car_changeday=" .$this->car_changeday .
				"&car_changeday=" .$this->car_changeday .
				"&ip=" .$this->ip .
				"&car_ok_rent=" .$this->car_ok_rent .
				"&car_ok_sell=" .$this->car_ok_sell .
				"&car_color=" .$this->car_color .
				"&car_information=" .$this->car_information .
				"&car_information2=" .$this->car_information2 .
				"&car_name=" .$this->car_name;
				
			}		
		}
		
		//$this->information = str_replace("<br />", "", $this->information);
		
		//$this->TestAll();
			
		$output = "";
				
		//return $this->information;
	}
	
	/**
	 * Test print car information
	 */
	public function PrintCar(){
		echo "car_id: $this->car_id<br>\n";
		echo "car_plate: $this->car_plate<br>\n";
		echo "car_gear: $this->car_gear<br>\n";
		echo "car_type: $this->car_type<br>\n";
		echo "car_name: $this->car_name<br>\n";
		echo "car_color: $this->car_color<br>\n";
		echo "car_fuel: $this->car_fuel<br>\n";
		echo "car_power: $this->car_power<br>\n";
		echo "car_volume: $this->car_volume<br>\n";
		echo "car_year: $this->car_year<br>\n";
		echo "car_doors: $this->car_doors<br>\n";
		echo "car_hitch: $this->car_hitch<br>\n";
		echo "car_ppl: $this->car_ppl<br>\n";
		echo "car_counter: $this->car_counter<br>\n";
		echo "car_summertires: $this->car_summertires<br>\n";
		echo "car_summertiresalu: $this->car_summertiresalu<br>\n";
		echo "car_wintertires: $this->car_wintertires<br>\n";
		echo "car_wintertiresalu: $this->car_wintertiresalu<br>\n";
		echo "car_tires: $this->car_tires<br>\n";
		echo "car_rental: $this->car_rental<br>\n";
		echo "car_sell: $this->car_sell<br>\n";
		echo "car_location: $this->car_location<br>\n";
		echo "car_locationmore: $this->car_locationmore<br>\n";
		echo "car_surveyed: $this->car_surveyed<br>\n";
		echo "car_information: $this->car_information<br>\n";
		echo "car_information2: $this->car_information2<br>\n";
		echo "car_status: $this->car_status<br>\n";
		echo "car_cadmin: $this->car_cadmin<br>\n";
		echo "car_changeday: $this->car_changeday<br>\n";
		echo "car_ok_rent: $this->car_ok_rent<br>\n";
		echo "car_ok_sell: $this->car_ok_sell<br>\n";
	}	
	
	/**
	 * Car dropdown
	 */
	public function CarDropDown($car_id,$cname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
 		$output = "<select name=\"$cname\">\n";
		$sql = "SELECT * FROM `cars` ORDER BY car_name";
		//echo "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($user_id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[0] $rivi[4]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[0] $rivi[4]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}	

	/**
	 * Car status
	 */
	public function CarStatusDropDown($car_stat,$cname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
 		$output = "<select name=\"$cname\">\n";
		$sql = "SELECT * FROM status ORDER BY status_id";
		//echo "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($car_stat == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[0] $rivi[1]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[0] $rivi[1]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}
	
	/**
	 * Car status
	 */
	public function GiveCarStatus($car_stat){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();

		$sql = "SELECT * FROM status where status_id=$car_stat";
		
		$haku = $db->AskSQL($sql);
		
		$rivi = mysql_fetch_row ($haku);
		$this->car_status_txt=$rivi[1];
	}
	
	/**
	 * GetTableOption
	 */
	public function GetTableOption($tname, $in_id, $cname){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
 		$output = "<select name=\"$cname\">\n";
		$sql = "SELECT * FROM $tname ORDER BY 1";
		//echo "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($in_id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[0] $rivi[1]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[0] $rivi[1]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $output;
	}	
	
	/**
	 * GetTableOptionTxt
	 */
	public function GetTableOptionTxt($tname, $cname, $in_id){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();

		$sql = "SELECT * FROM $tname where $cname=$in_id";
		//echo $sql  . "<br>";
		$haku = $db->AskSQL($sql);
		
		$rivi = mysql_fetch_row ($haku);
		return $rivi[1];
	}
	
	public function ShowCars($location, $locationname, $list_type){
	
		$output = "";
		if (!isset($db))
			$db = new Database();
				
		if (!isset($locations))
			$locations = new Location();
			
		$page2 = $_SESSION['Search']->page2;	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$this->DoAllCars();
		
		$car_type1 = "";
		$order_car = "car_location, car_name";
		
		if (!isset($_GET["car_type"]) == "")
			$car_type1 = $_GET["car_type"];
			
		if (!isset($_GET["order_car"]) == "")
			$order_car = $_GET["order_car"];
			
		$sql = "SELECT * FROM cars ORDER BY " . $order_car;
		
		if ($car_type1 <> ""){
			$sql = "SELECT * FROM cars WHERE car_type='" . $car_type1 . "' ORDER BY " . $order_car; 
		}

		//echo "$sql<br>\n";
		//if ($page2 == "searchform"){
		//	$sql = $_SESSION['Search']->sql_user;
		//} else {	
		//	$sql = "SELECT * FROM cars ORDER BY car_name";
			       
			//if ($oikeus < 99)
			//	$sql = "SELECT * FROM cars WHERE car_location = $location ORDER BY car_location, car_name";
		//}
			
		//echo "$page2 $sql<br>";
		
		if($locationname=="All"){
			$output2 = "Autot";
		} else {
			$output2 = "$locationname autot";
		}
		
		$tmp_txt="<a href=\"index.php?page=car&list=type";

		if ($list_type == '0'){
			echo "<table width=\"100%\"><tr>";
			echo "<td align=\"center\" class=\"stylish-cBack\">";
			echo "<table width=\"100%\"><tr>";
			echo "<td>". $tmp_txt . "&order_car=car_plate\" class=\"stylish-button\">Rekisterikilpi</a></td>\n";
			echo "<td>". $tmp_txt . "&order_car=car_name\" class=\"stylish-button\">Nimi</a></td>\n";
			echo "<td>". $tmp_txt . "&order_car='car_counter,car_name'\" class=\"stylish-button\">Kilometrej&#228;</a></td>\n";
			echo "<td>". $tmp_txt . "&order_car='location_name,car_name'\" class=\"stylish-button\">Paikkakunta</a></td>\n";
			echo "<td>". $tmp_txt . "&order_car='car_loaned,car_name'\" class=\"stylish-button\">Lainassa</a></td>\n";
			
			echo "<td height=\"28\">";
			echo "<a href=\"classes/excel.php?name=$output2&cols=6&col1=0&col2=1&col3=13&col4=13&col5=21&col6=15&";
			echo "coln1=ID&coln2=Name&coln3=Plate&coln4=Mileadge&coln5=Location&coln6=Lend&sql=$sql\" class=\"stylish-button\">Exel&nbsp;</a>&nbsp;";
			echo "<a href=\"index.php?page=car&id=&car_id=&new=1\" class=\"stylish-button\">Uusi</a></td></td></tr>\n";
		} 
		if ($list_type == '1'){
			echo "<table><tr>";
			echo "<td align=\"center\" class=\"stylish-cBack\">";
			echo "<table><tr><td class=\"stylish-button\" colspan=\"1\">Kuva</a></td>\n";
			echo "<td class=\"stylish-button\"colspan=\"1\">" . $tmp_txt . "&order_car=car_plate\">Rekisterikilpi</a></td>\n";
			echo "<td class=\"stylish-button\">". $tmp_txt . "&order_car=car_name\">Nimi</a></td>\n";
			echo "<td class=\"stylish-button\" colspan=\"1\">". $tmp_txt . "&order_car='location_name,car_name'\">Paikkakunta</a></td>\n";
			echo "<td class=\"stylish-button\" colspan=\"1\">". $tmp_txt . "&order_car='car_rental,car_name'\">Hinta</a></td></tr>\n";
		}
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				$this->car_id = $rivi[0];
				$this->car_plate = $rivi[1];
				$this->car_gear = $rivi[2];
				$this->car_type = $rivi[3];
				$this->car_name = $this->ReplaceFont(stripslashes(nl2br($rivi[4])));
				$this->car_color = $rivi[5];
				$this->car_fuel = $rivi[6];
				$this->car_power = $rivi[7];
				$this->car_volume = $rivi[8];
				$this->car_year = $rivi[9];
				$this->car_doors = $rivi[10];
				$this->car_hitch = $rivi[11];
				$this->car_ppl = $rivi[12];
				$this->car_counter = $rivi[13];
				$this->car_summertires = $rivi[14];
				$this->car_summertiresalu = $rivi[15];
				$this->car_wintertires = $rivi[16];
				$this->car_wintertiresalu = $rivi[17];
				$this->car_tires = $rivi[18];
				$this->car_rental = $rivi[19];
				$this->car_sell = $rivi[20];
				$this->car_location_id = $rivi[21];
				$this->car_location = $this->ReplaceFont($rivi[22]);
				$this->car_locationmore = $rivi[23];
				$this->car_surveyed = $rivi[24];
				$this->car_information = $rivi[25];
				$this->car_information2 = $rivi[26];
				$this->car_status = $rivi[27];
				$this->car_cadmin = $rivi[28];
				$this->car_changeday = $rivi[29];
				$this->ip = $rivi[30];
				$this->car_ok_rent = $rivi[31];
				$this->car_ok_sell = $rivi[32];
				
				$tmp_carid = $this->CarNro();
				
				$this->car_name = $this->ReplaceFont($this->car_name);
				$this->car_information = $this->ReplaceFont($this->car_information);
				$this->car_information2 = $this->ReplaceFont($this->car_information2);
				
				$cardelete = "";
				$carupdate = "";
				$username = $rivi[1];
				$toiminnot = "Not shown";
	
				$temp = "<a href=\"index.php?page=car&id=$rivi[9]&car_id=$rivi[0]&show=1\" class=\"stylish-cRows\">$rivi[15]</a>";	
				$temp2 = "<td class=\"stylish-cRows\"><a href=\"index.php?page=location&id=$this->car_location&location_id=$this->car_location_id&show=1&edtype=$list_type\" class=\"stylish-cRows\">" . $this->car_location ."</a>&nbsp;</td>\n";		//."," . $this->ReplaceFont($this->car_locationmore)	
				$temp3 = "<td class=\"stylish-cRows\"><a href=\"index.php?page=location&id=$this->car_location&location_id=$this->car_location_id&show=1&edtype=$list_type\" class=\"stylish-cRows\">" . $this->car_location ."</a>&nbsp;</td>\n";	
				$temp4 = "<td class=\"stylish-cRows\">" . $this->car_location ."</td>\n";
				$hinta = "<td class=\"stylish-cRows\">"; // . $this->car_ok_sell . ":" . $this->car_sell . "/" . $this->car_ok_rent. ":" . $this->car_rental . "<br>"; 
				
				if ($this->car_ok_rent == "1"){
					$hinta = $hinta . $this->car_rental . "&#8364;/day&nbsp;<br>";
				}
				
				if ($this->car_ok_sell == "1"){
					$hinta = $hinta . $this->car_sell . "&#8364;&nbsp;";
				}
				
				$hinta = $hinta . "</td>"; 				
				if ($oikeus > "1") {
					$car_remove = "<a onclick=\"return confirmSubmitCAR()\" href=\"index.php?page=car&id=$rivi[0]&car_id=$rivi[0]&delete=1\"><img src=\"" . DIR_PICTURES . LANG ."/small_delete.gif\" border=\"0\" title=\"Delete car\"></a>";
					$toiminnot = "<a href=\"index.php?page=car&id=$rivi[0]&car_id=$rivi[0]&edit=1\" class=\"stylish-button\">Muokkaa</a>\n";
					//$toiminnot = "<a href=\"index.php?page=car&id=$rivi[0]&car_id=$rivi[0]&edit=1\"><img src=\"" . DIR_PICTURES . "update2.gif\" border=\"0\" title=\"Update information\"></a>\n";
										
					if ($this->car_id == $rivi[0])
						$car_remove = "";		
				}
			
				if ($list_type == '0'){
					if ($rivi[1] != NULL){
						$output = $output . "<tr><td class=\"stylish-cRows\">&nbsp;<a href=\"index.php?page=car&id=$rivi[0]&car_id=$rivi[0]&show=1&edtype=$list_type\"class=\"stylish-cRows\">$this->car_plate</a>&nbsp;</td><td class=\"stylish-cRows\">" . $this->ReplaceFont($rivi[4]) . "&nbsp;</a></td>\n";
						$output = $output . "<td class=\"stylish-cRows\">$this->car_counter km</td>$temp2<td class=\"stylish-cRows\">$temp&nbsp;</td>\n";
				
						if ($oikeus > "1")
							$output = $output . "<td>$toiminnot</td></tr>";
					}
				} else {					
					if ($rivi[1] != NULL)
						$tmp = "<a href=\"index.php?page=car&id=$rivi[0]&car_id=$rivi[0]&show=1&edtype=$list_type\"><img src=\"images/cars/Car_" . $this->car_plate . "_001.jpg\" alt=\"$rivi[4]\" title=\"$rivi[4]\" width=\"100\" border='0'/></a>";
						$output = $output . "<tr><td class=\"stylish-cRows\">$tmp</td><td class=\"stylish-cRows\">&nbsp;<a href=\"index.php?page=car&id=$rivi[0]&car_id=$rivi[0]&show=1&edtype=$list_type\">$this->car_plate</a>&nbsp;</td><td class=\"stylish-cRows\">" . $this->ReplaceFont($rivi[4]) . "&nbsp;</a></td>\n";
						$output = $output . "$temp4 $hinta</tr>\n";
					}
				}
			} else {
				$output = $output . "<tr><td colspan=\"6\" class=\"td_listrow\">Ei autoja!</td></tr>";
			}
		
		$output = $output . "</table>\n";
		$output = $output . "</td></tr></table>\n";
		echo "$output";
	}

	/**
	 * Edit Car
	 */
	public function EditCar($in_id, $location2, $thing){

		$this->id = $in_id;
		$this->car_id = $in_id;
		$this->location2 = $location2;
		$this->thing = $thing;
		$this->oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		if (!isset($locations))
			$locations = new Location();
			
		if (isset($_GET["location"]))				
			$this->location = $_GET["location"];
			
		if (!isset($FixDate))
			$fixdate = new FixDate();	
			
		if (isset($_GET["ed"])=="1"){
		
			$this->ReadPost();
				
		} else {
			$this->ReadCar($this->id);
		}
		
		if (isset($_GET["copy2new"])=="1"){
			$this->id = "";
			$this->thing = "new";
		}
		if ($this->thing == "new"){
			$this->car_id = "";
		}
	
		if (($this->thing == "edit") || ($this->thing == "new")){
			$this->car_changeday = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
		}
		
		$this->car_locationmore = $this->ReplaceFont($this->car_locationmore);						
		$this->car_information = $this->ReplaceFont($this->car_information);
		$this->car_information2 = $this->ReplaceFont($this->car_information2);
				
		echo "<table width=\"800\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "<center><img src=\"" . DIR_PICTURES  . LANG ."/car_edit.gif\" border=\"0\">";
		echo "</td></tr></table></td></tr></table>";
		
		$carNroIs = $this->CarNro();
		echo "<table width=\"800\"><tr>";
		echo "<td height='90' class=\"stylish-cBack\" align=\"left\">";
		for ($i=1; $i<=5; $i++){
			//echo "The number is " . $i . "<br />";
			$tmpimg = "images/cars/Car_" . $this->car_plate . "_00$i.jpg";
			if (file_exists("$tmpimg")){
					//echo $linkki . "$i" . $linkki2 . "<img name='car" . $i . "' src='$tmpimg' onMouseOver=\"document.images['selectedimage'].src = '$tmpimg';\" width='70' height='70' alt='' onClick=\"document.images['selectedimage'].src='$tmpimg'\" ></a>";
					echo "<img name='car" . $i . "' src='$tmpimg' onMouseOver=\"document.images['selectedimage'].src = '$tmpimg';\" width='70' height='70' alt='' onClick=\"document.images['selectedimage'].src='$tmpimg'\" border='0'>";
			}
		}
		echo "</td></tr></table>";
		
		echo "<table width=\"800\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\">";
		
		if ($this->thing == "edit"){
			echo "<form action=\"index.php\" method=\"post\" name=\"updatecar\">\n";
			echo "<input type=\"hidden\" name=\"page2\" value=\"updatecar\">\n";
			echo "<input type=\"hidden\" name=\"id\" value=\"$this->id\">";
			echo "<input type=\"hidden\" name=\"car_id\" value=\"$this->id\">";
		}
		
		if ($this->thing == "new"){
			echo "<form action=\"index.php\" method=\"post\" name=\"newcar\">\n";
			echo "<input type=\"hidden\" name=\"page2\" value=\"newcar\">\n";
			echo "<input type=\"hidden\" name=\"car_id\" value=\"$this->id\">";
		}
		
		echo "<tr><td class=\"stylish-button\">Auton numero :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		echo "$this->car_id&nbsp;</td>";
				
		echo "<td class=\"stylish-button\">Rekisterikilpi :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_plate\" size=\"30\" value=\"$this->car_plate\"></td></tr>";
		} else {
			echo "$this->car_plate&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Vaihteisto :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_gear\" size=\"30\" value=\"$this->car_gear\"></td>";
		} else {
			echo "$this->car_gear&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Auto tyyppi :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_type\" size=\"30\" value=\"$this->car_type\"></td></tr>";
		} else {
			echo "$this->car_gear&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Auton nimi :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_name\" size=\"30\" value=\"$this->car_name\"></td>";
		} else {
			echo "$this->car_name&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Auton v&#228;ri :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_color\" size=\"30\" value=\"$this->car_color\"></td></tr>";
		} else {
			echo "$this->car_color&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Polttoaine :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_fuel\" size=\"30\" value=\"$this->car_fuel\"></td>";
		} else {
			echo "$this->car_fuel&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Voimakkuus :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_power\" size=\"30\" value=\"$this->car_power\"></td></tr>";
		} else {
			echo "$this->car_power&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Tilavuus :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_volume\" size=\"30\" value=\"$this->car_volume\"></td>";
		} else {
			echo "$this->car_volume&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Valmistus vuosi :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_year\" size=\"30\" value=\"$this->car_year\"></td></tr>";
		} else {
			echo "$this->car_year&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Ovia :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_doors\" size=\"30\" value=\"$this->car_doors\"></td>";
		} else {
			echo "$this->car_doors&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Vaihteisto :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_hitch\" size=\"30\" value=\"$this->car_hitch\"></td></tr>";
		} else {
			echo "$this->car_hitch&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Matkustajia (max):&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_ppl\" size=\"30\" value=\"$this->car_ppl\"></td>";
		} else {
			echo "$this->car_ppl&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Matkamittari n. :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_counter\" size=\"30\" value=\"$this->car_counter\"></td></tr>";
		} else {
			echo "$this->car_counter&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Kes&#228;renkaat :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_summertires\" size=\"30\" value=\"$this->car_summertires\"></td>";
		} else {
			echo "$this->car_summertires&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Alumiini kes&#228;renkaat :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_summertiresalu\" size=\"30\" value=\"$this->car_summertiresalu\"></td></tr>";
		} else {
			echo "$this->car_summertiresalu&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Talvirenkaat :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_wintertires\" size=\"30\" value=\"$this->car_wintertires\"></td>";
		} else {
			echo "$this->car_wintertires&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Alumiini talvirenkaat :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_wintertiresalu\" size=\"30\" value=\"$this->car_wintertiresalu\"></td></tr>";
		} else {
			echo "$this->car_wintertiresalu&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Renkaat paikoillaan :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo $this->GetTableOption('tires', $this->car_tires, 'car_tires');
			echo "</td></tr>";
		} else {
			echo $this->GetTableOptionTxt('tires', 'tires_id', $this->car_tires);
			echo "</td></tr>";
		}

		
		echo "<tr><td class=\"tab2\" colspan=\"5\">&nbsp;</td></tr>\n";	
		
		echo "<tr><td class=\"stylish-button\">Vuokraushinta :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_rental\" size=\"30\" value=\"$this->car_rental\"></td>";
		} else {
			echo "$this->car_rental&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Myyntihinta :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_sell\" size=\"30\" value=\"$this->car_sell\"></td></tr>";
		} else {
			echo "$this->car_sell&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"tab2\" colspan=\"5\">&nbsp;</td></tr>\n";	
		
		echo "<tr><td class=\"stylish-button\">Paikkakunta : </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo $locations->LocationDropDown("car_location_id", $this->car_location_id);
			echo "</td>";
			//echo "<input type=\"text\" name=\"car_location\" size=\"30\" value=\"$this->car_location\"></td>";
		} else {
			echo "$this->car_location_id&nbsp;$this->car_location&nbsp;</td>";
		}
		
		echo "<td class=\"stylish-button\">Tarkka osoite :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_locationmore\" size=\"30\" value=\"$this->car_locationmore\"></td></tr>";
		} else {
			echo "$this->car_locationmore&nbsp;</td></tr>";
		}
		echo "<tr><td class=\"tab2\" colspan=\"5\">&nbsp;</td></tr>\n";	
		
		echo "<tr><td class=\"stylish-button\">Katsastettu :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_surveyed\" size=\"30\" value=\"$this->car_surveyed\"></td></tr>";
		} else {
			echo "$this->car_surveyed&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Auto vuokrattavissa :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_ok_rent\" size=\"30\" value=\"$this->car_ok_rent\"></td></tr>";
		} else {
			echo "$this->car_ok_rent&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Auto myynnissä :&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"text\" name=\"car_ok_sell\" size=\"30\" value=\"$this->car_ok_sell\"></td></tr>";
		} else {
			echo "$this->car_ok_sell&nbsp;</td></tr>";
		}
				
		echo "<tr><td class=\"stylish-button\">Tietoa autosta :&nbsp;</td><td class=\"tab2\" colspan=\"4\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<textarea name=\"car_information\" rows=\"3\" cols=\"50\" size=\"254\">$this->car_information</textarea></td></tr>";
		} else {
			echo "$this->car_information&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Tietoa autosta 2 :&nbsp;</td><td class=\"tab2\" colspan=\"4\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<textarea name=\"car_information2\" rows=\"3\" cols=\"50\" size=\"254\">$this->car_information2</textarea></td></tr>";
		} else {
			echo "$this->car_information2&nbsp;</td></tr>";
		}
		
		echo "<tr><td class=\"stylish-button\">Status :&nbsp;</td><td class=\"tab2\" colspan=\"4\">\n";
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo $this->GetTableOption('status', $this->car_status, 'car_status');
		} else {
			echo $this->GetTableOptionTxt('status', 'status_id', $this->car_status);
			//echo "$this->car_status_txt&nbsp;";
			
			//GetTableOptionTxt($tname, $cname, $in_id){

				//$sql = "SELECT * FROM '$tname' where $cname='$in_id'";
		}
		
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Viimeinen muutos:&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
				
		$this->car_changeday = $fixdate->ReturnDate($this->car_changeday);
		$temp = date("Y-m-d",$this->car_changeday);
		echo "$this->cadmin_name $temp</td></tr>";
		
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		echo "<table width=\"800\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		
		if (($this->thing == "edit") || ($this->thing == "new")){
			echo "<input type=\"submit\" value=\"Submit\" id=\"el09\">\n";
			echo "</form>";
		} else {
			if (($_SESSION['LogInUser']->id==$this->id)||($this->oikeus > "1")) {
				echo "<a href=\"index.php?page=car&id=$this->id&car_id=$this->id&edit=1&edtype=0\"><img src=\"" . DIR_PICTURES  . LANG ."/small_edit.gif\" border=\"0\"></a>\n";
				if ($this->oikeus > "1"){
					echo "<a onclick=\"return confirmSubmitUSER()\" href=\"index.php?page=car&id=$this->id&car_id=$this->id&delete=1&edtype=0\"><img src=\"" . DIR_PICTURES  . LANG ."/small_delete.gif\" border=\"0\" border='0'></a>\n";
				}
			}
		}	
		echo "<center><br><a href=\"index.php\"><img src=\"" . DIR_PICTURES . LANG . "/logo01.gif\" border=\"0\"></a>";
		//echo "</td></tr></table>";
	}
			
	/**
	 * Check car data
	 */
	public function CheckCar(){
		$output = 0;
		//echo "username "; 
		
		if (!preg_match("/^[a-�A-�0-9_]{1,254}$/",$this->name)) { 
			$output = "10";
			return $output;
    	}

		//echo "Email "; 
		$pattern = "^([a-�A-�0-9\.|-|_]{1,60})([@])";
		$pattern .="([a-�A-�0-9\.|-|_]{1,60})(\.)([A-Za-z]{2,3})$";

		return $output;
	}
	
	/**
	 * Add new user to database
	 */
	public function AddCar(){
		if (!isset($db))
			$db = new Database();
			
		/**
		 * Checks and makes admin user
		 */
		$this->DoAllCars();
		$this->ReadPost();
	
		$this->name = mysql_real_escape_string($this->name);
			
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->car_changeday = date("Y-m-d H:i:s",time());
		
		/*$this->check_car = $this->CheckCar();
		if ($this->check_car!=0){
			return $this->check_car;
		}
	   */
		$sql = "SELECT * FROM cars WHERE car_plate = '$this->car_plate'";
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) > 0){
			$output = "4";
			return $output;
		}
		
		$sql = "SELECT * FROM cars WHERE car_plate = '$this->car_plate'";
		$haku = $db->AskSQL("$sql");
				
		if (mysql_num_rows($haku) > 0){
			$output = "1";
			return $output;
		}
		
		$sql = "INSERT INTO cars (car_plate, car_gear, car_type, car_name, car_color, car_fuel, car_power, car_volume, car_year, car_doors, car_hitch, car_ppl, car_counter, car_summertires, car_summertiresalu, car_wintertires, car_wintertiresalu, car_tires, car_rental, car_sell, car_location, car_locationmore, car_surveyed, car_information, car_information2, car_status, car_cadmin, car_changeday, car_ok_rent, car_ok_sell) VALUES ('$this->car_plate', '$this->car_gear', '$this->car_type', '$this->car_name', '$this->car_color', '$this->car_fuel', '$this->car_power', '$this->car_volume', '$this->car_year', '$this->car_doors', '$this->car_hitch', '$this->car_ppl', '$this->car_counter', '$this->car_summertires', '$this->car_summertiresalu', '$this->car_wintertires', '$this->car_wintertiresalu', " . 
		"'$this->car_tires', '$this->car_rental', '$this->car_sell', '$this->car_location', '$this->car_locationmore', '$this->car_surveyed', '$this->car_information', '$this->car_information2', '$this->car_status', '$this->car_cadmin', NOW(), '$this->car_ok_rent', '$this->car_ok_sell')";
			
				
		$tulos = $db->UseSQL($sql);
		$this->SearchNewst();
		$output = "0";
		
		return $output;
	}
	
	/**
	 * Luetaan muuttujat postista
	 */
	public function ReadPost(){
	
		if (isset($_POST["car_id"]))
			$this->car_id  = $_POST["car_id"];
			
		if (isset($_POST["car_plate"]))
			$this->car_plate = $_POST["car_plate"];
			
		if (isset($_POST["car_gear"]))
			$this->car_gear = $_POST["car_gear"];
			
		if (isset($_POST["car_type"]))
			$this->car_type = $_POST["car_type"];
			
		if (isset($_POST["car_name"]))
			$this->car_name = $_POST["car_name"];
			
		if (isset($_POST["car_color"]))
			$this->car_color = $_POST["car_color"];
			
		if (isset($_POST["car_fuel"]))
			$this->car_fuel = $_POST["car_fuel"];
			
		if (isset($_POST["car_power"]))
			$this->car_power = $_POST["car_power"];
			
		if (isset($_POST["car_volume"]))
			$this->car_volume = $_POST["car_volume"];
			
		if (isset($_POST["car_year"]))
			$this->car_year = $_POST["car_year"];
			
		if (isset($_POST["car_doors"]))
			$this->car_doors = $_POST["car_doors"];
			
		if (isset($_POST["car_hitch"]))
			$this->car_hitch = $_POST["car_hitch"];
			
		if (isset($_POST["car_ppl"]))
			$this->car_ppl = $_POST["car_ppl"];
			
		if (isset($_POST["car_counter"]))
			$this->car_counter = $_POST["car_counter"];
			
		if (isset($_POST["car_summertires"]))
			$this->car_summertires = $_POST["car_summertires"];
			
		if (isset($_POST["car_summertiresalu"]))
			$this->car_summertiresalu = $_POST["car_summertiresalu"];
			
		if (isset($_POST["car_wintertires"]))
			$this->car_wintertires = $_POST["car_wintertires"];
			
		if (isset($_POST["car_wintertiresalu"]))
			$this->car_wintertiresalu = $_POST["car_wintertiresalu"];
			
		if (isset($_POST["car_tires"]))
			$this->car_tires = $_POST["car_tires"];
			
		if (isset($_POST["car_rental"]))
			$this->car_rental = $_POST["car_rental"];
			
		if (isset($_POST["car_sell"]))
			$this->car_sell = $_POST["car_sell"];
			
		if (isset($_POST["car_location_id"]))
			$this->car_location_id = $_POST["car_location_id"];
			
		if (isset($_POST["car_location"]))
			$this->car_location = $_POST["car_location"];
			
		if (isset($_POST["car_locationmore"]))
			$this->car_locationmore = $_POST["car_locationmore"];
			
		if (isset($_POST["car_surveyed"]))
			$this->car_surveyed = $_POST["car_surveyed"];
			
		if (isset($_POST["car_information"]))
			$this->car_information = $_POST["car_information"];
			
		if (isset($_POST["car_information2"]))
			$this->car_information2 = $_POST["car_information2"];
			
		if (isset($_POST["car_status"]))
			$this->car_status = $_POST["car_status"];
			
		if (isset($_POST["car_cadmin"]))
			$this->car_cadmin = $_POST["car_cadmin"];
			
		if (isset($_POST["car_changeday"]))
			$this->car_changeday = $_POST["car_changeday"];
	
		if (isset($_POST["car_ok_rent"]))
			$this->car_ok_rent = $_POST["car_ok_rent"];
		
		if (isset($_POST["car_ok_sell"]))
			$this->car_ok_sell = $_POST["car_ok_sell"];
			
	}

	/**
	 * Luetaan muuttujat getistä
	 */
	public function ReadGet(){
	
		if (isset($_GET["car_id"]))
			$this->car_id  = $_GET["car_id"];
			
		if (isset($_GET["car_plate"]))
			$this->car_plate = $_GET["car_plate"];
			
		if (isset($_GET["car_gear"]))
			$this->car_gear = $_GET["car_gear"];
			
		if (isset($_GET["car_type"]))
			$this->car_type = $_GET["car_type"];
			
		if (isset($_GET["car_name"]))
			$this->car_name = $_GET["car_name"];
			
		if (isset($_GET["car_color"]))
			$this->car_color = $_GET["car_color"];
			
		if (isset($_GET["car_fuel"]))
			$this->car_fuel = $_GET["car_fuel"];
			
		if (isset($_GET["car_power"]))
			$this->car_power = $_GET["car_power"];
			
		if (isset($_GET["car_volume"]))
			$this->car_volume = $_GET["car_volume"];
			
		if (isset($_GET["car_year"]))
			$this->car_year = $_GET["car_year"];
			
		if (isset($_GET["car_doors"]))
			$this->car_doors = $_GET["car_doors"];
			
		if (isset($_GET["car_hitch"]))
			$this->car_hitch = $_GET["car_hitch"];
			
		if (isset($_GET["car_ppl"]))
			$this->car_ppl = $_GET["car_ppl"];
			
		if (isset($_GET["car_counter"]))
			$this->car_counter = $_GET["car_counter"];
			
		if (isset($_GET["car_summertires"]))
			$this->car_summertires = $_GET["car_summertires"];
			
		if (isset($_GET["car_summertiresalu"]))
			$this->car_summertiresalu = $_GET["car_summertiresalu"];
			
		if (isset($_GET["car_wintertires"]))
			$this->car_wintertires = $_GET["car_wintertires"];
			
		if (isset($_GET["car_wintertiresalu"]))
			$this->car_wintertiresalu = $_GET["car_wintertiresalu"];
			
		if (isset($_GET["car_tires"]))
			$this->car_tires = $_GET["car_tires"];
			
		if (isset($_GET["car_rental"]))
			$this->car_rental = $_GET["car_rental"];
			
		if (isset($_GET["car_sell"]))
			$this->car_sell = $_GET["car_sell"];
			
		if (isset($_GET["car_location_id"]))
			$this->car_location_id = $_GET["car_location_id"];
			
		if (isset($_GET["car_location"]))
			$this->car_location = $_GET["car_location"];
			
		if (isset($_GET["car_locationmore"]))
			$this->car_locationmore = $_GET["car_locationmore"];
			
		if (isset($_GET["car_surveyed"]))
			$this->car_surveyed = $_GET["car_surveyed"];
			
		if (isset($_GET["car_information"]))
			$this->car_information = $_GET["car_information"];
			
		if (isset($_GET["car_information2"]))
			$this->car_information2 = $_GET["car_information2"];
			
		if (isset($_GET["car_status"]))
			$this->car_status = $_GET["car_status"];
			
		if (isset($_GET["car_cadmin"]))
			$this->car_cadmin = $_GET["car_cadmin"];
			
		if (isset($_GET["car_changeday"]))
			$this->car_changeday = $_GET["car_changeday"];
	
		if (isset($_GET["car_ok_rent"]))
			$this->car_ok_rent = $_GET["car_ok_rent"];
		
		if (isset($_GET["car_ok_sell"]))
			$this->car_ok_sell = $_GET["car_ok_sell"];
			
	}
	
	/**
	 * Search the newst
	 */
	public function SearchNewst(){
		if (!isset($db))
			$db = new Database(); 
		$db->Database();
 		
		$output = "";
		$sql = "SELECT MAX(car_id) FROM `cars`";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
		}
	}
		
	public function UpdateCar($in_id){
		if (!isset($db))
			$db = new Database();
			
		$this->car_id = $in_id;
		
		$this->ReadPost();
					
		$this->car_changeday = date("Y-m-d H:i:s",time());
		
		/**
		$this->check_car = $this->CheckCar();
		if ($this->check_car!=0){
			return $this->check_car;
		}
		*/
		
		$sql = "SELECT * FROM cars WHERE car_plate = '$this->car_plate'";
		
		$haku = $db->AskSQL("$sql");
		
		if (mysql_num_rows($haku) == 0){
			$output = "4";
			return $output;
		}
		
		$sql = "UPDATE cars SET car_plate = '$this->car_plate', 
				car_gear = '$this->car_gear', 
				car_type = '$this->car_type', 
				car_name = '$this->car_name', 
				car_color = '$this->car_color', 
				car_fuel = '$this->car_fuel', 
				car_power = '$this->car_power', 
				car_volume = '$this->car_volume', 
				car_year = '$this->car_year', 
				car_doors = '$this->car_doors', 
				car_hitch = '$this->car_hitch', 
				car_ppl = '$this->car_ppl', 
				car_counter = '$this->car_counter', 
				car_summertires = '$this->car_summertires', 
				car_summertiresalu = '$this->car_summertiresalu', 
				car_wintertires = '$this->car_wintertires', 
				car_wintertiresalu = '$this->car_wintertiresalu', 
				car_tires = '$this->car_tires', 
				car_rental = '$this->car_rental', 
				car_sell = '$this->car_sell', 
				car_location_id = '$this->car_location_id', 
				car_location = '$this->car_location', 
				car_locationmore = '$this->car_locationmore', 
				car_surveyed = '$this->car_surveyed', 
				car_information = '$this->car_information', 
				car_information2 = '$this->car_information2', 
				car_status = '$this->car_status', 
				car_cadmin = '$this->car_cadmin', 
				car_changeday = '$this->car_changeday', 
				car_ok_rent = '$this->car_ok_rent', 
				car_ok_sell = '$this->car_ok_sell' WHERE car_id = '$this->car_id'";	
		
		$tulos = $db->UseSQL($sql);
	
		$output = "0";
		return $output;
	}
	
	/**
	 * Delete Car
	 */ 
	public function DeleteCar($id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
 		$output = $this->CheckBeforeDelete($car_id);
 		if($output=="0"){
			/**
		 	* Copy to deleted
		 	*/
			$this->DeletedCar($car_id);	
		
			$sql = "DELETE FROM cars WHERE car_id = '$car_id'";
			$db->UseSQL("$sql");
		}
		return $output;
	}
	
	/**
	 * Copy car to deleted
	 */
	public function DeletedCar($in_id){
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
 		$this->ReadCar($in_id);
		
		if ($this->car_id != ""){
		    /**
		 	 * Delete car from database
		 	 */
			$sql = "INSERT INTO deleted_cars (car_id, car_plate, car_gear, car_type, car_name, car_color, car_fuel, car_power, car_volume, car_year, car_doors, car_hitch, car_ppl, car_counter, car_summertires, car_summertiresalu, car_wintertires, car_wintertiresalu, car_tires, car_rental, car_sell, car_location, car_locationmore, car_surveyed, car_information, car_information2, car_status, car_cadmin, car_changeday) VALUES ('$this->car_id', " .
			"$this->car_plate', '$this->car_gear', '$this->car_type', '$this->car_name', '$this->car_color', '$this->car_fuel', '$this->car_power', '$this->car_volume', '$this->car_year', '$this->car_doors', '$this->car_hitch', '$this->car_ppl', '$this->car_counter', '$this->car_summertires', '$this->car_summertiresalu', '$this->car_wintertires', '$this->car_wintertiresalu', '$this->car_tires', '$this->car_rental', '$this->car_sell', '$this->car_location', '$this->car_locationmore', '$this->car_surveyed', '$this->car_information', '$this->car_information2', '$this->car_status', '$this->car_cadmin', NOW())";
			$tulos = $db->UseSQL($sql);		
		}		
	}
	
	/*
	public function UpdateOtherCar($car_plate, $name, $email, $location, $oikeustaso, $id, $project, $phone, $information){
		$haku = $db->AskSQL("SELECT * FROM cars WHERE car_plate = '$car_plate' AND id NOT LIKE '$id'");
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
	*/

	/**
	 * Makes Test car if there is none
	 */
	public function MakeOneCar(){
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		
		$sql = "SELECT * FROM cars WHERE car_plate = '$this->car_plate'";
		
		$haku = $db->AskSQL("$sql");
		$tulos = mysql_fetch_row($haku);
		
		if (mysql_num_rows($haku) == 0){
			$sql = "INSERT INTO cars (car_plate, car_gear, car_type, car_name, car_color, car_fuel, car_power, car_volume, car_year, car_doors, car_hitch, car_ppl, car_counter, car_summertires, car_summertiresalu, car_wintertires, car_wintertiresalu, car_tires, car_rental, car_sell, car_location, car_locationmore, car_surveyed, car_information, car_information2, car_status, car_cadmin, car_changeday, car_ok_rent, car_ok_sell) VALUES ('$this->car_plate', '$this->car_gear', '$this->car_type', '$this->car_name', '$this->car_color', '$this->car_fuel', '$this->car_power', '$this->car_volume', '$this->car_year', '$this->car_doors', '$this->car_hitch', '$this->car_ppl', '$this->car_counter', '$this->car_summertires', '$this->car_summertiresalu', '$this->car_wintertires', '$this->car_wintertiresalu', '$this->car_tires', '$this->car_rental', '$this->car_sell', '$this->car_location', '$this->car_locationmore', '$this->car_surveyed', '$this->car_information', '$this->car_information2', '$this->car_status', '$this->car_cadmin', NOW(), '$this->car_ok_rent', '$this->car_ok_sell')";
			$tulos = $db->UseSQL($sql);
		}
	}
	
	/**
	 * Makes Test cars if there is none
	 */
	public function DoAllCars(){
		/*
			ZJA-633
			Mercedes-Benz
		*/
		/**
		$this->car_plate = "ZJA-633";
		$this->car_gear = "Automatic";
		$this->car_type = "4";
		$this->car_name = "Mercedes-Benz E 220 CDI";
		$this->car_color = "Musta";
		$this->car_fuel = "Diesel";
		$this->car_power = "98 kW / 133 Hv";
		$this->car_volume = "2";
		$this->car_year = "1997";
		$this->car_doors = "5";
		$this->car_hitch = "Automatic";
		$this->car_ppl = "5";
		$this->car_counter = "200000";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "1";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "1";
		$this->car_tires = "1";
		$this->car_rental = "50";
		$this->car_sell = "7000";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "01.05.2012";
		$this->car_information = "Ohjaustehostin, Lohkol&#228;mmitin, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "Renkaat: 205/65R15. Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		*/
		/*
			JCB-81
			Dodge
		*/
		/*
		$this->car_plate = "JCB-81";
		$this->car_gear = "Automatic";
		$this->car_type = "3";
		$this->car_name = "Dodge Caravan";
		$this->car_color = "Valkea";
		$this->car_fuel = "Bensiini";
		$this->car_power = "98 kW / 133 Hv";
		$this->car_volume = "2";
		$this->car_year = "1997";
		$this->car_doors = "5";
		$this->car_hitch = "Automatic";
		$this->car_ppl = "7";
		$this->car_counter = "180000";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "1";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "1";
		$this->car_tires = "1";
		$this->car_rental = "50";
		$this->car_sell = "6280";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "01.05.2012";
		$this->car_information = "Ohjaustehostin, Lohkol&#228;mmitin, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "Tarkemmat varuste ym tiedot tulossa! Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();	
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";		
		$this->MakeOneCar();
		*/
		/*
			TCG-199
			Mitsubishi Space Wagon 2.0GLXi
		*/
		$this->car_plate = "TCG-199";
		$this->car_gear = "Manual";
		$this->car_type = "3";
		$this->car_name = "Mitsubishi Space Wagon 2.0GLXi";
		$this->car_color = "Muu - Metalliv&#228;ri";
		$this->car_fuel = "Bensiini";
		$this->car_power = "98 kW / 133 Hv";
		$this->car_volume = "2";
		$this->car_year = "1997";
		$this->car_doors = "5";
		$this->car_hitch = "Manual";
		$this->car_ppl = "7";
		$this->car_counter = "437980";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "0";
		$this->car_wintertires = "0";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "1";
		$this->car_rental = "30";
		$this->car_sell = "2280";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "26.08.2008";
		$this->car_information = "Ohjaustehostin, Lohkol&#228;mmitin, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "Renkaat: 185/70R14 88. Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "0";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		/*
			EIA-758
			Renault
		*/
		$this->car_plate = "EIA-758";
		$this->car_gear = "Manual";
		$this->car_type = "2";
		$this->car_name = "Renault Megane";
		$this->car_color = "Harmaa";
		$this->car_fuel = "Bensiini";
		$this->car_power = "98 kW / 133 Hv";
		$this->car_volume = "2";
		$this->car_year = "1997";
		$this->car_doors = "5";
		$this->car_hitch = "Manual";
		$this->car_ppl = "5";
		$this->car_counter = "180000";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "1";
		$this->car_wintertires = "0";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "1";
		$this->car_rental = "40";
		$this->car_sell = "3500";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "05.07.2012";
		$this->car_information = "Ohjaustehostin, Lohkolämmitin, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistojärjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "kes&#228;renkaat alumiinivanteilla.Tarkemmat varuste ym tiedot tulossa! Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();	
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		/*
			JXY-56
			Pontiac Trans Sport
		*/
		$this->car_plate = "JXY-56";
		$this->car_gear = "Manual";
		$this->car_type = "3";
		$this->car_name = "Pontiac Trans Sport";
		$this->car_color = "Vihre&#228;";
		$this->car_fuel = "Bensiini";
		$this->car_power = "108 kW / 133 Hv";
		$this->car_volume = "2260";
		$this->car_year = "1994";
		$this->car_doors = "5";
		$this->car_hitch = "Manual";
		$this->car_ppl = "7";
		$this->car_counter = "316476";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "0";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "0";
		$this->car_rental = "50";
		$this->car_sell = "4280";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "29.05.2007";
		$this->car_information = "Ohjaustehostin, Lohkol&#228;mmitin, Ilmastointi, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "Tarkemmat varuste ym tiedot tulossa! Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "0";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "0";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();	
		
		/*
			NYM-84
			Pontiac Trans Sport
		*/
		$this->car_plate = "NYM-84";
		$this->car_gear = "Manual";
		$this->car_type = "3";
		$this->car_name = "Pontiac Trans Sport";
		$this->car_color = "Vihre&#228;";
		$this->car_fuel = "Bensiini";
		$this->car_power = "108 kW / 133 Hv";
		$this->car_volume = "2260";
		$this->car_year = "1994";
		$this->car_doors = "5";
		$this->car_hitch = "Manual";
		$this->car_ppl = "7";
		$this->car_counter = "373335";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "1";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "1";
		$this->car_tires = "0";
		$this->car_rental = "50";
		$this->car_sell = "4280";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "26.08.2012";
		$this->car_information = "Ohjaustehostin, Lohkol&#228;mmitin, ABS+ALB, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "Kattoikkuna. Renkaat: P205/65R15. Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		/*
			KMZ-142
			Ford Transit 2.4 TDI VAN 3300MM
		*/
		$this->car_plate = "KMZ-142";
		$this->car_gear = "Manual";
		$this->car_type = "5";
		$this->car_name = "Ford Transit 2.4 TDI VAN 3300MM";
		$this->car_color = "Valkea";
		$this->car_fuel = "Diesel";
		$this->car_power = "98 kW / 133 Hv";
		$this->car_volume = "2";
		$this->car_year = "1997";
		$this->car_doors = "4";
		$this->car_hitch = "Manual";
		$this->car_ppl = "4";
		$this->car_counter = "437980";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "0";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "0";
		$this->car_rental = "60";
		$this->car_sell = "6280";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "26.08.2008";
		$this->car_information = "Ohjaustehostin, lohkol&#228;mmitin, ilmastointi, penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm�, Vetokoukku ja Huoltokirja";
		$this->car_information2 = ".Tarkemmat varuste ym tiedot tulossa! Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "0";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "0";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		/*
			WVA-655
			Kevyt per�k�rry
		*/
		$this->car_plate = "WVA-655";
		$this->car_gear = "Manual";
		$this->car_type = "9";
		$this->car_name = "Aisapoika 3.3K Kevyt per&#228;k&#228;rry";
		$this->car_color = "Valkea";
		$this->car_fuel = "-";
		$this->car_power = "-";
		$this->car_volume = "1790";
		$this->car_year = "2009";
		$this->car_doors = "1";
		$this->car_hitch = "-";
		$this->car_ppl = "-";
		$this->car_counter = "-";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "0";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "0";
		$this->car_rental = "30";
		$this->car_sell = "2700";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "-";
		$this->car_information = "Keskiakseliper&#228;k&#228;rry, kevyt tavarankuljetusper&#228;vaunu.";
		$this->car_information2 = "Kuomullinen. Renkaat: 145/80R13. Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		/*
			EYX-154
			Opel Vectra-B
		*/
		$this->car_plate = "EYX-154";
		$this->car_gear = "Manual";
		$this->car_type = "1";
		$this->car_name = "Opel 4D Vectra Sedan 1.8";
		$this->car_color = "Vihreä";
		$this->car_fuel = "Bensiini";
		$this->car_power = "92 kW / xxx Hv";
		$this->car_volume = "1790";
		$this->car_year = "2001";
		$this->car_doors = "5";
		$this->car_hitch = "Manual";
		$this->car_ppl = "5";
		$this->car_counter = "270000";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "0";
		$this->car_wintertires = "1";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "0";
		$this->car_rental = "40";
		$this->car_sell = "4280";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllil&#228;nkuja 5B, 33730 Tampere";
		$this->car_surveyed = "28.06.2011";
		$this->car_information = "ABS";
		$this->car_information2 = "Tarkemmat varuste ym tiedot tulossa! Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		/*
			GEN-966
			Opel 5D Astra Caravan
		*/
		$this->car_plate = "GEN-966";
		$this->car_gear = "Manual";
		$this->car_type = "4";
		$this->car_name = "Opel 5D Astra Caravan 1.8-TGF35/261";
		$this->car_color = "Sininen";
		$this->car_fuel = "Bensiini";
		$this->car_power = "92 kW / 133 Hv";
		$this->car_volume = "2";
		$this->car_year = "2001";
		$this->car_doors = "5";
		$this->car_hitch = "Manual";
		$this->car_ppl = "5";
		$this->car_counter = "180000";
		$this->car_summertires = "1";
		$this->car_summertiresalu = "0";
		$this->car_wintertires = "0";
		$this->car_wintertiresalu = "0";
		$this->car_tires = "1";
		$this->car_rental = "30";
		$this->car_sell = "3500";
		$this->car_location = "Tampere, Finland";
		$this->car_locationmore = "Hyllilänkuja 5B, 33730 Tampere";
		$this->car_surveyed = "21.09.2012";
		$this->car_information = "Ohjaustehostin, Lohkol&#228;mmitin, Ilmastointi, Penkinl&#228;mmittimet Elektroniikka &#228;&#228;nentoistoj&#228;rjestelm&#228; Muut Vetokoukku, Huoltokirja";
		$this->car_information2 = "Tarkemmat varuste ym tiedot tulossa! Tiedot myyj&#228;lt&#228; p 040-4166005";
		$this->car_status = "1";
		$this->car_cadmin = "0";
		$this->car_changeday = time();	
		$this->car_ok_rent = "1";
		$this->car_ok_sell = "1";	
		$this->MakeOneCar();
		
		
	}
	
	/**
	 * Test Print car type
	 */
	public function PrintCarType(){
		echo "ct_id: $this->ct_id<br>\n";
		echo "ct_vehiclebody: $this->ct_vehiclebody<br>\n";
		echo "ct_type: $this->ct_type<br>\n";		
	}
	
	/**
	 * Car type dropdown
	 */
	public function CarTypeDropDown($ct_id){
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		$tmp = "";
 		$output = "<select ct_id=\"$ct_id\">\n";
		$sql = "SELECT * FROM `car_type` ORDER BY ct_id";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($ct_id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[0] $rivi[1]</option>\n";  
					$tmp = $rivi[1];
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[0] $rivi[1]</option>\n";  
				}
			}
		}
		
		$output = $output . "</select>\n";
		
		return $tmp; //$output;
	}
	
	/**
	 * Car type list
	 */
	public function CarTypeList(){
		$output = "";
		if (!isset($db))
 			$db = new Database();
 			
 		$db->Database();
 		
		$sql = "SELECT * FROM `car_type` ORDER BY ct_id";
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
			//	if ($ct_id == $rivi[0]){
					$sql = "SELECT * FROM cars WHERE car_type='" . $rivi[0] . "' ORDER BY car_location, car_name";
					$haku2 = $db->AskSQL($sql);
					$rows2 = mysql_num_rows($haku2);
					$typeName = $this->ReplaceFont($rivi[1]);
					if ($rows2 > 0){
						$output = $output . "<a href=\"index.php?page=car&list=type&car_type=$rivi[0]\" target=\"_top\">";
						$output = $output . "<img src=\"images/type/$rivi[3]\" alt=\"Type_$rivi[0]\" title=\"$typeName\" border='0'/></a><br>\n"; 
					} else {
						$output = $output . "<img src=\"images/type/$rivi[3]\" alt=\"Type_$rivi[0]\" title=\"$typeName\" border='0'/><br>\n"; 
					}
					//$output = $output . "<tr><td><a href=\"index.php?page=car@list=type@car_type=$rivi[0]\" target=\"_top\">";
					//$output = $output . "<img src=\"images/type/$rivi[3]\" alt=\"Type_$rivi[0]\" title=\"$rivi[1]\"/></a></td></tr>\n";  					
			//	} else {
		//			$output = $output . "<tr><td class=\"td_links\">$rivi[1]</td><\tr>\n";  
		//		}
			}
		}
		
		//$output = $output . "</td></tr></table>\n";
		
		echo $output;
	}
	
	/**
	 * Car information
	 */
	public function CarInformation($id){

		$this->GetCarName($id);
		$tmp = $this->ReplaceFont($this->CarTypeDropDown($this->car_type));
		echo "<table valign='top' width='180' border =\"0\"><tr><td class=\"stylish-cBack\">";
		echo "<table valign=\"top\" width=\"180\" border =\"0\">";
		echo "<tr><td class=\"stylish-button\" colspan=\"2\">Auton tiedot</td>"; //td_carlist0
		echo "<tr><td class=\"stylish-cRows\">Tyyppi</td><td class=\"stylish-cRows\">"; //td_carlist1
		echo "$tmp</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Korimalli</td><td class=\"stylish-cRows\">Tila-auto</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Henkil&#246;m&#228;&#228;r&#228;</td><td class=\"stylish-cRows\">$this->car_ppl</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Ovien lkm</td><td class=\"stylish-cRows\">$this->car_doors</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">V&#228;ri</td><td class=\"stylish-cRows\">$this->car_color</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Vuosimalli</td><td class=\"stylish-cRows\">$this->car_year</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Mittarilukema</td><td class=\"stylish-cRows\">$this->car_counter km</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Polttoaine</td><td class=\"stylish-cRows\">$this->car_fuel</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Moottorin til.</td><td class=\"stylish-cRows\">$this->car_volume l</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Teho</td><td class=\"stylish-cRows\">$this->car_power</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Vetotapa</td><td class=\"stylish-cRows\">Etuveto</td></tr>";	
		
		$tmp = "Ei";
		if ($this->car_summertires == "1") {
			$tmp = "On";
		}
		echo "<tr><td class=\"stylish-cRows\">Kes&#228;renkaat</td><td class=\"stylish-cRows\">$tmp</td></tr>";
		
		$tmp = "Ei";
		if ($this->car_summertiresalu == "1") {
			$tmp = "On";
		}
		echo "<tr><td class=\"stylish-cRows\">Kes&#228;alumiinit</td><td class=\"stylish-cRows\">$tmp</td></tr>";
		
		$tmp = "Ei";
		if ($this->car_wintertires == "1") {
			$tmp = "On";
		}
		echo "<tr><td class=\"stylish-cRows\">Talvirenkaat</td><td class=\"stylish-cRows\">$tmp</td></tr>";
		
		$tmp = "Ei";
		if ($this->car_wintertiresalu == "1") {
			$tmp = "On";
		}
		echo "<tr><td class=\"stylish-cRows\">Talvialumiinit</td><td class=\"stylish-cRows\">$tmp</td></tr>";
		
		
		$tmp = "Kes&#228;renkaat";
		
		if ($this->car_tires == "0") {
			$tmp = "Kes&#228;renkaat";
		}
		
		if ($this->car_tires == "1") {
			$tmp = "Kes&#228; alumiinirenkaat";
		}
		
		if ($this->car_tires == "2") {
			$tmp = "Talvirenkaat";
		}
		
		if ($this->car_tires == "3") {
			$tmp = "Talvi alumiinirenkaat";
		}
		
		echo "<tr><td class=\"stylish-cRows\">Paikoillaan</td><td class=\"stylish-cRows\">$tmp</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Vaihteisto</td><td class=\"stylish-cRows\">$this->car_hitch</td></tr>";
		echo "<tr><td class=\"stylish-cRows\">Katsastettu</td><td class=\"stylish-cRows\">09/2011</td></tr>";
		echo "<tr><td class=\"stylish-button\" colspan=\"2\">Sis&#228;tilat ja mukavuudet</td></tr>";
		echo "<tr><td class=\"stylish-cRows\" colspan=\"2\">$this->car_information</td></tr>";
		echo "<tr><td class=\"stylish-button\" colspan=\"2\">Tekniset tiedot</td></tr>";
		echo "<tr><td class=\"stylish-cRows\" colspan=\"2\">$this->car_information2</td></tr>";
		
		if (($this->car_ok_rent == "1") || ($this->car_ok_sell == "1")){
			echo "<tr><td class=\"stylish-button\" colspan=\"2\">Hinnat</td></tr>";
		
			if ($this->car_ok_rent == "1"){
				echo "<tr><td class=\"stylish-cRows\">P&#228;iv&#228;vuokra</td><td class=\"stylish-cRows\">$this->car_rental&#8364;/p&#228;iv&#228;</td></tr>";
			}
			
			if ($this->car_ok_sell == "1"){
				echo "<tr><td class=\"stylish-cRows\">Myyntihinta</td><td class=\"stylish-cRows\">$this->car_sell&#8364;</td></tr>";
			}
		}

		echo "<tr><td class=\"stylish-button\" colspan=\"2\">Sijainti</td></tr>";
		echo "<tr><td class=\"stylish-cRows\" colspan=\"2\">$this->car_location</td></tr>";
		echo "<tr><td class=\"stylish-button\" colspan=\"2\">P&#228;ivitetty</td></tr>";
		echo "<tr><td class=\"stylish-cRows\" colspan=\"2\">$this->car_changeday</td></tr>";
		echo "<tr><td class=\"stylish-cRows\" colspan=\"2\">";
		$tmp = "includes/classes/car_a4.php?car_id=" . $this->car_id;
		echo "<a id=\"myLink\" href=\"#\" onclick=\"javascript:event_popupWin = window.open('$tmp', 'event', 'resizable=yes, scrollbars=no, toolbar=yes');event_popupWin.opener = self;return false;\">A4-information</a></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
	}
	
	/**
	 * Car Picture Box
	 */
	public function CarPictureBox($id){

		if ($this->pic_id == ""){
			$this->pic_id = 1;
		}
		
		$this->GetCarName($id);
		$carNroIs = $this->CarNro();
		$picNroIs = $this->PicNro();
		
		$linkki = "<a href=\"index.php?page=car&car_id=" . $this->car_id . "&pic_id=";
		$linkki2 = "\" target=\"_top\">";
		echo "<table valign='top' width='100%' height='400' border =\"0\"><tr><td height='350' class=\"stylish-cBack\"><center>";
		echo "<a href='images/cars/Car_" . $this->car_plate . "_" . $picNroIs . ".jpg' target='_blank'><center>";
		echo "<img name='selectedimage' src='images/cars/Car_" . $this->car_plate . "_" . $picNroIs . ".jpg' alt='Auto' title=' Auto ' width='550' border='0'/></a>";
		echo "</td></tr><tr>";
		echo "<td height='90' class=\"stylish-cBack\" width='100%'>";
		for ($i=1; $i<=8; $i++){
			//echo "The number is " . $i . "<br />";
			$tmpimg = "images/cars/Car_" . $this->car_plate . "_00$i.jpg";
			if (file_exists("$tmpimg")){
					//echo $linkki . "$i" . $linkki2 . "<img name='car" . $i . "' src='$tmpimg' onMouseOver=\"document.images['selectedimage'].src = '$tmpimg';\" width='70' height='70' alt='' onClick=\"document.images['selectedimage'].src='$tmpimg'\" ></a>";
					echo "<img name='car" . $i . "' src='$tmpimg' onMouseOver=\"document.images['selectedimage'].src = '$tmpimg';\" width='70' height='70' alt='' onClick=\"document.images['selectedimage'].src='$tmpimg'\" border='0'>";
			}
		}
		echo "</td></tr></table>";
	}

	/**
	 * Getting right day
	 */
	public function DayType($day,$month,$year,$car_id){
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		
		//$this->car_id = $car_id;
		$testday = "cEmptySlot";
		
		$event_date = $year."-".$month."-".$day;
		
		$sql = "SELECT * FROM tmp_reservation WHERE car_id = '$this->car_id' AND start_time='$event_date'";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			$testday = "cPartly";
		}
		
		return $testday;		
	
		//	$insEvent_sql = "INSERT INTO tmp_reservation (user_session_id, car_id, accessory_id, location, start_time, end_time, changeday);	
	}
	/**
	 * Picture
	 */
	public function CarPictureName($id){
		$this->GetCarName($id);
		echo "<table valign='top' width='100%' border=1><tr><td class=\"td_carlist3\"><center>";
		echo "<h2><a href='includes/car_selected_more_info.php' target='_top'>" . $this->car_name . "</a></h2>";
		echo "</td><td width='100' class=\"td_carlist3\"> Vuokrahinta yht. " . $this->car_rental . "&#8364;</td></tr></table>";
	}
	
	/**
	 * Car Name Cost
	 */
	public function CarNameCost($id){
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		$this->GetCarName($id);
		$car_cost = 0;
		//$client_id = $_SESSION["kayttajatunniste"];//$_GET['client_id'];
		//$car_id = $id;
		//$accessory_id = ""; //$_GET['accessory_id'];
		//$location = "1";// $_GET['location'];
		
		//$event_date = $y."-".$m."-".$d;
		$sql = "SELECT * FROM tmp_reservation WHERE car_id = '" . $this->car_id . "' AND user_session_id='" . $_SESSION["kayttajatunniste"] . "'";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			$car_cost = $rows *  $this->car_rental;			
		}
	
		echo "<table valign='top' width='600' border=\"0\"><tr><td class=\"stylish-button\"><center>";
		echo "<h2>" . $this->ReplaceFont($this->car_name) . "</h2>";
		echo "<h2>" . $this->ReplaceFont($this->car_locationmore . ', ' . $this->car_location) . "</h2>";
		echo "</td><td width='100' class=\"stylish-button\"> Vuokrahinta yht. " . $car_cost . "&#8364;</td></tr></table>";
	}
	/**
	 * Car extra
	 */
	public function CarExtras(){
		//$this->GetCarName($id);
		echo "<table height=\"100%\"><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		echo "<table valign=\"top\" width=\"130\" height=\"100%\" border=\"0\">";
		echo "<tr><td class=\"stylish-button\"><center>Extrat autoon p&#228;iv&#228; hinta</td></tr>";
		echo "<tr><td align=\"left\" class=\"stylish-cRows\">";
		//echo "<form action=\"index.php\" method=\"post\" name=\"extraform\"><br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_1\" enabled=\"false\"/> Pelikonsoli 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_2\" /> Videopeli1 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_3\" /> Videopeli2 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_4\" /> Videopeli3 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_5\" /> Videopeli4 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_6\" /> Videopeli5 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_7\" /> DVD-Soitin 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_8\" /> Suksiboxi 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_9\" /> Kattoteline 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_10\" /> Py&#246;r&#228;teline 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_11\" /> J&#228;&#228;kaappi 5&#8364;<br>";
		echo "<input type=\"checkbox\" name=\"extra\" value=\"extra_12\" /> Vessa 5&#8364;";
		//echo "<input type=\"submit\" value=\"P&#228;ivit&#228;\" id=\"el09\">";
		echo "</form>";
		echo "</td></tr></table>";
		echo "</td></tr></table>";
	}
	
	/**
	 * Car box
	 */
	public function CarBox($id){
		$this->GetCarName($id);
		$carNroIs = $this->CarNro();
		echo "<table><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		echo "<table valign=\"top\" width=\"120\" height=\"150\">\n";
		echo "<tr><td class=\"stylish-button\">$this->car_name</td></tr>\n";
		echo "<tr><td class=\"stylish-cRows\"><center><br>";
		echo "<a href=\"index.php?page=car&car_id=$this->car_id&show=1\" target=\"_top\">";
		echo "<img src=\"images/cars/Car_" . $this->car_plate. "_001.jpg\" alt=\"$this->car_name\" title=\"$this->car_name\" width=\"100\" border='0'/></a><br>$this->car_rental&#8364;/day<br>$this->car_sell&#8364;</center></td></tr>\n";
		echo "</table>\n";
		echo "</td></tr></table>";
	}
	
	/**
	 * Onko asiakkaalla ostoskorissa kamaa
	 */
	public function IsBasket(){
		if (!isset($db))
		$db = new Database();
 			
 		$db->Database();
		
		$user_session = $_SESSION["kayttajatunniste"];
			
		$sql = "SELECT DISTINCT car_id FROM tmp_reservation WHERE user_session_id = '$user_session' order by car_id";
		
		$IsBasketOk = $db->AskSQL($sql);
		
		return mysql_num_rows($IsBasketOk);	
	}
	
	/**
	 * car_selected_info
	 */
	public function Car_Selected_Info($id){
		$border_now = 0;
		$this->GetCarName($id);
		$_SESSION["car_id"] = $id;
		$kayttajan_id = $_SESSION['LogInUser']->id;
		
		echo "<table valign='top' width='480' border=\"$border_now\"><tr><td width='100%' VALIGN=TOP>";
		$this->CarNameCost($id);
		echo "</td><td rowspan=2 VALIGN=TOP>";
		$this->CarInformation($id);
		echo "</td></tr><tr><td VALIGN=TOP>";
		echo "<table border=\"$border_now\"></tr><td width='350'>";
		$this->CarPictureBox($id);
		echo "</td></tr><tr><td colspan=2>";
		$this->Calendar();
		echo "</td></tr></table></td></tr></table>";
	}
	
	public function Calendar(){		
		if (!isset($reservations))
			$reservations = new Reserve();
		
		$userid = $_SESSION['LogInUser']->id;
		
		$monthNames = Array("Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Kes&#228;kuu", "Hein&#228;kuu", 
		"Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu");

		/**$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
		"August", "September", "October", "November", "December");*/

		if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
		if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

		$cMonth = $_REQUEST["month"];
		$cYear = $_REQUEST["year"];
		 
		$prev_year = $cYear;
		$next_year = $cYear;
		$prev_month = $cMonth-1;
		$next_month = $cMonth+1;
		 
		if ($prev_month == 0 ) {
			$prev_month = 12;
			$prev_year = $cYear - 1;
		}
		if ($next_month == 13 ) {
			$next_month = 1;
			$next_year = $cYear + 1;
		}

		echo "<table width='100%'><tr><td align='center' class=\"stylish-cBack\">";
		echo "<table width='100%' cellpadding='2' cellspacing='2' border=0><tr align='center'>";
		echo "<td colspan='2' align='left' class=\"stylish-cMonth\">  <a href='". $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year . "&page=car&car_id=$this->car_id&show=1' class=\"stylish-cMonth\">&#171; Edellinen</a></td>";
		echo "<td colspan='3' class=\"stylish-cMonth\"><strong>" . $monthNames[$cMonth-1] . " " . $cYear ."</strong></td>";
		echo "<td colspan='2' align='right' class=\"stylish-cMonth\"><a href='" . $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . "&page=car&car_id=$this->car_id&show=1' class=\"stylish-cMonth\">Seuraava &#187;</a> </td>";
		echo "</tr><tr>";


		echo "<td class=\"stylish-cRows\">M</td>";
		echo "<td class=\"stylish-cRows\">T</td>";
		echo "<td class=\"stylish-cRows\">K</td>";
		echo "<td class=\"stylish-cRows\">T</td>";
		echo "<td class=\"stylish-cRows\">P</td>";
		echo "<td class=\"stylish-cRows\">L</td>";
		echo "<td class=\"stylish-cRows\">S</td>";
		
		echo "</tr>";

		$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
		$maxday = date("t",$timestamp);
		$thismonth = getdate ($timestamp);
		$startday = $thismonth['wday']-1;
		//echo "$startday ";
		$empty = 0;

		for ($i=0; $i<($maxday+$startday); $i++) {
			if(($i % 7) == 0 ) {
				echo "<tr>";
				$empty = 0;
			}
			
			$td_name = "td_" . ($i - $startday + 1);
			
			if($i < $startday) {
				echo "<td class=\"stylish-cEmpty\"></td>";
			} else {	
				$reservations->DayType(($i - $startday + 1), $cMonth, $cYear, $this->car_id, $_SESSION["kayttajatunniste"], $_SESSION['LogInUser']->id);
				$tmpClick ="if(this.style.className='stylish-cEmptySlot'){this.style.className='stylish-cPartly'}";
				
				echo "<td onClick=\"this.className='$reservations->classNew'\" class=\"$reservations->classNow\">";
				
				if(($reservations->DayOld == "1") || ($reservations->car_ok_rent == "0") ){
					echo $this->gNro(($i - $startday + 1),2);
				}else{
					$tmp = "includes/classes/event.php?client_id=" . $_SESSION["kayttajatunniste"] . "&m=" . $cMonth . "&d=" . ($i - $startday + 1) . "&y=$cYear&car_id=" . $this->car_id;
					echo "<a id=\"myLink\" href=\"#\" onclick=\"javascript:event_popupWin = window.open('$tmp', 'event', 'resizable=no, scrollbars=no, toolbar=no,width=250,height=230');event_popupWin.opener = self;return false;\">" . $this->gNro(($i - $startday + 1),2) . "</a>";
				}
				
				echo "</td>";
				$empty++;
				
				if(($i % 7) == 6 ) echo "</tr>";

			}
		}

		if (($empty)>0 || ($empty)<7){
			for ($i=($empty+1); $i==7; $i++) {
				echo "<td class=\"cEmpty\"></td>";
			}
		}

		echo "</tr></table></td></tr>";
		echo "<tr><td>";
		echo "<table><tr>";
		echo "<td class=\"cEmptySlot\">&nbsp;&nbsp;</td><td class=\"cLabel\">Vapaa</td>";
		echo "<td class=\"cPartly\">&nbsp;&nbsp;</td><td class=\"cLabel\">Varaamassa</td>";
		echo "<td class=\"cFull\">&nbsp;&nbsp;</td><td class=\"cLabel\">Varattu</td>";
		echo "<td class=\"cSell\">&nbsp;&nbsp;</td><td class=\"cLabel\">Maksamasi</td><td>";
		echo "<br><center>";
		echo "<a href=\"index.php?page=ostoskori&user_id=" . $_SESSION['LogInUser']->id . "\" class=\"stylish-button\">Vuokrakori</a><br><br>";
		if ($this->IsBasket()>0){
			echo "<a href=\"index.php?page=kassa\" class=\"stylish-button\">Kassalle</a>";
		}
		echo "</td></tr></table>";
		echo "</td></tr></table><br>";
		echo "Varatut mutta ei viel&#228; maksetut varaukset<br>h&#228;vi&#228;v&#228;t 10min p&#228;&#228;st&#228;.";
		$tmpClick = "";
		$empty = "";
	}
	
	/**
	 * Remove old reservations
	 */
	public function Calendar_Remove_Old(){
		if (!isset($db))
			$db = new Database();
			
		$time_now = date("Ymd") . substr("00" . date("h"), -2). substr("00" . date("i"), -2);
		
		$sql = "DELETE FROM tmp_reservation WHERE (changeday+10)<'".$time_now ."' AND locked='0'";
		$haku = $db->UseSQL($sql);
		
		$sql = "DELETE FROM tmp_reservation WHERE (changeday+60)<'".$time_now ."' AND locked<>'0' AND locked<>'LOCKED'";
		$haku = $db->UseSQL($sql);
	}	

	/**
	 * Car number
	 */
	public function CarNro(){
		return substr("000000$this->car_id", -5);
	}
	
	/**
	 * Pic number
	 */
	public function PicNro(){
		return substr("000$this->pic_id", -3);
	}
	
	public function gNro($inNro,$iLenght){
		return substr("00000000000000$inNro", -$iLenght);
	}
	
	/**
	 * Replace font
	 */
	public function ReplaceFont($string){
	//� = &#8364;
	//� = &#228;
	//� = &#246;
		return str_replace( array('�', '�','�','�','�','�', '�', '�','�','�','�', '�','�','�','�', '�', '�','�','�','�','�', '�','�','�','�', '�','�', '�','�','�','�','�', '�', '�','�','�','�', '�','�','�','�', '�', '�','�','�','�','�', '�','�','�','�', '�'), array('&#8364;', 'a','a','a','a','&#228;', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','&#246;', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string); 
	}
}
?>

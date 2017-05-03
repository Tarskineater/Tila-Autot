<?php
class Reserve{
	var $reserve_id;
	var $user_id;
	var $user_session_id;
	var $car_id;
	var $accessory_id;
	var $location; 
	var $start_time;
	var $end_time;
	var $information;
	var $cadmin;
	var $changeday;
	var $location_name;
	var $cadmin_name;
 
	var $iperson_name;
	var $txtadd;
	
	var $carID;
	var $classNow;
	var $classNew;
	var $DayOld;
	var $costCar;
	var $costTotal;

	var $order_number;
	var $order_description;
	var $contact_telno;
	var $contact_cellno;
	var $contact_email;
	var $contact_firstname;
	var $contact_lastname;
	var $contact_company; 
	var $contact_addr_street;
	var $contact_addr_zip;
	var $contact_addr_city; 
	var $contact_addr_country; 
	var $user_ip;
	var $authcodetxt;
	var $authcode;	
	var $items;
	var $authitems;
	var $itemsbox;
	
	var $ORDER_NUMBER;
	var $PAID;
	var $METHOD;
	var $TIMESTAMP;
	var $RETURN_AUTHCODE;
	
	var $i;
	var $ii;
	var $params;

	/**
	 * Start Reserve
	 */
	public function Reserve(){
		$this->carID="";
		$this->classNow="stylish-cEmptySlot";
		$this->classNew="stylish-cPartly";
	}

	/**
	 * Luodaan oikea vuokraus
	 **/
	public function GreateRent(){

		if (!isset($car))
			$car = new Car();
			
		if (!isset($locations))
			$locations = new Location();
			
		$this->reserve_id = "";
		$this->reserve_state = "";
		$this->user_id = "";
		$this->user_session_id = "";
		$this->information = "";
		$this->cadmin = "";
		$this->changeday = "";
		$this->location_name = "";
		$this->cadmin_name = "";
		$this->AddNewReserve();
		$this->start_time = $_GET["start_time"];
		$this->end_time = $_GET["end_time"];
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->start_time = time();
		$this->end_time = time() + 30;	
		$this->changeday = time();
		$this->user_id = $this->cadmin;
		$this->user_ip = $this->getip();
		$this->ORDER_NUMBER = "";
		$this->PAID = "";
		$this->METHOD = "";
		$this->TIMESTAMP = "";
		$this->RETURN_AUTHCODE = "";
	
	}

	/**
	 * Aloita uusi varaus
	 */
	public function AddNewReserve(){
		if (!isset($db))
			$db = new Database();
 			
 		$db->Database();
		
		$sql = "INSERT INTO reservation (user_session_id, car_id, accessory_id, location, start_time, end_time, changeday))";	
		$tulos = $db->UseSQL($sql);
	}
	
	/**
	 * Getting right day
	 */
	public function DayType($day,$month,$year,$car_id,$user_session_id, $user_id){
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		
		$this->car_id = $car_id;
		$this->classNow = "stylish-cEmptySlot";
		$this->classNew = "stylish-cPartly";
		
		$event_date = $year."-". substr("00" . $month, -2) ."-". substr("00" . $day, -2);
		
		$nowis = date("Y") . substr("00" . date("m"), -2) . substr("00" . date("d"), -2);
		$isnow = $year. substr("00" . $month, -2) . substr("00" . $day, -2);
		$this->DayOld = "0";
		
		$sql = "SELECT * FROM tmp_reservation WHERE car_id = '$car_id' AND start_time='$event_date'";
		
		$haku = $db->AskSQL($sql);
			
		if(intval($nowis)>intval($isnow)){
			//echo "$nowis>$isnow<br>";
			$this->classNow = "stylish-cClose";
			$this->classNew = "stylish-cClose";
			$this->DayOld = "1";
		}
			
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			$rivi = mysql_fetch_row ($haku);
			
			$this->classNow = "stylish-cPartly";
			$this->classNew = "stylish-cEmptySlot";
			
			if ($rivi[0]<>$user_session_id){
				$this->classNow = "stylish-cFull";
				$this->classNew = "stylish-cFull";
			}
			
			if ($rivi[8]==$user_id){
				$this->classNow = "stylish-cSell";
				$this->classNew = "stylish-cSell";
			}
			//echo "$nowis $isnow<br>";
		}			
	}
	 
	/**
	 * N�yt� asiakkaan ostoskori
	 */
	public function ShowBasket(){
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "Vuokrauskori";
		echo "</td></tr></table></td></tr></table>";
		$this->DoBasket("1");
	}
	
	/**
	 * Onko asiakkaalla ostoskorissa kamaa
	 */
	public function IsBasket(){
		if (!isset($db))
		$db = new Database();
 			
 		$db->Database();
		
		$user_session = $_SESSION["kayttajatunniste"];
			
		$sql = "SELECT DISTINCT car_id FROM tmp_reservation WHERE user_session_id = '$user_session' AND locked <> 'LOCKED' order by car_id";
		
		$IsBasketOk = $db->AskSQL($sql);
		
		return mysql_num_rows($IsBasketOk);	
	}
		
	/**
	 * Tee ostoskori
	 */
	public function DoBasket($inType){
		if (!isset($db))
			$db = new Database();
 			
 		$db->Database();
		
		if (!isset($car))
			$car = new Car();
			
		if (!isset($locations))
			$locations = new Location();
			
		$this->order_number = $this->gNro($_SESSION['LogInUser']->id ,7) . '-' . date('Ymdhis');
		
		$user_session_id = $_SESSION["kayttajatunniste"];
		$kayttajan_id = $_SESSION['LogInUser']->id;
		
		if ($inType == "3"){
			$sql = "SELECT DISTINCT car_id FROM tmp_reservation WHERE (user_id = '$kayttajan_id') OR (user_session_id = '$user_session_id') order by car_id";
		} else {
			$sql = "SELECT DISTINCT car_id FROM tmp_reservation WHERE user_session_id = '$user_session_id' AND locked <> 'LOCKED' order by car_id";
		}
				
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$this->carID="";
		
		$this->costCar = "";
		$this->costTotal = "";
		
		$this->items = -1;
		if (!isset($_SESSION['LogInUser']->id))
			$this->$user_id = $_SESSION['LogInUser']->id;
		
		if ($rows > 0){			
			for ($laskuri = 0; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr>";
				echo "<td class=\"stylish-button\">Auto</td><td class=\"stylish-button\">Vuokrauspaikka</td><td class=\"stylish-button\">P&#228;iv&#228;m&#228;&#228;r&#228;</td><td class=\"stylish-button\">Hinta/p&#228;iv&#228;</td></tr>";
				$this->carID = $rivi[0];
				$car->ReadCar($this->carID);
				$locations->ReadLocation($car->car_location_id);
				
				if ($inType == "3"){
					$sql2 = "SELECT * FROM tmp_reservation WHERE (user_id = '$kayttajan_id') OR (user_session_id = '$user_session_id') order by start_time";
				} else {
					$sql2 = "SELECT * FROM tmp_reservation WHERE (user_session_id = '$user_session_id' and car_id = '$this->carID') order by start_time";
				}
				
				$haku2 = $db->AskSQL($sql2);
				$rows2 = mysql_num_rows($haku2);
				$rivi2 = mysql_fetch_row ($haku2);
				//$tmp_day = $rivi2[4];
				$this->costCar = $car->car_rental * $rows2;
				$this->costTotal = $this->costTotal + ($car->car_rental*$rows2);
				//echo "$rivi2[0] $this->costCar";
				$tmp_carid = $car->CarNro();
				
				if ($inType == "2"){
					$sql2 = "UPDATE tmp_reservation SET locked = '" . $this->order_number . "', user_id = '" . $_SESSION['LogInUser']->id . "'  WHERE user_session_id = '$user_session_id' and car_id = '$this->carID'";
					$db->UseSQL($sql2);		
				}
				
				echo "<tr><td class=\"stylish-cRows\"><a href=\"index.php?page=car&id=$this->carID&car_id=$this->carID&show=1\"><img src=\"images/cars/Car_" . $car->car_plate . "_001.jpg\" alt=\"$car->car_name\" title=\"$car->car_name\" width=\"100\"/></a>";
				echo "<br>$car->car_name $car->car_plate</td>";
				echo "<td class=\"stylish-cRows\" width=\"100\">$locations->name<br>$locations->country</td>";
				echo "<td class=\"stylish-cRows\" width=\"100\">$rivi2[4]<br>";
				
				for ($laskuri2 = 0; $rivi2 = mysql_fetch_row ($haku2); ++$laskuri2){
					echo "$rivi2[4]<br>";
				}
				
				echo "</td>";
				echo "<td class=\"stylish-button\" width=\"100%\">";
				echo "<table width=\"100%\"><tr><td class=\"stylish-cRows\">P&#228;iv&#228;hinta: $car->car_rental&#8364;</td></tr></table>";
				echo "<table width=\"100%\"><tr><td class=\"stylish-cRows\">Vuokrap&#228;ivi&#228;: " . $rows2 . "</td></tr></table>";
				echo "<table width=\"100%\"><tr><td class=\"stylish-cRows\">Kokonaisvuokra:$this->costCar&#8364;</td></tr></table>";
				echo "</td></tr></table></td></tr></table>";
				
				$this->items = $this->items + 1;
				//echo "test $this->items $car->car_plate $car->car_name<br>";
				$this->params["ITEM_TITLE[$this->items]"] = $car->car_plate . " ". $car->car_name;
				$this->params["ITEM_NO[$this->items]"] = $this->carID;
				$this->params["ITEM_AMOUNT[$this->items]"] = $rows2;
				$this->params["ITEM_PRICE[$this->items]"] = $car->car_rental;
				$this->params["ITEM_TAX[$this->items]"] = "23.00";
				$this->params["ITEM_DISCOUNT[$this->items]"] = 0;
				$this->params["ITEM_TYPE[$this->items]"] = 1;
				$this->params["ITEMS"] = $this->items;
				
			}
	
			echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr>";
			echo "<td width=\"70%\"></td><td class=\"stylish-button\">Total:$this->costTotal&#8364;</td>";
			
			echo "$inType";
			if ($this->IsBasket() > 0 && $inType != "3"){
				echo "<td><a href=\"index.php?page=kassa\" class=\"stylish-button\">Kassalle</a></td>";
			}
			
			echo "</tr>";
			echo "</tr></table></td></tr></table>";
		}else{
			echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
			echo "<table width=\"100%\"><tr><td><center>Vuokrauskorisi on tyhj&#228;!</center></td>";
			echo "</tr></table></td></tr></table>";
		}
	}
	/**
	 * N�yt� kassa
	 */
	public function ShowCash(){		
		if (!isset($user))
			$user = new User();
			
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		
		// echo "test " . htmlentities("äää ööö ÄÄÅÅ", ENT_COMPAT, "UTF-8") . "<br>\n";
		 
		$this->user_ip = $this->getip();
		$user->ShowCashUser($_SESSION['LogInUser']->id);
		$this->order_description = "Heurex Oy Auton vuokrausta";			
		$this->contact_telno = $user->phone1;
		$this->contact_cellno = $user->phone2;
		$this->contact_email = $user->email;
		$this->contact_firstname = $user->firstname;
		$this->contact_lastname = $user->lastname;
		$this->contact_company = $user->company;
		$this->contact_addr_street = $user->address;
		//echo htmlentities($this->contact_addr_street, ENT_COMPAT, "UTF-8") . " = " . $user->address;
		$this->contact_addr_zip = $user->zip;
		$this->contact_addr_city = $user->postoffice;
		$this->contact_addr_country = $user->country;
		$this->params = array();

		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "Vuokrauskori";
		echo "</td></tr></table></td></tr></table>\n";
		
		$this->DoBasket("2");
		
		echo "<table width=\"100%\"><tr><td>\n";	

		$this->GetAUTHCODE_E1();
		$i = $this->items + 1;
		//echo "test " . htmlentities("WVA-655 Aisapoika 3.3K Kevyt peräkärry äää ööö ÄÄÅÅ", ENT_COMPAT, "UTF-8") . "<br>\n";
		echo "<form action=\"https://payment.verkkomaksut.fi/\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"MERCHANT_ID\" value=\"". MERCHANT_ID ."\">\n";
		echo "<input type=\"hidden\" name=\"ORDER_NUMBER\" value=\"". $this->order_number ."\">\n";
		echo "<input type=\"hidden\" name=\"REFERENCE_NUMBER\" value=\"\">\n";
		echo "<input type=\"hidden\" name=\"ORDER_DESCRIPTION\" value=\"$this->order_description\">\n";
		echo "<input type=\"hidden\" name=\"CURRENCY\" value=\"EUR\">\n";
		echo "<input type=\"hidden\" name=\"RETURN_ADDRESS\" value=\"" . RETURN_ADDRESS . "\">\n";
		echo "<input type=\"hidden\" name=\"CANCEL_ADDRESS\" value=\"" . CANCEL_ADDRESS . "\">\n";
		echo "<input type=\"hidden\" name=\"PENDING_ADDRESS\" value=\"" . PENDING_ADDRESS . "\">\n";
		echo "<input type=\"hidden\" name=\"NOTIFY_ADDRESS\" value=\"" . NOTIFY_ADDRESS . "\">\n";
		echo "<input type=\"hidden\" name=\"TYPE\" value=\"E1\">\n";
		echo "<input type=\"hidden\" name=\"CULTURE\" value=\"fi_FI\">\n";
		echo "<input type=\"hidden\" name=\"PRESELECTED_METHOD\" value=\"\">\n";
		echo "<input type=\"hidden\" name=\"MODE\" value=\"1\">\n";
		echo "<input type=\"hidden\" name=\"VISIBLE_METHODS\" value=\"\">\n";
		echo "<input type=\"hidden\" name=\"GROUP\" value=\"\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_TELNO\" value=\"$this->contact_telno\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_CELLNO\" value=\"$this->contact_cellno\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_EMAIL\" value=\"$this->contact_email\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_FIRSTNAME\" value=\"" . htmlentities($this->contact_firstname) . "\">\n"; //, ENT_COMPAT, "UTF-8"
		echo "<input type=\"hidden\" name=\"CONTACT_LASTNAME\" value=\"" . htmlentities($this->contact_lastname) . "\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_COMPANY\" value=\"" . htmlentities($this->contact_company) . "\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_ADDR_STREET\" value=\"" . htmlentities($this->contact_addr_street) . "\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_ADDR_ZIP\" value=\"$this->contact_addr_zip\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_ADDR_CITY\" value=\"" . htmlentities($this->contact_addr_city) . "\">\n";
		echo "<input type=\"hidden\" name=\"CONTACT_ADDR_COUNTRY\" value=\"$this->contact_addr_country\">\n";
		echo "<input type=\"hidden\" name=\"INCLUDE_VAT\" value=\"1\" />\n";
		echo "<input type=\"hidden\" name=\"ITEMS\" value=\"". $i ."\" />\n";
		
    	for ($ii = 0; $ii < $i; $ii++)
    	{
    		//$str = mb_convert_encoding($this->params["ITEM_TITLE[$ii]"], "UTF-8", "auto");
			$str = $this->params["ITEM_TITLE[$ii]"];
			
			//echo "test change'" . $this->params["ITEM_TITLE[$ii]"] . "' = htmlentities '" . htmlentities($this->params["ITEM_TITLE[$ii]"]) . "'<br>\n";
			
			echo "<input type=\"hidden\" name=\"ITEM_TITLE[$ii]\" value=\"" . htmlentities($this->params["ITEM_TITLE[$ii]"]) . "\">\n";
			echo "<input type=\"hidden\" name=\"ITEM_NO[$ii]\" value=\"".$this->params["ITEM_NO[$ii]"]."\">\n";
			echo "<input type=\"hidden\" name=\"ITEM_AMOUNT[$ii]\" value=\"".$this->params["ITEM_AMOUNT[$ii]"]."\">\n";
			echo "<input type=\"hidden\" name=\"ITEM_PRICE[$ii]\" value=\"".$this->params["ITEM_PRICE[$ii]"]."\">\n";
			echo "<input type=\"hidden\" name=\"ITEM_TAX[$ii]\" value=\"".$this->params["ITEM_TAX[$ii]"]."\">\n";
			echo "<input type=\"hidden\" name=\"ITEM_DISCOUNT[$ii]\" value=\"".$this->params["ITEM_DISCOUNT[$ii]"]."\">\n";
			echo "<input type=\"hidden\" name=\"ITEM_TYPE[$ii]\" value=\"".$this->params["ITEM_TYPE[$ii]"]."\">\n";
			
			$sql = "DELETE FROM rental WHERE user_id='" . $_SESSION['LogInUser']->id . "' AND order_number<>'" . $this->order_number. "' AND item_no='" .$this->params["ITEM_NO[$ii]"] ."' ";
			$tulos = $db->UseSQL($sql);		
				
			$sql = "INSERT INTO rental (user_id, order_number, reserve_state, item_type, item_title, item_no, item_amount, item_price, item_tax, item_discount, ip) " .
				"VALUES (" .
				"'" . $_SESSION['LogInUser']->id . "', " . 				
				"'" . $this->order_number . "', " . 
				"'0', " .
				"'0', " .
				"'" . $this->params["ITEM_TITLE[$ii]"] . "', " .  
				"'" . $this->params["ITEM_NO[$ii]"] . "', " .  
				"'" . $this->params["ITEM_AMOUNT[$ii]"] . "', " . 
				"'" . $this->params["ITEM_PRICE[$ii]"] . "', " . 
				"'" . $this->params["ITEM_TAX[$ii]"] . "', " . 
				"'" . $this->params["ITEM_DISCOUNT[$ii]"] . "', " .
				"'" . $this->user_ip . "');";
			$tulos = $db->UseSQL($sql);
		}
	
		echo "<input type=\"hidden\" name=\"AUTHCODE\" value=\"$this->authcode\">\n";
		echo "<input type=\"submit\" value=\"Siirry maksamaan\">\n";
		echo "</form>\n";
		echo "</td></tr></table><br>\n";
	
	}
	
	/**
	 * Lasketaan AUTHCODE E1
	 */
	public function GetAUTHCODE_E1(){
	
		/*$this->order_description = $this->ReplaceFont($this->order_description);
		$this->contact_firstname = $this->ReplaceFont($this->contact_firstname);
		$this->contact_lastname = $this->ReplaceFont($this->contact_lastname);
		$this->contact_company = $this->ReplaceFont($this->contact_company);
		$this->contact_addr_street = $this->ReplaceFont($this->contact_addr_street);
		$this->contact_addr_city = $this->ReplaceFont($this->contact_addr_city);
		*/
		$this->order_description = $this->order_description;
		$this->contact_firstname = $this->contact_firstname;
		$this->contact_lastname = $this->contact_lastname;
		$this->contact_company = $this->contact_company;
		$this->contact_addr_street = $this->contact_addr_street;
		$this->contact_addr_city = $this->contact_addr_city;
		
		$i = $this->items + 1;
		
		$this->authcodetxt = TESTIOY . "|" . 						//MERCHANT_ID
							MERCHANT_ID . "|" . 					//MERCHANT_ID
							$this->order_number . "|" . 			//order_number
							"|" . 									//REFERENCE_NUMBER
							$this->order_description . "|" . 		//order_description 
							"EUR|" . 								//Currency
							RETURN_ADDRESS . "|" . 
							CANCEL_ADDRESS . "|" . 
							PENDING_ADDRESS . "|" . 
							NOTIFY_ADDRESS . "|" . 
							"E1|" . 
							"fi_FI|" . 
						    "|" . 
							"1|" .
							"|" . 
							"|" . 
							$this->contact_telno . "|" . 
							$this->contact_cellno . "|" .
							$this->contact_email . "|" . 
							$this->contact_firstname . "|" . 
							$this->contact_lastname . "|" . 
							$this->contact_company . "|" . 
							$this->contact_addr_street . "|" . 
							$this->contact_addr_zip . "|" . 
							$this->contact_addr_city . "|" . 
							$this->contact_addr_country . "|" . 
							"1|" . 
							$i;
							for ($ii = 0; $ii < $i; $ii++)
								{
									$this->authcodetxt = $this->authcodetxt . "|" .
									$this->params["ITEM_TITLE[$ii]"] . "|" . 
									$this->params["ITEM_NO[$ii]"] . "|" . 
									$this->params["ITEM_AMOUNT[$ii]"] . "|" . 
									$this->params["ITEM_PRICE[$ii]"] . "|" . 
									$this->params["ITEM_TAX[$ii]"] . "|" . 
									$this->params["ITEM_DISCOUNT[$ii]"] . "|" . 
									$this->params["ITEM_TYPE[$ii]"]; 
								}
								
		$this->authcode = strtoupper(md5($this->authcodetxt));
	}
	
	/**
	 * Lasketaan AUTHCODE S1
	 */
	public function GetAUTHCODE_S1(){
		$this->authcodetxt = TESTIOY . "|" . 						//MERCHANT
							MERCHANT_ID . "|" . 					//MERCHANT_ID
							$this->costTotal . "|" .				//Cost total
							$this->order_number . "|" . 			//order_number
							REFERENCE_NUMBER . "|" . 				//REFERENCE_NUMBER
							$this->order_description . "|" . 		//order_description 
							CURRENCY . "|" . 						//Currency
							RETURN_ADDRESS . "|" . 
							CANCEL_ADDRESS . "|" . 
							PENDING_ADDRESS . "|" . 
							NOTIFY_ADDRESS . "|" . 
							"S1|" . 
							CULTURE . "|" . 
							PRESELECTED_METHOD . "|" . 
							MODE . "|" .
							VISIBLE_METHODS . "|" . 
							GROUP; 
		$this->authcode = strtoupper(md5($this->authcodetxt));
	}
	
	/**
	 * Tarkistetaan tullut maksu juttu
	 */
	public function SellCheck(){
		if(isset($_GET["sell"]) && $_GET["sell"] !== ""){
			$this->sell = $_GET["sell"];	
		}
		
		if(isset($_GET["ORDER_NUMBER"]) && $_GET["ORDER_NUMBER"] !== ""){
			$this->ORDER_NUMBER = $_GET["ORDER_NUMBER"];	
		}
		
		if(isset($_GET["PAID"]) && $_GET["PAID"] !== ""){
			$this->PAID = $_GET["PAID"];	
		}
			
		if(isset($_GET["METHOD"]) && $_GET["METHOD"] !== ""){
			$this->METHOD = $_GET["METHOD"];	
		}
		
		if(isset($_GET["TIMESTAMP"]) && $_GET["TIMESTAMP"] !== ""){
			$this->TIMESTAMP = $_GET["TIMESTAMP"];	
		}
		
		if(isset($_GET["RETURN_AUTHCODE"]) && $_GET["RETURN_AUTHCODE"] !== ""){
			$this->RETURN_AUTHCODE = $_GET["RETURN_AUTHCODE"];	
		}
		
		if (($this->sell == "success")||($this->sell == "pending")||($this->sell == "notify")){
			$this->authcodetxt = $this->ORDER_NUMBER . "|" . 	//$this->ORDER_NUMBER
							$this->TIMESTAMP . "|" . 			//$this->TIMESTAMP
							$this->PAID . "|" .					//$this->PAID
							$this->METHOD. "|" . 				//$this->METHOD
							TESTIOY; 
		}	

		if ($this->sell == "cancel"){
			$this->authcodetxt = $this->ORDER_NUMBER . "|" . 	//$this->ORDER_NUMBER
							$this->TIMESTAMP . "|" . 			//$this->TIMESTAMP
							TESTIOY; 
		}		
		/*
		echo "<br>SELL: $this->sell<br>";
		echo "ORDER_NUMBER: $this->ORDER_NUMBER<br>";
		echo "PAID: $this->PAID<br>";
		echo "METHOD: $this->METHOD<br>";
		echo "TIMESTAMP: $this->TIMESTAMP<br>";
		echo "RETURN_AUTHCODE: $this->RETURN_AUTHCODE<br>";
		echo "CHECKED: " . strtoupper(md5($this->authcodetxt)) . "<br>";
		*/
		if (strtoupper(md5($this->authcodetxt)) != $this->RETURN_AUTHCODE) {
			echo "Ei mene tarkistuksesta läpi.";
		}else{			
			if ($this->sell == "cancel"){
				$this->DeleteOrder($this->ORDER_NUMBER);
			}
			
			if ($this->sell == "success"){
				$this->RentCarFromOrder();
			}
		}
	}
	
	/*
	 * Tehd��n vuokraus tilaus kannasta
     */ 
	public function RentCarFromOrder(){
		if (!isset($user))
			$user = new User();
			
		if (!isset($car))
			$car = new Car();
	
		if (!isset($db)){
			$db = new Database();
			$db->Database();
		}
		if (isset($_SESSION['LogInUser']->id))	
			$this->cadmin = $_SESSION['LogInUser']->id;
		
		//echo "1<br>";
		$sql = "SELECT * FROM tmp_reservation WHERE locked = '" . $this->ORDER_NUMBER . "'";
	
		//echo "$sql<br>";
		$tmp_reservation = $db->AskSQL($sql);
		$this->order_number = $this->ORDER_NUMBER;
		$this->user_id = intval($this->Left($this->ORDER_NUMBER,6));
		$user->ReadUser($_SESSION['LogInUser']->id);
		
		//echo "2 " . mysql_num_rows($tmp_reservation) . "<br>";
		if (mysql_num_rows($tmp_reservation) > 0){	
			$tmp_reservation_rivi = mysql_fetch_row ($tmp_reservation);
			$this->user_id = $tmp_reservation_rivi[8];
			$this->user_ip = $tmp_reservation_rivi[9];
			$this->user_session_id = $tmp_reservation_rivi[0]; 
			$this->changeday = date("YmdHis",time());
			
			$sql = "INSERT INTO reservation (order_number, " .
				"reserve_state, user_id, user_session_id, " .
				"information, cadmin, changeday, " .
				"location_name, cadmin_name, ip) " .
				"VALUES (" .				
				"'$this->order_number', " . 
				"'1', " .
				"$this->user_id, " .
				"'$this->user_session_id', " .  
				"'Vuokraus', " .  
				"$this->cadmin, " . 
				"$this->changeday, " . 
				"'$this->location_name', " . 
				"'$this->cadmin_name', " .
				"'$this->user_ip');";
				
			//echo "$sql<br>";
			
			$tulos = $db->UseSQL($sql);
			//echo "3<br>";
			$sql = "SELECT * FROM reservation WHERE order_number = '" . $this->ORDER_NUMBER . "'";
			//echo "$sql<br>";
			$reservation = $db->AskSQL($sql);
			
			$rows = mysql_num_rows($reservation);
			
			$reservation_rivi = mysql_fetch_row ($reservation);
			
			$this->reserve_id = $reservation_rivi[0];
			//echo "4 $this->reserve_id<br>";
			$sql = "SELECT * FROM tmp_reservation WHERE locked = '" . $this->ORDER_NUMBER . "' ORDER BY car_id, start_time";
			//echo "$sql<br>";
			//echo "5<br>";
        	$tmpRow = "<table width='100%' border=1><tr><td>";
			$tmpRow .= "Varausnumerosi: $this->reserve_id<br>";
			$tmpRow .= "Tilausnumero: $this->order_number<br>";
			$tmpRow .= "</td></tr><tr><td>";
			$tmpRow .= "Nimi: $user->firstname $user->lastname<br>";
			$tmpRow .= "Osoite: $user->address<br>";
			$tmpRow .= "Postinumero: $user->zip<br>";
			$tmpRow .= "Postiosoite: $user->postoffice<br>";
			$tmpRow .= "Maa: $user->country<br>";
			$tmpRow .= "</td></tr><tr><td><table width='100%' border=1><tr>";
			$tmpRow .= "<td>CarID</td><td>Plate</td><td>Alkup&#228;iv&#228;</td><td>Loppup&#228;iv&#228;</td><td>Paikkakunta</td></tr>";
			$tmp_reservation = $db->AskSQL($sql);
			if (mysql_num_rows($tmp_reservation) > 0){
				for ($laskuri = 0; $rivi = mysql_fetch_row ($tmp_reservation); ++$laskuri){			
					$this->car_id = $rivi[1];
					$this->accessory_id = $rivi[2];
					$this->location = $rivi[3];
					$this->start_time = $rivi[4];
					$this->end_time = $rivi[5];
					$this->location_name = "TAMPERE";
					
					$car->ReadCar($this->car_id);
					
					$tmpRow .= "<tr><td>" . $this->gNro($this->car_id,5) . "</td><td>" . $car->car_plate . "</td><td>" . $this->start_time . "</td><td>" . $this->end_time . "</td><td>" . $this->location_name . "</td></tr>";
					
					$sql = "INSERT INTO reservations (reserve_id, " .
							"car_id, " .
							"accessory_id, " .
							"location, " .
							"start_time, " .
							"end_time, " .
							"information, " .
							"cadmin, changeday, location_name, cadmin_name,ip) " .
							"VALUES (" .	
							"$this->reserve_id, " .		
							"$this->car_id, " .
							"$this->accessory_id, " .
							"$this->location, " .
							"'$this->start_time', " .
							"'$this->end_time', " .
							"'Vuokraus', " .  
							"$this->cadmin, " . 
							"$this->changeday, " . 
							"'$this->location_name', " . 
							"'$this->cadmin_name', " .
							"'$this->user_ip');";
					$tulos = $db->UseSQL($sql);

				}
				$tmpRow .= "</table>";
			}
			
			$tmpRow .= "</td></tr></table>";
			
			//echo "$sql<br>";
			//echo "6<br>";
			$sql = "UPDATE tmp_reservation SET locked = 'LOCKED' WHERE locked = '" . $this->ORDER_NUMBER . "'";
			//echo "$sql<br>";
			$tmp_reservation = $db->UseSQL($sql);
		
			$to = $user->email; 
			$from = "myynti@tila-autot.heurex.fi"; 
			$subject = "Vuokrauksesi!";
			
			$message = "<html><body bgcolor=\"#DCEEFC\"><center>"; 
			$message = $message . "<b>Tilauksesi</b> <br>"; 
			$message = $message . "<font color=\"red\">Kiitoksia tilauksestasi $user->firstname $user->lastname!</font> <br>"; 
			$message = $message . "<a href=\"http://tila-autot.com\">www.tila-autot.com</a>"; 
			$message = $message . "</center>"; 
			$message = $message . "<br><br><font face=\"courier new\" size=\"3\">$tmpRow</font><br><br>Terveisin Tila-Autot.com";  
			$message = $message . "</body>"; 
			$message = $message . "</html>";
			
			echo $message;
			
			$headers  = "From: $from\r\n"; 
			$headers .= "Content-type: text/html\r\n"; 

			//options to send to cc+bcc 
			//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
			//$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
     
			mail($to, $subject, $message, $headers); 

			echo "<br>Olet saanut emailin kyseisest&#228; tilauksestasi.<br>Tulosta se tullessasi hakemaan autoa."; 
	
		}			
	}
	
	/*
	 * poistetaan tilaus kannasta
     */
	public function DeleteOrder($tmpNumber){
		if (!isset($db))
			$db = new Database();
			
		$db->Database();
		$sql = "DELETE FROM rental WHERE order_number = '" . $tmpNumber . "'";
		$tulos = $db->UseSQL($sql);	
				
	}
	
	/*
	 * Right function
	 */
	public function right($value, $count){
		return substr($value, ($count*-1));
	}
	
	/*
	 * Left function
	 */
	public function left($string, $count){
		return substr($string, 0, $count);
	}

	/*
	 * Palautetaan asiakkaan numero
	 */
	public function gNro($inNro,$iLenght){
		return substr("00000000000000$inNro", -$iLenght);
	}
	
	/**
	 * Replace font
	 */
	public function ReplaceFont($string){
		return str_replace(array('�','�','�','�'), array('a&#776;','o&#776;','A&#776;','O&#776;'), $string); 
	}
	
	/**
	 * IP-Address
	 */
	function getip() {
		return $_SERVER["REMOTE_ADDR"];
	}
	
	/**
	 * N�kym�tt�miss� l�hetett�v� tieto
	 */
	public function HiddenDragon(){
		echo "<form action=\"https://payment.verkkomaksut.fi/\" method=\"post\">";
		echo "<input name=\"MERCHANT_ID\" type=\"hidden\" value=\"13466\">";
		echo "<input name=\"ORDER_NUMBER\" type=\"hidden\" value=\"123456\">";
		echo "<input name=\"REFERENCE_NUMBER\" type=\"hidden\" value=\"\">";
		echo "<input name=\"ORDER_DESCRIPTION\" type=\"hidden\" value=\"Testitilaus\">";
		echo "<input name=\"CURRENCY\" type=\"hidden\" value=\"EUR\">";
		echo "<input name=\"RETURN_ADDRESS\" type=\"hidden\" value=\"http://www.esimerkki.fi/success\">";
		echo "<input name=\"CANCEL_ADDRESS\" type=\"hidden\" value=\"http://www.esimerkki.fi/cancel\">";
		echo "<input name=\"PENDING_ADDRESS\" type=\"hidden\" value=\"\">";
		echo "<input name=\"NOTIFY_ADDRESS\" type=\"hidden\" value=\"http://www.esimerkki.fi/notify\">";
		echo "<input name=\"TYPE\" type=\"hidden\" value=\"E1\">";
		echo "<input name=\"CULTURE\" type=\"hidden\" value=\"fi_FI\">";
		echo "<input name=\"PRESELECTED_METHOD\" type=\"hidden\" value=\"\">";
		echo "<input name=\"MODE\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"VISIBLE_METHODS\" type=\"hidden\" value=\"\">";
		echo "<input name=\"GROUP\" type=\"hidden\" value=\"\">";
		echo "<input name=\"CONTACT_TELNO\" type=\"hidden\" value=\"0412345678\">";
		echo "<input name=\"CONTACT_CELLNO\" type=\"hidden\" value=\"0412345678\">";
		echo "<input name=\"CONTACT_EMAIL\" type=\"hidden\" value=\"esimerkki@esimerkki.fi\">";
		echo "<input name=\"CONTACT_FIRSTNAME\" type=\"hidden\" value=\"Matti\">";
		echo "<input name=\"CONTACT_LASTNAME\" type=\"hidden\" value=\"Meika�la�inen\">";
		echo "<input name=\"CONTACT_COMPANY\" type=\"hidden\" value=\"\">";
		echo "<input name=\"CONTACT_ADDR_STREET\" type=\"hidden\" value=\"Testikatu 1\">";
		echo "<input name=\"CONTACT_ADDR_ZIP\" type=\"hidden\" value=\"40500\">";
		echo "<input name=\"CONTACT_ADDR_CITY\" type=\"hidden\" value=\"Jyva�skyla�\">";
		echo "<input name=\"CONTACT_ADDR_COUNTRY\" type=\"hidden\" value=\"FI\">";
		echo "<input name=\"INCLUDE_VAT\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"ITEMS\" type=\"hidden\" value=\"2\">";
		echo "<input name=\"ITEM_TITLE[0]\" type=\"hidden\" value=\"Tuote #101\">";
		echo "<input name=\"ITEM_NO[0]\" type=\"hidden\" value=\"101\">";
		echo "<input name=\"ITEM_AMOUNT[0]\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"ITEM_PRICE[0]\" type=\"hidden\" value=\"10.00\">";
		echo "<input name=\"ITEM_TAX[0]\" type=\"hidden\" value=\"22.00\">";
		echo "<input name=\"ITEM_DISCOUNT[0]\" type=\"hidden\" value=\"0\">";
		echo "<input name=\"ITEM_TYPE[0]\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"ITEM_TITLE[1]\" type=\"hidden\" value=\"Tuote #202\">";
		echo "<input name=\"ITEM_NO[1]\" type=\"hidden\" value=\"202\">";
		echo "<input name=\"ITEM_AMOUNT[1]\" type=\"hidden\" value=\"2\">";
		echo "<input name=\"ITEM_PRICE[1]\" type=\"hidden\" value=\"8.50\">";
		echo "<input name=\"ITEM_TAX[1]\" type=\"hidden\" value=\"22.00\">";
		echo "<input name=\"ITEM_DISCOUNT[1]\" type=\"hidden\" value=\"0\">";
		echo "<input name=\"ITEM_TYPE[1]\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"AUTHCODE\" type=\"hidden\" value=\"399A88703393FCDD7BCD6C5512EC6F30\">";
		echo "<input type=\"submit\" value=\"Siirry maksamaan\">";
		echo "</form>";
		
		echo "<form action=\"https://payment.verkkomaksut.fi/\" method=\"post\">";
		echo "MERCHANT_ID: <input name=\"MERCHANT_ID\" value=\"". MERCHANT_ID ."\"><br>";
		echo "ORDER_NUMBER: <input name=\"ORDER_NUMBER\" value=\"". $this->order_number ."\"><br>";
		echo "REFERENCE_NUMBER: <input name=\"REFERENCE_NUMBER\" value=\"". REFERENCE_NUMBER ."\"><br>";
		echo "ORDER_DESCRIPTION: <input name=\"ORDER_DESCRIPTION\" value=\"". $this->order_description ."\"><br>";
		echo "CURRENCY: <input name=\"CURRENCY\" value=\"". CURRENCY ."\"><br>";
		echo "RETURN_ADDRESS: <input name=\"RETURN_ADDRESS\" value=\"". RETURN_ADDRESS ."\"><br>";
		echo "CANCEL_ADDRESS: <input name=\"CANCEL_ADDRESS\" value=\"". CANCEL_ADDRESS ."\"><br>";
		echo "PENDING_ADDRESS: <input name=\"PENDING_ADDRESS\" value=\"". PENDING_ADDRESS ."\"><br>";
		echo "NOTIFY_ADDRESS: <input name=\"NOTIFY_ADDRESS\" value=\"". NOTIFY_ADDRESS ."\"><br>";
		echo "TYPE: <input name=\"TYPE\" value=\"". TYPE ."\"><br>";
		echo "CULTURE: <input name=\"CULTURE\" value=\"". CULTURE ."\"><br>";
		echo "PRESELECTED_METHOD: <input name=\"PRESELECTED_METHOD\" value=\"". PRESELECTED_METHOD ."\"><br>";
		echo "MODE :<input name=\"MODE\" value=\"". MODE ."\"><br>";
		echo "VISIBLE_METHODS: <input name=\"VISIBLE_METHODS\" value=\"". VISIBLE_METHODS ."\"><br>";
		echo "GROUP: <input name=\"GROUP\" value=\"". GROUP ."\"><br>";
		echo "CONTACT_TELNO: <input name=\"CONTACT_TELNO\" value=\"". $this->contact_telno ."\"><br>";
		echo "CONTACT_CELLNO: <input name=\"CONTACT_CELLNO\" value=\"". $this->contact_cellno ."\"><br>";
		echo "CONTACT_EMAIL: <input name=\"CONTACT_EMAIL\" value=\"". $this->contact_email ."\"><br>";
		echo "CONTACT_FIRSTNAME: <input name=\"CONTACT_FIRSTNAME\" value=\"". $this->contact_firstname ."\"><br>";
		echo "CONTACT_LASTNAME: <input name=\"CONTACT_LASTNAME\" value=\"". $this->contact_lastname ."\"><br>";
		echo "CONTACT_COMPANY: <input name=\"CONTACT_COMPANY\" value=\"". $this->contact_company ."\"><br>";
		echo "CONTACT_ADDR_STREET: <input name=\"CONTACT_ADDR_STREET\" value=\"". $this->contact_addr_street ."\"><br>";
		echo "CONTACT_ADDR_ZIP: <input name=\"CONTACT_ADDR_ZIP\" value=\"". $this->contact_addr_zip ."\"><br>";
		echo "CONTACT_ADDR_CITY: <input name=\"CONTACT_ADDR_CITY\" value=\"". $this->contact_addr_city ."\"><br>";
		echo "CONTACT_ADDR_COUNTRY: <input name=\"CONTACT_ADDR_COUNTRY\" value=\"". $this->contact_addr_country ."\"><br>";
		echo "INCLUDE_VAT: <input name=\"INCLUDE_VAT\" value=\"". INCLUDE_VAT ."\" /><br>";
		echo "ITEMS: <input name=\"ITEMS\" value=\"1\"><br>";
		echo "ITEM_TITLE: <input name=\"ITEM_TITLE[0]\" value=\"Tuote #101\"><br>";
		echo "ITEM_NO: <input name=\"ITEM_NO[0]\" value=\"101\"><br>";
		echo "ITEM_AMOUNT: <input name=\"ITEM_AMOUNT[0]\" value=\"1\"><br>";
		echo "ITEM_PRICE: <input name=\"ITEM_PRICE[0]\" value=\"10.00\"><br>";
		echo "ITEM_TAX: <input name=\"ITEM_TAX[0]\" value=\"22.00\"><br>";
		echo "ITEM_DISCOUNT: <input name=\"ITEM_DISCOUNT[0]\" value=\"0\"><br>";
		echo "ITEM_TYPE :<input name=\"ITEM_TYPE[0]\" value=\"1\"><br>";
		echo "AUTHCODE :<input name=\"AUTHCODE\" value=\"$this->authcode\"><br>";
		echo "<input type=\"submit\" value=\"Siirry maksamaan\"><br>";
		echo "</form>";
		
		echo "S1 malli<br>";
		echo "<form action=\"https://payment.verkkomaksut.fi/\" method=\"post\">";
		echo "<input name=\"MERCHANT_ID\"  value=\"13466\">";
		echo "<input name=\"AMOUNT\"  value=\"99.90\">";
		echo "<input name=\"ORDER_NUMBER\"  value=\"123456\">";
		echo "<input name=\"REFERENCE_NUMBER\"  value=\"\">";
		echo "<input name=\"ORDER_DESCRIPTION\"  value=\"Testitilaus\">";
		echo "<input name=\"CURRENCY\"  value=\"EUR\">";
		echo "<input name=\"RETURN_ADDRESS\"  value=\"http://www.esimerkki.fi/success\">";
		echo "<input name=\"CANCEL_ADDRESS\"  value=\"http://www.esimerkki.fi/cancel\">";
		echo "<input name=\"PENDING_ADDRESS\"  value=\"\">";
		echo "<input name=\"NOTIFY_ADDRESS\"  value=\"http://www.esimerkki.fi/notify\">";
 		echo "<input name=\"TYPE\"  value=\"S1\">";
		echo "<input name=\"CULTURE\"  value=\"fi_FI\">";
		echo "<input name=\"PRESELECTED_METHOD\"  value=\"\">";
		echo "<input name=\"MODE\"  value=\"1\">";
		echo "<input name=\"VISIBLE_METHODS\"  value=\"\">";
		echo "<input name=\"GROUP\"  value=\"\">";
		echo "<input name=\"AUTHCODE\"  value=\"270729B19016F94BE5263CA5DE95E330\">";
		echo "<input type=\"submit\" value=\"Siirry maksamaan\">";
		echo "</form><br>";
		
/*		
		$this->GetAUTHCODE_S1();
		
		echo "S1 oma $this->costTotal<br>";
		//echo "<br>authcodetxt $this->authcodetxt";
		echo "<br>authcode $this->authcode";
		echo "<form action=\"https://payment.verkkomaksut.fi/\" method=\"post\">";
		echo "<input name=\"MERCHANT_ID\" value=\"" . MERCHANT_ID . "\">";
		echo "<input name=\"AMOUNT\" value=\"" . $this->costTotal . "\">";
		echo "<input name=\"ORDER_NUMBER\" value=\"" .$this->order_number . "\">";
		echo "<input name=\"REFERENCE_NUMBER\" value=\"\">";
		echo "<input name=\"ORDER_DESCRIPTION\" value=\"" . $this->order_description . "\">";
		echo "<input name=\"CURRENCY\" value=\"" . CURRENCY . "\">";
		echo "<input name=\"RETURN_ADDRESS\" value=\"" . RETURN_ADDRESS . "\">";
		echo "<input name=\"CANCEL_ADDRESS\" value=\"" . CANCEL_ADDRESS . "\">";
		echo "<input name=\"PENDING_ADDRESS\" value=\"" . PENDING_ADDRESS . "\">";
		echo "<input name=\"NOTIFY_ADDRESS\" value=\"" . NOTIFY_ADDRESS . "\">";
 		echo "<input name=\"TYPE\" value=\"S1\">";
		echo "<input name=\"CULTURE\" value=\"fi_FI\">";
		echo "<input name=\"PRESELECTED_METHOD\" value=\"\">";
		echo "<input name=\"MODE\" value=\"1\">";
		echo "<input name=\"VISIBLE_METHODS\" value=\"\">";
		echo "<input name=\"GROUP\" value=\"\">";
		echo "<input name=\"AUTHCODE\" value=\"" . $this->authcode . "\">";
		echo "<input type=\"submit\" value=\"Siirry maksamaan\"><br>";
		echo "</form><br>";
*/
		/**
E1
<form action="https://payment.verkkomaksut.fi/" method="post">
  <input name="MERCHANT_ID" type="hidden" value="13466">
  <input name="ORDER_NUMBER" type="hidden" value="123456">
  <input name="REFERENCE_NUMBER" type="hidden" value="">
  <input name="ORDER_DESCRIPTION" type="hidden" value="Testitilaus">
  <input name="CURRENCY" type="hidden" value="EUR">
  <input name="RETURN_ADDRESS" type="hidden" value="http://www.esimerkki.fi/success">
  <input name="CANCEL_ADDRESS" type="hidden" value="http://www.esimerkki.fi/cancel">
  <input name="PENDING_ADDRESS" type="hidden" value="">
  <input name="NOTIFY_ADDRESS" type="hidden" value="http://www.esimerkki.fi/notify">
  <input name="TYPE" type="hidden" value="E1">
  <input name="CULTURE" type="hidden" value="fi_FI">
  <input name="PRESELECTED_METHOD" type="hidden" value="">
  <input name="MODE" type="hidden" value="1">
  <input name="VISIBLE_METHODS" type="hidden" value="">
  <input name="GROUP" type="hidden" value="">
  <input name="CONTACT_TELNO" type="hidden" value="0412345678">
  <input name="CONTACT_CELLNO" type="hidden" value="0412345678">
  <input name="CONTACT_EMAIL" type="hidden" value="esimerkki@esimerkki.fi">
  <input name="CONTACT_FIRSTNAME" type="hidden" value="Matti">
  <input name="CONTACT_LASTNAME" type="hidden" value="Meik�l�inen">
  <input name="CONTACT_COMPANY" type="hidden" value="">
  <input name="CONTACT_ADDR_STREET" type="hidden" value="Testikatu 1">
  <input name="CONTACT_ADDR_ZIP" type="hidden" value="40500">
  <input name="CONTACT_ADDR_CITY" type="hidden" value="Jyv�skyl�">
  <input name="CONTACT_ADDR_COUNTRY" type="hidden" value="FI">
  <input name="INCLUDE_VAT" type="hidden" value="1" />
  <input name="ITEMS" type="hidden" value="2">
  <input name="ITEM_TITLE[0]" type="hidden" value="Tuote #101">
  <input name="ITEM_NO[0]" type="hidden" value="101">
  <input name="ITEM_AMOUNT[0]" type="hidden" value="1">
  <input name="ITEM_PRICE[0]" type="hidden" value="10.00">
  <input name="ITEM_TAX[0]" type="hidden" value="22.00">
  <input name="ITEM_DISCOUNT[0]" type="hidden" value="0">
  <input name="ITEM_TYPE[0]" type="hidden" value="1">
  <input name="ITEM_TITLE[1]" type="hidden" value="Tuote #202">
  <input name="ITEM_NO[1]" type="hidden" value="202">
  <input name="ITEM_AMOUNT[1]" type="hidden" value="2">
  <input name="ITEM_PRICE[1]" type="hidden" value="8.50">
  <input name="ITEM_TAX[1]" type="hidden" value="22.00">
  <input name="ITEM_DISCOUNT[1]" type="hidden" value="0">
  <input name="ITEM_TYPE[1]" type="hidden" value="1">
  <input name="AUTHCODE" type="hidden" value="399A88703393FCDD7BCD6C5512EC6F30">
  <input type="submit" value="Siirry maksamaan">
</form>
*/
	}	

	/*
			$params["ITEM_TITLE[$i]"] = $order->products[$i]['name'];
			$params["ITEM_NO[$i]"] = $order->products[$i]['id'];
			$params["ITEM_AMOUNT[$i]"] = $order->products[$i]['qty'];
			$params["ITEM_PRICE[$i]"] = $order->products[$i]['final_price'];
			$params["ITEM_TAX[$i]"] = $order->products[$i]['tax'];
			$params["ITEM_DISCOUNT[$i]"] = 0;
			$params["ITEM_TYPE[$i]"] = 1;			
	*/
	/**
	 * Korjataan p�iv�
	 */
	public function FixDay(){
	}
	
	/**
	 * Tee yksi rivi n�ytett�v�ksi
	 */
	public function MakeRow(){
		if (!isset($db))
			$db = new Database();
 			
 		$db->Database();
		
		if (!isset($car))
			$car = new Car();
			
		$car->ReadCar($this->carID);
		$tmp_carid = $car->CarNro();		
		
		$sql2 = "SELECT COUNT(*) AS NumberOfCar FROM tmp_reservation WHERE user_session_id = '$user_session_id' and car_id = '$this->carID' order start_time";
		
		$haku2 = $db->AskSQL($sql2);

		$rows2 = mysql_num_rows($haku2);
		
		echo "<tr><td class=\"stylish-cRows\"><img src=\"images/cars/Car_" . $tmp_carid . "_001.jpg\" alt=\"$rivi[4]\" title=\"$rivi[4]\" width=\"100\"/>";
		
	}
	
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
				$this->user_id =$rivi[1];
				$this->car_id = $rivi[2];
				$this->accessory_id = $rivi[3];
				$this->location = $rivi[4];		
				$this->start_time =$rivi[5];
				$this->end_time =$rivi[6];
				$this->information = $rivi[7];
				$this->cadmin = $rivi[8];
				$this->changeday = $rivi[9];
				$this->location_name = $rivi[10];
				$this->cadmin_name = $rivi[11];
				$this->start_time = date("Y-m-d H:i:s",$this->start_time);
				$this->end_time = date("Y-m-d H:i:s",$this->end_time);
	
			}		
		}		
		
		if ($this->reserve_id == "")
			$this->reserve_id = "";
			
		if ($this->user_id == "")
			$this->user_id = "0";
			
		if ($this->car_id == "")
			$this->car_id = "0";
			
		if ($this->accessory_id == "")
			$this->accessory_id = "0";

		if ($this->location == "")
			$this->location = "1";
			
		if ($this->start_time == "")
			$this->start_time = date("Y-m-d H:i:s",$this->start_time);
		
		if ($this->end_time == "")
			$this->end_time = date("Y-m-d H:i:s",$this->start_time);
		
		if ($this->information == "")
			$this->information = "";	
					
		if ($this->cadmin == "")
			$this->cadmin = $_SESSION['LogInUser']->id;
			
		if ($this->changeday == "" || $this->changeday == "Today")
			$this->changeday = time();
			
		$output = $this->reserve_id;
		
		return $output;
	}
	
	/**
	 * Test print reserve information
	 */
	public function PrintReservation(){
		echo "$this->reserve_id<br>";
		echo "$this->user_id<br>";
		echo "$this->car_id<br>";
		echo "$this->accessory_id<br>";
		echo "$this->location<br>";
		echo "$this->start_time<br>";
		echo "$this->end_time<br>";
		echo "$this->information<br>";
		echo "$this->cadmin<br>";
		echo "$this->changeday<br>";
		echo "$this->location_name<br>";
		echo "$this->cadmin_name<br>";		
	}
	
	public function ReservationTab($location){
				
		if (isset($_GET["search"]) == "")
			$_GET["search"] = "all";
			
		$xx = $_GET["search"];

		$xxx = " id=\"selectedtab\"";
		
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
		
	if (!isset($accessories))
		$accessories = new Accessories();
		
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
	
	print "\n<table width=\"1050\"><tr><td colspan=\"9\" class=\"td_phonelistheader\">$locationname Reservations</td></tr>";
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
				//print "t�ss�1 $rivi[1]<br>";
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
				//print "t�ss�6 $rivi[6]<br>";
				$tila = $this->CheckReservationCondition($rivi[0],"",$rivi[6],"","");
			}
			
			if ($rivi[7]>0){
				//print "t�ss�7 $rivi[7]<br>";
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
		print "<table width=\"1050\">\n";		
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
		
		print "</table><table width=\"1050\"><tr><td class=\"td_phonelistheader\" colspan=\"3\">Ended reservations (last five)</td></tr>";
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
		//Onko varauksen start_time aiemmin varatulla aikavälillä
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
			
		//Onko varauksen end_time aiemmin varatulla aikavälillä	
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

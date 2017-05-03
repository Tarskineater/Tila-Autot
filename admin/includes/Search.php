<?php
/**
 * Inventory Tool 0.6
 * Search.php 0.7
 * 31.03.2009
 */
class Search{
	var $searchtxt;
	var $s_all;
	var $s_user;
	var $s_project;
	var $s_location;
	var $s_reservation;	
	var $s_phone;
	var $s_sim;
	var $s_accessory;
	var $s_acctype;
	var $s_flash;
	var $page2;
	
	var $product;
	var $location;
	var $project;
	
	var $sql_user;
	var $sql_project;
	var $sql_location;
	var $sql_reservation;
	var $sql_phone;
	var $sql_sim;
	var $sql_accessory;
	var $sql_acctype;
	var $sql_flash;

	var $order_user;
	var $order_project;
	var $order_location;
	var $order_reservation;
	var $order_phone;
	var $order_sim;
	var $order_accessory;
	var $order_acctype;
	var $order_flash;
	
	var $sendback;
	var $send;
	
	public function Search(){
		$this->sql_user = "";
		$this->sql_project = "";
		$this->sql_location = "";
		$this->sql_reservation = "";
		$this->sql_phone = "";
		$this->sql_sim = "";
		$this->sql_accessory = "";
		$this->sql_acctype = "";
		$this->sql_flash = "";

		$this->order_user = "location";
		$this->order_project = "";
		$this->order_location = "";
		$this->order_reservation = "";
		$this->order_phone = "model, imei";
		$this->order_sim = "operator, cardnumber, phonenumber";
		$this->order_accessory = "typea, manufactor, model";
		$this->order_acctype = "id";
		$this->order_flash = "";
		
	}	
	
	/**
	 * PrintSQL
	 */
	public function PrintSQL(){
		print "sql_user='<b>$this->sql_user</b>'<br>";
		print "sql_project='<b>$this->sql_project</b>'<br>";
		print "sql_location='<b>$this->sql_location</b>'<br>";
		print "sql_reservation='<b>$this->sql_reservation</b>'<br>";
		print "sql_phone='<b>$this->sql_phone</b>'<br>";
		print "sql_sim='<b>$this->sql_sim</b><br>";
		print "sql_accessory='<b>$this->sql_accessory</b>'<br>";
		print "sql_acctype='<b>$this->sql_acctype</b>'<br>";
		print "sql_flash='<b>$this->sql_flash</b>'<br>";
		print "searchtype='<b>$this->searchtype</b>'<br>";
	}	
	
	public function SearchTab(){
		if (!isset($project))
			$projects = new Projects();
					
		if (!isset($locations))
			$locations = new Location();
			
		$this->Search();
		
			
		//$this->searchtxt = "";
		
		$search_q = " OR ";
		
		if ($this->TestPageType()==0){
			$this->searchtxt = $_POST["searchtxt"];
			$this->product = $_POST["product"];
			//print $_GET["product"] . "<br>";
			
			if ($_GET["product"]!=""){
				$this->product = $_GET["product"];
			}
			
			$this->location = $_POST["location"];
			$this->project = $_POST["project"];
			$this->page2 = $_POST["page2"];
		}

		if ($this->product=="all")
			$this->product = "";
		
		if ($this->location=="" && $this->project!=""){
			$projects->id = $this->project;
			$projects->ReadProject($this->project);
			$this->location=$projects->location;
		}
		
		$s0 ="";
		$s1 ="";
		if ($_POST["sendback"]=="" || $_POST["sendback"]=="0" || $_GET["sendback"]=="0"){
			$this->sendback = "sdate = '0000-00-00 00:00:00'"; 
			$this->send = "0";
			$s0 =" selected";
		} else {
			$this->sendback = "sdate <> '0000-00-00 00:00:00'";
			$this->send = "1";
			$s1 =" selected";
			
		}
		
		//print "product:$this->product<br>";
		/*
		if ($this->product ==""){
			print "tyhj‰<br>";
			if (isset($_GET["s_product"])!="")
				$this->product = $_GET["s_product"];
			print "product:$this->product<br>";
		}
		*/

		/*
		$a1 = "";
		$a2 = "";
		$a3 = "";
		$a4 = "";
		$a5 = "";
		$a6 = "";
		$a7 = "";
		$a8 = "";
		$a9 = "";
		$this->s_user = 0;
		$this->s_project = 0;
		$this->s_location = 0;
		$this->s_reservation = 0;	
		$this->s_phone =0;
		$this->s_sim = 0;
		$this->s_accessory = 0;
		$this->s_flash = 0;
			
		if ($this->product == ""){
			$this->s_user = 1;
			$this->s_project = 1;
			$this->s_location = 1;
			$this->s_reservation = 1;	
			$this->s_phone = 1;
			$this->s_sim = 1;
			$this->s_accessory = 1;
			$this->s_flash = 1;
		}
		*/
		
		/**
		 * split
		 */
		$this->searchtxt = trim($this->searchtxt);
		$this->searchtxt = str_replace("'", "", $this->searchtxt);
		$this->searchtxt = str_replace("#", "", $this->searchtxt);
		$this->searchtxt = str_replace("%", "", $this->searchtxt);
		$this->searchtxt = str_replace("&", "", $this->searchtxt);
		$this->searchtxt = str_replace("/", "", $this->searchtxt);
		
		
		$sana = split(" ", $this->searchtxt);
		$count = -1;
		if ($this->searchtxt !=""){
			$count = count($sana)-1;		
		
			for ($i=0; $i<=$count; $i++)
				$sana[$i] = "LIKE '%$sana[$i]%'"; 

			/*for ($i=0; $i<=$count; $i++)
				print "$i $sana[$i]<br>";
				*/
		}
		
		$s_len = 0;
		
		$s_locationsql = "";
		if ($this->location != "")
			$s_locationsql = "location = $this->location";
			
		$s_projectsql = "";
		if ($this->project != ""){
			$s_projectsql = "project = $this->project";
			if ($s_locationsql != "")
				$s_projectsql = " AND $s_projectsql";	
		}
		
		$s_more = "$s_locationsql$s_projectsql";
		
		if($s_more!=""){
			$s_len = 1;
			$s_more = "($s_locationsql$s_projectsql)";
		}
		/*
		print "product $this->product<br>";
		print "location $this->location $s_locationsql<br>";
		print "project $this->project $s_projectsql<br>";
		print "s_len $s_more $s_len || $count<br>";
		*/
		$this->searchtype = "";
		
		/**
		 * User
		 */
		if (($this->product == "") || ($this->product == "user")){
			$this->order_user = "location, username";
			
			if ($_POST["order_user"]!=""){
				$this->order_user = $_POST["order_user"];	
			}
			
			if ($_GET["order_user"]!=""){
				$this->order_user = $_GET["order_user"];	
			}
			
			//$this->sql_user = "SELECT * FROM users, location WHERE (users.location=location.id)";
			
			$this->sql_user = "SELECT * FROM users";
				 
			$s_sql = "";
			if ($this->product == "user")
				$this->searchtype = "users";
				
			if ($count!=-1){
				
				//$this->sql_user = $this->sql_user . " AND ";
				
				for ($i=0; $i<=$count; $i++){
					if ($i!=0)
						$s_sql = $s_sql . $search_q;
						
					/**
					$s_sql = $s_sql . "(users.username $sana[$i]) OR (users.name $sana[$i]) OR (users.email $sana[$i]) OR " .
					"(users.oikeustaso $sana[$i]) OR (users.tunniste $sana[$i]) OR (users.phone $sana[$i]) OR (users.information $sana[$i]) OR " .
					"(location.country $sana[$i]) OR (location.name $sana[$i])";
					*/
					
					$s_sql = $s_sql . "((username $sana[$i]) OR (name $sana[$i]) OR (email $sana[$i]) OR " .
					"(oikeustaso $sana[$i]) OR (tunniste $sana[$i]) OR (phone $sana[$i]) OR (information $sana[$i]) " .
					"OR (location_name $sana[$i]) OR (project_name $sana[$i]) OR (cadmin_name $sana[$i]))";	
				}
			}
			if($s_sql!="")
				$s_sql = "($s_sql)"; 
			
			//$this->sql_user = $this->sql_user . $s_sql;
				
			if ($s_len==1 || $s_sql!="")
				$this->sql_user = $this->sql_user ." WHERE ";

			if ($s_more!="")
				$this->sql_user = $this->sql_user . "$s_more"; 
				
			if ($s_more!="" && $s_sql!=""){
				$this->sql_user = $this->sql_user . " AND ";
				//print "'$s_more' '$s_sql'<br>";
			}
				
			if ($s_sql!="")
				$this->sql_user = $this->sql_user . "$s_sql"; 
			
			$this->sql_user = $this->sql_user . " ORDER BY $this->order_user";	
		}
		
		//print "$this->sql_user $s_locationsql '$s_more'<br>";
		
		/**
		 * Phone
		 */		
		if (($this->product == "") || ($this->product == "phone")){
			$this->order_phone = "model, imei";
			
			if ($_POST["order_phone"]!=""){
				$this->order_phone = $_POST["order_phone"];	
			}
			
			if ($_GET["order_phone"]!=""){
				$this->order_phone = $_GET["order_phone"];	
			}
			
			$this->sql_phone = "SELECT * FROM `phones` WHERE ";
			$s_sql = "";
			if ($s_len == 1 || $count!=-1){
				//$this->sql_phone = $this->sql_phone . "(";
				
				if ($this->product == "phone")
					$this->searchtype = "phones";
					
				if ($count!=-1){
					//$this->sql_phone = $this->sql_phone . "(";
					for ($i=0; $i<=$count; $i++){
						if ($i!=0)
							$s_sql = $s_sql . $search_q;	
							
						$s_sql = $s_sql . "((manufactor $sana[$i]) OR (model $sana[$i]) OR (software $sana[$i]) OR " .
						"(imei $sana[$i]) OR (pin1 $sana[$i]) OR (pin2 $sana[$i]) OR " .
						"(puk $sana[$i]) OR (location $sana[$i]) OR (project $sana[$i]) OR " .
						"(nickname $sana[$i]) OR (information $sana[$i]) OR (classa $sana[$i]) OR " .
						"(proto $sana[$i]) OR (iperson $sana[$i]) OR (owner $sana[$i]) OR " .
						"(location_name $sana[$i]) OR (project_name $sana[$i]) OR (iperson_name $sana[$i]) OR (cadmin_name $sana[$i]))";		
					}
				}
			
				$this->sql_phone = $this->sql_phone . $s_sql;
				
				if ($count!=-1){
					if ($s_len==1){
 						$this->sql_phone = $this->sql_phone . " AND "; 
					}
				}
				
				if ($s_more!=""){
					$this->sql_phone = $this->sql_phone . "$s_more"; 
				}
			}
			
			if ($count!=-1 or $s_more!=""){
 				$this->sql_phone = $this->sql_phone . " AND $this->sendback ORDER BY $this->order_phone";
			} else {	
				$this->sql_phone = $this->sql_phone . " $this->sendback ORDER BY $this->order_phone";
			}
		}	
		
		//print "sql_phone='<b>$this->sql_phone</b>' $sendback<br>";
		
		/**
		 * Sim
		 */		
		if (($this->product == "") || ($this->product == "sim")){
			$this->order_sim = "operator, cardnumber, phonenumber";
			
			if ($_POST["order_sim"]!=""){
				$this->order_sim = $_POST["order_sim"];	
			}
			
			if ($_GET["order_sim"]!=""){
				$this->order_sim = $_GET["order_sim"];	
			}
			
			$this->sql_sim = "SELECT * FROM `sims` WHERE";
			$s_sql = "";
			if ($s_len == 1 || $count!=-1){
				$this->sql_sim = $this->sql_sim . " (";
				
				if ($this->product == "sim")
					$this->searchtype = "sims";
					
				if ($count!=-1){
					for ($i=0; $i<=$count; $i++){
						if ($i!=0)
							$s_sql = $s_sql . $search_q;
						
						$s_sql = $s_sql . "((cardnumber $sana[$i]) OR (phonenumber $sana[$i]) OR (operator $sana[$i]) OR " .
						"(owner $sana[$i]) OR (location $sana[$i]) OR (information $sana[$i]) OR " .
						"(project $sana[$i]) OR (pin1 $sana[$i]) OR (pin2 $sana[$i]) OR " .
						"(puk $sana[$i]) OR (reserve_id $sana[$i]) OR (cadmin $sana[$i]) OR " .
						"(classa $sana[$i]) OR (proto $sana[$i]) OR (iperson $sana[$i]) OR " .
						"(location_name $sana[$i]) OR (project_name $sana[$i]) OR (iperson_name $sana[$i]) OR (cadmin_name $sana[$i]))";
					}
					$s_sql = "($s_sql)";
				}
				
				$this->sql_sim = $this->sql_sim . $s_sql;
				
				if ($count!=-1 && $s_len==1){
					$this->sql_sim = $this->sql_sim . " AND $s_more) AND"; 
				} else {
					$this->sql_sim = $this->sql_sim . "$s_more) AND"; 
				}
			}	
 			$this->sql_sim = $this->sql_sim . " $this->sendback ORDER BY $this->order_sim";
		}	
			
		//print "sql_sim='<b>$this->sql_sim</b><br>";
		
		/**
		 * Accessory
		 */	
		if (($this->product == "") || ($this->product == "accessory")){
			
			if ($this->product == "accessory")
				$this->searchtype = "accessories";
				
			$this->order_accessory = "typea, manufactor, model";
			
			if ($_POST["order_accessory"]!=""){
				$this->order_accessory = $_POST["order_accessory"];	
			}
			
			if ($_GET["order_accessory"]!=""){
				$this->order_accessory = $_GET["order_accessory"];	
			}
			
			$this->sql_accessory = "SELECT * FROM accessories WHERE ";
			
			/*$this->sql_accessory = "SELECT accessories.id,accessories.project,accessories.manufactor,accessories.model,accessories.statusa," . 
			"accessories.location,accessories.information,accessories.reserve_id,accessories.typea, " .
			"accessories.location_name, accessories.project_name, accessories.iperson_name, accessories.cadmin_name, " .
			"acctype.name, acctype.picture FROM accessories JOIN acctype ON accessories.typea = acctype.id";
			*/
			
			$s_sql = "";
			
			if ($s_len == 1 || $count!=-1){
				
				if ($count!=-1){
					//$this->sql_accessory = $this->sql_accessory . "(";
					for ($i=0; $i<=$count; $i++){
						if ($i!=0)
							$s_sql = $s_sql . $search_q;
						
						$s_sql = $s_sql . "((accessories.project $sana[$i]) OR (accessories.manufactor $sana[$i]) OR (accessories.model $sana[$i]) OR " .
						"(accessories.statusa $sana[$i]) OR (accessories.location $sana[$i]) OR (accessories.information $sana[$i]) OR " .
						"(accessories.reserve_id $sana[$i]) OR (accessories.typea $sana[$i]) OR (accessories.cadmin $sana[$i]) OR " .
						"(accessories.classa $sana[$i]) OR (accessories.proto $sana[$i]) OR (accessories.iperson $sana[$i]) OR " .
						"(accessories.owner $sana[$i]) OR " .
						"(accessories.location_name $sana[$i]) OR (accessories.project_name $sana[$i]) OR (accessories.iperson_name $sana[$i]) OR (accessories.cadmin_name $sana[$i]))";
					}
					$s_sql = "($s_sql)";
					$this->sql_accessory = $this->sql_accessory . $s_sql;
					//$this->sql_accessory = $this->sql_accessory . ")";
				}
			}
			
			if ($count!=-1 && $s_len==1){
				$this->sql_accessory = $this->sql_accessory . " AND ($s_more) AND "; 
			} else {
				if ($s_more!=""){
					$this->sql_accessory = $this->sql_accessory . "$s_more AND "; 
				}
			}
			
			if ($count!=-1){
 				$this->sql_accessory = $this->sql_accessory . " AND $this->sendback ORDER BY $this->order_accessory";
			} else {	
				$this->sql_accessory = $this->sql_accessory . " $this->sendback ORDER BY $this->order_accessory";
			}
					
		}	
		
		//print "sql_accessory='<b>$this->sql_accessory</b>'<br>";

		/**
		 * Accessory type
		 */	
		if (($this->product == "") || ($this->product == "acctype")){
			//print "$this->order_acctype<br>";
			if ($this->product == "acctype")
				$this->searchtype = "acctype";
				
			$this->order_acctype = "id";
			if ($_POST["order_acctype"]!=""){
				$this->order_acctype = $_POST["order_acctype"];	
			}
			
			if ($_GET["order_acctype"]!=""){
				$this->order_acctype = $_GET["order_acctype"];	
			}
			
			//print "$this->order_acctype<br>";
			
			$this->sql_acctype = "SELECT id, name, picture, cadmin, changeday, " . 
			"cadmin_name FROM acctype";
			
			$s_sql = "";
			
			if ($count!=-1){
				$this->sql_acctype = $this->sql_acctype . " WHERE ";
				
				if ($count!=-1){
					//$this->sql_acctype = $this->sql_acctype . "(";
					for ($i=0; $i<=$count; $i++){
						if ($i!=0)
							$s_sql = $s_sql . $search_q;
						
						$s_sql = $s_sql . "((id $sana[$i]) OR (name $sana[$i]) OR (picture $sana[$i]) OR (cadmin $sana[$i]) OR (information $sana[$i]) OR " .
						"(cadmin_name $sana[$i]))";
					}
					
					$s_sql = "($s_sql)";
					
					$this->sql_acctype = $this->sql_acctype . $s_sql;
				}
			}
			
			/**if ($count!=-1 && $s_len==1){
				$this->sql_acctype = $this->sql_acctype . " AND ($s_more)"; 
			} else {
				$this->sql_acctype = $this->sql_acctype . "$s_more"; 
			}
			*/	
 			$this->sql_acctype = $this->sql_acctype . " ORDER BY $this->order_acctype";
		}	
			
		/**
		 * Flash
		 */
		if (($this->product == "") || ($this->product == "flash")){
			$this->sql_flash = "SELECT * FROM `flash_adapters` WHERE ";
			
			$this->order_flash = "manufactor, name, nickname";
			
			if ($_POST["order_flash"]!=""){
				$this->order_flash = $_POST["order_flash"];	
			}
			
			if ($_GET["order_flash"]!=""){
				$this->order_flash = $_GET["order_flash"];	
			}
			
			$s_sql = "";
			
			if ($this->product == "flash")
				$this->searchtype = "flashs";
				
			if ($s_len == 1 || $count!=-1){
				$this->sql_flash = $this->sql_flash . " (";
				
				if ($count!=-1){
					for ($i=0; $i<=$count; $i++){
						if ($i!=0)
							$s_sql = $s_sql . $search_q;
						
						$s_sql = $s_sql . "((serialnro $sana[$i]) OR (nickname $sana[$i]) OR (name $sana[$i]) OR (manufactor $sana[$i]) OR " .
						"(model $sana[$i]) OR (classa $sana[$i]) OR (proto $sana[$i]) OR " .
						"(typea $sana[$i]) OR (location $sana[$i]) OR (project $sana[$i]) OR " .
						"(owner $sana[$i]) OR (statusa $sana[$i]) OR (reserve_id $sana[$i]) OR " .
						"(iperson $sana[$i]) OR (cadmin $sana[$i]) OR (information $sana[$i]) OR " .
						"(location_name $sana[$i]) OR (project_name $sana[$i]) OR (iperson_name $sana[$i]) OR (cadmin_name $sana[$i]))";
					}
					$s_sql = "($s_sql)";
					$this->sql_flash = $this->sql_flash . $s_sql;
				}
			
				if ($count!=-1 && $s_len==1){
					$this->sql_flash = $this->sql_flash . " AND $s_more) AND"; 
				} else {
					$this->sql_flash = $this->sql_flash . "$s_more) AND"; 
				}
			}
 			$this->sql_flash = $this->sql_flash . " $this->sendback ORDER BY $this->order_flash";
		}	
				
		//print "sql_flash='<b>$this->sql_flash</b>' $this->sendback<br>";
		
		/**
		 * Location
		 */
		if (($this->product == "") || ($this->product == "location")){
			$this->sql_location = "SELECT * FROM `location`";
			
			$this->order_location = "name, country";
			
			if ($_POST["order_location"]!=""){
				$this->order_location = $_POST["order_location"];	
			}
			
			if ($_GET["order_location"]!=""){
				$this->order_location = $_GET["order_location"];	
			}
			
			$s_sql = "";
			
			if ($this->product == "location")
				$this->searchtype = "locations";
				
			if ($this->location!="" || $count!=-1){
				$this->sql_location = $this->sql_location . " WHERE ";
				
				if ($count!=-1 && $this->location==""){
					//$this->sql_location = $this->sql_location . "(";
					for ($i=0; $i<=$count; $i++){
						if ($i!=0)
							$s_sql = $s_sql . $search_q;
						
						$s_sql = $s_sql . "((name $sana[$i]) OR (country $sana[$i]) OR (information $sana[$i]) OR (cadmin_name $sana[$i]))";
					}
					$s_sql = "($s_sql)";
				}
				
				$this->sql_location = $this->sql_location . $s_sql;
					
				if ($sql_location!=""){
					$s_locationsql = "(id=$this->location)";
				}
				
				if ($s_locationsql!=""){
					$this->sql_location = $this->sql_location . "(id=$this->location)"; 
				}
			}
 			$this->sql_location = $this->sql_location . " ORDER BY $this->order_location";
		}	
			
		/**
		 * Project
		 */
		if (($this->product == "") || ($this->product == "project")){
			/**
			$this->sql_project = "SELECT projects.id, projects.number, projects.name, projects.status, projects.location, ";
			$this->sql_project = $this->sql_project . "projects.information, projects.showme, location.id, location.name, location.country ";
			$this->sql_project = $this->sql_project . "FROM projects JOIN location ON projects.location = location.id ";
			*/
			
			$this->order_project = "location_name, name";
			
			if ($_POST["order_project"]!=""){
				$this->order_project = $_POST["order_project"];	
			}
			
			if ($_GET["order_project"]!=""){
				$this->order_project = $_GET["order_project"];	
			}
			
			$this->sql_project = "SELECT * FROM projects ";
			
			$s_projectsql = "";
			if ($this->project != ""){
				
				$s_projectsql = "(projects.id = $this->project)";
				if ($s_locationsql != "")
					$s_projectsql = " AND " . $s_projectsql;	
			}
			
			$s_more = $s_locationsql. "" . $s_projectsql;
			
			if($s_more!=""){
				$s_len = 1;
			}
		
			$s_sql = "";
			
			if ($this->product == "project")
				$this->searchtype = "projects";
			
			if ($s_len == 1 || $count!=-1){
				$this->sql_project = $this->sql_project . " WHERE ";
				
				if ($count!=-1){
					for ($i=0; $i<=$count; $i++){
						if ($i!=0){
							$this->s_sql = $this->s_sql . $search_q;
						}
						
						$this->s_sql = $this->s_sql . "((projects.number $sana[$i]) OR (projects.name $sana[$i]) OR (projects.status $sana[$i]) OR " .
						"(projects.information $sana[$i]) OR " .
						"(location_name $sana[$i]) OR (cadmin_name $sana[$i]))";
					}
					
					$this->s_sql = "($this->s_sql)";
					$this->sql_project = $this->sql_project . $this->s_sql;	
					
					//print "<br>$this->s_sql<br><br>";
					
					$this->s_sql = "";
				}
				
				if ($count!=-1 && $s_len==1){
					$this->sql_project = $this->sql_project . " AND $s_more"; 
				} else {
					$this->sql_project = $this->sql_project . "$s_more"; 
				}
			}
 			$this->sql_project = $this->sql_project . " ORDER BY $this->order_project";
		}
		
		//print "<br>$this->sql_project<br><br>";
		/**
		 * Reservations
		 */
		if ($this->product == "reservation"){
			$this->sql_reservation = "SELECT * FROM `reservation` WHERE (";
			//$this->sql_reservation = $this->sql_reservation . "(";
			
			if ($this->product == "reservation")
				$this->searchtype = "reservations";
				
			if ($s_len == 1 || $count!=-1){
				$this->sql_project = $this->sql_project . " WHERE (";
				
				if ($count!=-1){
					for ($i=0; $i<=$count; $i++){
						if ($i!=0){
							$this->sql_reservation = $this->sql_reservation . $search_q;
						}
						$this->sql_reservation = $this->sql_reservation . "((phone_id $sana[$i]) OR (user_id $sana[$i]) OR (project $sana[$i]) OR ";
						$this->sql_reservation = $this->sql_reservation . "(accessory_id $sana[$i]) OR (sim_id $sana[$i]) OR (flash_id $sana[$i]) OR ";
						$this->sql_reservation = $this->sql_reservation . "(location $sana[$i]) OR (information $sana[$i]) OR (cadmin $sana[$i]))";
					}
				}
				
				if ($count!=-1 && $s_len==1){
					$this->sql_reservation = $this->sql_reservation . " AND $s_more)"; 
				} else {
					$this->sql_reservation = $this->sql_reservation . "$s_more)"; 
				}
			}
 			$this->sql_reservation = $this->sql_reservation . " ORDER BY start_time, end_time";
		}
		
		//$this->PrintSQL();	
				
		print "<table width=\"950\" id=\"tabmenu2\">\n";
		print "<form action=\"index.php\" method=\"post\" name=\"searchform\">\n";
		//print "<input type=\"hidden\" name=\"page\" value=\"$this->searchtype\">\n";
		print "<input type=\"hidden\" name=\"page2\" value=\"searchform\">\n";
		
		print "<input type=\"hidden\" name=\"order_user\" value=\"$this->order_user\">\n";		
		print "<input type=\"hidden\" name=\"order_project\" value=\"$this->order_project\">\n";	
		print "<input type=\"hidden\" name=\"order_location\" value=\"$this->order_location\">\n";
		print "<input type=\"hidden\" name=\"order_reservation\" value=\"$this->order_reservation\">\n";
		print "<input type=\"hidden\" name=\"order_phone\" value=\"$this->order_phone\">\n";	
		print "<input type=\"hidden\" name=\"order_sim\" value=\"$this->order_sim\">\n";	
		print "<input type=\"hidden\" name=\"order_accessory\" value=\"$this->order_accessory\">\n";	
		print "<input type=\"hidden\" name=\"order_acctype\" value=\"$this->order_acctype\">\n";		
		print "<input type=\"hidden\" name=\"order_flash\" value=\"$this->order_flash\">\n";
		
		print "<tr>\n";
		print "<td class=\"tab\" colspan=\"1\">\n";
		print $this->ProductSelect("product", "$this->product");
		print "</td>\n";
		print "<td class=\"tab\" colspan=\"1\">\n";
		print $locations->LocationDropDown($this->location);
		print "</td>\n";
		print "<td class=\"tab\" colspan=\"1\">\n";
		print $projects->ProjectDropDown($this->project, $this->location);
		print "</td>\n</tr>\n";
		print "<tr>\n<td class=\"tab\" colspan=\"1\">Search word(s): <input type=\"text\" name=\"searchtxt\" size=\"60\" id=\"el02\" value=\"$this->searchtxt\"></td>\n";
		print "<td class=\"tab\" colspan=\"1\">\n";
		print "<select name=\"sendback\">\n";
		print "<option value =\"0\"$s0>&nbsp;In use&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";  
		print "<option value =\"1\"$s1>&nbsp;Sent back</option>\n";  
		print "</select>\n";
		print "</td>\n";
		print "<td class=\"tab\" colspan=\"1\"><input type=\"submit\" value=\"Search!\" id=\"el09\"></td>\n</tr>\n";
		print "</form>\n";
		print "</table>\n";
		$_GET["page"] = $this->product;
		$_GET["page3"] = "$searchtype";
	}
		
	/**
	 * product name selecting
	 */
	public function ProductSelect($name,$product){
		//print "name:$name $product<br>";
		$page2 = $product;
		/*if ($page2=="")
			$page2 = $_GET["$name"];
		*/
		$l0 = "";
		if ($page2 == "")
	 		$l0 = " selected";
	
		$l1 = "";
		if ($page2 == "phone")
	 		$l1 = " selected";
	 		
		$l2 = "";
		if ($page2 == "sim")
	 		$l2 = " selected";
	 		
		$l3 = "";
		if ($page2 == "accessory")
	 		$l3 = " selected";	
	 		
		$l4 = "";
		if ($page2 == "acctype")
	 		$l4 = " selected";	
	 		
		$l5 = "";
		if ($page2 == "flash")
	 		$l5 = " selected";
	 		
		$l6 = "";
		if ($page2 == "location")
	 		$l6 = " selected";

		$l7 = "";
		if ($page2 == "project")
	 		$l7 = " selected";
	 		
		$l8 = "";
		if ($page2 == "user")
	 		$l8 = " selected";
	 		
		$output1 = "<select name=\"$name\">\n";
		$output1 = $output1 . "<option value =\"\"$l0>&nbsp;- Select item -&nbsp;</option>\n";  
		$output1 = $output1 . "<option value =\"phone\"$l1>&nbsp;Phone</option>\n";  
		$output1 = $output1 . "<option value =\"sim\"$l2>&nbsp;SIM</option>\n";  
		$output1 = $output1 . "<option value =\"accessory\"$l3>&nbsp;Accessory</option>\n";  
		$output1 = $output1 . "<option value =\"acctype\"$l4>&nbsp;Accessory type</option>\n";  
		$output1 = $output1 . "<option value =\"flash\"$l5>&nbsp;Flash adapter</option>\n";  
		$output1 = $output1 . "<option value =\"location\"$l6>&nbsp;Location</option>\n";  
		$output1 = $output1 . "<option value =\"project\"$l7>&nbsp;Project</option>\n";  
		$output1 = $output1 . "<option value =\"user\"$l8>&nbsp;User</option>\n";  
		$output1 = $output1 . "</select>\n";
		return $output1;
	}
	
	/**
	 * New product tab
	 */
	public function NewTab(){
	 				 			
		$output = "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\"><tr>\n";
		$output = $output . "<form action=\"index.php\" method=\"post\" name=\"new\">\n";
		$output = $output . "<input type=\"hidden\" name=\"page2\" value=\"newform\">\n";
		$output = $output . "<td class=\"tab\" colspan=\"2\">&nbsp;</td>\n";
		$output = $output . "<td class=\"tab\" colspan=\"1\">\n";
		$output = $output . $this->ProductSelect("product","");
		$output = $output . "</td>\n"; 
		$output = $output . "<td class=\"tab\">\n<input type=\"submit\" value=\"Add\" id=\"el09\">\n</td>\n";
		$output = $output . "</form>\n";
		$output = $output . "</tr>\n</table>\n";
		
		print $output;
		//return $output;
	}
	/**
	 * Testing page type
	 */
	public function TestPageType(){
		$i = 0;
		/*
		print "show" . $_GET["show"] ."<br>";
		print "edit" . $_GET["edit"] ."<br>";
		print "new" . $_GET["new"] ."<br>";
		print "delete" . $_GET["delete"] ."<br>";
		print "save" . $_GET["save"] ."<br>";
		*/	
		if($_GET["show"]=="1" || $_GET["edit"]=="1" || $_GET["new"]=="1" || $_GET["delete"]=="1" || $_GET["save"]=="1")
			$i=1;
		return $i;
	}
	
	/**
	 * Testing Ascii
	 */
	public function TestText($in_text){
		/*
		$i = 0;
		if (!preg_match("/^[" . chr(0) . "-" . chr(255) . "]+$/", $in_text)){
			$i = 1;
			//die("possible hack attempt with non-ASCII input");
		}
		return $i;
		*/
	}
	
	/**
	 * Check text for lenght and char
	 * $in_err = error number back
	 * $output = 0 = no error
	 */
	public function CheckText($in_txt,$in_err){
		$output1 = 0; 
		$t = "/^[a-‰A-÷0-9\:\@\£\Ä%&#! \;\-_\[\]\.\,\/\\(\)\<\>\|\+\*\?
]{1,254}$/";

		if (!preg_match("$t",$in_txt)) { 
	    	$output1 = $in_err; 
	    	//print "$t $in_txt<br>";
    	}
    	return $output1;
	}
	
	public function FixThisfknText($in_txt){
		$in_txt = mb_convert_encoding($in_txt, "ISO-8859-1", "UTF-8");
		$in_txt = str_replace("<br />", "", $in_txt);	
		return $in_txt;
	}
	
}
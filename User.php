<?php
/**
 * Heurex Rental 0.0
 * User.php
 * 24.10.2012
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
	var $firstname;
	var $lastname;
	var $email;
	var $address;
	var $zip;
	var $postoffice;
	var $country;
	var $company;
	var $phone1;
	var $phone2;
	var $oikeustaso;
	var $tunniste;
	var $location;
	var $locationname;
	var $phone;
	var $information;
	var $location_name;
	var $location_id;
	var $project;
	var $project_name;
	var $cadmin_name;
	var $user_ip;
	
	var $test;
	
	public function User(){
		$this->id = "";
		$this->user_id = "";
		$this->username = "";
		$this->username0 = "";
		$this->password0 = "";
		$this->password1 = "";
		$this->password2 = "";
		$this->firstname = "";
		$this->lastname = "";
		$this->email = "";
		$this->address = "";
		$this->zip = "";
		$this->postoffice = "";
		$this->country = "FI";
		$this->company = "";
		$this->phone1 = "";
		$this->phone2 = "";
		$this->oikeustaso = 0;
		
		if (isset($_SESSION["kayttajatunniste"]) && isset($_SESSION["kayttajatunniste"]) == "")
			$this->tunniste = $_SESSION["kayttajatunniste"];
			
		$this->location = "";
		$this->aktivointi ="";
		$this->locationname = "Tampere";
		$this->location_id = "1";
		$this->project = "";
		$this->phone = "";
		$this->information = "";
  		$this->cadmin = "0";
  		$this->changeday = time();
  		$this->location_name = "";
		$this->project_name = "";
		$this->cadmin_name = "";
		$this->user_ip = $this->getip();
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
		$output = $this->firstname . " ". $this->lastname;    
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
				$this->firstname = stripslashes(nl2br($rivi[3]));
				$this->lastname = stripslashes(nl2br($rivi[4]));
				$this->email = stripslashes(nl2br($rivi[5]));
				$this->address = $rivi[6];
				$this->zip = $rivi[7];
				$this->postoffice = $rivi[8];
				$this->country = $rivi[9];
				
				if ($this->country == ""){
					$this->country = "FI";
				}
				
				$this->company = $rivi[10];
				$this->phone1 = $rivi[11];
				$this->phone2 = $rivi[12];
				$this->oikeustaso = $rivi[13];
				$this->tunniste = $rivi[14];
				$this->location = $rivi[15];
				$this->aktivointi = $rivi[16];
				$this->project = $rivi[17];
				$this->phone = stripslashes(nl2br($rivi[18]));
				$this->information = stripslashes(nl2br($rivi[19]));
				$this->cadmin = $rivi[20];
				$this->changeday = $rivi[21];
				$this->location_name = $rivi[22];
				$this->project_name = $rivi[23];
				$this->cadmin_name = $rivi[24];	
				$this->user_ip = $rivi[25];	
				$this->address = $this->ReplaceFont($this->address);
				$this->postoffice = $this->ReplaceFont($this->postoffice);
				$this->information = $this->ReplaceFont($this->information);
			}		
		}
		
		$this->information = str_replace("<br />", "", $this->information);
		
		$this->TestAll();
			
		$output = "";
				
		return $this->information;
	}
	
	/**
	 * Test print user information
	 */
	public function PrintUser(){
		echo "id: $this->id<br>\n";
		echo "id: $this->user_id<br>\n";
		echo "username: $this->username<br>\n";
		echo "username0: $this->username0<br>\n";
		echo "password0: $this->password0<br>\n";
		echo "password1: $this->password1<br>\n";
		echo "password2: $this->password2<br>\n";
		echo "firstname: $this->firstname<br>\n";
		echo "lastname: $this->lastname<br>\n";
		echo "email: $this->email<br>\n";
		echo "address: $this->address<br>\n";
		echo "zip: $this->zip<br>\n";
		echo "postoffice: $this->postoffice<br>\n";
		echo "country: $this->country<br>\n";
		echo "company: $this->company<br>\n";
		echo "phone1: $this->phone1<br>\n";
		echo "phone2: $this->phone2<br>\n";
		echo "oikeustaso: $this->oikeustaso<br>\n";
		echo "location: $this->location<br>\n";
		echo "aktivointi: $this->aktivointi<br>\n";
		echo "project: $this->project<br>\n";
		echo "phone: $this->phone<br>\n";
		echo "information: $this->information<br>\n";		
		echo "cadmin: $this->cadmin<br>\n";
		echo "changeday: $this->changeday<br>\n";		
		echo "location_name: $this->location_name<br>\n";
		echo "project_name: $this->project_name<br>\n";
		echo "cadmin_name: $this->cadmin_name<br>\n";
		echo "user_ip: $this->user_ip <br>\n";
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
		//echo "$sql\n";
		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		
		if ($rows > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				if ($user_id == $rivi[0]){
  					$output = $output . "<option value =\"$rivi[0]\" selected>$rivi[3] $rivi[4]</option>\n";  
				} else {
					$output = $output . "<option value =\"$rivi[0]\">$rivi[3] $rivi[4]</option>\n";  
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
			
		//if (!isset($project))
		//	$projects = new Projects();
				
		if (!isset($locations))
			$locations = new Location();
			
		$page2 = $_SESSION['Search']->page2;	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$sql = "SELECT * FROM users ORDER BY location, username";
		
		if ($page2 == "searchform"){
			//$sql = $_SESSION['Search']->sql_user;
		} else {	
			$sql = "SELECT * FROM users ORDER BY location, username";
			       
			//if ($oikeus < 99)
			//	$sql = "SELECT * FROM users WHERE location = $location ORDER BY location, username";
		}
			
		//echo "$page2 $sql<br>";
		
		if($locationname=="All"){
			$output2 = "User list";
		} else {
			$output2 = "$locationname users";
		}
		
		$tmp_user="<a href=\"index.php?page=user&page2=searchform&product=user&order_user=";
		
		echo "<table width=\"100%\"><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr>";
		
		echo "<td>" . $tmp_user . "lastname,firstname\" class=\"stylish-button\">Nimi</a></td>";
		echo "<td>". $tmp_user . "email,lastname,firstname\" class=\"stylish-button\">S&#228;hk&#246;posti</a></td>";
		echo "<td>". $tmp_user . "oikeustaso,lastname,firstname\" class=\"stylish-button\">Oikeudet</a></td>";
		echo "<td>". $tmp_user . "information,lastname,firstname\" class=\"stylish-button\">information</a></td>";
		echo "<td>". $tmp_user . "location_name,lastname,firstname\" class=\"stylish-button\">Paikkakunta</a></td>";
		echo "<td height=\"28\">";
		echo"<a href=\"includes/classes/excel.php?name=$output2&cols=6&col1=0&col2=3&col3=4&col4=5&col5=14&col6=15&";
		echo "coln1=ID&coln2=Name&coln3=E-mail address&coln4=User rights&coln5=Location&coln6=information&sql=$sql\" class=\"stylish-button\">Exel k&#228;ytt&#228;j&#228;t&nbsp;</a>&nbsp;";	
		echo "<a href=\"index.php?page=user&id=&user_id=&new=1\" class=\"stylish-button\">Uusi</a></td></tr>\n";
		echo "</tr>\n";
		
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
						$kayttajapoisto = "<a onclick=\"return confirmSubmitUSER()\" href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&delete=1\"><img src=\"" . DIR_PICTURES . LANG ."/small_delete.gif\" border=\"0\" title=\"Delete user\"></a>";
//						$toiminnot = "<a href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&edit=1\"><img src=\"" . DIR_PICTURES . "update2.gif\" border=\"0\" title=\"Update information\"></a>&nbsp;$kayttajapoisto\n";
						$toiminnot = "<a href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&edit=1\" class=\"stylish-button\">Muokkaa</a>\n";
					} else {
						$kayttajapoisto = "";
						$toiminnot = "Not shown";		
					}
					
					if ($this->id == $rivi[0])
						$kayttajapoisto = "";		
				}
			
				//Projecti
				//$temp = $projects->ReadProject($rivi[9]);
				$temp = "<a href=\"index.php?page=project&id=$rivi[16]&project_id=$rivi[16]&show=1\" class=\"stylish-cRows\">$rivi[16]</a>";				
	
				//Location
				$loc = $locations->ReadLocation($rivi[14]);

				if ($rivi[1] != NULL)
					//User
					echo "<tr><td class=\"stylish-cRows\">&nbsp;<a href=\"index.php?page=user&id=$rivi[0]&user_id=$rivi[0]&show=1\" class=\"stylish-cRows\">$rivi[3] $rivi[4]</a>&nbsp;</td>";
					//e-mail
					echo "<td class=\"stylish-cRows\"><a href=\"mailto:$rivi[5]\" class=\"stylish-cRows\">$rivi[5]&nbsp;</a></td>";
					//Status
					echo "<td class=\"stylish-cRows\">$status</td>";
					
					//Information
					echo "<td class=\"stylish-cRows\" colspan=\"1\">$rivi[19]&nbsp;</td>";	
					
					//location
					echo"<td class=\"stylish-cRows\" colspan=\"1\"><a href=\"index.php?page=location&id=$rivi[15]&location_id=$rivi[15]&show=1\" class=\"stylish-cRows\">$loc</a>&nbsp;</td>\n";
				
				if ($oikeus > "1")
					echo "<td>$toiminnot</td>";
				
				echo "</tr>";
			}
		} else {
			echo "<tr><td colspan=\"6\" class=\"stylish-cRows\">No users!</td></tr>";
		}
		
		echo "</tr></table>";
		echo "</tr></table>";
	}
	
	/**
	 * Luetaan POST
	 */
	public function ReadPost(){
		if (isset($_POST["user_id"]) && isset($_POST["user_id"]) != ""){
			$this->id = $_POST["user_id"];
			$this->user_id = $_POST["user_id"];	
		}	
				
		if (isset($_POST["username"]) && isset($_POST["username"]) != "")
			$this->username = $_POST["username"];
			
		//echo "Uname $this->username<br>";
		
		if (isset($_POST["username0"]) && isset($_POST["username0"]) != "")
			$this->username0 = $_POST["username0"];
		
		if (isset($_POST["password0"]))
			$this->password0 = $_POST["password0"];
			
		if (isset($_POST["password1"]))	
			$this->password1 = $_POST["password1"];
			
		if (isset($_POST["password2"]))
			$this->password2 = $_POST["password2"];
			
		if (isset($_POST["firstname"]) && isset($_POST["firstname"]) != "")
			$this->firstname = $_POST["firstname"];	
			
		if (isset($_POST["lastname"]) && isset($_POST["lastname"]) != "")
			$this->lastname = $_POST["lastname"];
		
		if (isset($_POST["email"]))
			$this->email = $_POST["email"];
			
		if (isset($_POST["address"]))	
			$this->address = $_POST["address"];
		
		if (isset($_POST["zip"]) && isset($_POST["zip"]) != "")
			$this->zip = $_POST["zip"];
			
		if (isset($_POST["postoffice"]) && isset($_POST["postoffice"]) != "")
			$this->postoffice = $_POST["postoffice"];
			
		if (isset($_POST["country"]) && isset($_POST["country"]) != "")
			$this->country = $_POST["country"];
			
		if (isset($_POST["company"]) && isset($_POST["company"]) != "")
			$this->company = $_POST["company"];
			
		if (isset($_POST["phone1"]))
			$this->phone1 = $_POST["phone1"];
		
		if (isset($_POST["phone2"]))
			$this->phone2 = $_POST["phone2"];
			
		if (isset($_POST["oikeustaso"]))
			$this->oikeustaso = $_POST["oikeustaso"];
			
		if (isset($_POST["tunniste"]))		
			$this->tunniste = $_POST["tunniste"];
			
		if (isset($_POST["location"]))		
			$this->location = $_POST["location"];
		
		if (isset($_POST["aktivointi"]))	
			$this->aktivointi = $_POST["aktivointi"];
		
		if (isset($_POST["locationname"]))	
			$this->locationname = mysql_real_escape_string($_POST["locationname"]);

		if (isset($_POST["project"]))	
			$this->project = $_POST["project"];
			
		if (isset($_POST["phone"]))		
			$this->phone = mysql_real_escape_string($_POST["phone"]);
			
		if (isset($_POST["information"]) && isset($_POST["information"]) != "")	
			$this->information = $_POST["information"];
	}
	
	/**
	 * Register
	 */
	public function NewUserAccount(){
					
		if (!isset($locations))
			$locations = new Location();
			
		$this->ReadPost();
			
		$this->location = "";
		$this->changeday = date("Y-m-d H:i:s",time());
		
		if ($this->location == "")
			$this->location = 1;	
				
		echo "<center><table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "<center><img src=\"" . DIR_PICTURES  . LANG ."/registration.gif\" border=\"0\"><br>";
		echo "T&#228;ytt&#228;m&#228;ll&#228; t&#228;m&#228;n rekister&#246;inti kaavakkeen p&#228;&#228;set vuokraamaan autoja Tila-Autot.com:sta.";
		echo "</td></tr></table></td></tr></table>";
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<form action=\"index.php\" method=\"post\" name=\"register\">\n" .
		"<input type=\"hidden\" name=\"password\" value=\"\">\n" .
		"<input type=\"hidden\" name=\"newregister\" value=\"1\">\n" .
		"<input type=\"hidden\" name=\"aktivointi\" value=\"100\">\n" .
		"<input type=\"hidden\" name=\"oikeustaso\" value=\"1\">\n" .
		"<input type=\"hidden\" name=\"page\" value=\"user\">\n" .
		"<input type=\"hidden\" name=\"page2\" value=\"registration\">\n" .
		"<input type=\"hidden\" name=\"save\" value=\"1\">\n";
		echo "<table width=\"100%\">";
		echo "<tr><td  class=\"stylish-button\">K&#228;ytt&#228;j&#228;nimi:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"username0\" size=\"50\" value=\"$this->username0\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Etunimi:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"firstname\" size=\"50\" value=\"$this->firstname\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Sukunimi:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"lastname\" size=\"50\" value=\"$this->lastname\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Salasana:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"password\" name=\"password1\" size=\"50\" value=\"$this->password1\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Salasana uudestaan:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"password\" name=\"password2\" size=\"50\" value=\"$this->password2\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Osoite:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"address\" size=\"50\" value=\"$this->address\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Postinumero:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"zip\" size=\"50\" value=\"$this->zip\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Postiosoite:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"postoffice\" size=\"50\" value=\"$this->postoffice\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Maa:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"country\" size=\"50\" value=\"$this->country\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Firma:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"company\" size=\"50\" value=\"$this->company\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Puhelin 1:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"phone1\" size=\"50\" value=\"$this->phone1\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Puhelin 2:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"phone2\" size=\"50\" value=\"$this->phone2\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">S&#228;hk&#246;posti:&nbsp;</td><td class=\"tab2\" colspan=\"2\">";
		echo "<input type=\"text\" name=\"email\" size=\"50\" value=\"$this->email\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">Vakituinen vuokraus paikka:&nbsp;</td><td class=\"tab2\" colspan=\"2\">\n";
		if ($this->location == ""){
			$this->location = "Tampere";
			$this->location_id = "1";
		}
		echo $locations->LocationDropDown("$this->location", "$this->location_id");
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><center>";
		echo "<div><input type=\"submit\" value=\"Talleta\" id=\"el09\"></div><br><br>";
		echo "\n<center><a href=\"index.php\"><img src=\"" . DIR_PICTURES . LANG . "/logo01.gif\" border=\"0\"></a>\n";
		echo "</form>\n";
		echo "</td></tr></table>\n";
	}

	/**
	 * Password
	 */
	public function NewPassword(){
		//$annettutunnus = $_POST["sstunnus"];
		//$annettuemail = $_POST["ssemail"];
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "<center><img src=\"" . DIR_PICTURES  . LANG ."/user_edit.gif\" border=\"0\">";
		echo "</td></tr></table></td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\">";
		echo "<form action=\"index.php\" method=\"post\" name=\"salasanavaihto\">";
		echo "<input type=\"hidden\" name=\"newPassword\" value=\"1\">\n";
		echo "<tr><td class=\"stylish-button\">K&#228;ytt&#228;j&#228;tunnus: </td><td class=\"tab2\" colspan=\"2\">\n";
		echo "<input type=\"password\" name=\"username\" size=\"40\" value=\"$this->username\"><br>";
		echo "</td></tr>\n";
		echo "<tr><td class=\"stylish-button\">S&#228;hk&#246;posti: </td><td class=\"tab2\" colspan=\"2\">\n";
		echo "<input type=\"text\" name=\"email\" size=\"40\" value=\"$this->email\">";
		echo "</td></tr>\n";
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<input type=\"submit\" value=\"Tilaan uuden salasanan\"> <input type=\"reset\" value=\"Tyhjenn&#228;\"></form>";
		echo "</table>";
	}

	public function SendForgetPassword($username, $email){
		
		if (!isset($db))
 			$db = new Database();
 		
 		$db->Database();
 		
		if (($username == "") && ($email != ""))
			$username = "ABCDEFGHIJKLMNOPQR";
			
		if (($username != "") && ($email == ""))
			$email = "ABCDEFGHIJKLMNOPQR";	
			
		$haku = $db->AskSQL("SELECT id, username, email FROM users WHERE username = '$username' OR email = '$email'");
		$tulos = mysql_fetch_row($haku);
		
		$to = $tulos[2]; 
		$from = "myynti@tila-autot.heurex.fi"; 
		$subject = "Salasana vaihdettu!";
			
		if (mysql_num_rows($haku) > 0){
			$kayttaja_ID = $tulos[0];
			srand((double)microtime()*1234567);
			$satunnaisluku = rand(100000,999999);
			$randompassu = "$satunnaisluku";
			$uusipassword = md5($randompassu);
			$db->UseSQL("UPDATE users set password = '$uusipassword' WHERE id = '$kayttaja_ID'");
			$message = $message ."<html><body bgcolor=\"#DCEEFC\"><center>"; 
			$message = "Teidän käyttäjätunnukselle <font color=\"red\">$tulos[1]</font> on keksitty uusi salasana.\n\n";
			$message = $message . "<br>Uusi salasana on: <font color=\"red\">$randompassu</font><br>";
			$message = $message . "Pystytte loggautumaan sisään käyttäjätunnuksella:<font color=\"red\">$tulos[1]</font> ja uudella salasanalla.\n";
			$message = $message . "Voitte vaihtaa salasanan toiseksi omien tietojen kautta antamalla uuden salasanan.\n\n";
			$message = $message . "</center>"; 
			$message = $message . "<br><br><font face=\"courier new\" size=\"3\">$tmpRow</font><br><br>Terveisin Tila-Autot.com";  
			$message = $message . "</body>"; 
			$message = $message . "</html>";
			$headers  = "From: $from\r\n"; 
			$headers .= "Content-type: text/html\r\n"; 
			mail($to, $subject, $message, $headers); 
			
			$output = "Uusi salasana on lähetetty osoitteeseen $tulos[2]. Loggaa sisään uudella salasanalla ja vaihda salasana sellaiseksi kuin haluat.";
		}
		
		if (mysql_num_rows($haku) < 1){
			$output = 1;
		}
		
		return $output;
	}

	/**
	 * Edit User
	 */
	public function EditUser($in_id, $thing){

		$this->id = $in_id;
		$this->user_id = $in_id;
		//$this->location2 = $location2;
		$this->thing = $thing;
					
		if (!isset($locations))
			$locations = new Location();
			
		if (!isset($FixDate))
			$fixdate = new FixDate();
			
		if (!isset($user2))
			$user2 = new User();	

		if (isset($_GET["location"]))				
			$this->location = $_GET["location"];
	 		 	
		$oikeus = $_SESSION['LogInUser']->oikeustaso;

		if (isset($_GET["ed"])=="1"){			
			$this->ReadPost();
		} else {
			$this->ReadUser($this->id);
		}
		
		if (isset($_GET["copy2new"])=="1"){
			$this->id = "";
			$thing = "new";
			$this->location ="";
			$this->project = ""; 
		}
		
		if (($thing == "edit") || ($thing == "new")){
			$this->changeday = time();
			$this->cadmin = $_SESSION['LogInUser']->id;
		}
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "<center><img src=\"" . DIR_PICTURES  . LANG ."/user_edit.gif\" border=\"0\">";
		echo "</td></tr></table></td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		/**
		 * Activated?
		 */
		if (($this->aktivointi != 100) && ($this->username != "")){
			if (($oikeus == $this->oikeustaso) || ($oikeus == 99) || (isset($_SESSION["LogInUser"]->location) == $this->location)){
				$aktivointi = "<img src=\"" . DIR_PICTURES  . LANG ."/activate.gif\" border=\"0\">\n";
			} else {
				$aktivointi = "<img src=\"" . DIR_PICTURES  . LANG ."/notactivate.gif\" border=\"0\">\n";
			}		
		}
		
		if (($this->aktivointi == 100) && ($this->username != ""))
			$aktivointi = "<img src=\"" . DIR_PICTURES  . LANG ."/activated.gif\" border=\"0\">";
					
		//echo "<table id=\"tabmenu2\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">";
			
		if ($thing == "edit"){
			echo "<form action=\"index.php\" method=\"post\" name=\"updateuser\">\n";
			echo "<input type=\"hidden\" name=\"page2\" value=\"updateuser\">\n";
			echo "<input type=\"hidden\" name=\"id\" value=\"$this->id\">";
			echo "<input type=\"hidden\" name=\"user_id\" value=\"$this->id\">";
			echo "<input type=\"hidden\" name=\"oikeustaso\" size=\"40\" value=\"$this->oikeustaso\">";
		}
		
		if ($thing == "new"){
			echo "<form action=\"index.php\" method=\"post\" name=\"newuser\">\n";
			echo "<input type=\"hidden\" name=\"page2\" value=\"newuser\">\n";
		}
		
		if ($thing != "edit" && $thing != "new"){
		} else {
			echo "<input type=\"hidden\" name=\"page\" value=\"user\">\n";
			echo "<input type=\"hidden\" name=\"location\" value=\"$this->location\">";
			echo "<input type=\"hidden\" name=\"password0\" value=\"$this->password0\">";
		}
		
		echo "<table width=\"100%\">";
		echo "<tr><td class=\"stylish-button\" width=\"30%\">K&#228;ytt&#228;j&#228;tunnus: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"username0\" size=\"40\" value=\"$this->username\">";
		} else {
			echo "$this->username&nbsp;";
		}
		echo "</td></tr>\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<tr><td class=\"stylish-button\">Salasana: </td><td class=\"tab2\" colspan=\"2\">\n";
			echo "<input type=\"password\" name=\"password1\" size=\"40\" value=\"\"><br>";
		} else {
			echo "<tr><td class=\"stylish-button\">Password: </td><td class=\"tab2\" colspan=\"2\">\n";
			echo "*******************";
		}
			
		echo "</td></tr>\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<tr><td class=\"stylish-button\">Salasana uudestaan: </td><td class=\"tab2\" colspan=\"2\">\n";
			echo "<input type=\"password\" name=\"password2\" size=\"40\" value=\"\">";
			echo "</td></tr>\n";
		}
		
		//echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Etunimi: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"firstname\" size=\"40\" value=\"$this->firstname\">";
		} else {
			echo "$this->firstname&nbsp;";
		}
					
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Sukunimi: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"lastname\" size=\"40\" value=\"$this->lastname\">";
		} else {
			echo "$this->lastname&nbsp;";
		}
					
		echo "</td></tr>\n";

		echo "<tr><td class=\"stylish-button\">S&#228;hk&#246;posti: </td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"email\" size=\"40\" value=\"$this->email\">";
		} else {
			echo "$this->email&nbsp;";
		}
					
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Osoite: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"address\" size=\"50\" value=\"$this->address\">\n";
		} else {
			echo "$this->address&nbsp;";
		}
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Postinumero: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"zip\" size=\"50\" value=\"$this->zip\">\n";
		} else {
			echo "$this->zip&nbsp;";
		}
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Postiosoite: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"postoffice\" size=\"50\" value=\"$this->postoffice\">\n";
		} else {
			echo "$this->postoffice&nbsp;";
		}
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Maa: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"country\" size=\"50\" value=\"$this->country\">\n";
		} else {
			echo "$this->country&nbsp;";
		}
		echo "</td></tr>\n";	

		echo "<tr><td class=\"stylish-button\">Firma: </td><td class=\"tab2\" colspan=\"2\">\n";
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"company\" size=\"50\" value=\"$this->company\">\n";
		} else {
			echo "$this->company&nbsp;";
		}
		echo "</td></tr>\n";	
		
		echo "<tr><td class=\"stylish-button\">Puhelin 1: </td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"phone1\" size=\"40\" value=\"$this->phone1\">";
		} else {
			echo "$this->phone1&nbsp;";
		}
					
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Puhelin 2: </td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<input type=\"text\" name=\"phone2\" size=\"40\" value=\"$this->phone2\">";
		} else {
			echo "$this->phone2&nbsp;";
		}
					
		echo "</td></tr>\n";
		
		if ($oikeus > "1"){
			echo "<tr><td class=\"stylish-button\">K&#228;ytt&#228;j&#228; tyyppi: </td><td class=\"tab2\" colspan=\"2\">\n";
		
			if (($thing == "edit") || ($thing == "new")){
				if ($oikeus > "1"){
					echo $this->AdminRightsDropDown($this->oikeustaso,"1");
				} else {
					echo "<input type=\"hidden\" name=\"oikeustaso\" size=\"40\" value=\"$this->oikeustaso\">";
					echo $this->AdminRightsDropDown($this->oikeustaso,"0");	
				}
			} else {
				echo $this->AdminRightsDropDown($this->oikeustaso,"0") . "&nbsp;";
				echo "<input type=\"hidden\" name=\"oikeustaso\" size=\"20\" value=\"$this->oikeustaso\">";
			}
			
			echo "</td></tr>\n";
		}
		
		echo "<tr><td class=\"stylish-button\">Vakituinen vuokraus paikka: </td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo $locations->LocationDropDown("",$this->location);
			echo "</td></tr>\n";
		} else {
			echo $this->location_name . "&nbsp;"; //$locations->ReadLocation($this->location) . "&nbsp;";
		}
		
		echo "</td></tr>\n";

		echo "<tr><td class=\"stylish-button\">Information: </td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (($thing == "edit") || ($thing == "new")){
			echo "<textarea name=\"information\" rows=\"3\" cols=\"45\">$this->information</textarea>";
		} else {
			echo "$this->information&nbsp;";
		}
		
		echo "</td></tr>\n";
		
		echo "<tr><td class=\"stylish-button\">Viimeinen muutos: </td><td class=\"tab2\" colspan=\"2\">\n";
		
		if (!isset($user2))
			$user2 = new User();
				
		$this->changeday = $fixdate->ReturnDate($this->changeday);
		$temp = date("Y-m-d",$this->changeday);
		
		echo "$this->cadmin_name $temp";
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td>";
		
		if (($thing == "edit") || ($thing == "new")){			
			echo "<div><input type=\"submit\" value=\"Submit\" id=\"el09\"></div></td>\n";
			echo "</form>";
			echo "</td></tr></table>";
		} else {
			echo "</td></tr></table>";
			if (($_SESSION['LogInUser']->id==$this->id)||($oikeus > "1")) {
				echo "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
				echo "<td class=\"tab\"><a href=\"index.php?page=user&id=$this->id&user_id=$this->id&edit=1\"><img src=\"" . DIR_PICTURES  . LANG ."/small_edit.gif\" border=\"0\"></a></td>\n";

				if ($oikeus > "1"){
					echo "<td class=\"tab\"><a onclick=\"return confirmSubmitUSER()\" href=\"index.php?page=user&id=$this->id&user_id=$this->id&delete=1\"><img src=\"" . DIR_PICTURES  . LANG ."/small_delete.gif\" border=\"0\"></a></td>\n";
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
 	 * Activate user
 	 */
	public function UserActivate($id){
		if (!isset($db))
			$db = new Database();
			
		$oikeus = $_SESSION['LogInUser']->oikeustaso;
		
		$sql = "SELECT * FROM users WHERE id = '$id' AND aktivointi < '100'";
		$haku = $db->AskSQL("$sql");
		$tulos = mysql_fetch_row($haku);
		
		//echo "$sql<br>$oikeus = $tulos[5]<br>";
		
		if (($oikeus == $tulos[5]) || ($oikeus == 99) || (isset($_SESSION['LogInUser']->location) == $tulos[7])){	

			if (mysql_num_rows($haku) > 0){
				$sql = "UPDATE users SET aktivointi = '100', oikeustaso = '1' WHERE id = '$id'";
				//echo "$sql<br>";
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
		echo "username $this->username"; 
		
		/*if (!preg_match("/^[a-�A-�0-9_]{1,254}$/",$this->username)) { 
			$output = "10";
			return $output;
    	}
		*/
		
  		/*echo "username "; 	
		if ($this->username!="" && $_SESSION['Search']->CheckText($this->username,11) == 11) { 
			$output = "11";
			return $output;
		}	
		*/
		
		//echo "password1 "; 	
		if ($this->password1!="" && $_SESSION['Search']->CheckText($this->password1,11) == 11) { 
			$output = "11";
			return $output;
		}	
		
		//echo "password2 "; 	
		if ($this->password2!="" && $_SESSION['Search']->CheckText($this->password2,12) == 12) { 
			$output = "12";
			return $output;
		}	
		
		//echo "name "; 
		if ($_SESSION['Search']->CheckText($this->firstname . " " . $this->lastname,13) == 13) { 
			$output = "13";
			return $output;
		}

		//echo "Email "; 
		//$pattern = "~^([a-�A-�0-9\.|-|_]{1,60})([@])";
		//$pattern .="([a-�A-�0-9\.|-|_]{1,60})(\.)([A-Za-z]{2,3})$";
		
		$pattern="/([\s]*)([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*([ ]+|)@([ ]+|)([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,}))([\s]*)/i"; 
		
		if ($this->email != "" && preg_match($pattern,$this->email,$regs)) { 
	  	} else {
	    	$output = "14"; 
	    	return $output;
    	}
    	
		if ($this->phone1!="" && !preg_match("/^([0-9+\-\+]{0,30})$/",$this->phone1)) { 
			$output = "15";
			return $output;
    	}
		
 	//	if ($this->information!="" && $_SESSION['Search']->CheckText($this->information,16) == 16) { 
	//		$output = "16";
	//		return $output;
	//	}	
		
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
			
		if (!isset($user2))
			$user2 = new User();
			
		$this->location_name = $locations2->ReadLocation($this->location);
		$user2->ReadUser($this->cadmin);	
		$this->cadmin_name = $user2->username;	
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
			
		if ($_POST["oikeustaso"]=="" || $_POST["oikeustaso"]=="0")
			$_POST["oikeustaso"]="1";

		$_POST["aktivointi"] = "100";
		
		$this->ReadPost();
		//$this->PrintUser();
		
		if (isset($_POST["locationname"]))	
			$this->locationname = $_POST["locationname"];
			
		$this->cadmin = $_SESSION['LogInUser']->id;
		$this->changeday = date("Y-m-d H:i:s",time());
		
		$this->GetNames();
		
		$check_user = $this->CheckUser();
		
		if ($check_user!=0){
			return $check_user;
		}
		
	   	$this->username=$this->username0;
		
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
		
		if (($this->password1 == "") || ($this->password2 == "") || ($this->username0 == "") || ($this->firstname == "") || ($this->lastname == "") || ($this->email == "") || ($this->location == "")){
			$output = "2";
			return $output;
		}
		
		if ($this->password1 != $this->password2){
			$output = "3";
			return $output;
		}
		
		$this->password = md5($this->password1);
		
		$this->user_ip = $this->getip();
				
		$sql = "INSERT INTO users (username, password, firstname, lastname, email, address, " .
		"zip, postoffice, country, company, phone1, phone2, oikeustaso, " .
		"location, aktivointi, project, phone, information, cadmin, changeday, location_name, project_name, cadmin_name, ip) " .
		"VALUES ('$this->username' , '$this->password', '$this->firstname', '$this->lastname', '$this->email', '$this->address', " .
		"'$this->zip', '$this->postoffice', '$this->country', '$this->company', '$this->phone1', '$this->phone2', " .
		"'$this->oikeustaso', '$this->location', '$this->aktivointi', '0', " .
		"'$this->phone', '$this->information', '$this->cadmin', NOW(), " .
		"'$this->location_name', 'Main', '$this->cadmin_name', '$this->user_ip')";
						
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
		$sql = "SELECT id FROM `users` WHERE username = '$this->username'";
		
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
		
		$this->ReadPost();
		
		$this->user_id = $in_id;
			
		if (isset($_SESSION['LogInUser']->id))	
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
		
		if (($this->username == "") || ($this->firstname == "") || ($this->lastname == "") || ($this->email == ""))	{
			$output = "2";
			return $output;
		}
		
		$this->user_ip = $this->getip();
		 
		if ($this->password1 != ""){			
			$sql = "UPDATE users SET username = '$this->username', " .
				   "password = '$this->password1', " .
				   "firstname = '$this->firstname', " .
				   "lastname = '$this->lastname', " .
				   "zip = '$this->zip', " .
				   "postoffice = '$this->postoffice', " .
				   "country = '$this->country', " .
				   "company = '$this->company', " .
				   "email = '$this->email', " .
				   "oikeustaso = '$this->oikeustaso', " .
			       "tunniste = '$this->tunniste', " .
				   "location = '$this->location', " .
				   "project = '$this->project', " .
				   "phone = '$this->phone', " .
				   "information = '$this->information', " .
				   "cadmin = '$this->cadmin', " .
				   "changeday = '$this->changeday', " .
				   "location_name='$this->location_name', " .
				   "project_name='$this->project_name', " .
				   "cadmin_name='$this->cadmin_name', " .
				   "ip='$this->user_ip' " .
				   "WHERE id = '$this->id'";
		}	
		
		if ($this->password1 == ""){
			$sql = "UPDATE users SET username = '$this->username', " .
				   "firstname = '$this->firstname', " .
				   "lastname = '$this->lastname', " .
				   "zip = '$this->zip', " .
				   "postoffice = '$this->postoffice', " .
				   "country = '$this->country', " .
				   "company = '$this->company', " .
				   "email = '$this->email', " .
				   "oikeustaso = '$this->oikeustaso', " .
				   "tunniste = '$this->tunniste', " .
				   "location = '$this->location', " .
				   "project = '$this->project', " .
				   "phone = '$this->phone', " .
				   "information = '$this->information', " .
				   "cadmin = '$this->cadmin', " .
				   "changeday = '$this->changeday', " .
				   "location_name='$this->location_name', " .
			       "project_name='$this->project_name', " .
				   "cadmin_name='$this->cadmin_name',  " .
				   "ip='$this->user_ip' " .
				   "WHERE id = '$this->id'";
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
			$sql = "INSERT INTO deleted_users (id, username, password, firstname, lastname, email, address, zip, postoffice, country, company, " .
				"phone1, phone2, oikeustaso, location, aktivointi, project, phone, information, cadmin, changeday) VALUES " .
				"('$this->id', '$this->username' , '$this->password', '$this->firstname', '$this->lastname','$this->email', '$this->address', ". 
				"'$this->zip','$this->postoffice', '$this->country', '$this->company', '$this->phone1', '$this->phone2', '$this->oikeustaso', " .
				"'$this->location', '$this->aktivointi', '$this->project', '$this->phone', '$this->information', '$this->cadmin', NOW())";
	
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
		
		/**				
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
		*/
		
		$sql = "SELECT * FROM accessories WHERE iperson = '$in_user'";
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id: " . $rivi[0]." " . $rivi[2] ." " . $rivi[3];
			return "13";
		}
		
		/*
		$sql = "SELECT * FROM flash_adapters WHERE iperson = '$in_user'"; // OR cadmin = '$in_user'
		
		$haku = $db->AskSQL($sql);
		
		if (mysql_num_rows($haku) > 0){
			$rivi = mysql_fetch_row ($haku);
			$_GET["pro_del_err"] = "id: " . $rivi[0]." " . $rivi[1] ." " . $rivi[2];
			return "14";
		}
		*/
		
		return 0;
	}
	
	public function UpdateOtherUser($username, $firstname, $lastname, $email, $location, $oikeustaso, $id, $project, $phone, $information){
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
				
		if (($username == "") || ($firstname == "") || ($lastname == "") || ($email == "") || ($location == "") || ($oikeustaso == "")){
			$output = "Update didn't success! <br><br>You didn't put all needed information. Add needed information and try again.";
			return $output;
		}
			   
		$db->UseSQL("UPDATE users SET username = '$username', " .
				"firstname = '$firstname', " .
				"lastname = '$lastname', " .
				"email = '$email', " .
				"oikeustaso = '$oikeustaso', " .
				"location = '$location', " .
				"project = '$project', " .
				"phone = '$phone', " .
				"information = '$information' " .
				"WHERE id = '$id'");		
		
		$output = "User information update successfully!";
		
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
			$this->firstname = "Admin";
			$this->lastname = "Administrator";
			$this->email = "myynti@heurex.fi";
			$this->address = "Hyllilänkuja 5B";
			$this->zip = "33730";
			$this->postoffice = "Tampere";
			$this->country = "FI";
			$this->company = "Heurex Oy";
			$this->phone1 = "040-4166005";
			$this->phone2 = "040-5616629";
			$this->oikeustaso = "99";
			$this->tunniste = "";
			$this->location = "";
			$this->locationname = "Tampere, Finland";
			$this->project = "";
			$this->phone = "";
			$this->information = "Administrator";
			$this->user_ip = $this->getip();
			$sql = "INSERT INTO users (username, password, firstname, lastname, email, address, zip, postoffice, country, company, ";
			$sql = $sql . "phone1, phone2, oikeustaso, location, aktivointi, project, phone, information, cadmin, changeday, ip) VALUES ";
			$sql = $sql . "('$this->username' , '$this->password', '$this->firstname', '$this->lastname','$this->email', '$this->address', ";
			$sql = $sql . "'$this->zip','$this->postoffice', '$this->country', '$this->company', '$this->phone1', '$this->phone2', '$this->oikeustaso', '$this->location', '$this->aktivointi', '$this->project', '$this->phone', '$this->information', '$this->cadmin', NOW(), '$this->user_ip')";
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
		//echo "Loggaan: $in_username, $in_password<br>$sql<br>";
		$haku = $db->AskSQL("$sql");
		$rivi = mysql_fetch_row($haku);
		$this->user_id = $rivi[0];
		$this->username = $rivi[1];
		$this->password = $rivi[2];
		$this->location = $rivi[15];
		
		//echo "Loggaan: $this->user_id, $this->username, $this->password, $this->location<br>";
		
		$sql = "SELECT * FROM location WHERE id = '$this->location'";
		$haku2 = $db->AskSQL("$sql");
		$tulos2 = mysql_fetch_row($haku2);
		
		if ($rivi[16] == 1){
			$output = "User account has not yet activated!<br><br>Yeo can use this system then when your account is activated by administrator.<br>Saat ilmoituksen sähköpostilla, kun tunnuksesi on aktivoitu.";
			return $output;
		}
		
		if (mysql_num_rows($haku) > 0){
			$this->id = $rivi[0];
			$this->user_id = $rivi[0];
			$this->username = stripslashes(nl2br($rivi[1]));
			$this->username0 = stripslashes(nl2br($rivi[1]));
			$this->password = $rivi[2];
			$this->password0 = $rivi[2];
			$this->password1 = $rivi[2];
			$this->password2 = $rivi[2];
			$this->firstname = stripslashes(nl2br($rivi[3]));
			$this->lastname = stripslashes(nl2br($rivi[4]));
			$this->email = stripslashes(nl2br($rivi[5]));
			$this->address = $rivi[6];
			$this->zip = $rivi[7];
			$this->postoffice = $rivi[8];
			$this->country = $rivi[9];
			
			if ($this->country == ""){
				$this->country = "FI";
			}
			
			$this->company = $rivi[10];
			$this->phone1 = $rivi[11];
			$this->phone2 = $rivi[12];
			$this->oikeustaso = $rivi[13];
			$this->tunniste = $rivi[14];
			$this->location = $rivi[15];
			$this->aktivointi = $rivi[16];
			$this->project = $rivi[17];
			$this->phone = stripslashes(nl2br($rivi[18]));
			$this->information = stripslashes(nl2br($rivi[19]));
			$this->cadmin = $rivi[20];
			$this->changeday = $rivi[21];
			$this->location_name = $rivi[22];
			$this->project_name = $rivi[23];
			$this->cadmin_name = $rivi[24];	
			
			$this->address = $this->ReplaceFont($this->address);
			$this->postoffice = $this->ReplaceFont($this->postoffice);
			$this->information = $this->ReplaceFont($this->information);
				
			$output = "Sign-up complete!";

			return $output;
		}	
			
		if (mysql_num_rows($haku) < 1){
			$this->id = "";
	    	$this->username = "";
        	$this->password = "";
			$this->firstname = "";
			$this->lastname = "";
	      	$this->email = "";
			$this->address = "";
			$this->zip = "";
			$this->postoffice = "";
			$this->country = "";
			$this->company = "";
			$this->phone1 = "";
			$this->phone2 = "";
        	$this->oikeustaso = 0;
			
			if (isset($sessio_id))	
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
		$this->address = "";
		$this->postoffice = "";
		$this->country = "";
		$this->company = "";
		$this->phone1 = "";
		$this->phone2 = "";
    	$this->oikeustaso = 0;
		
		if (isset($sessio_id))
			$this->tunniste = $sessio_id;
			
		$this->location = "";
		$this->project = "";
		$this->phone = "";
		$this->information = "";
		$_SESSION['LogInUser']->oikeustaso = 0;
		session_destroy();
		$output = "You are now logout from system!";
		return $output;
	}

	public function HaeKayttajanOikeustaso(){
		if ($this->oikeustaso == 1)
			return "Normal user";
		
		if ($this->oikeustaso == 99)
			return "Administrator";
					
		return "$this->oikeustaso";

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
	 * Get own information
	 */
	public function OwnInformation(){
		$annettutunnus = $user->tunnus;
		$annettunimi = $user->nimi;
		$annettuemail = $user->email;
		$annettusijainti = $_POST["uusisijainti"];
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "Omat tiedot";
		echo "</td></tr></table></td></tr></table>";
		
		echo "$pagestart$logo</td></tr>\n";
		echo "<tr><td><img src=\"pictures/" + $lang + "profile_iso.gif\" border=\"0\"><form action=\"index.php\" method=\"post\" name=\"profiilipaivitys\"><input type=\"hidden\" name=\"profiilipaivitys\" value=\"1\">";
		echo "This form you can update your information and change password. <br>Let password empty if you want to keep old password.<br><br>User name<br><input type=\"text\" name=\"uusitunnus\" size=\"20\" value=\"$annettutunnus\">\n";
		echo "<br><br>New password: <br><input type=\"password\" name=\"uusisalasana1\" size=\"20\">\n";
		echo "<br><br>New password again: <br><input type=\"password\" name=\"uusisalasana2\" size=\"20\">\n";
		echo "<br><br>Name: <br><input type=\"text\" name=\"uusinimi\" size=\"20\" value=\"$annettunimi\">\n";
		echo "<br><br>Email: <br><input type=\"text\" name=\"uusiemail\" size=\"20\" value=\"$annettuemail\">\n";
		echo "<br><br><input type=\"submit\" value=\"Update\"></form>";
		echo "</table>";
	}

	/**
	 * Get own menu
	 */
	public function UserOwnMenu(){
		$kayttajan_id = $_SESSION['LogInUser']->id;
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
		echo "<table width=\"100%\"><tr>";
		echo "<td>";
		echo "<a href=\"index.php?page=user&user_id=" . $kayttajan_id . "&edit=1\" class=\"stylish-button\">Omat tietosi</a>&nbsp;";
		echo "<a href=\"index.php?page=user&user_id=" . $kayttajan_id . "&reserve=1\" class=\"stylish-button\">Vuokrauksesi</a>&nbsp;";
		echo "</td></tr></table></td></tr></table>";
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
		
		echo "$pagestart$logo</td></tr>\n";
		echo "<tr><td><img src=\"pictures/" + $lang + "kayttajapaivitys.gif\" border=\"0\"><form action=\"index.php\" method=\"post\" name=\"kayttajapaivitys\"><input type=\"hidden\" name=\"kayttajapaivitys\" value=\"1\"><input type=\"hidden\" name=\"kayttajaid\" value=\"$annettuid\">";
		echo "With this form you can update user information. <br><br>User name:<br><input type=\"text\" name=\"uusitunnus\" size=\"20\" value=\"$annettutunnus\">\n";
		echo "<br><br>Name: <br><input type=\"text\" name=\"uusinimi\" size=\"20\" value=\"$annettunimi\">\n";
		echo "<br><br>Email: <br><input type=\"text\" name=\"uusiemail\" size=\"20\" value=\"$annettuemail\">\n";
		echo "<br><br>Location:<br><select name=\"uusisijainti\">";
	
		for ($i = 2; $i <= 13; $i++){	
			$valittu = " ";
			
			if ($i <> 4){
				if ($annettusijainti == $i)
					$valittu = " SELECTED";
					
				if (($user->oikeustaso == $i) || ($user->oikeustaso == 99))	{
					echo "<option value=\"$i\" $valittu>$places[$i]</option>\n";
				}
			}	
		}	
		
		echo "</select><br><br>Oikeustaso:<br><select name=\"uusioikeustaso\">";
		
		$valittu = " ";
		
		if ($annettuoikeustaso == 1)
			$valittu = " SELECTED";
				
		if (($user->oikeustaso > 1) || ($user->oikeustaso == 99)){
			echo "<option value=\"1\" $valittu>Normal user</option>\n";
		}
		
		for ($i = 2; $i <= 13; $i++){	
			$valittu = " ";
			
			if ($i <> 4){
				if ($annettusijainti == $i)
					$valittu = " SELECTED";
					
				if (($user->oikeustaso == $i) || ($user->oikeustaso == 99)){
					echo "<option value=\"$i\" $valittu>$places[$i] administrator</option>\n"; }
			}	
		}	
	
		if (($user->oikeustaso == 99)){
			$valittu = " ";
			if ($annettuoikeustaso == 99)
				$valittu = " SELECTED";
			
			echo "<option value=\"99\" $valittu>Administrator</option>\n";
		}
		
		echo "</select>";
		echo "<br><br><input type=\"submit\" value=\"Update\"></form>";
		echo "</table>";
	}

	/**
	 * Show Users
	 */
	public function ShowUsersxxx(){
		echo "$pagestart$logo</td></tr>\n";
		echo "<tr><td><img src=\"pictures/" + $lang + "addnewuser.gif\" border=\"0\"><form action=\"index.php\" method=\"post\" name=\"puhelinlisays\"><input type=\"hidden\" name=\"kayttajalisays\" value=\"1\">";
		echo "Add new user to system:<br><br>Username:<br><input type=\"text\" name=\"uusitunnus\" size=\"20\">\n";
		echo "<br><br>Password: <br><input type=\"text\" name=\"uusisalasana\" size=\"20\">\n";
		echo "<br><br>Name: <br><input type=\"text\" name=\"uusinimi\" size=\"20\">\n";
		echo "<br><br>Email address: <br><input type=\"text\" name=\"uusiemail\" size=\"20\">\n";
		echo "<br><br>Location:<br><select name=\"uusisijainti\">";
		
		for ($i = 2; $i <= 13; $i++){	
			if ($i <> 4){
				if (($this->oikeustaso == $i) || ($this->oikeustaso == 99)){
					echo "<option value=\"$i\">$places[$i]</option>\n";
				}	
			}	
		}			
		
		echo "</select><br><br>Rights:<br><select name=\"uusioikeustaso\">";
		if (($this->oikeustaso > 1) || ($this->oikeustaso == 99))
		{
			echo "<option value=\"1\">Normal user</option>\n";
		}
		
		for ($i = 2; $i <= 13; $i++){	
			if ($i <> 4){
				if (($this->oikeustaso == $i) || ($this->oikeustaso == 99)){
					echo "<option value=\"$i\">$places[$i] admin</option>\n";
				}	
			}	
		}
	
		if (($this->oikeustaso == 99)){
			echo "<option value=\"99\">System administrator</option>\n";
		}
		
		echo "</select><br><br><input type=\"submit\" value=\"Add user\"> <input type=\"reset\" value=\"Clear form\"></form>";
		echo "</table>";
		echo "$tablenormal";
		echo "<td class=\"td_phonelistheader\">Username</td><td class=\"td_phonelistheader\">Name</td><td class=\"td_phonelistheader\">Email address</td><td class=\"td_phonelistheader\">Admin rights</td><td class=\"td_phonelistheader\">Location</td><td class=\"td_phonelistheader\">State</td></tr>";
		$action = $this->NaytaKayttajataulukko();
		echo "$action";
		echo "</table>";	
	}
	
	/**
	 * N�yt� loggautunut henkil�
	 */
	public function ShowCashUser($in_id1){	
		$this->ReadUser($in_id1);
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td class=\"stylish-button\">";
		echo "Asiakas";
		echo "</td></tr></table></td></tr></table>";
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\">";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Nimi :</td><td class=\"stylish-cRows\">$this->firstname $this->lastname</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Osoite :</td><td class=\"stylish-cRows\">$this->address</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Postinumero :</td><td class=\"stylish-cRows\">$this->zip</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Postiosoite :</td><td class=\"stylish-cRows\">$this->postoffice</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Maa :</td><td class=\"stylish-cRows\">$this->country</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Firma :</td><td class=\"stylish-cRows\">$this->company</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Puhelin :</td><td class=\"stylish-cRows\">$this->phone1</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">Puhelin2 :</td><td class=\"stylish-cRows\">$this->phone2</td></tr>";
		echo "<tr><td class=\"stylish-button\" width=\"130\">e-mail :</td><td class=\"stylish-cRows\">$this->email</td></tr>";
		echo "</table></td></tr></table>";
	}

	/**
	 * IP-Address
	 */
	function getip() {
		return $_SERVER["REMOTE_ADDR"];
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
	/**
		var $name;
	var $email;
	var $address;
	var $postoffice;
	var $phone1;
	var $phone2;
	var $oikeustaso;
	var $tunniste;
	var $location;
	*/
}

?>

<?php
/**
 * Heurex Rental 0.1
 * index.php
 * 14.04.2014
 */ 
?>
<?php 
//if (!isset($_SESSION['Refresh']))
	//$_SESSION['Refresh'] = "60";;Content-Type:text/html;charset=UTF-8
$refresh = 60;
	//echo $refresh . " " . $_SESSION['Refresh'] . "<br>";
	
header('Refresh:$refresh'); 

/**
 * Add Classes.
 */
 
//ob_start();

include 'includes/classes/Database.php';
include 'includes/classes/User.php';
include 'includes/classes/Location.php';
include 'includes/classes/Car.php';
include 'includes/classes/Car_AccType.php';
include 'includes/classes/Accessories.php';
include 'includes/classes/Reserve.php';
include 'includes/classes/Advertising.php';
include 'includes/classes/FixDate.php';
include 'includes/classes/Search.php';
include 'includes/Counter.php';

//include	'includes/classes/ExcelExport.php';
include('includes/configure.php');

/**
 * New Session
 */
if (isset($_SESSION) == "") {
  session_start();
}
$sessio_id = session_id();

//header("Content-Type: text/html; charset=UTF-8");

$logo = "<br><br><img src=\"" . DIR_PICTURES . "/logo01.gif\" border=\"0\"><br><br>\n";
$pagestart = "<table width=\"" . WEB_WIDTH . "\"><tr><td colspan=\"6\"><center><br><img src=\"images/logo.gif\"><br><a href=\"index.php\"><img src=\"" . DIR_PICTURES . "/logo01.gif\" border=\"0\"></a></td></tr></table>\n";
$tablenormal = "<table width=\"" . WEB_WIDTH . "\"><tr>";

if (!isset($user))
	$user = new User();

if(isset($_GET["user_id"]))
	$user_id = $_GET["user_id"];

if (isset($_POST["username"]))
	$username = $_POST["username"];
	
if (isset($_POST["username0"]))
	$username0 = $_POST["username0"];
	
?>

<script type="text/JavaScript">
	
	var TableBackgroundNormalColor = "#ffffff";
	var TableBackgroundMouseoverColor = "#9999ff";
	
	function eventWindow(url){
		event_popupWin = window.open('includes/classes/event.php?' + url, 'event', 'resizable=no, scrollbars=no, toolbar=no,width=250,height=230');
		event_popupWin.opener = self;
	}

	function changeImage(url) {
		document.images['selectedimage'].src = url;
	}

	// These two functions need no customization.
	function ChangeBackgroundColor(row) {
		row.style.backgroundColor = TableBackgroundMouseoverColor;
	}
	
	function RestoreBackgroundColor(row) {
		row.style.backgroundColor = TableBackgroundNormalColor;
	}

	function toggle($x){
		cEmptySlot = "#58A222";
		cPartly = "#FC0";
		cFull = "#D60D3F";
		
		var x = document.getElementById($id); 
			
		if ( x.style.backgroundColor == cEmptySlot) {
			x.style.backgroundColor = cPartly;
			break toggle;
		} 
		if (x.style.backgroundColor == cPartly) {
			x.style.backgroundColor = cEmptySlot;
			break toggle;
		} 
	}
</script>

<link href="includes/storestyle.css" rel="stylesheet" type="text/css" />
 
<?php
if (!isset($_SESSION["kayttajatunniste"])){
	if (!isset($_SESSION['LogInUser']))
		$_SESSION['LogInUser'] = new User();
	
	$tunniste = date("YmdHis");
	srand((double)microtime()*1234567);
	$satunnaisluku = rand(100000,999999);
	$_SESSION["kayttajatunniste"] = "$tunniste-$satunnaisluku";
	$tunniste = $_SESSION["kayttajatunniste"];
	$_SESSION['LogInUser']->tunniste = $tunniste;
}

$vcopy = INFO_COPY + " <a href=\"http://www.heurex.fi\">www.heurex.fi</a><br>";

/**
 * If Session...
 */
if (!isset($db)){
 	$db = new Database();
 	$db->Database();
}

if (!isset($_SESSION['LogInUser']))
	$_SESSION['LogInUser'] = new User();
			
if (!isset($user))
	$user = new User();
	
if (!isset($locations))
	$locations = new Location();
	
if (!isset($car))
	$car = new Car();
	
if (!isset($accessories))
	$accessories = new Accessories();
	
if (!isset($car_acctype))
	$car_acctype = new Car_AccType();

if (!isset($reservations))
	$reservations = new Reserve();
	
if (!isset($advertising))
	$advertising = new Advertising();
	
if (!isset($FixDate))
	$fixdate = new FixDate();
	
if (!isset($counter))
	$counter = new Counter();

if (!isset($_SESSION['Search']))
	$_SESSION['Search'] = new Search();
			
if (isset($_GET["phpinfo"]) == 1)
	phpinfo();
	
if (isset($_GET["page"])!= "")	
    $_POST["product"] = $_GET["page"];

if (isset($_POST["page"])!= "")	
    $_POST["product"] = $_POST["page"];
      
if (isset($_POST["page2"]) == "")
	$_POST["page2"] = "searchform";

if (isset($_POST["product"])=="")
 	$_POST["product"] ="all";
	
$page = $_POST["product"];

$page2 = $_POST["page2"];

$_SESSION['Search']->page2 = $page2;

if ($page2=="searchform"){
	$page = $_POST["product"];
	$_SESSION['Search']->product = $page;
	$_GET["page"] = $page;
}	

if ($page2=="newform"){
	$page = $_POST["product"];
	$_GET["page"] = $_POST["product"];
	$_SESSION['Search']->product = $page;
	$_GET["page"] = $page;
}	

if (isset($_POST["product"]) == "")
	$_POST["product"] = "car";

if (isset($_GET["page"]) == "")
	$_GET["page"] = $_POST["product"];

$page = $_GET["page"];

if ($page=='all')
	$page = "";
	
if ($_SESSION['Search']->product =="")
	$_SESSION['Search']->product = $page;

if ($page2 != "")
	$_SESSION['Search']->page2 = $page2;
	
if ($_SESSION['Search']->page2 == "")
	$_SESSION['Search']->page2 = $_POST["page2"];

if (isset($_GET["location"]) == ""){
	if(isset($_POST["location"]) && $_POST["location"] !== ""){
		$_GET["location"] = $_POST["location"];
	}
}
 
 //if(isset($_POST["location"]) && $_POST["location"] !== "") { kirjautumaan } else { etusivu }

/**
 *  Luodaan tarvittavat oliot SESSIO-muuttujien avulla, jos niita ei ole viela luotu
 */
 if(isset($_GET["newregister"]) && $_GET["newregister"] !== ""){
	$register = $_GET["newregister"];
}

if ($register ==""){
	if(isset($_POST["newregister"]) && $_POST["newregister"] !== ""){
		$register = $_POST["newregister"];
	}
}

$newPassword = "";

if(isset($_GET["newPassword"]) && $_GET["newPassword"] !== ""){
	$register = $_GET["newPassword"];
}

if(isset($_POST["newPassword"]) && $_POST["newPassword"] !== ""){
	$newPassword = $_POST["newPassword"];
}

$userReserve = "";

if(isset($_GET["reserve"]) && $_GET["reserve"] !== ""){
	$userReserve = $_GET["reserve"];
}

if(isset($_POST["reserve"]) && $_POST["reserve"] !== ""){
	$userReserve = $_POST["reserve"];
}

if(isset($_POST["login"]) && $_POST["login"] !== ""){
	$login = $_POST["login"];
}

if(isset($_POST["save"]) && $_POST["save"] !== ""){
	$save = $_POST["save"];
}

if(isset($_POST["list"])){
	$list = $_POST["list"];
}

if(isset($_GET["save"]) && $_GET["save"] !== ""){
	$save = $_GET["save"];
}

if(isset($_POST["username"]) && $_POST["username"] !== ""){
	$username = $_POST["username"];
}

if(isset($_POST["username0"]) && $_POST["username0"] !== ""){
	$username0 = $_POST["username0"];
}

	//echo "$page2 $userReserve <br>";
//echo "us0 $username0 <br>";

if(isset($_POST["password"]) && $_POST["password"] !== ""){
	$password = $_POST["password"];
}

if(isset($_GET["delete"]) && $_GET["delete"] !== ""){
	$delete = $_GET["delete"];
}
if(isset($_GET["show"]) && $_GET["show"] !== ""){
	$show = $_GET["show"];
}
if(isset($_GET["edit"]) && $_GET["edit"] !== ""){
	$edit = $_GET["edit"];
}
if(isset($_GET["new"]) && $_GET["new"] !== ""){
	$new = $_GET["new"];	
}

if ($page2=="newform"){
	$new="1";
	$_SESSION['Search']->Search();
}

if(isset($_GET["error"]) && $_GET["error"] !== ""){
	$error = $_GET["error"];
}

if(isset($_GET["location"]) && $_GET["location"] !== ""){
	$location = $_GET["location"];
}

if(isset($_POST["car_id"]) && $_POST["car_id"] !== ""){
	$car->car_id = $_POST["car_id"];
}

if(isset($_GET["car_id"]) && $_GET["car_id"] !== ""){
	$car->car_id = $_GET["car_id"];
}

if(isset($_POST["pic_id"]) && $_POST["pic_id"] !== ""){
	$car->pic_id= $_POST["pic_id"];
}

if(isset($_GET["pic_id"]) && $_GET["pic_id"] !== ""){
	$car->pic_id= $_GET["pic_id"];
}

$temp = $page . " " . $_SESSION['LogInUser']->username . " " . $_SESSION['LogInUser']->oikeustaso;

if (($page2 != "registration") && ($login == "1") && (isset($_POST["username"]) != "") && (isset($_POST["password"]) != "")){
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	//echo "login $username<br>";
	
	if (!isset($_SESSION['LogInUser']))
		$_SESSION['LogInUser'] = new User();
	
	if (!isset($_SESSION['Search']))
		$_SESSION['Search'] = new Search();
		
	$action = $_SESSION['LogInUser']->LogUserIn($username,$password);
			
	$sijainti = $_SESSION['LogInUser']->location;
	
	if (isset($_GET["location"]) == "")
		$_GET["location"] = $sijainti;
		
	if ($action == "Sign up did not work! <br> Check the ID and password for your spelling!")
		$td = "td_actionred";
	
	if ($action == "Sign-up complete!")
		$td = "td_actiongreen";
}

if (isset($_GET["logout"]) == "1"){
	$action = $_SESSION['LogInUser']->LogOutUser();
	$td = "td_actiongreen";
}

/**
 * Uusi salasana
 */
if ($newPassword == "1"){
	
	$username = $_POST["username"];
	$email = $_POST["email"];
	
	if (!isset($_SESSION['LogInUser']))
		$_SESSION['LogInUser'] = new User();

	$action = $_SESSION["LogInUser"]-> SendForgetPassword($username, $email);
	
	$page = "";
	$td = "td_actiongreen";
	$page = "user";
	if ($action!="0"){
		if ($action=="1")
			$td = "td_actionred";
			$action = "Syötit käyttäjätunnuksen ja/tai väärän email osoitteen. Tarkista oikeinkirjoitus ja yritä uudelleen.";	
			$pass = "1";		
		} else {	
		$new = "";
		$show = "";
		$edit = "";
		$pass = "";
		$page2 = "newform";	
	}	
}

/**
 * Registration
 */
if (($page2=="registration") && ($register == "1") && ($save=="1")){
	
	$username = $_POST["username0"];
	$password = $_POST["password"];
	
	if (!isset($_SESSION['LogInUser']))
		$_SESSION['LogInUser'] = new User();
		
	$_POST["oikeustaso"] = "1";
	$_POST["aktivointi"] = "100";
	
	//echo "us $username <br>";
	//echo "us0 $username0 <br>";

	$action = $_SESSION["LogInUser"]->AddUser();
	
	//echo "us $username <br>";
	//echo "us0 $username0 <br>";

	$page = "";
	$td = "td_actiongreen";
	
	if ($action!="0"){
		$page = "user";
	 	$save="";
		$new="1";
		$_SESSION['LogInUser']->oikeustaso = 0;
		$td = "td_actionred";
		if ($action=="1")
			$action = "E-mail address <b>$email</b> is already in use! Enter another e-mail address and try again.";		
	
		if ($action=="2")
			$action  = "Adding a new user failed. All the required information is not filled.<br>Enter the missing information and try again.";
	
		if ($action=="3")
			$action = "Adding a new user failed. The passwords do not match.<br>Please re-enter your password twice.";				
		
		if ($action=="4")
			$action = "Entered User id <b>$username</b> is already in use. Enter another User id and try again.";				
			
		if ($action=="10") 
			$action = "Forbidden characters in User name[<b>" . $_SESSION["LogInUser"]->username . "</b>]-field.<br>Only letters and numbers are allowed.";
		 	
		if ($action=="11" || $action=="12") 
			$action = "Forbidden characters in password! Only letters and numbers allowed!<br>Check your writings and try again.";
				
		if ($action=="13") 
			$action = "Forbidden characters in name! Only letters and numbers allowed!<br>Check your writings and try again.";
			
		if ($action=="14") 
			$action = "Forbidden characters in email! Only letters, numbers and email characters are allowed!<br>Check your writings and try again.";
			
		if ($action=="15") 
			$action = "Wrong phonenumber! Only numbers, '+' and '-' allowed!<br>Phone mumber is like '+358-12-34567890'<br>Check your writings and try again.";
		
		if ($action=="16") 
			$action = "Forbidden characters in information! Only letters and numbers allowed!<br>Check your writings and try again.";	
					
		if ($action=="17")
			$action = "Incorrect location! Select other location than '- Location - '.<br>Check your selection and try again.";				
		} else {
		$action = "You can use system as soon as you want.";		
		$show = "";
		$edit = "";
		$page2 = "newform";	
		//$action = $_SESSION['LogInUser']->LogUserIn($username,$password);	
	}	
}

/**
 * Add user
 */
if (($page2 == "newuser") && ($_SESSION['LogInUser']->oikeustaso > 1)){	
	$action = $user->AddUser();	
	$page = "user";
	
	if ($action=="0") {	
		$_GET["id"] = $user->id;
		$_GET["user_id"] = $user->id;
		$user_id = $user->id;
		$new = "";
		$show = "1";
		$edit = "";
		$new = "";
		$action = "A new user was added successfully to database.";
		$td = "td_actiongreen";
	} else {
		$ed = "1";
		$new = "1";
		$td = "td_actionred";
		if ($action=="1") 
			$action = "E-mail address <b>$email</b> is already in use! Enter another e-mail address and try again.";		

		if ($action=="2") 
			$action  = "Adding a user failed. All the required information is not filled. Enter the missing information and try again.";

		if ($action=="3")
			$action = "Adding a new user failed. The passwords do not match.<br>Please re-enter your password twice.";				

		if ($action=="4")
			$action = "User id <b>$username</b> is already in use. Enter another User id and try again.";	
			
		if ($action=="10") 
			$action = "Forbidden characters in User id -field.<br>Only letters and numbers are allowed.";
			
		if ($action=="11" || $action=="12") 
			$action = "Wrong characters in password! Only letters and numbers allowed!<br>Check your writings and try again.";
				
		if ($action=="13") 
			$action = "Wrong characters in name! Only letters and numbers allowed!<br>Check your writings and try again.";
			
		if ($action=="14") 
			$action = "Forbidden characters entered in email! Only letters, numbers and email characters are allowed!<br>Check your writings and try again.";
			
		if ($action=="15") 
			$action = "Wrong phonenumber! Only numbers, '+' and '-' allowed!<br>Phone mumber is like '+358-12-34567890'<br>Check your writings and try again.";
		
		if ($action=="16") 
			$action = "Wrong characters in information! Only letters and numbers allowed!<br>Check your writings and try again.";	
		
		if ($action=="17")
			$action = "Incorrect location! Select other location than '- Location - '.<br>Check your selection and try again.";					
	}	
}
/**
 * Update User
 */
if ($page2 == "updateuser") {
	if(isset($_GET["user_id"]))
		$id = $_GET["user_id"];
	
	if(isset($_POST["location"]))
		$location = $_POST["location"];
	
	if ($id!=""){
		$user_id = $id;
	} else {
		if(isset($_POST["user_id"]))
			$user_id = $_POST["user_id"];
		$id = $user_id;
	}
	//print "$user_id<br>";
	$page = "user";
			
	if ($_SESSION['LogInUser']->oikeustaso > 1 || $_SESSION["LogInUser"]->id == $user_id){
		//print "$user_id<br>";
		$action = $user->UpdateUser($user_id);
		$td = "td_actiongreen";
		if ($action != "0"){
			$show = "";
			$edit = "1";
			$ed = "1";
			$td = "td_actionred";
			if ($action=="1") 
				$action = "Your e-mail address <b>$email</ b> have already been registered! Choose another e-mail address and try again";		
			
			if ($action=="2")
				$action  = "The upgrade will not work! <br><br>You do not meet all the required information. Fill in the missing information and try again.";
				
			if ($action=="3") 
				$action = "The upgrade will not work! <br><br>The passwords are not the same. Please check the spelling of your password and try again.";				

			if ($action=="4") 
				$action = "Entered User id <b>$username</b> is already in use.<br>Enter another User id and try again.";
				
			if ($action=="10") 
				$action = "Forbidden characters entered in username! Only letters and numbers allowed!<br>Check your writings and try again.";
				
			if ($action=="11" || $action=="12") 
				$action = "Forbidden characters entered in password! Only letters and numbers allowed!<br>Check your writings and try again.";
				
			if ($action=="13") 
				$action = "Forbidden characters entered in name! Only letters and numbers allowed!<br>Check your writings and try again.";
				
			if ($action=="14") 
				$action = "Forbidden characters entered in email! Only letters, numbers and email characters are allowed!<br>Check your writings and try again.";
				
			if ($action=="15") 
				$action = "Wrong phonenumber! Only numbers, '+' and '-' allowed!<br>Phone mumber is like '+358-12-34567890'<br>Check your writings and try again.";
			
			if ($action=="16") 
				$action = "Forbidden characters entered in information! Only letters and numbers allowed!<br>Check your writings and try again.";
				
			if ($action=="17")
				$action = "Incorrect location! Select other location than '- Location - '.<br>Check your selection and try again.";	
							
		} else {
			$new = "";
			$show = "1";
			$edit = "";
			$new = "";
			$action = "Updating user to database is successfully!";
		}
	}
}

/**
 * AktivoiKayttaja
 */
if (isset($_GET["activation"]) == 1 && $_SESSION['LogInUser']->oikeustaso > 1){
	$id = $_GET["user_id"];
	$user_id = $_GET["user_id"];
	
	$action = $user->UserActivate($user_id);
	
	//print "user_id $user_id HEI Aktivointi!<br>";
	
	if ($action != "0"){
		$_GET["page"] = "user";
		$_GET["edit"] = "1";
		$ed = "1";
		$td = "td_actionred";
		if ($action=="1")
			$output = "The user is not found or the user has already been activated!";	
				
		if ($action=="1") 		
			$output = "The user activation did not work! You rights are not enough, this feature is to perform his duties or the user has already activated.";
	} else {
		$output = "The user activation has been successfully!";
	}
	
	$_GET["page"] = "user";
	$_GET["show"] = "1";
}

/**
 *  Delete user
 */
if (($page == "user") && ($_SESSION['LogInUser']->oikeustaso > 1) && ($delete == 1)){
	$user_id = $_GET["user_id"];
	if (!isset($user))
		$user = new User();
	
	$user_id = $_GET["user_id"];
	$page = "user";

	if ($user_id==$_SESSION['LogInUser']->id){
		$action = "You can't delete yourself from system!";
		$td = "td_actionred";	
		$page = "user";
		$show = "1";
	} else {
		$action = $user->DeleteUser($user_id);
		$delete = "";
		//print "$action<br>";
		if($action !="0"){
			$td = "td_actionred";
			$page = "user";
			$show = "1";
			if ($action=="10") 
				$action = "This user can't be deleted because he/she is project '" . $_GET["pro_del_err"] . "' manager.";
				
			if ($action=="11") 
				$action = "This user can't be deleted because he/she is phone '" . $_GET["pro_del_err"] . "' inventory person.";
				
			if ($action=="12") 
				$action = "This user can't be deleted because he/she is SIM '" . $_GET["pro_del_err"] . "' inventory person.";
				
			if ($action=="13") 
				$action = "This user can't be deleted because he/she is accessory '" . $_GET["pro_del_err"] . "' inventory person.";
				
			if ($action=="14") 
				$action = "This user can't be deleted because he/she is flash addapter '" . $_GET["pro_del_err"] . "' inventory person.";

		} else {
			$page = "user";
			$user_id = "";
			$show = "";
			$edit = "";
			$action = "User has been deleted from database.";
		}
	}
}

/**
 * Add Car
 */
if (($page2 == "newcar") && ($_SESSION['LogInUser']->oikeustaso > 1)){	
	$action = $car->AddCar();	
	$page = "car";
	
	if ($action=="0") {	
		$_GET["id"] = $car->car_id;
		$_GET["car_id"] = $car->car_id;
		$car_id = $car->car_id;
		$new = "";
		$show = "1";
		$edit = "";
		$new = "";
		$action = "A new car was added successfully to database.";
		$td = "td_actiongreen";
	} else {
		$ed = "1";
		$new = "1";
		$td = "td_actionred";
		if ($action=="1") 
			$action = "Auton rekisteri kilpi ei kelpaa <b>$car->car_plate</b> se on jo k�yt�ss�! Valitse toinen rekisteti kilpi ja yrit� uudestaan.";		

		if ($action=="2") 
			$action  = "Adding a car failed. All the required information is not filled. Enter the missing information and try again.";			
		
		if ($action=="17")
			$action = "Incorrect location! Select other location than '- Location - '.<br>Check your selection and try again.";					
	}	
}
/**
 * Update car
 */
// echo "page: $page2";
if ($page2 == "updatecar") {
	if(isset($_GET["car_id"]))
		$id = $_GET["car_id"];
	
	if(isset($_POST["location"]))
		$location = $_POST["location"];
	
	if ($id!=""){
		$car_id = $id;
	} else {
		if(isset($_POST["car_id"]))
			$car_id = $_POST["car_id"];
		$id = $car_id;
	}
	//print "$car_id<br>";
	$page = "car";
			
	if ($_SESSION['LogInUser']->oikeustaso > 1){
		//print "$user_id<br>";
		$action = $car->UpdateCar($car_id);
		$td = "td_actiongreen";
		if ($action != "0"){
			$show = "";
			$edit = "1";
			$ed = "1";
			$td = "td_actionred";
			if ($action=="1") 
				$action = "Auton rekisteri kilpi ei kelpaa <b>$car->car_plate</b> se on jo k�yt�ss�! Valitse toinen rekisteti kilpi ja yrit� uudestaan.";		
			
			if ($action=="2")
				$action  = "The upgrade will not work! <br><br>You do not meet all the required information. Fill in the missing information and try again.";
				
			if ($action=="17")
				$action = "Incorrect location! Select other location than '- Location - '.<br>Check your selection and try again.";	
							
		} else {
			$new = "";
			$show = "1";
			$edit = "";
			$new = "";
			$action = "Updating user to database is successfully!";
		}
	}
}

/**
 *  Delete car
 */
if (($page == "car") && ($_SESSION['LogInUser']->oikeustaso > 1) && ($delete == 1)){
	$car_id = $_GET["car_id"];
	if (!isset($car))
		$car = new Car();
	
	$car_id = $_GET["car_id"];
	$page = "car";
	$action = $car->DeleteCar($car_id);
	$delete = "";
	//print "$action<br>";
	if($action !="0"){
		$td = "td_actionred";
		$page = "car";
		$show = "1";

	} else {
		$page = "car";
		$user_id = "";
		$show = "";
		$edit = "";
		$action = "car has been deleted from database.";
	}
}

if (isset($_SESSION['LogInUser']->oikeustaso) > 0)
{
	echo "<script LANGUAGE=\"JavaScript\">
	<!--
	
	function confirmSubmitKP(){
		var agree=confirm(\"Do you really want to delete user information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitUSER(){
		var agree=confirm(\"Do you really want to delete USER information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitSIM(){
		var agree=confirm(\"Do you really want to delete SIM-card information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitLOCATION(){
		var agree=confirm(\"Do you really want to delete Location information?\");
		if (agree)
			return true ;
		else
			return false ;
	}

	function confirmSubmitACCESSORY(){
		var agree=confirm(\"Do you really want to delete Accessory information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitACCTYPE(){
		var agree=confirm(\"Do you really want to delete Accessory type information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitRESERVATION(){
		var agree=confirm(\"Do you really want to delete reservation information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitBOOK(){
		var agree=confirm(\"Do you really want to book this item?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitRETURN(){
		var agree=confirm(\"Do you really want return this item?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function checkAll() {
		for (var j = 1; j <= 9; j++) {
			box = eval(\"document.extraform.extra_\" + j); 
			if (box.checked == false) box.checked = true;
   		}
	}

	function uncheckAll() {
		for (var j = 1; j <= 9; j++) {
			box = eval(\"document.extraform.extra_\" + j); 
			if (box.checked == true) box.checked = false;
   		}
	}

	function switchAll() {
		for (var j = 1; j <= 9; j++) {
			box = eval(\"document.extraform.extra_\" + j); 
			box.checked = !box.checked;
 		}
	}
	
	function toggleVert(section)  {
	  if (eval(section + \".style.display != 'none'\"))  
		{
		  eval(section + \".style.display='none'\");
		}
	  else 
		{
	  	  eval(section + \".style.display='block'\");
		}
	}

	function OpenVert(section)  {
	  eval(section + \".style.display='block'\");
	}
	
	function CloseVert(section)  {
	  eval(section + \".style.display='none'\");
	}
	
</script>\n";

}

/**
	require('includes/static_callbacks.php'); 
 **/

//if ($_GET["reserve_id"] != "")
//	$reserve_id = $_GET["reserve_id"];
	
if(isset($_GET["show"]) && $_GET["show"] !== ""){
	$show = $_GET["show"];
}

if(isset($_GET["edit"]) && $_GET["edit"] !== ""){
	$edit = $_GET["edit"];
}

if(isset($_GET["new"]) && $_GET["new"] !== ""){
	$new = $_GET["new"];	
}

if(isset($_GET["list"]) && $_GET["list"] !== ""){
	$list = $_GET["list"];	
}

if(isset($_GET["delete"]) && $_GET["delete"] !== ""){
	$delete = $_GET["delete"];
}

if(isset($_GET["save"]) && $_GET["save"] !== ""){
	$save = $_GET["save"];
}

$edtype = "1";

if(isset($_GET["edtype"])){
	$edtype = $_GET["edtype"];
}
	
if ($page2=="newform"){
	$new="1";
	$_SESSION['Search']->Search();
}

if(isset($_GET["error"]) && $_GET["error"] !== ""){
	$error = $_GET["error"];
}

if(isset($_GET["newregister"]) && $_GET["newregister"] !== ""){
	$register = $_GET["newregister"];
}

if(isset($_GET["location"]) && $_GET["location"] !== ""){
	$location = $_GET["location"];
}

if ($register ==""){
	if(isset($_POST["newregister"]) && $_POST["newregister"] !== ""){
		$register = $_POST["newregister"];
	}
}

$temp = $page . " " . $_SESSION['LogInUser']->username . " " . $_SESSION['LogInUser']->oikeustaso;
//$test_type = $_SESSION['Search']->TestPageType();

//echo "page:$temp\n location:$location_id id:$id reserve:$reserve return:$return register:$register<br>";
//echo "N:$new.S:$show.E:$edit.D:$delete lvl:" . $_SESSION['LogInUser']->oikeustaso . " Ok:" . $test_type . "<br>";
	
/**
 * Log user in!
 */	
//$ulocationname = $location -> ReadLocation($location); 

if(!isset($_POST["location"])|| $_POST["location"] == ""){
	$location = "1";
	$locationname = "Tampere, Finland";
}
if(!isset($_POST["location"])|| $_POST["location"] == ""){
	$ulocationname = "All";
}

$xx = " id=\"selectedtab\"";

/*
if ($_SESSION['Search']->s_product == "")
	$_SESSION['Search']->s_product = $page;
*/		

/**
 * Search tab
 */
//$_SESSION['Search']->SearchTab();

//print $_SESSION['Search']->page2 . " " . $_SESSION['Search']->product . "<br>";

if ($page2=="newform"){
	$new="1";
	$_SESSION['Search']->Search();
}

if ($action != "")
	echo "<center><table width=\"1074\"><tr><td class=\"$td\"><b>$action</b></td></tr></table>";
	
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fi">
<head>
<title>Tila-Autot, Tervetuloa verkkokauppaamme!</title>
</head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="keywords" content="tila-autot, myynti, klapituli, vuokraus, paketti, auto, peräkärry, asuntoauto, asuntovaunu, halpa" />
<meta name="description" content="" /><meta http-equiv="imagetoolbar" content="no" />
<meta name="author" content="Markku Tauriainen" />
<meta name="generator" content="system by MTT http://www.mtauriainen.com eLending" />
<body>
<?php
//<base href="http://localhost/tila-autot/"/>
/**
	login_buttons.php
	Log user in!
 */
//echo "test " . htmlentities("äää ööö ÄÄÅÅ", ENT_COMPAT, "UTF-8") . "<br>\n";

$userid = $_SESSION['LogInUser']->id;
$border_now = 0;
echo "<center>";
echo "<table border=$border_now height='1370'><tr><td width='1308' valign='top'><center>\n";
echo "<p><br>\n";
//Top LOGO
echo "<table border=$border_now width='1000'>";
echo "<tr><td colspan='3' height='100' width='1000'><center><br>\n";

echo "<table border=$border_now><tr><td height='180' width='1000' style=\"background:url(images/top_logo.png) no-repeat; \"></td></tr></table>";

echo "<table width=\"100%\" border=\"$border_now\"><tr><td align=\"right\" class=\"stylish-cBack\">";

if ( $userid==""){
	$_SESSION['LogInUser']->oikeustaso = 0;
}

//echo $_SESSION['LogInUser']->oikeustaso . " $page $userid";

if (($_SESSION['LogInUser']->oikeustaso == 0) && ($page != "register") && ($page != "password") && ($userid == "")){
	if (isset($_POST["username"]))
		$username = $_POST["username"];
	
	echo "<table width=\"1000\" border=\"$border_now\">";
	echo "<form action=\"index.php\" method=\"post\" name=\"login\">\n";
	echo "<td align=\"left\"><a href=\"index.php\" class=\"stylish-button\">P&#228;&#228;sivulle</a></td>";
	echo "<td align=\"right\"><input type=\"hidden\" name=\"login\" value=\"1\">";
	echo "K&#228;ytt&#228;j&#228;:<input type=\"text\" name=\"username\" size=\"15\" value=\"$username\">\n";
	echo "Salasana:<input type=\"password\" name=\"password\" size=\"15\">\n";
	echo "<input type=\"submit\" value=\"Loggaa sis&#228;&#228;n\" class=\"stylish-button\"></form>&nbsp;";
	if ($reservations->IsBasket() != 0){
		echo "<a href=\"index.php?page=ostoskori&\" class=\"stylish-button\">Vuokrakori</a>&nbsp;";
	}
	echo "<a href=\"index.php?page=user&newregister=1&new=1\" class=\"stylish-button\">Rekister&#246;idy</a>&nbsp;";
	echo "<a href=\"index.php?page=user&pass=0\" class=\"stylish-button\">Unohtunut salasana</a>";
	echo "</td>";
	echo "</tr></table>\n";
}

if (isset($userid) && $userid != ""){
	$_GET["show"] = $show;
	$_GET["edit"] = $edit;
	$_GET["new"] = $new;
	$_GET["list"] = $list;	
	$_GET["reserve"] = $reserve;	
	$_GET["copy2new"] = $copy2new;
	$_GET["delete"] = $delete;	
	$usershow = $_SESSION['LogInUser']->username;
	
	// Get user information
	$kayttajan_id = $_SESSION['LogInUser']->id;
	$kayttajan_nimi = $_SESSION['LogInUser']->username; 
	$kayttajan_sijainti = $_SESSION['LogInUser']->locationname;
	$kayttajan_oikeustaso = $_SESSION['LogInUser']->HaeKayttajanOikeustaso();
	
	echo "<table width=\"100%\" border=\"$border_now\"><td align=\"left\">";
	echo "<a href=\"index.php\" class=\"stylish-button\">P&#228;&#228;sivulle</a>&nbsp;</td>";
	echo "<td align=\"right\" class=\"stylish-button\">";
	echo "$kayttajan_nimi " . $_SESSION["kayttajatunniste"] . "</td>";
	echo "<td align=\"right\"><a href=\"index.php?page=user&user_id=" . $kayttajan_id . "&edit=1\" class=\"stylish-button\">Omat tiedot</a>&nbsp;";
	if ($reservations->IsBasket() != 0){
		echo "<a href=\"index.php?page=ostoskori&\" class=\"stylish-button\">Vuokrakori</a>&nbsp;";
		echo "<a href=\"index.php?page=kassa\" class=\"stylish-button\">Kassalle</a>&nbsp;";
	}	
	echo "<a href=\"index.php?logout=1\" class=\"stylish-button\">Kirjaudu ulos</a>";
	echo "</td>";
	echo "</tr></table>\n";
}
echo "</tr></table>\n";
/**
 * New tab
 */
if ($_SESSION['LogInUser']->oikeustaso == 99){
	echo "<table width=\"100%\" border=\"$border_now\"><tr><td align=\"right\" class=\"stylish-cBack\">";
	echo "<table width=\"100%\" border=\"$border_now\">";
	echo "<tr><td align=\"left\">"; 
	echo "<a href=\"index.php?page=car&list=1\" class=\"stylish-button\">Autot</a>&nbsp;";
	echo "<a href=\"index.php?page=accessory&list=1\" class=\"stylish-button\">Tarvikkeet</a>&nbsp;";
	echo "<a href=\"index.php?page=location&list=1\" class=\"stylish-button\">Toimipisteet</a>&nbsp;";
	echo "<a href=\"index.php?page=user&list=1\" class=\"stylish-button\">K&#228;ytt&#228;j&#228;t</a>&nbsp;";
	echo "<a href=\"index.php?page=counter&list=1\" class=\"stylish-button\">Tilastot</a>&nbsp;";
	echo "<a href=\"index.php?page=counter&list=2\" class=\"stylish-button\">Tilastot 2</a>&nbsp;";
	echo "<a href=\"index.php?page=counter&list=3\" class=\"stylish-button\">Tilastot 3</a>&nbsp;";
	echo "<a href=\"index.php?page=counter&list=4\" class=\"stylish-button\">Tilastot 4</a>&nbsp;";
	echo "</td></tr></table>\n";	
	echo "</td></tr></table>\n";
	
	/**
	 * new
	 */
	if ($page2=="newform"){
		$_SESSION['Search']->Search();
		$new = "1";
		$_GET["new"] = "1";
	}

	$nextpage = "";
	
	if($page==""){
		$page = "all";
	}

	if ($_SESSION['Search']->TestPageType() == "0"){
		if(isset($_GET["product"])){
			$page = $_GET["product"];
		}
		
		if($page==""){
			$page = "all";
		}

		if ($page=="car" || $page=="accessory" || $page=="user" || $page=="location" || $page=="counter"){

			/**
			 * Show cars
			 */
			if ($page == "car"){
				$car->ShowCars($location, $ulocationname,0);
				$page = $nextpage;
				$_SESSION['Search']->sql_car = "";
			}
			
			/**
			 * Show locations
			 */
			if ($page == "location"){
				
				if (!isset($location))
					$locations = new Location();
					
				$locations->ShowLocations($location, $ulocationname);
				$page = $nextpage;
				$_SESSION['Search']->sql_location = "";
			}
			
			/**
			 * Show users
			 */
			if ($page == "user"){
				$user->ShowUsers($location, $ulocationname);
				//$page = $nextpage;
				$_SESSION['Search']->sql_user = "";
			}
			
			/**
			 * Show counter
			 */
			if ($page == "counter"){
				$counter->ShowCounter();
				//$page = $nextpage;
				$_SESSION['Search']->sql_user = "";
			}
			
		}
	}

	if ($_SESSION['Search']->TestPageType() == "1"){		
		/**
		 * Accessories Show, add, edit, copy2new, delete
		 *
		 */
		if ($page == "accessory"){
			
			if ($new == "1")
				$accessories->EditAccessory("", $ulocationname,"new");
			
			if ($show == "1")
				$accessories->EditAccessory($accessory_id, $ulocationname,"show");
			
			if ($copy2new == "1")
				$accessories->EditAccessory($accessory_id, $ulocationname,"new");
			
			if ($edit == "1")
				$accessories->EditAccessory($accessory_id, $ulocationname,"edit");		
		} 
		
		/**
		 * Accessory types  Show, add, edit, copy2new, delete
		 *
		 */
		if ($page == "acctype"){
			
			if ($new == "1")
				$acctype->EditAccType("", $ulocationname,"new");
			
			if ($show == "1")
				$acctype->EditAccType($acctype_id, $ulocationname,"show");
			
			if ($copy2new == "1")
				$acctype->EditAccType($acctype_id, $ulocationname,"new");
			
			if ($edit == "1")
				$acctype->EditAccType($acctype_id, $ulocationname,"edit");	
			//print "index $id, $ulocationname, show<br>";	
		} 
				
		/**
		 * Reservations Show, add, edit, copy2new, delete
		 *
		 */
		 
		if ($page == "reservation"){
			if (!isset($reservations))
				$reservations = new Reserve();
				
			if ($reserve == "1"){
				//print "$reserve_id, $ulocationname, reserve<br>";
				$reservations->EditReservation($reserve_id, $ulocationname, "reserve");		
				$new == "";
				$show == "";
				$edit == "";
			}
			
			if ($return == "1"){
				//print "$reserve_id, $ulocationname, return<br>";
				$reservations->EditReservation($reserve_id, $ulocationname, "return");		
				$new == "";
				$show == "";
				$edit == "";
			}
			
			if ($new == "1") 
				$reservations->EditReservation("", $ulocationname, "new");
			
			if ($show == "1")
				$reservations->EditReservation($reserve_id, $ulocationname, "show");
			
			if ($copy2new == "1")
				$reservations->EditReservation($reserve_id, $ulocationname, "new");
			
			if ($edit == "1")
				$reservations->EditReservation($reserve_id, $ulocationname, "edit");			
		
		} 
	}	
}
	//echo "</td></tr></table>\n";
	
//echo "$page $reserve<br>";

if (($page == "yllapito") && (isset($_SESSION['LogInUser']->oikeustaso) > 1))	{

	/**
	 * Register
	 */
	//if ($page == "rekisterointi")
	//	$user->NewUserAccount();

	/**
	 * Password
	 */
	if ($page == "password")
		$user->NewPassword();

	/**
	 * Get own information
	 */
	if ($page == "omattiedot")
		$user->OwnInformation();

	/**
	 * Update profile
	 */
	if ($page == "paivitakayttaja"){
		$id = $_GET["user"];
		$user->UpdateUserInformation($id);
	}
}
	
if  ($car->car_id==""){
	$car->car_id = 1;
}

if  ($car->pic_id==""){
	$car->pic_id = 1;
}
//echo "$list <br>";
/**
 * Delete old ones
 */
$car->Calendar_Remove_Old();

$advertising->ad_leftbox="1";
$advertising->ad_top_middlebox="1";
$advertising->ad_bottom_middlebox="1";
$advertising->ad_rightbox="1";

$end_tag = "</td></tr></table></body></html>\n";	

/**
 * Vasen boxi
 */
echo "</td></tr><tr>";
echo "<td height='480' valign='top' width='110'>";
$car->CarTypeList();
echo "<br>";

/**
 * Mainos vasemmassa boxissa
 */
if ($advertising->ad_leftbox="1")
	$advertising->Adbox();
	
echo "</td>";

/**
 * Keskusta
 */
echo "<td align='top' valign='top' height='480'>";

/**
 * Suomen halvimmat tila-autot!
 */
if ($page == ""){
	echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\">";
	echo "<table width=\"100%\"><tr><td class=\"stylish-button\">";
	echo "<center>Suomen halvimmat tila-autot!";
	echo "</td></tr></table></td></tr></table>";
}

/**
 * User Show, add, edit, copy2new, delete
 *
 */ 
$pass = "";
if(isset($_GET["pass"]))
	$pass = $_GET["pass"];

$reserve = "";
if(isset($_GET["reserve"]))
	$reserve = $_GET["reserve"];
	
//echo "$page $reserve<br>";

if ($page == "user"){
	if (!isset($user))
		$user = new User();
	
	if(isset($_GET["user_id"]))
		$user_id = $_GET["user_id"];

	if ($register=="1"){
		if (($action=="")||($action!="0")){ 
			if ($register == "1"){
			
				if (!isset($_SESSION['LogInUser']))
					$_SESSION['LogInUser'] = new User();
					
				$_SESSION["LogInUser"]->NewUserAccount();
				
				$page = "";
				$new = "";
				$edit = "";
				$show = "";
				$register = "";
				echo "</td>\n";
				if ($advertising->ad_rightbox == "1"){
					require('includes/car_list.php');
				}
				echo "</td></tr><tr><td colspan=\"3\">\n";
				$advertising->InfoBox();
				echo "$end_tag";		
				exit();
			}
		} else {
			$_GET["copy2new"] = "";
			$_GET["delete"] = "";
			$_GET["show"] = "";
			$_GET["edit"] = "";
			$_GET["new"] = "";
			$_GET["list"] = "";			
			$_GET["reserve"] = "";	

			$_SESSION['LogInUser']->oikeustaso = 0;
			$_POST["username"] = "";
			$_POST["password"] = "";
			$_GET["logout"] == "1";
			$action = "You are registed to Tila-Autot.com system user.";		
		}
		$page="Register";
	}
	
	$user->UserOwnMenu();
	
	if ($new == "1"){ 
		$user->EditUser("", "new");
		$edit = "";
		$show = "";
		echo "</td>\n";
		
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	//echo "Page:$page $reserve<br>";
	//echo "UserReserve: $userReserve";
	
	if ($userReserve == "1"){
		$reservations->DoBasket("3");
		$edit = "";
		$show = "";
		echo "</td>\n";
		
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if(isset($user_id) && ($user_id != "")){
		if ($show == "1" && (($user_id == $_SESSION['LogInUser']->user_id) || ($_SESSION['LogInUser']->oikeustaso == "99"))){
			$edit = "";
			$user->EditUser($user_id, "show");
			$show == "";
			echo "</td>\n";
			if ($advertising->ad_rightbox == "1"){
				require('includes/car_list.php');
			}
			echo "</td></tr><tr><td colspan=\"3\">\n";
			$advertising->InfoBox();
			echo "$end_tag";		
			exit();
		}
	
		if (($copy2new == "1") && ($_SESSION['LogInUser']->oikeustaso == 99)){
			$show = "";
			$user->EditUser($user_id, "new");
			$copy2new ="";
			echo "</td>\n";
			if ($advertising->ad_rightbox == "1"){
				require('includes/car_list.php');
			}
			echo "</td></tr><tr><td colspan=\"3\">\n";
			$advertising->InfoBox();
			echo "$end_tag";		
			exit();
		}
	
		if ($edit == "1" && (($user_id==$_SESSION['LogInUser']->user_id) || ($_SESSION['LogInUser']->oikeustaso == 99))){
			$show = "";
			$user->EditUser($user_id, "edit");	
			$edit = "";
			echo "</td>\n";
			if ($advertising->ad_rightbox == "1"){
				require('includes/car_list.php');
			}
			echo "</td></tr><tr><td colspan=\"3\">\n";
			$advertising->InfoBox();
			echo "$end_tag";		
			exit();
		}
	
		if ($reserve == "1" && (($user_id==$_SESSION['LogInUser']->user_id) || ($_SESSION['LogInUser']->oikeustaso == 99))){
			$show = "";
			$user->EditUser($user_id, "reserve");
			echo "</td>\n";
			if ($advertising->ad_rightbox == "1"){
				require('includes/car_list.php');
			}
			echo "</td></tr><tr><td colspan=\"3\">\n";
			$advertising->InfoBox();
			echo "$end_tag";		
			exit();
		}
	}

	if ($pass == "0"){
		$show = "";
		$user->NewPassword();
		echo "</td>\n";
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
} 
/**
 * Location Show, add, edit, copy2new, delete
 */ 
if ($page == "location"){
	if(isset($_GET["location_id"]))
		$location_id = $_GET["location_id"];	
  
	if ($new == "1"){ 
		$locations->EditLocation("", $ulocationname, "new");
		$edit == "";
		$show == "";
		echo "</td>\n";
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if ($show == "1"){
		$edit == "";
		$locations->EditLocation($location_id, $ulocationname, "show");
		$show == "";
		echo "</td>\n";
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if ($copy2new == "1"){
		$show == "";
		$locations->EditLocation($location_id, $ulocationname, "new");
		$copy2new ="";
		echo "</td>\n";
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if ($edit == "1"){
		$show == "";
		$locations->EditLocation($location_id, $ulocationname, "edit");	
		$edit = "";
		echo "</td>\n";
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if ($reserve == "1") {
		$show == "";
		$locations->EditLocation($location_id, $ulocationname, "reserve");		
		echo "</td>\n";
		if ($advertising->ad_rightbox == "1"){
			require('includes/car_list.php');
		}
		echo "</td></tr><tr><td colspan=\"3\">\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
} 

if ($list == "type" || $page == "" || $page == "all"){
	$car->ShowCars($location, $ulocationname,"1");
	$page = "";
}

/**
 * Car Show, add, edit, copy2new, delete
 */ 
if ($page == "car"){
	if(isset($_GET["car_id"]))
		$car_id = $_GET["car_id"];	
	
	if (!isset($car))
		$car = new Car();
 
	if (($new == "1") && ($edtype<>"1")){ 
		$car->EditCar("", $ulocationname, "new");
		$edit == "";
		$show == "";
		$page = "";
		echo "</td></tr></table>\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if (($show == "1") && ($edtype<>"1")){
		$edit == "";
		$car->EditCar($car_id, $ulocationname, "show");
		$show == "";
		$page = "";
		echo "</td></tr></table>\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if (($copy2new == "1") && ($edtype<>"1")){
		$show == "";
		$car->EditCar($car_id, $ulocationname, "new");
		$copy2new ="";
		$page = "";
		echo "</td></tr></table>\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if (($edit == "1") && ($edtype<>"1")){
		$show == "";
		$car->EditCar($car_id, $ulocationname, "edit");	
		$edit = "";
		$page = "";
		echo "</td></tr></table>\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
	
	if (($reserve == "1") && ($edtype<>"1")){
		$show == "";
		$car->EditCar($car_id, $ulocationname, "reserve");	
		$page = "";		
		echo "</td></tr></table>\n";
		$advertising->InfoBox();
		echo "$end_tag";		
		exit();
	}
} 

if($page == "ostoskori"){
	$reservations->ShowBasket();
	$page="all";
}

/*
 * tarkistetaan saapunut vuokraus
 */
if($page == "sell"){

	$reservations->SellCheck();
	$page="all";
}

if($page == "kassa"){
	if(isset($_SESSION['LogInUser']->id) && $_SESSION['LogInUser']->id!=""){
		$reservations->ShowCash();
	}else{
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\"><table width=\"100%\"><tr><td class=\"td_actionred\">";
		echo "Et voi viel&#228; tehd&#228; vuokraustasi. Loggaaa sis&#228;&#228;n tai rekister&#246;idy!";
		echo "</td></tr></table></td></tr></table>";
		$reservations->ShowBasket();
	}
}

if($page == "car"){
	$car->Car_Selected_Info("$car->car_id");	
	$advertising->ad_rightbox="0";	
}

if($page == "saannot"){
	echo "<textarea name=\"saannot\" rows=\"57\" cols=\"72\">";
	include 'Saannot.php';
	echo "</textarea>";
	$advertising->ad_rightbox="1";	
}

if($page == "palvelu"){
	echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\" width=\"100%\">";
	echo "<table valign=\"top\" width=\"100%\">\n";
	echo "<tr><td class=\"stylish-button\">";
	echo "Heurex Oy<br>";
	echo "Hyllil&#228;nkuja 5B<br>";
	echo "33730 Tampere<br>";
	echo "FINLAND<br>";
	echo "puh: 040-4166005<br>";
	echo "puh: 040-5616629 (web-page problems)<br>";
	echo "email: myynti@heurex.fi";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	$advertising->ad_rightbox="1";	
}

//echo "$advertising->ad_rightbox<br>";
echo "</td>\n";
if ($advertising->ad_rightbox == "1"){
	require('includes/car_list.php');
}
echo "</td></tr><tr><td colspan=\"3\">\n";
//$advertising->InfoBox();
$user_ip = $_SERVER['REMOTE_ADDR'];

//if ($user_ip == "66.249.71.68") {
//	$user_ip = $user_ip . " TARKISTAPPA TIETOKONEESI KELLO! Antaa v��ri� aikoja tietokantaan, tv. Markku T.";
//}

echo "<table width=\"100%\" border = 0><tr><td align=\"center\" class=\"stylish-cBack\" width=\"100%\"><table valign=\"top\" width=\"100%\" border = 0>\n";
echo "<tr><td class=\"stylish-button\">&copy;Markku Tauriainen 040-5616629, Heurex Oy, Hyllil&#228;nkuja 5B, 33730 Tampere, Finland Your IP = " . 

$user_ip . " Counter: " . $counter->ct_counter_long . "</td>";

echo "<td class=\"stylish-button\"><a href=\"index.php?page=saannot\" target=\"_top\">Vuokrauksen s&#228;&#228;nn&#246;t!</a></td>";
echo "<td class=\"stylish-button\"><a href=\"index.php?page=palvelu\" target=\"_top\">Asiakaspalvelu</a></td></tr></table>\n";
echo "</td></tr></table>";


echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\" width=\"100%\">";
echo "<table width=\"100%\"><tr><td>";
echo "<img src=\"http://img.verkkomaksut.fi/index.svm?id=20468&type=horizontal&cols=10&text=1&auth=f4b655c81d5e1d6b\" alt=\"Suomen Verkkomaksut\" />";
echo "</td></tr></table>\n";
echo "$end_tag";	
//echo "test " . htmlentities("äää ööö ÄÄÅÅ", ENT_COMPAT, "UTF-8") . "<br>\n";
exit();
				
echo ob_get_contents();
ob_end_clean();
?>
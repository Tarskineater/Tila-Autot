<?php 
/**
 * load any local(user created) configure file.
 */
if (file_exists('../includes/configure.php')) {
	include('../includes/configure.php');
}

/**
 * Add Classes.
 */
if (file_exists('includes/Database.php')) {
	include 'includes/Database.php';
}

if (file_exists('includes/User.php')) {
	include 'includes/User.php';
}

if (file_exists('includes/Location.php')) {
	include 'includes/Location.php';
}

if (file_exists('includes/Accessories.php')){
	include 'includes/Accessories.php';
}

include 'includes/Reserve.php';
include 'includes/AccType.php';
include 'includes/Projects.php';
include 'includes/FixDate.php';
include 'includes/Search.php';
include	'includes/ExcelExport.php';

global $db;
global $user;
global $locations;
global $accessories;
global $projects;
global $reservations;
global $fixdate;
global $xls;
global $logo;

$logo = "<br><br><img src=\"" . DIR_PICTURES . "/logo01.gif\" border=\"0\"><br><br>\n";

$pagestart = "<table width=\"850\"><tr><td colspan=\"6\"><center><br><img src=\"pictures/logo.gif\"><br><a href=\"index.php\"><img src=\"" . DIR_PICTURES . "/logo01.gif\" border=\"0\"></a></td></tr></table>\n";
$tablenormal = "<table width=\"850\"><tr>";
/**
 * New Session
 */
 
session_start();
$sessio_id = session_id();
header("Content-Type: text/html; charset=UTF-8");

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
	
if (!isset($location))
	$locations = new Location();
		
	
if (!isset($accessories))
	$accessories = new Accessories();
	
if (!isset($projects))
	$projects = new Projects();

if (!isset($reservations))
	$reservations = new Reserve();
	
if (!isset($FixDate))
	$fixdate = new FixDate();
	
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
 	
//print $_POST["product"] . "<br>";
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
	$_POST["product"] = "phone";

if (isset($_GET["page"]) == "")
	$_GET["page"] = $_POST["product"];

$page = $_GET["page"];

//if ($_SESSION['Search']->product =="")
	$_SESSION['Search']->product = $page;

if ($page2 != "")
	$_SESSION['Search']->page2 = $page2;
	
if ($_SESSION['Search']->page2 == "")
	$_SESSION['Search']->page2 = $_POST["page2"];
	
//print "3 $page2.$page<br>";

if (isset($_GET["location"]) == ""){
	if ($_POST["location"] != ""){
		$_GET["location"] = $_POST["location"];
	}
}

/**
 *  Luodaan tarvittavat oliot SESSIO-muuttujien avulla, jos niita ei ole viela luotu
 */

$register = $_GET["newregister"];

if ($register =="")
	$register = $_POST["newregister"];

$login = $_POST["login"];
$save = $_POST["save"];
	
$username = $_POST["username"];
$password = $_POST["password"];
$delete = $_GET["delete"];

/**include 'includes/user_admin.php'; */
/**
 * Registration
 */
if (($page2=="registration") && ($register == "1") && ($save=="1")){ 
	if (!isset($_SESSION['LogInUser']))
		$_SESSION['LogInUser'] = new User();
	$_POST["oikeustaso"] = "1";
	$_POST["aktivointi"] = "100";
	
	$action = $_SESSION["LogInUser"]->AddUser();
	
	$page = "";
	
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
			$action = "Forbidden characters in User id -field.<br>Only letters and numbers are allowed.";
			
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
		$action = "You can use system as soon as you want.<br>You have only normal user rights so ask more rights from your project manager or system administrator.";		
		$page="phone";
		$new = "";
		$show = "";
		$edit = "";
		$new = "";
		$page2=="newform";
		//$action = "You can use system as soon as system administrator<br>\nor your workplace admin is activated your account.";		
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
	$id = $_GET["user_id"];
	$location = $_POST["location"];
	
	if ($id!=""){
		$user_id = $id;
	} else {
		$user_id = $_POST["user_id"];
		$id = $user_id;
	}
	//print "$user_id<br>";
	$page = "user";
			
	if ($_SESSION['LogInUser']->oikeustaso > 1 || $_SESSION["LogInUser"]->id == $user_id){
		//print "$user_id<br>";
		$action = $user->UpdateUser($user_id);
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
?>

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fi"><head><title>Tila-Autot, Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="keywords" content="tila-autot" />
<meta name="description" content="" /><meta http-equiv="imagetoolbar" content="no" /><meta name="author" content="Markku Tauriainen" />
<meta name="generator" content="system by MTT http://www.mtauriainen.com eLending" /><base href="http://tila-autot.heurex.fi" />
<link rel="canonical" href="http://tila-autot.heurex.fi/" />
<link rel="stylesheet" type="text/css" href="includes/styles.css">

<link href="INstyle.css" rel="stylesheet" type="text/css" />
<?php

if (isset($_SESSION['LogInUser']->oikeustaso) > 0)
{
	print "<script LANGUAGE=\"JavaScript\">
	<!--
	function confirmSubmit(){
		var agree=confirm(\"Do you really want to delete phone information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
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
	
	function confirmSubmitPROJECT(){
		var agree=confirm(\"Do you really want to delete Project information?\");
		if (agree)
			return true ;
		else
			return false ;
	}
	
	function confirmSubmitFLASH(){
		var agree=confirm(\"Do you really want to delete Flash adapter information?\");
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
			box = eval(\"document.searchform.s_\" + j); 
			if (box.checked == false) box.checked = true;
   		}
	}

	function uncheckAll() {
		for (var j = 1; j <= 9; j++) {
			box = eval(\"document.searchform.s_\" + j); 
			if (box.checked == true) box.checked = false;
   		}
	}

	function switchAll() {
		for (var j = 1; j <= 9; j++) {
			box = eval(\"document.searchform.s_\" + j); 
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
	
	</script>";

}
?>

<?php 
/**
	require('includes/static_callbacks.php'); 
 **/

?>

</head>
<?php
/**
<center>
<table>
<tr>
	<tr>		
<td colspan="7" height="100" width="860">
	</tr>	<tr><td width="30"></td>
	<td colspan="5" align="left"><?php require('includes/loggin_buttons.php');?></td>
	<td width="30"> </td>
	</tr>
	<tr><td width="30"> </td>
	<td height="480" valign="top" width="110"><?php require('includes/car_button_links.php');?></td>
	<td colspan="2" valign="top"><?php require('includes/car_selected_info.php');?></td>
	<td valign="top" width="100"><?php require('includes/car_extra.php');?></td>
	<td valign="top" width="110"><?php require('includes/car_list.php');?></td>
	<td width="20"> </td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</center>

</center>
</body>
</html>
**/
?>

<body bgcolor="#ffffff">
<center>

<?php

//if ($_GET["reserve_id"] != "")
//	$reserve_id = $_GET["reserve_id"];
	
$show = $_GET["show"];
$edit = $_GET["edit"];
$new = $_GET["new"];	
$delete = $_GET["delete"];
$save = $_GET["save"];

if ($page2=="newform"){
	$new="1";
	$_SESSION['Search']->Search();
}

$error = $_GET["error"];
$register = $_GET["newregister"];
$location = $_GET["location"];

if ($register =="")
	$register = $_POST["newregister"];

$temp = $page . " " . $_SESSION['LogInUser']->username . " " . $_SESSION['LogInUser']->oikeustaso;
$test_type = $_SESSION['Search']->TestPageType();

//print "page:$temp\n location:$location_id id:$id reserve:$reserve return:$return register:$register<br>";
//print "N:$new.S:$show.E:$edit.D:$delete lvl:" . $_SESSION['LogInUser']->oikeustaso . " Ok:" . $test_type . "<br>";

if ($action != "")
	print "$tablenormal<td class=\"$td\"><b>$action</b></td></tr></table>";

	//print "$td<br>";

if (($page == "user") && ($register=="1")){
	if (($action=="")||($action!="0")){ 
		if ($register == "1"){
			$_SESSION["LogInUser"]->NewUserAccount();
			$new == "";
			$edit == "";
			$show == "";
			exit();
		}
	} else {
		$_GET["show"] = "";
		$_GET["edit"] = "";
		$_GET["new"] = "";	
		$_GET["reserve"] = "";	
		$_GET["copy2new"] = "";
		$_GET["delete"] = "";
		$_SESSION['LogInUser']->oikeustaso = 0;
		$_POST["username"] = "";
		$_POST["password"] = "";
		$_GET["logout"] == "1";
		$action = "You are registed to Tila-Autot.com system user.";		
	}
}
	
/**
 * Log user in!
 */
 
//print "o" . $_SESSION['LogInUser']->oikeustaso . "<br>";
if (($_SESSION['LogInUser']->oikeustaso == 0) && ($page != "register") && ($page != "password")){
	print "$pagestart\n";	
	$username = $_POST["username"];
	
	print "$tablenormal<td colspan=\"2\"><form action=\"admin/index.php\" method=\"post\" name=\"login\">\n";
	print "<input type=\"hidden\" name=\"login\" value=\"1\">";
	print "<tr><td class=\"td_login\">User:<br><input type=\"text\" name=\"username\" size=\"15\" value=\"$username\"></td></tr>\n";
	print "<tr><td class=\"td_login\">Password:<br><input type=\"password\" name=\"password\" size=\"15\"></td></tr>\n";
	print "<tr><td colspan=\"2\" class=\"td_login\"><br><br><input type=\"submit\" value=\"Log In\">\n";
	print "</form></td></tr>\n";
	print "<tr><td colspan=\"2\"><a href=\"admin/index.php?page=user&newregister=1&new=1\">Register</a></td></tr>";
	print "</table>";
	print $vcopy; 
	exit();
}

$userid = $_SESSION['LogInUser']->id;

if (isset($_SESSION['LogInUser']->oikeustaso) > 0){
	
	$_GET["show"] = $show;
	$_GET["edit"] = $edit;
	$_GET["new"] = $new;	
	$_GET["reserve"] = $reserve;	
	$_GET["copy2new"] = $copy2new;
	$_GET["delete"] = $delete;	
		
	$usershow = $_SESSION['LogInUser']->username;
	
	// Get user information
	$kayttajan_id = $_SESSION['LogInUser']->id;
	$kayttajan_nimi = $_SESSION['LogInUser']->name;
	$kayttajan_sijainti = $_SESSION['LogInUser']->locationname;
	$kayttajan_oikeustaso = $_SESSION['LogInUser']->HaeKayttajanOikeustaso();
	
	print "<table width=\"950\"><tr><td class=\"td_nimipalkki\">$kayttajan_id $kayttajan_nimi ($kayttajan_sijainti) - $kayttajan_oikeustaso</td></tr></table>\n";
	print "$tablenormal<td class=\"td_menupalkki\">";
	//print "<a href=\"index.php?page=users\"><img src=\"pictures/users.gif\" border=\"0\" title=\"Users\"></a>\n";
	//print "<a href=\"index.php?page=$page&page2=search\"><img src=\"pictures/search.gif\" border=\"0\" title=\"Search\"></a>\n";
	print "<a href=\"index.php?page=user&user_id=" . $kayttajan_id . "&edit=1\"><img src=\"pictures/profile.gif\" border=\"0\" title=\"Käyttäjätietojen päivitys\"></a>\n";
	print "<a href=\"index.php?logout=1\"><img src=\"pictures/logout.gif\" border=\"0\" title=\"Kirjaudu ulos järjestelmästä\"></a></td>\n";
	print "</tr></table>\n";

	print "$pagestart";	
	
	//$_SESSION['LogInUser']->PrintUser();
	
	/**
	 * New tab
	 */
	if ($_SESSION['LogInUser']->oikeustaso > 1){
		$_SESSION['Search']->NewTab();
	}
	
	/*if ($_SESSION['LogInUser']->oikeustaso == 99){
		$loc = $locations->ListLocations($page);
		print "$loc";
	}
	*/
	//if ($_SESSION['LogInUser']->oikeustaso > 1)
	

		
	//$user_id = $_SESSION["LogInUser"]->id;
	//print $_SESSION["LogInUser"]->id . "<br>";
	//if ($_SESSION["LogInUser"]->id==""){
	//	$_SESSION["LogInUser"]->id = $_GET["user_id"];	
	//}

}


	
$ulocationname = $locations -> ReadLocation($location); 

if ($_POST["location"] == ""){
	$ulocationname = "All";
	}
	
$xx = " id=\"selectedtab\"";

/*
print "1. page $page<br>";
print "1. page2 $page2<br>";
print "1. "  . $_SESSION['Search']->TestPageType();
*/
/*
if ($_SESSION['Search']->s_product == "")
	$_SESSION['Search']->s_product = $page;
*/		

/**
 * Search tab
 */
$_SESSION['Search']->SearchTab();

//print $_SESSION['Search']->page2 . " " . $_SESSION['Search']->product . "<br>";

if ($page2=="newform"){
	$new="1";
	$_SESSION['Search']->Search();
	//print "page: $page2.$page<br>";
}

if ($page == "all"){
	print "<table width=\"850\"><tr><td class=\"td_phonelistheader\">All items</td></tr></table>\n";
}
/**
 * SQL bughunt
 */
//$_SESSION['Search']->PrintSQL();


/*
print "page $page<br>";
print "page2 $page2<br>";
*/
if ($_SESSION['LogInUser']->id!= ""){	

	
	//print "page: $page<br>";
	/*
	$l0 = "";
	if (($page == "phones") || ($page == "phone")){
	 	$x0 = $xx;
	}
	
	$x1 = "";	
	if (($page == "sims") || ($page == "simm")){
	 	$x1 = $xx;
	}
	
	$x2 = "";	
	if (($page == "accessories") || ($page == "accessory")){
	 	$x2 = $xx;
	}

	$x3 = "";	
	if (($page == "locations") || ($page == "location")){
	 	$x3 = $xx;
	}
	
	$x4 = "";
	if (($page == "projects") || ($page == "project")){
	 	$x4 = $xx;
	}
	
	$x5 = "";
	if (($page == "reservations") || ($page == "reservation")){
	 	$x5 = $xx;
	}

	$x6 = "";
	
	if (($page == "flashs") || ($page == "flash")){
	 	$x6 = $xx;
	}

	print "<table id=\"tabmenu\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
	print "<td class=\"tab\"$x0><a href=\"index.php?page=phones&location=$location\">&nbsp;Phones&nbsp;</a></td>\n";
	print "<td class=\"tab\"$x1><a href=\"index.php?page=sims&location=$location\">&nbsp;Sims&nbsp;</a></td>\n";
	print "<td class=\"tab\"$x2><a href=\"index.php?page=accessories&location=$location\">&nbsp;Accessories&nbsp;</a></td>\n";
	print "<td class=\"tab\"$x6><a href=\"index.php?page=flashs&location=$location\">&nbsp;Flash_adap&nbsp;</a></td>\n";	
	print "<td class=\"tab\"$x3><a href=\"index.php?page=locations&location=$location\">&nbsp;Locations&nbsp;</a></td>\n";
	print "<td class=\"tab\"$x4><a href=\"index.php?page=projects&location=$location\">&nbsp;Projects&nbsp;</a></td>\n";
	//print "<td class=\"tab\"$x5><a href=\"index.php?page=reservations&location=$location\">&nbsp;Reservations&nbsp;</a></td>\n";
	print "</tr></table>\n";
	*/
	
	/**
	 * new
	 *
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
/*
	print "1. $page2.$page (" . $_SESSION['Search']->TestPageType() .")<br>";
	
	print "Type: " . $_SESSION['Search']->TestPageType() . "." . $page . "<br>";
*/
	if ($_SESSION['Search']->TestPageType() == "0"){
		//$page = $_GET["product"];
		
	
		//print "$page<br>";	
		
//		if ($page!="all" || $page!="phone" || $page=!"sim" || $page=!"accessory" || $page=!"flash" || $page=!"project" || $page=!"user" || $page=!"location"){
			/**
			 * Show phones
			 */
			if (($page == "phone")||($page == "all")){
				//||($_SESSION['Search']->sql_phone != "")){
		
				//print "$page, " . $_SESSION['Search']->sql_phone . "<br>";
				$phone->ShowPhones($location, $ulocationname);
		
				//$page = $nextpage;
				//$_SESSION['Search']->sql_phone = "";
				//$page = "";
			}
			
			/**
			 * Show Sims
			 */
			if (($page == "sim")||($page == "all")){
				//||($_SESSION['Search']->sql_sim != "")){
				$sim->ShowSims($location, $ulocationname);
				//$page = "";
			}
		
			/**
		 	 * Show Accessories
		     */
			if (($page == "accessory")||($page == "all")){
				//||($_SESSION['Search']->sql_accessory != "")){
				$accessories->ShowAccessories($location, $ulocationname);
				//$page = "";
			}
			
			
			//print "page:$page<br>";
			
			/**
		 	 * Show Accessory types
		     */
			if (($page == "acctype")||($page == "all")){
				//||($_SESSION['Search']->sql_accessory != "")){
				
				$acctype->ShowAccTypes($location, $ulocationname);
				//$page = "";
			}
			
			/**
			 * Show falsh
			 */
			if (($page == "flash")||($page == "all")){
				//||($_SESSION['Search']->sql_flash != "")){
				$flash->ShowFlashs($location, $ulocationname);
				//$page = "";
			}
		
		
			/**
			 * Show projects
			 */
			if (($page == "project")||($page == "all")){
				//||($_SESSION['Search']->sql_project != "")){
				$projects->ShowProjects($location, $ulocationname);
				//$page = "";
			}
		
			/**
			 * Show reservations
			 */
			 /*
			if (($page == "reservations")||($page == "all")||($_SESSION['Search']->sql_reservation != "")){
				$reservations->ShowReservations($location, $ulocationname);
				$page = "";
			}
			*/
			/**
			 * Show users
			 */
			if (($page == "user")||($page == "all")){
				//||($_SESSION['Search']->sql_user != "")){
				$user->ShowUsers($location, $ulocationname);
				//$page = "";
			}
				
			/**
			 * Show locations
			 */
			if (($page == "location")||($page == "all")){
				//||($_SESSION['Search']->sql_location != "")){
				$locations->ShowLocations($location, $ulocationname);
				//$page = "";
			}
			$page = "";
//		}
	}

	//print "P:$phone_id U:$user_id S:$sim_id A:$accessor_id F:$flash_id L:$location_id Pr:$project_id<br>";

	if ($_SESSION['Search']->TestPageType() == "1"){		
		/**
		 * Accessories Show, add, edit, copy2new, delete
		 *
		 */
		if ($page == "accessory"){
			
			//print "index $id, $ulocationname, show<br>";
			if ($new == "1")
				$accessories->EditAccessory("", $ulocationname,"new");
			
			if ($show == "1")
				$accessories->EditAccessory($accessory_id, $ulocationname,"show");
			
			if ($copy2new == "1")
				$accessories->EditAccessory($accessory_id, $ulocationname,"new");
			
			if ($edit == "1")
				$accessories->EditAccessory($accessory_id, $ulocationname,"edit");	
			//print "index $id, $ulocationname, show<br>";	
		} 
		
		/**
		 * Accessory types  Show, add, edit, copy2new, delete
		 *
		 */
		if ($page == "acctype"){
			
			//print "index $id, $ulocationname, show<br>";
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
		 * Locations Show, add, edit, copy2new, delete
		 *
		 */
		
		if ($page == "location"){
			//$location_id = $_POST["location_id"];
			if ($new == "1")
				$locations->EditLocation("", $ulocationname,"new");
			
			if ($show == "1")
				$locations->EditLocation($location_id, $ulocationname,"show");
			
			if ($copy2new == "1")
				$locations->EditLocation($location_id, $ulocationname,"new");
			
			if ($edit == "1")
				$locations->EditLocation($location_id, $ulocationname,"edit");		
		} 
		
		/**
		 * Projects Show, add, edit, copy2new, delete
		 *
		 */
		if ($page == "project"){
			
			if ($new == "1")
				$projects->EditProject("", $ulocationname,"new");
			
			if ($show == "1")
				$projects->EditProject($project_id, $ulocationname,"show");
			
			if ($copy2new == "1")
				$projects->EditProject($project_id, $ulocationname,"new");
			
			if ($edit == "1")
				$projects->EditProject($project_id, $ulocationname,"edit");		
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
		
		/**
		 * User Show, add, edit, copy2new, delete
		 *
		 */
		 
		//$id = $_GET["user_id"];
		//print "user_id:$user_id<br>";
		if ($page == "user"){
			
			//$user_id = $id;
			//print "PAGE: $page SHOW: $show USER:$id $user_id<br>";
			
			if (!isset($user))
				$user = new User();
		
			if ($new == "1"){ 
				$user->EditUser("", $ulocationname, "new");
				$edit == "";
				$show == "";
			}
			
			if ($show == "1"){
				$edit == "";
				$user->EditUser($user_id, $ulocationname, "show");
				$show == "";
			}
			
			if ($copy2new == "1"){
				$show == "";
				$user->EditUser($user_id, $ulocationname, "new");
				$copy2new ="";
			}
			
			if ($edit == "1"){
				$show == "";
				$user->EditUser($user_id, $ulocationname, "edit");	
				$edit = "";
			}
			
			if ($reserve == "1"){
				$show == "";
				$user->EditUser($user_id, $ulocationname, "reserve");		
			}
			
		} 
	}
	
	if (($page == "yllapito") && (isset($_SESSION['LogInUser']->oikeustaso) > 1))	{
	 
		/**
		* Phone search
		*/
		//if (($_GET["page"] == "puhelinhaku") || ($_POST["page"] == "puhelinhaku"))
		//	$phone->PhoneSearch();
	
		/**
		 * Register
		 */
		if ($page == "rekisterointi")
			$user->NewUserAccount();
	
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
}
if ((isset($_SESSION['LogInUser']->oikeustaso) > 0) && ($page == "varaukset")){
	//print "<br><br>\n";
	$aika = time() + 300;
	//print $aika;
	print "$pagestart$logo</td></tr>\n";
	$puhelinhaku = $phone->HaePuhelimenTiedot(isset($_GET["puhelin"]));
	print "$puhelinhaku";
	$puhelin = $_GET["puhelin"];
	$sijainti = $phone->HaePuhelimenSijainti($puhelin);
	
	if (($user->oikeustaso == $sijainti) || ($user->oikeustaso == 99))
		print "<tr><td colspan=\"3\"><a onclick=\"return confirmSubmit()\" href=\"index.php?poistapuhelin=1&id=$puhelin&site=$sijainti\"><img src=\"pictures/poista.gif\" border=\"0\" title=\"Poista puhelin järjestelmästä\"></a> <a href=\"index.php?page=paivitapuhelin&id=$puhelin\"><img src=\"pictures/update.gif\" border=\"0\" title=\"Päivitä puhelimen tiedot\"></a></td></tr>";
	
	print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Make new reservation</td></tr>";
	print "<tr><td class=\"td_phonelistrow\" colspan=\"3\">";
	print "<form action=\"index.php\" method=\"post\" name=\"varauksenteko\">Reservation starts<br><select name=\"alkupv\">";
	
	for ($i=1; $i<32; $i++){
		$paiva = date("d", $aika);
		if ($i < 10)
        	$i = "0$i";
		print "<option value=\"$i\"";
		if ($paiva == "$i")
			print " SELECTED"; 
		print ">$i</option>\n";
	}
	
	print "</select> . <select name=\"alkukk\">";
	
 	for ($i=1; $i<13; $i++){
		$kk = date("m", $aika);
		if ($i < 10)
        	$i = "0$i";
  		print "<option value=\"$i\"";
		if ($kk == "$i")
     		print " SELECTED";
		print ">$i</option>\n";
	}
	
	print "</select> . <select name=\"alkuvv\">";
	
	for ($i=2005; $i<2016; $i++){
   		$vuosi = date("Y", $aika);
		print "<option value=\"$i\"";
		
		if ($vuosi == "$i")
        	print " SELECTED";
        	
		print ">$i</option>\n";
	}
	
    print "</select> - <select name=\"alkuhh\">";
	
	for ($i=0; $i<24; $i++){
     		$tunti = date("H", $aika);
     		
			if ($i < 10)
           		$i = "0$i";
           		
			print "<option value=\"$i\"";
			
			if ($tunti == "$i")
            	print " SELECTED";
            	
			print ">$i</option>\n";
        }
        print "</select> : <select name=\"alkumm\">";
        
	for ($i=0; $i<60; $i++){
       		$min = date("i", $aika);
       		
			if ($i < 10)
				$i = "0$i";
				
			print "<option value=\"$i\"";
			
			if ($min == "$i")
         		print " SELECTED";
         		
			print ">$i</option>\n";
        }
        print "</select>";
        
	$aika = time() + 7500;
	print "<br><br>Varaus loppuu<br><select name=\"loppupv\">";
	
    for ($i=1; $i<32; $i++){
			$paiva = date("d", $aika);
			
     	if ($i < 10)
        	$i = "0$i";
        	
       	print "<option value=\"$i\"";
       	
     	if ($paiva == "$i")
         	print " SELECTED";
         	
    	print ">$i</option>\n";
    }
        
    print "</select> . <select name=\"loppukk\">";
    
    for ($i=1; $i<13; $i++){
 		$kk = date("m", $aika);
 		
   		if ($i < 10)
       		$i = "0$i";
       		
      	print "<option value=\"$i\"";
      	
      	if ($kk == "$i")
        	print " SELECTED";
        	
     	print ">$i</option>\n";
    }
    
    print "</select> . <select name=\"loppuvv\">";
        
    for ($i=2005; $i<2016; $i++){
 		$vuosi = date("Y", $aika);
   		print "<option value=\"$i\"";
 		if ($vuosi == "$i")
        	print " SELECTED";
     	print ">$i</option>\n";
    }
    
    print "</select> - <select name=\"loppuhh\">";
    
    for ($i=0; $i<24; $i++){
  		$tunti = date("H", $aika);
   		if ($i < 10)
       		$i = "0$i";
      	print "<option value=\"$i\"";
     	if ($tunti == "$i")
       		print " SELECTED";
   		print ">$i</option>\n";
    }
        
    print "</select> : <select name=\"loppumm\">";
    
	for ($i=0; $i<60; $i++){
		$min = date("i", $aika);
    	if ($i < 10)
      		$i = "0$i";
      	print "<option value=\"$i\"";
     	if ($min == "$i")
         	print " SELECTED";
  		print ">$i</option>\n";
    }
        
	print "</select><input type=\"hidden\" name=\"puhelin\" value=\"$puhelin\">";
	print "<br><br><input type=\"submit\" value=\"Save reservation\">"; 
	print "</form></td></tr>";
	print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Reservations</td></tr>";
	print "<tr><td class=\"td_phonelistheader\">Varaus alkaa</td><td class=\"td_phonelistheader\">Reservation ends</td><td class=\"td_phonelistheader\">Who has it</td></tr>";
	$varaushaku = $reserve->NaytaPuhelimenTulevatVaraukset(isset($_GET["puhelin"]));
	print "$varaushaku";
	print "<tr><td class=\"td_phonelistheader\" colspan=\"3\">Aikaisemmat varaukset (5 viimeisintä)</td></tr>";
	print "<tr><td class=\"td_phonelistheader\">Varaus alkoi</td><td class=\"td_phonelistheader\">Varaus loppui</td><td class=\"td_phonelistheader\">Varaaja</td></tr>";
	$varaushaku = $reserve->NaytaPuhelimenAikaisemmatVaraukset(isset($_GET["puhelin"]));
    print "$varaushaku";
	
	print "</table>";
}

print "$vcopy"; 
?>
</center>
</body>
</html>
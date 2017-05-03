/**
 * Registration
 */
if (($page2=="registration") && ($register == "1") && ($save=="1")){ 
	//print "reg!<br>";
	if (!isset($_SESSION['LogInUser']))
		$_SESSION['LogInUser'] = new User();
		
	//$_POST["password2"] = $_POST["password1"];
	$_POST["oikeustaso"] = "1";
	$_POST["aktivointi"] = "100";
	
	$action = $_SESSION["LogInUser"]->AddUser();
	
	$page = "";
	
	if ($action!="0"){
		$page = "user";
	 	$save="";
		$new="1";
		$_SESSION['LogInUser']->oikeustaso = 0;
		//$_POST["username"] = "";
		//$_POST["password"] = "";
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
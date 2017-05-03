<?php
/**
	login_buttons.php
*/
	
/**
 * Log user in!
 */
 print "<center>";
 print "<table width=\"974\">";
 // border=\"1\"
 print "<tr>";
 
if (($_SESSION['LogInUser']->oikeustaso == 0) && ($page != "register") && ($page != "password")){
	//print "$pagestart\n";	
	$username = $_POST["username"];
	print "<form action=\"admin/index.php\" method=\"post\" name=\"login\">\n";
	print "<input type=\"hidden\" name=\"login\" value=\"1\">";
	print "<td class=\"td_login\">K&#228;ytt&#228;j&#228;:<input type=\"text\" name=\"username\" size=\"15\" value=\"$username\">\n";
	print "Salasana:<input type=\"password\" name=\"password\" size=\"15\">\n";
	print "<input type=\"submit\" value=\"Loggaa sis&#228;&#228;n\">\n";
	print "</form>";
	print "</td><td colspan=\"2\" align=\"right\"><a href=\"index.php?page=user&newregister=1&new=1\"><img src=\"" . DIR_PICTURES . LANG."/button_create_account.gif\" border=\"0\" title=\"Rekisteröidy\"></a></td>";
	//print $vcopy; 
	//exit();
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
	
	print "<table width=\"850\"><tr><td class=\"td_nimipalkki\">$kayttajan_id $kayttajan_nimi ($kayttajan_sijainti) - $kayttajan_oikeustaso</td></tr></table>\n";
	print "class=\"td_login\" align=\"right\"><a href=\"index.php?page=user&user_id=" . $kayttajan_id . "&edit=1\"><img src=\"pictures/profile.gif\" border=\"0\" title=\"K&#228;ytt&#228;j&#228;tietojen p&#228;ivitys\"></a><br>\n";
	print "<a href=\"index.php?logout=1\"><img src=\"". DIR_PICTURES . LANG . "/logout.gif\" border=\"0\" title=\"Kirjaudu ulos j&#228;rjestelm&#228;st&#228;\"></a></td>\n";


	//print "$pagestart";	
	
	//$_SESSION['LogInUser']->PrintUser();
	
	/**
	 * New tab
	 */
	if ($_SESSION['LogInUser']->oikeustaso > 1){
		$_SESSION['Search']->NewTab();
	}
}
print "</tr></table>\n";
?>

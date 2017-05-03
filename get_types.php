<?php
/**
 * KlapiTuli 0.2
 * get_types.php
 * 05.09.2013
 **/
	
if (isset($_POST["page"]) == "")
	$_POST["page"] = "";
	
if (isset($_GET["page"]) == "")
	$_GET["page"] = $_POST["page"];
	
if (isset($_POST["type"]) == "")
	$_POST["type"] = "";
	
if (isset($_GET["type"]) == "")
	$_GET["type"] = $_POST["type"];
	
if (isset($_POST["lang"]) == "")
	$_POST["lang"] = "fi";
	
if (isset($_GET["lang"]) == "")
	$_GET["lang"] = $_POST["lang"];
	
if (isset($_POST["adv"]) == "")
	$_POST["adv"] = "0";
	
if (isset($_GET["adv"]) == "")
	$_GET["adv"] = $_POST["adv"];
	
$lang = $_GET["lang"];
$page = $_GET["page"];
$type = $_GET["type"];
$adv = $_GET["adv"];

if ($lang == ""){
	$lang = "fi";
}

if ($page == ""){
	$page = "product";
}

if ($type == ""){
	$type = "0";
}

if ($adv == ""){
	$adv = "0";
}

$bor = "0";

//Setting up language
$language->xlist($lang);
?>

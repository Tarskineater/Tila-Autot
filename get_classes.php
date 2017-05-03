<?php
/**
 * Tila-Autot 0.2
 * get_classes.php
 * 07.10.2013
 **/

/**
 * Start Classes
 **/

include 'includes/classes/Database.php';
include 'includes/classes/User.php';
include 'includes/classes/Location.php';
include 'includes/classes/Car.php';
include 'includes/classes/Car_AccType.php';

if (!isset($counter)){
	include_once 'include/Counter.php';
	$counter = new Counter();
}

if (!isset($boxes)){
	include_once 'include/Boxes.php';
	$boxes = new Boxes();
}

if (!isset($advertising)){
	include_once 'include/Advertising.php';
	$advertising = new Advertising();
}
	
if (!isset($language)){
	include_once 'include/Language.php';
	$language = new Language();
}

if (!isset($product)){
	include_once 'include/Product.php';
	$product = new Product();
}
	
if (!isset($media)){
	include_once 'include/Media.php';
	$media = new Media();
}

if (!isset($vuokraus)){
	include_once 'include/Vuokraus.php';
	$vuokraus = new Vuokraus();
}
	
if (!isset($info)){
	include_once 'include/Info.php';
	$info = new Info();
}

if (!isset($counter)){
	include_once 'include/Counter.php';
	$counter = new Counter();
}
?>

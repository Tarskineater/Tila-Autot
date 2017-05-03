<html>
<head>
<title>Autonvaraus</title>
</head>
<body onload="self.close()">

<?php
include 'Database.php';
include '../configure.php';
//onload="self.close()"
if (!isset($db))
	$db = new Database();
	
$user_ip = $_SERVER["REMOTE_ADDR"];

//echo $user_ip;
$time_now = date("Ymd") . substr("00" . date("h"), -2). substr("00" . date("i"), -2);	

if ($_POST){
	$m = $_POST['m'];
	$d = $_POST['d'];
	$y = $_POST['y'];
	
	$client_id = $_POST['client_id'];
	$car_id = $_POST['car_id'];
	$accessory_id = $_POST['accessory_id'];
	$location = $_POST['location'];
	
	$event_date = $y."-". substr("00" . $m, -2) ."-". substr("00" . $d, -2);
	
	$sql = "SELECT * FROM tmp_reservation WHERE car_id = '" . $car_id . "' AND start_time='" . $event_date . "' AND user_session_id='" . $client_id . "'";
	
	$haku = $db->AskSQL($sql);
	
	$rows = mysql_num_rows($haku);
	if ($rows > 0){
		$sql = "DELETE FROM tmp_reservation WHERE car_id = '" . $car_id . "' AND start_time='" . $event_date . "' AND user_session_id='" . $client_id . "'";
		$haku = $db->UseSQL($sql);
		echo "DELETING!";
		
	} else {
		$sql = "SELECT * FROM tmp_reservation WHERE car_id = '" . $car_id . "' AND start_time='" . $event_date . "'";
	
		$haku = $db->AskSQL($sql);
	
		$rows = mysql_num_rows($haku);
		if ($rows = 0){
			$sql = "INSERT INTO tmp_reservation (user_session_id,car_id, accessory_id, location, start_time, end_time, changeday, locked, ip) VALUES (
				'".$client_id."','".$car_id."','".$accessory_id."','".$location."','".$event_date."','".$event_date."', '$time_now', 0, '$user_ip')";
			
			$tulos = $db->UseSQL($sql);
		}
	}
			
} else {
	$m = $_GET['m'];
	$d = $_GET['d'];
	$y = $_GET['y'];
	$client_id = $_GET['client_id'];
	$car_id = $_GET['car_id'];
	$accessory_id = "";
	$location = "1";

	$event_date = $y."-". substr("00" . $m, -2) ."-". substr("00" . $d, -2);
	$sql = "SELECT * FROM tmp_reservation WHERE car_id = '" . $car_id . "' AND start_time='" . $event_date . "' AND user_session_id='" . $client_id . "'";
	
	$haku = $db->AskSQL($sql);
	
	$rows = mysql_num_rows($haku);
	
	if ($rows > 0){
		$sql = "DELETE FROM tmp_reservation WHERE car_id = '" . $car_id . "' AND start_time='" . $event_date . "' AND user_session_id='" . $client_id . "'";
		$haku = $db->UseSQL($sql);
	} else {
		$sql = "SELECT * FROM tmp_reservation WHERE car_id = '" . $car_id . "' AND start_time='" . $event_date . "'";
		
		$haku = $db->AskSQL($sql);
	
		$rows = mysql_num_rows($haku);
		
		if ($rows <= 0){
			$sql = "INSERT INTO tmp_reservation (user_session_id,car_id, accessory_id, location, start_time, end_time, changeday, locked, ip) VALUES (
				'".$client_id."','".$car_id."','".$accessory_id."','".$location."','".$event_date."','".$event_date."', '" . $time_now . "', 0, '$user_ip')";
				
			$tulos = $db->UseSQL($sql);
		} else {
			print "On jo varaus ajalle<br>"; 
		}
	}

}
?>
</body>
</html>

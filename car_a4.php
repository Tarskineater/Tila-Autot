<html>
<head>
<title>A4-Mainos</title>
</head>
<body>

<?php
include 'Car.php';
include 'Database.php';
include '../configure.php';
//onload="self.close()"
//if (!isset($db))
//	$db = new Database();
	
if (!isset($car))
	$car = new Car();

	//$car->ReadGet();
	
if (isset($_GET["car_id"]))
	$car->car_id  = $_GET["car_id"];

$car->ReadCar($car->car_id);
$car_picture = "http://www.tila-autot.heurex.fi/images/cars/Car_" . $car->car_plate;
$car_picture0 = "http://www.tila-autot.heurex.fi/images/cars/Car_000.jpg";

echo "<center>";
echo "<table border='0'><tr><td><center>";
echo "<table border='0'><tr><td colspan='10'><center><img src='http://www.tila-autot.heurex.fi/images/top_logo.png' border='0' width='700'></td></tr>";
echo "<tr><td colspan='10'><center>";
echo "<img src='" . $car_picture . "_001.jpg' alt='" . $car->car_plate . "' title='" . $car->car_plate . "' width='550' border='1'/></center>";
echo "</td></tr><tr><td colspan='10'><table border='0'><tr>";
for ($i = 2; $i<10; ++$i){
	$tmpimg = $car_picture . "_00$i.jpg";
	
	echo "<td>";
//	if (file_exists($car_picture . "_00$i.jpg")){
		echo "<center>";
		echo "<img src='" . $car_picture . "_00$i.jpg" . "' width='80' border='1'/>";
//	}else {
//		echo "<center>";
//		echo "<img src='" . $car_picture0 . "' width='80' border='1'/>";
//	}
	echo "</td>";
	
}
echo "</tr></table></tr><tr>";
echo "<td colspan='10'><center><b><font size=+3>$car->car_name<br>$car->car_plate<br>$car->car_year</b></td>";
echo "</tr><tr>";
echo "<td colspan='5'><center><b>Myyntihinta</td>";
echo "<td colspan='5'><center><b>Vuokrahinta</td>";
echo "</tr><tr>";
echo "<td colspan='5'><center><b><font size=+4><font color=red>$car->car_sell &#8364;</td>";
echo "<td colspan='5'><center><b><font size=+4><font color=red>$car->car_rental &#8364;</td>";
echo "</tr><tr>";
echo "<td colspan='10'><center><b>Tiedot</td>";
echo "</tr><tr>";
echo "<td colspan='2'><center><b>Ovet</td>";
echo "<td colspan='2'><center><b>Polttoaine</td>";
echo "<td colspan='2'><center><b>Vaihteisto</td>";
echo "<td colspan='2'><center><b>Mittarissa</td>";
echo "<td colspan='2'><center><b>Paikkakunta</td>";
echo "</tr><tr>";
echo "<td colspan='2'><center><b>$car->car_doors</td>";
echo "<td colspan='2'><center><b>$car->car_fuel</td>";
echo "<td colspan='2'><center><b>$car->car_gear</td>";
echo "<td colspan='2'><center><b>$car->car_counter</td>";
echo "<td colspan='2'><center><b>$car->car_location</td>";
echo "</tr></table>";
echo "</td></tr></table>";
?>
</body>
</html>

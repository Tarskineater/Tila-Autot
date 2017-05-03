<?php
/**
 * Heurex Rental 0.0
 * calendar_select.php
 * 14.07.2012
 */ 
?>
<?php
if (!isset($reservations))
	$reservations = new Reserve();
	
$monthNames = Array("Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Kes&#228;kuu", "Hein&#228;kuu", 
"Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu");

/**$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");*/

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
 
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}

echo "<table width='100%'><tr><td align='center'>";
echo "<table width='100%' cellpadding='2' cellspacing='2' border=0><tr align='center'>";
echo "<td colspan='2' align='left' class=\"cMonth\">  <a href='". $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year . "&car_id=" . $car_id . "' style='td_cal0'>&#171; Edellinen</a></td>";
echo "<td colspan='3' class=\"cMonth\"><strong>" . $monthNames[$cMonth-1] . " " . $cYear ."</strong></td>";
echo "<td colspan='2' align='right' class=\"cMonth\"><a href='" . $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . "&car_id=" . $car_id . "' style='td_cal0'>Seuraava &#187;</a> </td>";
echo "</tr><tr>";

echo "<td class=\"cWeekDay\">S</td>";
echo "<td class=\"cWeekDay\">M</td>";
echo "<td class=\"cWeekDay\">T</td>";
echo "<td class=\"cWeekDay\">K</td>";
echo "<td class=\"cWeekDay\">T</td>";
echo "<td class=\"cWeekDay\">P</td>";
echo "<td class=\"cWeekDay\">L</td>";
echo "</tr>";

$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
$empty = 0;
$car_id = $_SESSION["car_id"];

for ($i=0; $i<($maxday+$startday); $i++) {
    if(($i % 7) == 0 ) {
		echo "<tr>";
		$empty = 0;
	}
    if($i < $startday) {
		echo "<td class=\"cEmpty\"></td>";
	} else {
		//echo "<td class=\"cEmptySlot\">". ($i - $startday + 1) . "</td>";
		$testday = "cEmptySlot";
		$testday = $reservations->DayType(($i - $startday + 1), $cMonth, $cYear, $car_id, $_SESSION["kayttajatunniste"]);
		
		echo "<td class=\"$testday\"><a href=\"javascript:eventWindow('includes/classes/event.php?client_id=" . $_SESSION["kayttajatunniste"] . "&m=" . $cMonth . "&d=" . ($i - $startday + 1) . "&y=$cYear&car_id=" . $car_id . "')\">" . ($i - $startday + 1) . "</a></td>";
		$empty++;

    if(($i % 7) == 6 ) echo "</tr>";

	}
}

if (($empty)>0 || ($empty)<7){
	for ($i=($empty+1); $i==7; $i++) {
		echo "<td class=\"cEmpty\">$i</td>";
	}
}

echo "</tr></table></td></tr>";
echo "<tr><td>";
echo "<table><tr>";
echo "<td class=\"cEmptySlot\">&nbsp;&nbsp;</td><td class=\"cLabel\">Vapaa</td>";
echo "<td class=\"cPartly\">&nbsp;&nbsp;</td><td class=\"cLabel\">Varaamassa</td>";
echo "<td class=\"cFull\">&nbsp;&nbsp;</td><td class=\"cLabel\">Varattu</td>";
echo "</tr></table>";
echo "</td></tr></table>";
?>
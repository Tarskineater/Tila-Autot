<?php
/**
 * Heurex Rental 0.0
 * car_selected_info.php
 * 11.07.2012
 */ 
echo "<table valign='top' width='100%' border=1><tr><td width='350'>";
$car->CarNameCost(1);
echo "</td><td rowspan=3>";
$car->CarInformation(1);
echo "</td></tr>";
echo "<tr><td VALIGN=TOP>";
echo "<table border=1></tr><td>";
require('car_picturebox.php');
echo "</td><td>";
$car->CarExtras();
echo "</td></tr><tr><td colspan=2>";
require('includes/calendar_select.php');
echo "</td></tr></table></td></tr></table>";
?>
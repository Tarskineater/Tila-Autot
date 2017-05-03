<?php
/**
	car_list.php
*/
?>
<?php
echo "<td valign='top' align='top' height='480' width='110' border=1>";
	$tmpid = $car->GetMaxCar();
	$a[0] = 0;
	$i = 0;
	while($i<=5){
		$x = rand(1,$tmpid);
		
		if ($a[0]>0){
			for ($ii=1; $ii<=$a[0]; $ii++){
				if ($x == $a[$ii]){
					$x = 0;
				}
			}
		}
		
		if ($x>=1){
			$a[0]++;
			$a[$a[0]] = $x;
			$i++;
		}
		
	}
	
	for ($i=1; $i<=5; $i++){
		$car->CarBox($a[$i]);
	}
echo "</td>";
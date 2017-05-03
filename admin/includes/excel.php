<html>
<head>
<meta http-equiv="content-style-type" content="text/css">
	<style type="text/css">
		body {font-family: verdana, arial, sans-serif; }
		thead tr td {font-weight: bold; background: #ccffff;}
		.dec2 {mso-number-format:"\#\,\#\#0\.00";}
		.dec0 {mso-number-format:"0";}
		.date10 {mso-number-format:"Short Date";}
		.text {mso-number-format:"\@";}
	</style>             
</head>
<?php	

/**
 * Inventory Tool 0.7
 * Excel.php
 * 31.03.2008
 */
	$server = "localhost";
	$name = "inventory";
	$username = "inventory";
	$password = "123PlenWare654";
	
	$sql = $_GET["sql"];
	$name2 = $_GET["name"];
	$cols = $_GET["cols"];
	
	$header = "<table border=\"1\"><tr><td colspan=\"" . $_GET["cols"] . "\"><b><i>$name2</i><b></td></tr><tr></tr><tr>";
	
	for ($i = 1; $i <= $_GET["cols"]; ++$i){
		$col[$i] = $_GET["col$i"];
		$header = $header . "<th>" . $_GET["coln$i"] . "</th>"; 
	}
	
	$header = $header . "</tr>";
	
	$connection = mysql_connect($server, $username, $password);
	if (!connection){
		die('Could not connect: ' . mysql_error());
	}
		
	mysql_selectdb($name);	

	$tulos = mysql_query("$sql");
	
	if (!$tulos) {
		die('Invalid query: ' . mysql_error());
		print "AskSQL: $sql<br>\n";
	}
	
	$count = mysql_num_fields($tulos);
	/*
	for ($i = 1; $i < $_GET["cols"]; $i++){
	    $header .= mysql_field_name($tulos, $col[$i])."\t";
	}
*/
	$connection = mysql_close();
	
	while($row = mysql_fetch_row($tulos)){
	  	$line = "<tr>";
		for ($i = 1; $i <= $_GET["cols"]; ++$i){
			
			$value = $row[$col[$i]];
			
			$value = str_replace("Ã¤","ä",$value);
			$value = str_replace("Ã¶","ö",$value);
			$value = str_replace("Ã¥","å",$value);
			
			$value = str_replace("Ã„","Ä",$value);
			$value = str_replace("Ã–","Ö",$value);
			$value = str_replace("Ã…","Å",$value);
			
			$value = str_replace("Ãµ","õ",$value);

			if ($_GET["coln$i"]=="User rights"){
				if($value=="99" ){
					$value = "Admin";
				} else {
					$value = "Normal user";
				}
			}
			
			if ($_GET["coln$i"]=="Phone number"){
				$value = str_replace("+", "+ ", $value);
			}
				
			/*
		    if(!isset($value) || $value == ""){
		      $value = "\t";
		    }else{
		      $value = str_replace('"', '""', $value);
		      $value = '"' . $value . '"' . "\t";
		    }
		    */
		    $line .= "<td class=\"text\">" . $value . "</td>";
		}
	
/*	  foreach($row as $value){
	    if(!isset($value) || $value == ""){
	      $value = "\t";
	    }else{
	      $value = str_replace('"', '""', $value);
	      $value = '"' . $value . '"' . "\t";
	    }
	    $line .= $value;
	  }
	  */
	  $line = $line . "</tr>";
	  $data .= $line."\n";
	}
	$data = $data . "</table>";
  	$data = str_replace("\r", "", $data);
/*
	if (mysql_num_rows($tulos) > 0)	{
		for ($laskuri = 1; $rivi = mysql_fetch_row ($tulos); ++$laskuri){
			$data = $data . "<tr>";
			for ($i = 0; $i <= $cols; ++$i){
				$data = $data . "<td>" . $rivi[$co[$i]] . "</td>"; 
			}
			$data = $data . "</tr>";	
		}
	}
*/	
	if ($data == "") {
	  $data = "\nno matching records found\n";
	}

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Excel.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo $header . "\n" . $data;

	
	/*
	
	for ($i = 1; $i <= $header[0]; ++$i){
		$data = $data . "<th>" . $header[$i] . "</th>"; 
	}

	$data = $data . "</tr>";
	/*
	for ($ii = 0; $ii <= $rows; ++$ii){
		$data = $data . "<tr>";
		for ($i = 0; $i <= $header[0]; ++$i){
			$data = $data . "<td>" . $datarow[$ii][$i] . "</td>"; 
		}
		$data = $data . "</tr>";
	}	
	
	$data = $data . "</table>";
	print "$data";
	*/
		
/*	
	print "<table>";
	print "<tr>";
	print "<tr><th>Column 1</th><th>Column 2</th></tr>";
	print "<tr><td style='font-size:200%'>Answer 1</td><td style='color:#f00'>Answer 2</td></tr>";
	print "<tr><td colspan='2' style='font-weight:bold'>Answer 3 with 2 columns</td></tr>";
	print "</table>";	
*/

?>
</html>
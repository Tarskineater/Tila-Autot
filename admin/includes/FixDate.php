<?php
/**
 * Inventory Tool 0.6
 * FixDate.php
 * 12.02.2008
 */               
class FixDate{

	public function FixDate(){

	}
		
	/**
	 * Date show
	 */
	public function DateShow($dname, $ddate){
		$dnamedate = "$dname" . "date";
		$dnamemonth = "$dname" . "month";
		$dnameyear = "$dname" . "year";
		$dnamehour = "$dname" . "hour";
		$dnameminutes = "$dname" . "minutes";
		
		if ($ddate!="0000-00-00 00:00:00")
			$ddate = $this->ReturnDate($ddate);
		
		$p = date("d",$ddate);
		
		print "<select name=\"$dnamedate\">";
		for ($i=0; $i<32; $i++){
			if ($i < 10)
	        	$i = "0$i";
			print "<option value=\"$i\"";
			if ($p == "$i")
				print " SELECTED"; 
			print ">$i</option>\n";
		}

		print "</select> . ";
		
		$kk = date("m", $ddate);

		print "<select name=\"$dnamemonth\">";
	 	for ($i=0; $i<13; $i++){
			if ($i < 10)
	        	$i = "0$i";
	  		print "<option value=\"$i\"";
			if ($kk == "$i")
	     		print " SELECTED";
			print ">$i</option> ";
		}
		
		print "</select> . ";
		
		$vuosi = date("Y", $ddate);

		print "<select name=\"$dnameyear\">";
		print "<option value=\"0\">0000</option>";
		for ($i=2005; $i<2016; $i++){	
			print "<option value=\"$i\"";
			if ($vuosi == "$i")
	        	print " SELECTED";
			print ">$i</option>\n";
		}
		
	    print "</select>";
	    /**
	    print "<select name=\"$dnamehour\">";
	   $tunti = date("H", $ddate);
		for ($i=0; $i<24; $i++){
     		
     		
			if ($i < 10)
           		$i = "0$i";
           		
			//print "<option value=\"$i\"";
			
			if ($tunti == "$i")
            	print " SELECTED";
            	
			print ">$i</option>\n";
        }
        print "</select>";
        */
        $tunti = date("H", $ddate);
        print "<input type=\"hidden\" name=\"$dnamehour\" value=\"$tunti\">";
        

        /**
        print "<select name=\"$dnameminutes\" type=\"hidden\">";
        $min = date("i", $ddate);
		for ($i=0; $i<60; $i++){
       		
			if ($i < 10)
				$i = "0$i";
				
			print "<option value=\"$i\"";
			
			if ($min == "$i")
         		print " SELECTED";
         		
			print ">$i</option>\n";
        }
        print "</select>";	
        */
        $min = date("i", $ddate);
        print "<input type=\"hidden\" name=\"$dnameminutes\" value=\"$min\">";			
	}
	
	/**
	 * Returns right date
	 * Changes date/time to real date to save db
	 */
	public function ReturnDate($mydate){
		
		//print "$mydate<br>";
		
		//print "$mydate<br>";
		$output = "";
		if ($mydate=="0000-00-00 00:00:00")
			$mydate = time();
			
		if ($mydate!="0000-00-00 00:00:00"){
			$pos = strrpos($mydate, "-");
			if ($pos == true) { 
				list($year, $month, $date) = explode('-',substr($mydate,0,10));
				list($hour, $minute, $second) = explode(':',substr($mydate,11,8));
				//print "$mydate<br>";
				$newdate = $date.'-'.$month.'-'.$year;
				$newtime = $hour.'-'.$minute.'-'.$second;
				//print "$mydate $hour<br>";
				$output =  mktime($hour, $minute, $second, $month, $date, $year); 
			} else {
				$output =  mktime(date("H", $mydate), date("i", $mydate), date("s", $mydate), date("m", $mydate), date("d", $mydate), date("Y", $mydate)); 
			}
		}
		return $output;
	}
	
	/**
	 * Returns make date
	 * Reads information about combo boxes and changes it to real date
	 * Changes date/time to real date to save db
	 */
	public function MakeDate($dname){
		$dnamedate = "$dname" . "date";
		$dnamemonth = "$dname" . "month";
		$dnameyear = "$dname" . "year";
		$dnamehour = "$dname" . "hour";
		$dnameminutes = "$dname" . "minutes";
		$year = $_POST["$dnameyear"];
		$month = $_POST["$dnamemonth"];
		$date = $_POST["$dnamedate"];
		$hour = $_POST["$dnamehour"];
		$minute = $_POST["$dnameminutes"];
				
		//print "MakeDate: $year.$month.$date <br>";
		if ($year=="0"){
			$output = "";
		} else {
			$output =  mktime($hour , $minute, 0, $month, $date, $year); 
		}
		//print "output: $output<br>";
		return $output;
	}

	/**
	 * Adds year, month and date to user giving date
	 */
	public function AddMore($mydate,$year,$month,$day){
		$mydate = $this->ReturnDate($mydate);
		$mydate = mktime(date("H", $mydate) , date("i", $mydate), date("s", $mydate), date("m", $mydate) + $month, date("d", $mydate) + $day, date("Y", $mydate) + $year);
		return $mydate;
	}
}

<?php
/**
 * Counter.php
 * (c)Markku Tauriainen
 * 07.11.2013
 *
 */ 
?>
<?php
class Counter{
	var $ct_startdate;
	var $ct_counter;
	var $ct_counter_long;
	var $ct_date;
	var $ct_time;
	var $ct_ip;
	var $ct_hostname;
	var $ct_page;
	var $ct_product;
	var $ct_count;
	var $temp_date;
	var $temp_time;
	
	/**
	 * Start Counter
	 */
	public function Counter(){
		$this->ct_startdate = "";
		$this->ct_counter = "";
		
		$this->GetDate();
		$this->GetTime();
		$this->ct_date = $this->temp_date;
		$this->ct_time = $this->temp_time;
		
		$this->ct_ip = $this->GetIp();
		$this->ct_page = "Main";
		$this->ct_product = "0";
		$this->Ct_Make_Info($this->ct_page, $this->ct_product);
	}

	/**
	 * Load counter values
	 */
	public function Ct_Counter_Read(){
		if (!isset($db))
 			$db = new Database();
 			
 		$sql = "SELECT * FROM counter";
 		
		$haku = $db->AskSQL($sql);
		
		$rows = mysql_num_rows($haku);
		$rivi = mysql_fetch_row ($haku);
			
		if (mysql_num_rows($haku) > 0){
			$this->ct_startdate = $rivi[0];
			$this->ct_counter = $rivi[1];
		} else {
			$this->GetDate();
			$this->ct_startdate = $this->temp_date;
			$this->ct_counter = 1;
		}		
	}
	
	/**
	 * Load counter_info values
	 */
	public function Ct_Info_Read($table){
		if (!isset($db))
 			$db = new Database();
		$inRow = 0;
		$ip_type1 = "1";
		$order_counter = "ct_date, ct_time";
		
		if (!isset($_GET["list"]) == "")
			$ip_type1 = $_GET["list"];
			
		if (!isset($_GET["order_counter"]) == "")
			$order_counter = $_GET["order_counter"];
 			
 		$sql = "SELECT * FROM counter_info";
		
		if ($ip_type1 == "1"){
			$sql = "SELECT * FROM counter_info ORDER BY " . $order_counter; 
		}
		
		if ($ip_type1 == "2"){
			$sql = "SELECT DISTINCT ct_date,'', ct_ip, '', '' FROM counter_info ORDER BY " . $order_counter; 
		}
		
		if ($ip_type1 == "3"){
			$sql = "SELECT ct_date, COUNT(DISTINCT ct_ip) QTY FROM counter_info GROUP BY ct_date";
			//$sql = "SELECT ct_date, SUM(totalCOunt) FROM (SELECT ct_date, COUNT(DISTINCT ct_ip) totalCOunt FROM counter_info GROUP BY ct_date) AS S"; 
		}
		
		if ($ip_type1 == "4"){
			$sql = "SELECT COUNT(DISTINCT ct_ip) QTY, ct_ip FROM counter_info GROUP BY ct_ip";
		}
		
		$haku = $db->AskSQL($sql);
		
		$tmp_txt="<a href=\"index.php?page=counter&list=type";
		
		if ($table == "1"){
			echo "<table width=\"100%\" border = 0>\n<tr>\n<td align=\"center\" class=\"stylish-cBack\" width=\"100%\">\n";
			echo "<table valign=\"top\" width=\"100%\" border = 0>\n";
			echo "<td class=\"stylish-button\" width=\"50\">Rivi</a></td>\n";
				
			if ($ip_type1 == "1"){
				echo "<td>". $tmp_txt . "&order_counter=ct_date\" class=\"stylish-button\">Päivä</a></td>\n";
				echo "<td>". $tmp_txt . "&order_counter=ct_time\" class=\"stylish-button\">Kellonaika</a></td>\n";
				echo "<td>". $tmp_txt . "&order_counter=ct_ip\" class=\"stylish-button\">IP</a></td>\n";
				echo "<td class=\"stylish-button\">Osoite</td>\n";
				echo "<td class=\"stylish-button\">Sivu</td>\n";
				echo "<td class=\"stylish-button\">Nappi</td>\n";	
			}
		
			if ($ip_type1 == "2"){
				echo "<td>". $tmp_txt . "&order_counter=ct_date\" class=\"stylish-button\" width=\"100%\">Päivä</a></td>\n";
				echo "<td>". $tmp_txt . "&order_counter=ct_ip\" class=\"stylish-button\" width=\"100%\">IP</a></td>\n";
				echo "<td class=\"stylish-button\">Osoite</td>\n";
			}
			
			if ($ip_type1 == "3"){
				echo "<td>". $tmp_txt . "&order_counter=ct_date\" class=\"stylish-button\" width=\"100%\" >Päivä</a></td>\n";
				echo "<td>". $tmp_txt . "&order_counter=ct_ip\" class=\"stylish-button\" width=\"100%\" >Count</a></td>\n";
			}
			
			if ($ip_type1 == "4"){
				echo "<td class=\"stylish-button\" width=\"100%\">Count</a></td>\n";
				echo "<td class=\"stylish-button\" width=\"100%\">IP</a></td>\n";
				echo "<td class=\"stylish-button\">Osoite</td>\n";
			}
			
			echo "</tr>\n";
		}
		
		if (mysql_num_rows($haku) > 0){
			for ($laskuri = 1; $rivi = mysql_fetch_row ($haku); ++$laskuri){
				$inRow= $inRow + 1;
				if ($ip_type1 == "1" || $ip_type1 == "2"){
					$this->ct_date = $rivi[0];
					$this->ct_time = $rivi[1];
					$this->ct_ip = $rivi[2];
					$this->GetAddress();
					$this->ct_page = $rivi[3];
					$this->ct_product = $rivi[4];
					
				} 
				
				if ($ip_type1 == "3"){
					$this->ct_date = $rivi[0];
					$this->ct_count = $rivi[1];
				}
				
				if ($ip_type1 == "4"){
					$this->ct_count = $rivi[0];
					$this->ct_ip = $rivi[1];
					$this->GetAddress();
				}
				
				if ($table == "1") {
					if ($ip_type1 == "1"){
						$this->Ct_Write_Row($inRow);
					}
					
					if ($ip_type1 == "2"){
						$this->Ct_Write_Row2($inRow);
					}
					
					if ($ip_type1 == "3"){
						$this->Ct_Write_Row3($inRow);
					}	
					
					if ($ip_type1 == "4"){
						$this->Ct_Write_Row4($inRow);
					}	
				}
			}
		} else {
			$this->Ct_Make_Info("Main", "0");
			if ($table == "1") {
				if ($ip_type1 == "1"){
					$this->Ct_Write_Row($inRow);
				}
				
				if ($ip_type1 == "2"){
					$this->Ct_Write_Row2($inRow);
				}
				
				if ($ip_type1 == "3"){
					$this->Ct_Write_Row2($inRow);
				}
			}				
		}
		
		if ($table == "1"){
			echo "</table>\n";
			echo "</td></tr></table>\n";
		}
	}
	
	/**
	 * ShowCounter
	 */
	public function ShowCounter(){
		$this->Ct_Info_Read("1");
	}
	
	/**
	 * Write counter
	 */
	 public function Ct_Write_Counter() {
		$this->Ct_Counter_Read();
		//echo "<table valign=\"top\" width=\"100%\" border = 0>\n";
		//echo "<tr>\n";
		//echo "<td align=\"center\" class=\"stylish-cBack\" width=\"100%\">" . 
		echo $this->ct_counter;
		//. "</td>\n";
		//echo "</tr>\n";
		//echo "</table>\n";
	 }
	 
	/**
	 * Write row to page
	 */
	 public function Ct_Write_Row($inRow) {
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $inRow . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_date . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_time . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_ip . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_hostname . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_page . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_product . "</td>\n";
		echo "</tr>\n";
	}
	
	/**
	 * Write row to page
	 */
	 public function Ct_Write_Row2($inRow) {
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $inRow . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_date . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_ip . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_hostname . "</td>\n";
		echo "</tr>\n";
	}
	
	/**
	 * Write row to page
	 */
	 public function Ct_Write_Row3($inRow) {
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $inRow . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_date . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_count . "</td>\n";
		echo "</tr>\n";
	}
	
	/**
	 * Write row to page
	 */
	 public function Ct_Write_Row4($inRow) {
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $inRow . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_count . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_ip . "</td>\n";
		echo "<td align=\"center\" class=\"stylish-cRows\" width=\"100%\">" . $this->ct_hostname . "</td>\n";
		echo "</tr>\n";
	}
	
	/**
	 * Make info to insert
	 */
	 public function Ct_Make_Info($tmp_page, $tmp_product){
		$this->GetDate();
		$this->GetTime();
		
		$this->ct_date = $this->temp_date;
		$this->ct_time = $this->temp_time;
		
		$this->ct_ip = $this->GetIp();
		$this->ct_page = $tmp_page;
		$this->ct_product = $tmp_product;
		$this->Ct_Counter();
		$this->Ct_Info_Insert();
	 }
	
	/**
	 * Check IP & date, If new in day Then add counter
	 */
	public function Ct_Counter(){
		if (!isset($db))
 			$db = new Database();
		/**
		 * Lataa countteri tiedot
		 */
		$this->Ct_Counter_Read();
			
 		$sql = "SELECT * FROM counter_info where ct_date = '$this->ct_date' and ct_ip = '$this->ct_ip'";
 		
		$haku = $db->AskSQL($sql);
		//echo "$sql<br>"; 
		if (mysql_num_rows($haku) == 0){
			$this->ct_counter = $this->ct_counter + 1;
			$sql = "SELECT * FROM counter";
 		
			$haku = $db->AskSQL($sql);
			
			if (mysql_num_rows($haku) == 0){
				$sql = "INSERT INTO counter (ct_counter, ct_startdate) VALUES ('$this->ct_counter', '$this->ct_startdate')";
			}else {
				$sql = "UPDATE counter SET ct_counter = '$this->ct_counter' where ct_startdate = '$this->ct_startdate'";
			}
			
			//echo "$sql<br>"; 
			
			$tulos = $db->UseSQL($sql);
		}
		
		$this->ct_counter_long = $this->gNro($this->ct_counter,7);
	}	
	 
	/**
	 * Counter_info_Insert
	 */
	public function Ct_Info_Insert(){
		if (!isset($db))
			$db = new Database();
			
		$sql = "INSERT INTO counter_info (ct_date, ct_time, ct_ip, ct_page, ct_product) VALUES ('$this->ct_date', '$this->ct_time', '$this->ct_ip', '$this->ct_page', '$this->ct_product')";

		$tulos = $db->UseSQL($sql);
	}
	
	/**
	 * GetDate
	 */
	 function GetDate() {
		$this->temp_date = date("Ymd");	
	 }

	/**
	 * GetTime
	 */
	 function GetTime() {
		$this->temp_time = date("H:i:s");  	
	 }
	 
	/**
	 * IP-Address
	 */
	function GetIp() {
		return $_SERVER["REMOTE_ADDR"];
	}
	
	/**
	 * Address from Ip
	 */
	function GetAddress() {
		$this->ct_hostname = gethostbyaddr($this->ct_ip);
	}
	
	
	
	/**
	 * Change numers
	 */
	public function gNro($inNro,$iLenght){
		return substr("00000000000000$inNro", -$iLenght);
	}
	
	/**
	 * Database tables
	 */
	function Sql(){
		/**
		CREATE TABLE IF NOT EXISTS `counter` (
			`ct_startdate` char(8) DEFAULT NULL,
			`ct_counter` int(12) DEFAULT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `counter_info` (
			`ct_date` char(8) DEFAULT NULL,
			`ct_time` char(8) DEFAULT NULL,
			`ct_ip` char(20) DEFAULT NULL,
			`ct_page` char(10) DEFAULT NULL,
			`ct_product` char(10) DEFAULT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		*/
	}
}
?>

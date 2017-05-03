<?php
/**
 * Heurex Rental 0.1
 * Advertising.php
 * 27.11.2013
 */ 
?>
<?php
class Advertising{
	var $ad_id;
	var $ad_Now;
	var $ad_New;
	var $ad_location;
	var $ad_start_time;
	var $ad_end_time;
	var $ad_information;
	var $ad_cadmin;
	var $ad_changeday;
	var $ad_cadmin_name;
	var $ad_iperson_name;
	var $ad_leftbox;
	var $ad_top_middlebox;
	var $ad_bottom_middlebox;
	var $ad_rightbox;
	/**
	 * Start Advertising
	 */
	public function Advertising(){
		$this->ad_id="";
		$this->ad_Now="";
		$this->ad_New="";
		$this->ad_location="";
		$this->ad_start_time="";
		$this->ad_end_time="";
		$this->ad_information="";
		$this->ad_cadmin="";
		$this->ad_changeday="";
		$this->ad_cadmin_name="";
		$this->ad_iperson_name="";
		$this->ad_leftbox="1";
		$this->ad_top_middlebox="1";
		$this->ad_bottom_middlebox="1";
		$this->ad_rightbox="1";
	}

	/**
	 * Adbox box
	 */
	public function Adbox(){
		$this->Adbox_01();
		$this->Adbox_02();
	}	

	/**
	 * Adbox box
	 */
	public function Adbox_01(){
		echo "<table><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		echo "<table valign=\"top\" width=\"140\">\n";
		echo "<tr><td class=\"stylish-button\">Allomeera Oy</td></tr>\n";
		echo "<tr><td class=\"stylish-cRows\">";
		echo "<a href=\"http://www.allomeera.fi\" target=\"_top\">";
		echo "<img src=\"images\banners/Allomeera_banner.png\" border=0 alt=\Allomeera Oy\" title=\"Allomeera Oy\" width=\"130\"/></a></center>";
		echo "</td></tr></table>\n";
		echo "</td></tr></table>";
	}	
	/**
	 * Verkkokauppa
	 */
	public function Adbox_02(){
		echo "<table><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		echo "<table valign=\"top\" width=\"140\">\n";
		echo "<tr><td class=\"stylish-button\">KlapiTuli</td></tr>\n";
		echo "<tr><td class=\"stylish-cRows\"><center><br>";
		echo "<a href=\"http://verkkokauppa.heurex.net/index.php?main_page=product_info&cPath=3&products_id=82\" target=\"_top\">";
		echo "<img src=\"images/banners/Klapitulisarja_send.jpg\" alt=\"Klapitulisarja_banneri\" title=\"Klapitulisarja_banneri\" width=\"130\" border='0'/></a><br>158&#8364;</center></td></tr>\n";
		echo "</table>\n";
		echo "</td></tr></table>";
	}
	
	/**
	 * Adbox box
	 */
	public function Adbox2(){
		echo "<table><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		
		echo "<table valign=\"top\" width=\"140\">\n";
		echo "<tr><td class=\"stylish-button\">KlapiTuli</td></tr>\n";
		echo "<tr><td class=\"stylish-cRows\"><object>";
		echo "<param name=\"movie\" value=\"http://www.youtube.com/v/YUwXD26w9yc?version=3&feature=player_detailpage\">";
		echo "<param name=\"allowFullScreen\" value=\"true\"><param name=\"allowScriptAccess\" value=\"always\">";
		echo "<embed src=\"http://www.youtube.com/v/YUwXD26w9yc?version=3&feature=player_detailpage\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" allowScriptAccess=\"always\" left=\"400\" top=\"400\" width=\"130\">";
		echo "</object></td></tr></table>\n";
		echo "</td></tr></table>";
		echo "<table><tr>";
		echo "<td align=\"center\" class=\"stylish-cBack\">";
		echo "<table valign=\"top\" width=\"140\">\n";
		echo "<tr><td class=\"stylish-button\">KlapiTuli</td></tr>\n";
		echo "<tr><td class=\"stylish-cRows\"><center><br>";
		echo "<a href=\"http://verkkokauppa.heurex.net/index.php?main_page=product_info&cPath=3&products_id=82\" target=\"_top\">";
		echo "<img src=\"images/banners/Klapitulisarja_send.jpg\" alt=\"Klapitulisarja_banneri\" title=\"Klapitulisarja_banneri\" width=\"130\" border='0'/></a><br>149&#8364;</center></td></tr>\n";
		echo "</table>\n";
		echo "</td></tr></table>";
	}	
	/**
	 * InfoBox
	 */
	public function InfoBox(){
		//include 'includes/Counter.php';
		//if (!isset($counter))
		//	$counter = new Counter();
			
		$user_ip = $counter->Ct_ip; //$_SERVER['REMOTE_ADDR'];
		
		//if ($user_ip == "66.249.71.68") {
		//	$user_ip = $user_ip . " TARKISTAPPA TIETOKONEESI KELLO! Antaa v��ri� aikoja tietokantaan, tv. Markku T.";
		//}
		
		echo "<table width=\"100%\" border = 0><tr><td align=\"center\" class=\"stylish-cBack\" width=\"100%\"><table valign=\"top\" width=\"100%\" border = 0>\n";
		echo "<tr><td class=\"stylish-button\">&copy;Markku Tauriainen 040-5616629, Heurex Oy, Hyllil&#228;nkuja 5B, 33730 Tampere, Finland Your IP = " . 
		
		$user_ip . " Counter:" . $counter->Ct_Write_Counter() . "</td>";
		
		echo "<td class=\"stylish-button\"><a href=\"index.php?page=saannot\" target=\"_top\">Vuokrauksen s&#228;&#228;nn&#246;t!</a></td>";
		echo "<td class=\"stylish-button\"><a href=\"index.php?page=palvelu\" target=\"_top\">Asiakaspalvelu</a></td></tr></table>\n";
		echo "</td></tr></table>";
		
		
		echo "<table width=\"100%\"><tr><td align=\"center\" class=\"stylish-cBack\" width=\"100%\">";
		echo "<table width=\"100%\"><tr><td>";
		echo "<img src=\"http://img.verkkomaksut.fi/index.svm?id=20468&type=horizontal&cols=10&text=1&auth=f4b655c81d5e1d6b\" alt=\"Suomen Verkkomaksut\" />";
		echo "</td></tr></table>\n";
	}
	
	/**
	 * IP-Address
	 */
	function getip() {
		return $_SERVER["REMOTE_ADDR"];
	}
}
?>

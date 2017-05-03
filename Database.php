<?php
/**
 * Heurex Rental
 * Database.php
 * 24.05.2012
 */
class Database
{
	/**
	 * M‰‰ritell‰‰n luokan muuttujat
	 */
	var $server;
	var $name;
	var $username;
	var $password;
	var $connection;
	
	/**
	 * Tietokanta-olion alustusfunktio
	 */
	public function Database() {
		//m‰‰ritell‰‰n k‰ytett‰v‰n MySQL-palvelimen osoite, tietokannan nimi, k‰ytt‰j‰tunnus ja salasana
		$this->server = "localhost";
		$this->name = DB_DATABASE;
		$this->username = DB_SERVER_USERNAME;
		$this->password = DB_SERVER_PASSWORD;
	}
	
	/**
	 * Ask SQL
	 */
	public function AskSQL($sql) {
		//print "AskSQL: $sql<br>\n";
		$this->OpenDBConnection();
		$tulos = mysql_query("$sql");
		if (!$tulos) {
 		   die('Invalid query: ' . mysql_error());
 		   //print "AskSQL: $sql<br>\n";
		}
		$this->CloseDBConnection();
		return $tulos;		
	}
	
	/**
	 * Make SQL insert update delete
	 */
	public function UseSQL($sql) {
		$this->OpenDBConnection();
		$tulos = mysql_query("$sql");
		if (!$tulos) {
 		   die('Invalid query: ' . mysql_error());
 		  // print "UseSQL: $sql<br>\n";
		}
		$this->CloseDBConnection();		
		return $tulos;
	}
	
	/**
	 * Open MySQL-database
	 */
	public function OpenDBConnection() {
		//avataan yhteys m‰‰riteltyyn MySQL-tietokantapalvelimeen
		//print "<br>server: $this->server<br>User: $this->username<br>Password: $this->password<br>";
		$this->connection = mysql_connect($this->server, $this->username, $this->password) or die ("En voinut loggautua.");;
		//$this->connect = mysql_connect ( $this->dbhost, $this->dbuser, $this->dbpassword)
		if (!$this->connection) 
		{
			die('Could not connect: ' . mysql_error());
		}
		//valitaan k‰ytett‰v‰n tietokannan nimi
		mysql_selectdb($this->name);	
	}
	
	/**
	 * Close MySQL-Database
	 */
	public function CloseDBConnection()	{
		$this->connection = mysql_close();
	}
	
	public function gNro($inNro,$iLenght){
		return substr("00000000000000$inNro", -$iLenght);
	}
}
?>

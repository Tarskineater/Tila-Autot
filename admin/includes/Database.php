<?php
/**
 * Heurex Rental
 * Database.php
 * 03.05.2012
 */
class Database
{
	/**
	 * Määritellään luokan muuttujat
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
		//määritellään käytettävän MySQL-palvelimen osoite, tietokannan nimi, käyttäjätunnus ja salasana
		$this->server = "localhost";
		$this->name = DB_DATABASE;
		$this->username = DB_SERVER_USERNAME;
		$this->password = DB_SERVER_PASSWORD;
	}
	
	/**
	 * Ask SQL
	 */
	public function AskSQL($sql) {
		$this->OpenDBConnection();
		$tulos = mysql_query("$sql");
		if (!$tulos) {
 		   die('Invalid query: ' . mysql_error());
 		   print "AskSQL: $sql<br>\n";
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
 		   print "UseSQL: $sql<br>\n";
		}
		$this->CloseDBConnection();		
		return $tulos;
	}
	
	/**
	 * Open MySQL-database
	 */
	public function OpenDBConnection() {
		//avataan yhteys määriteltyyn MySQL-tietokantapalvelimeen
		//print "<br>$this->server<br>$this->username<br>$this->password<br>";
		$this->connection = mysql_connect($this->server, $this->username, $this->password);
		if (!$this->connection) 
		{
			die('Could not connect: ' . mysql_error());
		}
		//valitaan käytettävän tietokannan nimi
		mysql_selectdb($this->name);	
	}
	
	/**
	 * Close MySQL-Database
	 */
	public function CloseDBConnection()	{
		$this->connection = mysql_close();
	}
}
?>

<?php
/**	configure.php */
?>
<?php
/**	Setup data  **/
define('LANG', 'finnish');
define('WEB_WIDTH', '850');

/**	Web address **/
define('HTTP_SERVER', 'http://tila-autot.heurex.fi');
define('HTTPS_SERVER', 'http://tila-autot.heurex.fi');

/**	Directories **/
define('DIR_IMAGES', 'images/');
define('DIR_PICTURES', DIR_IMAGES . "buttons/");
define('DIR_INCLUDES', 'includes/');

/**	Define our database connection **/
define('DB_TYPE', 'mysql');
define('DB_PREFIX', 'rental_');
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'int35859_rental1'); //'int35859_rental1');
define('DB_SERVER_PASSWORD', '123Heurex654'); //'123Heurex654');
define('DB_DATABASE', 'int35859_rental1');

/**	Info about**/
define('INFO_COPY', '&copy;Markku Tauriainen 2012 v.0.1');


/**	The next 2 "defines" are for SQL cache support.**/
define('SQL_CACHE_METHOD', 'file');
//define('DIR_FS_SQL_CACHE', DIR_FS_CATALOG.'cache');
define('EURO', '&#8364;');

global $db;
global $user;
global $car;
global $locations;
global $accessories;
global $projects;
global $reservations;
global $fixdate;
global $xls;
global $logo;
global $page;
global $page2;
global $delete;
global $register;
global $login;
global $action;
global $username;
global $show;
global $list;
global $edit;
global $new;	
global $reserve;	
global $id;
global $copy2new;
global $places;
global $sessio_id;
global $location_id;
global $return;
global $test_type;
global $cardelete;
global $carupdate;
<?php
/**	configure.php */
?>
<?php
/**	Setup data  **/
define('LANG', 'finnish');
define('WEB_WIDTH', '850');

/**	Web address **/
define('HTTP_SERVER', 'http://www.tila-autot.com');
define('HTTPS_SERVER', 'http://www.tila-autot.com');

/**	Directories **/
define('DIR_IMAGES', 'images/');
define('DIR_PICTURES', DIR_IMAGES . "buttons/");
define('DIR_INCLUDES', 'includes/');

/**	Define our database connection **/
define('DB_TYPE', 'mysql');
define('DB_PREFIX', 'rental_');
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root'); //'int35859_rental1'root);
define('DB_SERVER_PASSWORD', ''); //'123Heurex654');
define('DB_DATABASE', 'int35859_rental1');

/**	Info about**/
define('INFO_COPY', '&copy;Markku Tauriainen 2012 v.0.1');


/**	The next 2 "defines" are for SQL cache support.**/
define('SQL_CACHE_METHOD', 'file');
//define('DIR_FS_SQL_CACHE', DIR_FS_CATALOG.'cache');
define('EURO', '&#8364;');

define ('MERCHANT_ID','20468');// 20468 oma / 13466 test
define ('REFERENCE_NUMBER','');
define ('CURRENCY','EUR');
define ('RETURN_ADDRESS','http://www.tila-autot.com/index.php?page=sell&sell=success');
define ('CANCEL_ADDRESS','http://www.tila-autot.com/index.php?page=sell&sell=cancel');
define ('PENDING_ADDRESS','http://www.tila-autot.com/index.php?page=sell&sell=pending');
define ('NOTIFY_ADDRESS','http://www.tila-autot.com/index.php?page=sell&sell=notify');
define ('CULTURE','fi_FI');
define ('PRESELECTED_METHOD','');
define ('MODE','1');
define ('VISIBLE_METHODS','');
define ('GROUP','');
define ('INCLUDE_VAT','1');
define ('TESTIOY','3PJzfNwp2bGtv1AMxRXSEnWsTB9WpS'); //3PJzfNwp2bGtv1AMxRXSEnWsTB9WpS oma / 6pKF4jkv97zmqBJ3ZL8gUw5DfT2NMQ test
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
?>
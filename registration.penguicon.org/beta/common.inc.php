<?php

include_once('./config-db.inc.php');
require_once('./config.inc.php');

define("DB_HOST",$db_host);
define("DB_USER",$db_user);
define("DB_PASSWD",$db_password);
define("DB_DATABASE",$db_database);



session_start();

include_once("lib/login_functions.php");
include_once("lib/page_functions.php");

//Connect to the database
$db=mysql_connect(DB_HOST,DB_USER,DB_PASSWD);
mysql_select_db(DB_DATABASE,$db);


?>

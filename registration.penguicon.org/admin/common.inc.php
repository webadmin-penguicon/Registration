<?php

include_once("../config.inc.php");
include_once("../common.inc.php");

$email_confirmation_text = "Your Penguicon order has been processed.  ";
$email_confirmation_text .= "The following items will be waiting for you at the ";
$email_confirmation_text .= "Registration desk.  If there are multiple lines at the time you arrive, ";
$email_confirmation_text .= "please pick your items up from the Pre-Registration line.\n\n ";

define("CONFIRMATION_TEXT",$email_confirmation_text);

include_once("lib/login_functions.php");
include_once("lib/page_functions.php");

session_start();


//Connect to the database
$db=mysql_connect(DB_HOST,DB_USER,DB_PASSWD);
mysql_select_db(DB_DATABASE,$db);


?>
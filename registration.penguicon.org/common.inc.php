<?php

/********************************************************/
/*                                                      */
/*       Make all your changes to config.inc.php        */
/*                                                      */
/*          No user-serviceable parts below!            */
/*                                                      */
/********************************************************/

include_once("config.inc.php");

//Turn everything possible into defined constants so we can safely
//use them globally.
define("TODAY",date("Y-m-d"));
//define("TODAY","2014-05-01");

if ($con_year) {
    define("CON_YEAR",$con_year);
} else {
    define("CON_YEAR",date("Y"));
}
define("BADGE_EMAIL_SUBJECT",CON_YEAR." registration submission");
define("RIBBON_EMAIL_SUBJECT",CON_YEAR." ribbon order");
define("CON_START",$con_start);
define("CON_END",$con_end);
define("PREREG_CLOSES", $badge_prereg_closes);
define("AT_DOOR_BADGE",	$at_door_badge_cost);
define("BADGE_EMAIL_TO",$badge_email_to);
define("EMAIL_FROM",$email_from);
define("SPECIAL_BADGES_AVAILABLE",$special_badges_available);
define("WARNING_FOR_SPECIAL_BADGES",$warning);
define("RIBBON_CLOSES", $ribbon_prereg_closes);
define("RIBBONS_AVAILABLE",$ribbons_available);
define("RIBBON_SETUP_FEE",$ribbon_setup_fee);
define("RIBBON_PER_ITEM_FEE",$ribbon_per_item_fee);
define("RIBBON_LINK",$ribbon_vendor_link); 
define("RIBBON_EMAIL_TO",$ribbon_email_to);
define("RIBBON_CHAR_LIMIT",$ribbon_character_limit);
define("DB_HOST",$db_host);
define("DB_USER",$db_user);
define("DB_PASSWD",$db_password);
define("DB_DATABASE",$db_database);

//Set the correct price for a weekend badge, based on today's date.
foreach ($badge_cutoff_dates as $cutoff_date => $cutoff_price) {
    if (TODAY <= $cutoff_date) {
        if ($badge_cost['weekend'] > $cutoff_price) { $badge_cost['weekend'] = $cutoff_price; }
    }
}

if (isset($_COOKIE['ordernum'])) {
    $order = $_COOKIE['ordernum'];
} else {
   $ip=str_replace(".","",$_SERVER['REMOTE_ADDR']);
   $time = date("Ymdhi");
   $order = $time.$ip;
   $expire = 60*60*24*7;
   setcookie("ordernum",$order, time()+$expire);
}

$protocol = 'http://';

if (isset($_SERVER['HTTPS'])) {
    if ($_SERVER['HTTPS'] == 'on' OR $_SERVER['HTTPS'] == 1) {
        $protocol = 'https://';
    }

    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) AND $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    }
}

$baseurl = $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
define("BASEURL",$baseurl);

/*
session_start();

//Setup the session
$do_list_cart = 0;
if (isset($_SESSION['order'])) {
   $order = $_SESSION['order']; 
   $do_list_cart = 1;
} else {
   //Session id is timestamp + IP
   $ip=str_replace(".","",$_SERVER['REMOTE_ADDR']);
   $time = date("Ymdhi");
   $order = $time.$ip;
   $_SESSION['order'] = $order;
}
*/

//Combine the badges
if (SPECIAL_BADGES_AVAILABLE) {
    $badge_types = array_merge($badge_name_and_info,$special_badge_name_and_info);
} else {
    $badge_types = $badge_name_and_info;
}

//Connect to the database
$db=mysql_connect(DB_HOST,DB_USER,DB_PASSWD);
mysql_select_db(DB_DATABASE,$db);

?>

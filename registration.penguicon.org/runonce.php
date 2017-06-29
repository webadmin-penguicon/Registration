<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();
    include_once("lib/database_functions.php");

//Remove badge number 9999

    $badge = array();
    $badge['con_year'] = "2014";
    $sql = "DELETE FROM badges WHERE badge_number='9999'";
    mysql_query($sql);



}
?>

<?php
include_once("common.inc.php");
include_once("lib/payment_functions.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    if ($_POST['submit']) {
        add_refund_to_database();
        $id = mysql_insert_id();
        $error = mysql_error();    
        echo "You entered a refund.  It has an id of ".$id;
        echo "<p>".$error;
    } else {
        display_refund_form();
    }

}

?>


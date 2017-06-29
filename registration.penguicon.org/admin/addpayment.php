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
        /****** TO-DO: Error-checking  *******/
        add_payment_to_database();
        $id = mysql_insert_id();
        process_payment($id);
        echo "You entered a payment.";
    } else {
        display_payment_form();
    }

}

?>


<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    if ($_GET['id']) { 


        include_once("lib/database_functions.php");
        include_once("lib/order_functions.php");

        $id = $_GET['id'];

        if (is_numeric($id)) {
            process_order_without_payment($id);
        } else {
            echo "<p>I need a number for the id, silly!";
            echo "<br><a href='vieworder.php'>Go back and try it again</a>\n";
        }

    } else {

        echo "<p>The potential for mistakes is very high if I let you just enter an order number.\n";
        echo "<br>Why don't you go find a report and get there from here?\n";

    }

}

?>

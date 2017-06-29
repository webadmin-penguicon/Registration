<?php
include_once("common.inc.php");
include_once("lib/payment_functions.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_header();

    $id = $_GET['id'];
    process_payment($id);
}

?>


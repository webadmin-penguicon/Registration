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
        echo $buffer;
        $payment = $_POST['id'];
        confirm_new_payment($payment);
    } else {
        header('Location: addpayment.php');
    }

}

?>


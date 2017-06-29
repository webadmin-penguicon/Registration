<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    $by = $_GET['by'];
    if ($by != "name") { $by = "number"; }

    $badge_sql = mysql_query("SELECT * FROM other_charges WHERE reason like '%refunded%'");
    while ($row = mysql_fetch_array($badge_sql)) {

        echo "<p>";
        $order_sql = mysql_query("SELECT lastname,firstname FROM master_orders WHERE id='".$row['order_number']."'");
        $order_row = mysql_fetch_array($order_sql);
        echo $order_row['lastname'].", ".$order_row['firstname'];
        echo "<br>";
        echo "$".$row['amount']." --- ".$row['reason']." --- ".$row['transaction_id'];

    }

}

?>

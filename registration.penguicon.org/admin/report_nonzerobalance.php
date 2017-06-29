<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><b>People with non-zero balances</b></p>\n";

//How the hell are we tracking this?
//It has to be by order number.
//Crud.
//Right then.  For each order number:
//Find a payment.
//Find all items that cost money (ribbons, badges, other_charges
//Compare payment to charge total

    $order_sql = mysql_query("SELECT * FROM master_orders");
    while ($order_row = mysql_fetch_array($order_sql)) {
        $order = $order_row['id'];
        $order_cost = 0.00;
        $paid_amt = 0.00;
        $last_payment = array();
        $payment_sql = mysql_query("SELECT * FROM payments WHERE order_id = '".$order."'");
        while ($payment_row = mysql_fetch_array($payment_sql)) {
            $paid_amt += $payment_row['payment_amt'];
            $last_payment = $payment_row;
        }
        $badge_sql = mysql_query("SELECT * FROM badges WHERE order_number = '".$order."'");
        while ($badge_row = mysql_fetch_array($badge_sql)) {
            $order_cost += $badge_row['cost'];
        }
        $ribbon_sql = mysql_query("SELECT * FROM ribbons WHERE order_number = '".$order."'");
        while ($ribbon_row = mysql_fetch_array($ribbon_sql)) {
            $order_cost += $ribbon_row['cost'];
        }
        $other_sql = mysql_query("SELECT * FROM other_charges WHERE order_number = '".$order."'");
        while ($other_row = mysql_fetch_array($other_sql)) {
            $order_cost += $other_row['amount'];
        }

        $paid_amt = number_format($paid_amt,2);
        $order_cost = number_format($order_cost,2);

        if ($paid_amt != $order_cost) {
            echo "<p><a href='vieworder.php?id=".$order."'>".$order."</a>";
            echo " - ".$order_row['lastname'].", ".$order_row['firstname'];
            echo "<br>";
            if ($paid_amt > $order_cost) {
                echo "Refund due: $";
                echo $paid_amt - $order_cost;
                echo " - ".$last_payment['payment_type']." transaction ";
                echo $last_payment['transaction_id'];
                echo " on ".$last_payment['payment_date'];
                echo " from ".$last_payment['payment_email'];
            } else {
                echo "Owes $";
                echo $order_cost - $paid_amt;
            }
        }


    }

}

?>

<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><b>This report includes ONLY orders that have been not been processed.  ";
    echo "\nProcessed orders are different reports.</b></p>\n";

    $order_sql = mysql_query("SELECT * FROM master_orders WHERE order_processed = 0");

    echo "<table border=1 width='100%'>\n";
    echo "<tr><th>Order #</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Date</th>";
    echo "<th>Amount</th>";
    echo "<th></th>";
    echo "</tr>\n";
    while ($row = mysql_fetch_array($order_sql)) {
        echo "<tr>";

        echo "<td>";
        echo "<a href='vieworder.php?id=";
        echo $row['id'];
        echo "'>";
        echo $row['id'];
        echo "</a>";
        echo "</td>";

        echo "<td>";
        echo $row['lastname'].", ",$row['firstname'];
        echo "</td>";

        echo "<td>";
        echo $row['email'];
        echo "</td>";

        echo "<td>";
        echo $row['date'];
        echo "</td>";

        echo "<td>";
        echo $row['total_cost'];
        echo "</td>";

        echo "<td>";
        echo "<a href='processorder.php?id=".$row['id']."'>";
        echo "Process without payment";
        echo "</a>\n";
        echo "</td>";

        echo "</tr>\n";
    }
    echo "</table>\n";


}

?>

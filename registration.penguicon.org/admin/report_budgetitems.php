<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><b>Items paid via convention budget</b></p>\n";

    $count = array();
    $expected_income = array();
    $paid_income = array();
    $total_badges = 0;

    $badge_sql = mysql_query("SELECT * FROM payments WHERE payment_type='budget' ORDER BY con_year,payment_note");

    echo "<table>\n";
    echo "<tr><th>Amount</th>";
    echo "<th>Year</th>";
    echo "<th>Department</th>";
    echo "</tr>";

    while ($row = mysql_fetch_array($badge_sql)) {

        echo "<tr>";

        echo "<td>";
        echo $row['payment_applied'];
        echo "</td>";

        echo "<td>";
        echo $row['con_year'];
        echo "</td>";

        echo "<td>";
        echo $row['payment_note'];
        echo "</td>";

        echo "</tr>\n";
    }
    echo "</table>\n";

    $total_ribbon_cost = array();
    $order_sql = mysql_query("SELECT cost,con_year FROM ribbons");
    while ($row = mysql_fetch_array($order_sql)) {
        $total_ribbon_cost[$row['con_year']] += $row['cost'];
    }

    echo "<p><p><b>Cost for entire ribbon order: </b>";
    foreach ($total_ribbon_cost as $year => $cost) {
        echo "<br>".$year.": $".$cost;
    }

}

?>

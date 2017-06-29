<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><b>Badgename differences</b></p>\n";

    $order_by = "badge_number,con_year";

    $badge_sql = mysql_query("SELECT * FROM badges ORDER BY ".$order_by);
    $count = 1;
    while ($row = mysql_fetch_array($badge_sql)) {

        echo "<br>";
        echo $row['badge_number'];
        echo " --- ";
        echo $row['con_year'];
        echo " --- ";
        echo $row['last_name'].", ".$row['first_name'];
        echo " --- ";
        echo $row['badge_name'];
        echo " --- ";
        echo $row['cost'];

        $count++;
        if ($count > 5) {
            echo "<hr />";
            $count = 1;
        }

    }

}

?>

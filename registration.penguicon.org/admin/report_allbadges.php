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

    echo "<p><b>All badges by ".$by."</b></p>\n";

    if ($by == "name") {
        $order_by = "last_name,first_name";
    } else {
        $order_by = "badge_number";
    }
    $badge_sql = mysql_query("SELECT * FROM badges WHERE con_year = ".CON_YEAR." ORDER BY ".$order_by);
    $count = 1;
    while ($row = mysql_fetch_array($badge_sql)) {

        echo "<br>";
        echo $row['badge_number'];
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

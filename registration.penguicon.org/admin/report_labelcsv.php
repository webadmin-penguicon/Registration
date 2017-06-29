<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><b>Badge Envelope Labels:</b><p>\n";

    $order_sql = mysql_query("SELECT * FROM badges WHERE con_year = '".CON_YEAR."' ORDER BY badge_number");

    $panelists = "";

    echo "<pre>\n";
    echo "Last Name, First Name, Badge Number\n";
    while ($row = mysql_fetch_array($order_sql)) {

        echo $row['last_name'];
        echo ",";

        echo $row['first_name'];
        echo ",";

        echo $row['badge_number'];
        echo "\n";

        if ($row['has_panels'] && $row['panelist_name']) {
            $panelists .= $row['last_name'];
            $panelists .= ",";
            $panelists .= $row['first_name'];
            $panelists .= ",";
            $panelists .= $row['panelist_name'];
	    $panelists .= "\n";
        }

    }
    echo "</pre>\n";

    echo "<p><b>Ribbon Bag Labels:</b><p>\n";

    $ribbon_sql = mysql_query("SELECT * FROM ribbons WHERE con_year='".CON_YEAR."'");

    echo "<pre>";
    echo "Last Name, First Name\n";

    while ($row = mysql_fetch_array($ribbon_sql)) {

        echo $row['last_name'];
        echo ",";

        echo $row['first_name'];
        echo ",";

        echo $row['ribbon_qty'];
        echo ",";

        echo $row['ribbon_text'];
        echo ",";

        echo $row['ribbon_text2'];
	echo "\n";

    }
    echo "</pre>";

    echo "<p><b>Panelist Packet Labels:</b><p>\n";

    echo "Last Name, First Name\n";

    echo "<pre>";
    echo $panelists;
    echo "</pre>";


}

?>

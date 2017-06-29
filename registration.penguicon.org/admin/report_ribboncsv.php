<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><p>\n";

    $order_sql = mysql_query("SELECT * FROM ribbons WHERE con_year = '".CON_YEAR."' ORDER BY ribbon_textcolor");

    echo "<pre>\n";
    echo "Last Name, First Name, Text, Text Line 2, Ribbon Color, Text Color, Quantity, Font, Number of Lines\n";
    while ($row = mysql_fetch_array($order_sql)) {

    	echo $row['last_name'];
	echo ",";

    	echo $row['first_name'];
	echo ",";

        $numlines = 1;
        echo $row['ribbon_text'];
        echo ",";

        if ($row['ribbon_text2']) {
            echo $row['ribbon_text2'];
            $numlines = 2;
        }
        echo ",";

        echo $row['ribbon_color'];
        echo ",";

        echo $row['ribbon_textcolor'];
        echo ",";

        echo $row['ribbon_qty'];
        echo ",";

        echo $row['ribbon_font'];
        echo ",";

        echo $numlines;
        echo "\n";

    }
    echo "</pre>\n";


}

?>

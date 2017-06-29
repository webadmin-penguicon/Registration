<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    $nonullsql = mysql_query("UPDATE badges SET paid=0.00 WHERE paid IS NULL");

    $wherestring = "con_year = ".CON_YEAR." AND (cost > paid)";
    $order_by = "last_name, first_name";

    $badge_sql = mysql_query("SELECT * FROM badges WHERE ".$wherestring." ORDER BY ".$order_by);
    $count = 1;
    while ($row = mysql_fetch_array($badge_sql)) {

        echo "<p>&nbsp;</p>";
        echo "<b>".$row['last_name'].", ".$row['first_name'];
        echo " --- Badge  ";
        echo $row['badge_number'];
        echo "</b></p><p>";

	echo "<table border=0 width=100%>";
	echo "<tr><td width=30%>Badge cost:</td>";
	echo "<td>";
        echo $row['cost'];
	echo "</td>";
	echo "<td>Amount paid &nbsp; &nbsp; &nbsp; <br/>&nbsp;</td></tr>\n";

	echo "<tr><td>Amount paid:</td>";
	echo "<td>";
        echo $row['paid'];
	echo "</td>";
	echo "<td>Method of payment<br/>&nbsp;</td></tr>\n";

	echo "<tr><td>&nbsp;</td><td>___________</td><td></td></tr>\n";

	echo "<tr><td><b>Total due:</b></td>";
	echo "<td>";
	$amtdue = $row['cost'] - $row['paid'];
        echo "$".number_format($amtdue,2);
	echo "</td>";

	echo "<td>Registration staff initials<br/>&nbsp;</td></tr>\n";
	echo "</table></p>\n";

    }

}

?>

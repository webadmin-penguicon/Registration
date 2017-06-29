<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    $wherestring = "con_year='".CON_YEAR."' AND (type='staff' OR type='panelist' OR type='concom')";

    echo "<p><b>Showing ";
    $confirmed = $_GET['confirmed'];
    if ($confirmed) {
        echo "ALL";
        $opposite_num = "0";
        $opposite_name = "only the UNCONFIRMED ones";
    } else {
        echo "only UNCONFIRMED";
        $opposite_num = 1;
        $opposite_name = "ALL";
        $wherestring .= " AND (staff_confirmed_by = '' OR staff_confirmed_by IS NULL)";
    }
    echo " staff, panelists, and concom.  <a href='".$_SERVER['PHP_SELF']."?confirmed=".$opposite_num."'>";
    echo "Show ".$opposite_name.".</a></b></p>\n";

    $order_sql = mysql_query("SELECT * FROM badges WHERE ".$wherestring);

    echo "<table border=1 width='100%'>\n";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Amount Paid</th>";
    echo "<th>Confirmed By</th>";
    echo "</tr>\n";
    while ($row = mysql_fetch_array($order_sql)) {
        echo "<tr>";

        echo "<td>";
        echo $row['last_name'].", ",$row['first_name'];
        echo "</td>";

        echo "<td>";
        echo $row['email'];
        echo "</td>";

        echo "<td>";
        echo $row['paid'];
        echo "</td>";

        echo "<td>";
        echo $row['staff_confirmed_by'];
        echo "</td>";

        echo "</tr>\n";
    }
    echo "</table>\n";


}

?>

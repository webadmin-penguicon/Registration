<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><b>This report includes ONLY badges that have been processed.  ";
    echo "\nUnprocessed badges are a different report.</b></p>\n";

    $count = array();
    $expected_income = array();
    $paid_income = array();
    $total_badges = 0;

    $badge_sql = mysql_query("SELECT * FROM badges WHERE con_year=".CON_YEAR." ORDER BY type");

    while ($row = mysql_fetch_array($badge_sql)) {
        $type = $row['type'];
        if ($type == "weekend") { $type = $type."-".$row['cost']; }
        if ($type == "panelist") { $type = $type."-".$row['cost']; }
        if (array_key_exists($type,$count)) {
            $count[$type] += 1;
        } else {
            $count[$type] = 1;
        }

        if (array_key_exists($type,$expected_income)) {
            $expected_income[$type] += $row['cost'];
        } else {
            $expected_income[$type] = $row['cost'];
        }

        if (array_key_exists($type,$paid_income)) {
            $paid_income[$type] += $row['paid'];
        } else {
            $paid_income[$type] = $row['paid'];
        }
        $total_badges += 1;
    }

    foreach ($count as $badge_type => $value) {
        echo "<p>".$value." ".ucfirst($badge_type)." badges:";
        echo "<br> &nbsp; bringing in \$".$expected_income[$badge_type];
        echo " (of which \$".$paid_income[$badge_type]." is paid)\n";
    }

    echo "<p><b>Total badges sold: </b>".$total_badges;

}

?>

<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    echo "<p><p>\n";

    $order_sql = mysql_query("SELECT * FROM order_details_archive WHERE ribbon_font != ''");

    while ($row = mysql_fetch_array($order_sql)) {

        $ribbon_sql = "UPDATE ribbons SET ribbon_font='";
	$ribbon_sql .= $row['ribbon_font'];
	$ribbon_sql .= "' WHERE con_year='2016' AND ribbon_text='";
	$ribbon_sql .= $row['ribbon_text'];
	$ribbon_sql .= "' AND ribbon_color='";
	$ribbon_sql .= $row['ribbon_color'];
	$ribbon_sql .= "'";

	echo "<p>SQL is ".$ribbon_sql;
	$temp = mysql_query($ribbon_sql);

    }



}

?>

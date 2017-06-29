<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();
    include_once("lib/database_functions.php");

//Set the date of the order in the item entry

   $ordersql = mysql_query("SELECT id,firstname,lastname,date from master_orders");
   while ($row = mysql_fetch_array($ordersql)) {
        echo "<p>Checking order number ".$row[id];
        $check_sql = mysql_query("SELECT first_name,last_name from ribbons WHERE order_number='".$row[id]."'");
        while ($check_row = mysql_fetch_array($check_sql)) {
             if (!$check_row['last_name']) {
                  $ribbon_sql = "UPDATE ribbons ";
                  $ribbon_sql .= "SET first_name='".$row['firstname']."'";
                  $ribbon_sql .= ",last_name='".$row['lastname']."'";
                  $ribbon_sql .= " WHERE order_number=".$row['id'];
                  echo "<p>".$ribbon_sql;
                  $temp = mysql_query($ribbon_sql);
             }
        }
   }


}
?>

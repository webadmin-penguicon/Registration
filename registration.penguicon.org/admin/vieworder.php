<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    if ($_GET['id']) { 

        include_once("lib/database_functions.php");
        include_once("lib/order_functions.php");

        $id = $_GET['id'];

        if (is_numeric($id)) {
            $total_cost = 0;
            $order_info = get_order_info($id);
            echo "<p>Order #";
            echo $order_info['id'];
            echo "<br>";
            echo $order_info['total_cost']." on ";
            echo $order_info['date'];
            echo "<br>";
            echo $order_info['lastname'].", ".$order_info['firstname'];
            echo " (".$order_info['email'].")";

            echo "<p>Pending items:";
            $has_item = 0;
            $item_total = 0;
            $sql = mysql_query("SELECT * FROM order_details WHERE session='".$order_info['session']."'");
            while ($row=mysql_fetch_array($sql)) {
                $item_total += $row['item_cost'];
                $total_cost += $row['item_cost'];
                echo "<p>";
                echo "<br>Pick-up name: ";
                echo $row['lastname'].", ".$row['firstname'];
                echo "<br>";
                echo ucfirst($row['item_type']);
                switch ($row['item_type']) {
                    case "ribbon":
                        echo "<br>";
                        echo $row['ribbon_qty']." with ";
                        echo $row['ribbon_textcolor']." text on a";
                        echo $row['ribbon_color']." background.\n";
                        echo "<br>";
                        echo $row['ribbon_text'];
                        if ($row['ribbon_text2']) {
                            echo "<br>".$row['ribbon_text2'];
                        }
                        break;
                    default:
                        echo " badge";
                        echo "<br>Badge name: ";
                        if ($row['badgename']) {
                            echo $row['badgename'];
                        } else {
                            echo " (blank)";
                        }
                }
                echo "<br>Pending cost: ".$row['item_cost'];
                
            }
            if ($has_item == 0) { 
                echo "<p>No pending items on order\n";
            }

            $has_item = 0;
            echo "<p>";
            $badge_sql = mysql_query("SELECT * FROM badges WHERE order_number = '".$id."'");
            while ($badge_row = mysql_fetch_array($badge_sql)) {
                $has_item = 1;
                $total_cost += $badge_row['cost'];
                echo "<br>";
                echo $badge_row['type']." badge #".$badge_row['badge_number']." for ";
                echo $badge_row['last_name'].", ".$badge_row['first_name'];
                echo " - $".$badge_row['cost'];
            }

            $ribbon_sql = mysql_query("SELECT * FROM ribbons WHERE order_number = '".$id."'");
            while ($ribbon_row = mysql_fetch_array($ribbon_sql)) {
                $has_item = 1;
                $total_cost += $ribbon_row['cost'];
                echo "<br>";
                echo $ribbon_row['ribbon_qty']." ribbons with ";
                echo $ribbon_row['ribbon_text'];
                if ($ribbon_row['ribbon_text2']) {
                    echo "/";
                    echo $ribbon_row['ribbon_text2'];
                }
                echo " - ".$ribbon_row['cost'];
            }

            $other_sql = mysql_query("SELECT * FROM other_charges WHERE order_number = '".$id."'");
            while ($other_row = mysql_fetch_array($other_sql)) {
                $has_item = 1;
                $total_cost += $other_row['amount'];
                echo "<br>";
                echo "Other charge: ";
                echo $other_row['amount'];
                echo " (".$other_row['reason'].")";
            }

            if ($has_item == 0) { 
                echo "No processed items on order\n";
            } 

            echo "<p><b>Total cost of items:</b> $".$total_cost;


            $has_item = 0;
            echo "<p>";
            $payment_sql = mysql_query("SELECT * FROM payments WHERE order_id = '".$id."'");
            while ($payment_row = mysql_fetch_array($payment_sql)) {
                $has_item = 1;
                echo "<br>";
                echo "Payment of ".$payment_row['payment_amt'];
                echo " on ".$payment_row['payment_date'];
                echo " via ".$payment_row['payment_type'];
            }

            if ($has_item == 0) { 
                echo "No payments made on order\n";
            }


        } else {
            echo "<p>I need a number for the id, silly!";
            echo "<br><a href='vieworder.php'>Go back and try it again</a>\n";
        }

    } else {

        echo "<div>\n";
        echo "<form method='get' action='".$_SERVER['PHP_SELF']."'>\n";
        echo "Order id: ";
        echo " &nbsp; <input type='text' size='10' name='id'>\n";
        echo "<p><input type='submit' name='submit' value='Submit'>\n";
        echo "</form>\n";    
    }

}

?>

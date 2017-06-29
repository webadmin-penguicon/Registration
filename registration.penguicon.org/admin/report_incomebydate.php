<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    $start = $_GET['start'];
    $end = $_GET['end'];
    $report_title = "Income report by date";

    echo "<p><b>".$report_title."</b></p>\n";

    $badge_data = array();
    $wherestring = "";
    $badge_sql = mysql_query("SELECT * FROM badges $wherestring");
    while ($row = mysql_fetch_array($badge_sql)) {
        $badge_data[$row['order_number']] += $row['cost'];
    }

    $ribbon_data = array();
    $ribbon_sql = mysql_query("SELECT * FROM ribbons $wherestring");
    while ($row = mysql_fetch_array($ribbon_sql)) {
        $ribbon_data[$row['order_number']] += $row['cost'];
    }

    $other_data = array();
    $other_reason = array();
    $other_sql = mysql_query("SELECT * FROM other_charges $wherestring");
    while ($row = mysql_fetch_array($other_sql)) {
        $other_data[$row['order_number']] += $row['amount'];
        $other_reason[$row['order_number']] .= $row['reason'].".";
    }

    $month_subtotal = array();
    $total_paid = (float) 0;
    $badge_by_date = array();
    $ribbon_by_date = array();
    $other_by_date = array();
    $notfound_by_date = array();
    $messages_by_date = array();
    $start_date = TODAY;
    $end_date = "1900-01-01";

//TO-DO: Fix bug that occurs when there are two payments on the same order.
    $payment_sql = mysql_query("SELECT * FROM payments $wherestring");
    while ($row = mysql_fetch_array($payment_sql)) {
    	$order = $row['order_id'];
        $paid = (float) $row['payment_amt'];
	$date = $row['payment_date'];
	$month = substr($date, 0, 7);

        if ($date < $start_date && $date > "1900-01-01") {
	    $start_date = $date;
        }        

        if ($date > $end_date) {
            $end_date = $date;
        }

        //Ribbons
	if ($paid > 0) {
	    $temp_amt = $ribbon_data[$order];
            $ribbon_by_date[$date] += $temp_amt;
	    $total_paid += $temp_amt;
	    $month_subtotal[$month]['ribbons'] += $temp_amt;
	    $paid = (int) $paid - (int) $temp_amt;
	    if ($paid < 0) {
		$messages_by_date[$date] .= "<br>Ribbon order not fully paid by ".$paid;
                $messages_by_date[$date] .= " - order is ";
                $messages_by_date[$date] .= "<a href='vieworder.php?id=".$order."'>".$order;
	        $messages_by_date[$date] .= "</a>\n";
	        $ribbon_by_date[$date] = (int) $ribbon_by_date[$date] - (int) $paid;
		$paid = 0;
	    }
	}

	//Badges
	if ($paid > 0) {
	    $temp_amt = $badge_data[$order];
            $badge_by_date[$date] += $temp_amt;
	    $total_paid += $temp_amt;
	    $month_subtotal[$month]['badges'] += $temp_amt;
	    $paid = (int) $paid - (int) $temp_amt;
	    if ($paid < 0) {
		$messages_by_date[$date] .= "<br>Badge order not fully paid by ".$paid;
                $messages_by_date[$date] .= " - order is ";
                $messages_by_date[$date] .= "<a href='vieworder.php?id=".$order."'>".$order;
    	        $messages_by_date[$date] .= "</a>\n";
	        $badge_by_date[$date] = (int) $badge_by_date[$date] - (int) $paid;
		$paid = 0;
	    }
	}

	//Other
	if ($paid > 0) {
	    $temp_amt = $other_data[$order];
            $other_by_date[$date] += $temp_amt;
	    $total_paid += $temp_amt;
	    $month_subtotal[$month]['other'] += $temp_amt;
	    $paid = (int) $paid - (int) $temp_amt;
            $messages_by_date[$date] .= "<br>Reason for charge: ".$other_reason[$order];
            $messages_by_date[$date] .= " - order is ";
            $messages_by_date[$date] .= "<a href='vieworder.php?id=".$order."'>".$order;
            $messages_by_date[$date] .= "</a>\n";
	    if ($paid < 0) {
		$messages_by_date[$date] .= "<br>Other charge not fully paid by ".$paid;
                $messages_by_date[$date] .= " - order is ";
                $messages_by_date[$date] .= "<a href='vieworder.php?id=".$order."'>".$order;
	        $messages_by_date[$date] .= "</a>\n";
	        $other_by_date[$date] = (int) $other_by_date[$date] - (int) $paid;
		$paid = 0;
	    }
	}

	//Not Found
	if ($paid <> 0) {
            $notfound_by_date[$date] += $paid;
	    $month_subtotal[$month]['notfound'] += $paid;
            $messages_by_date[$date] .= "<br>Unbalanced transaction found!  Unbalanced amount is ".$paid;
            $messages_by_date[$date] .= " - order is ";
            $messages_by_date[$date] .= "<a href='vieworder.php?id=".$order."'>".$order;
	    $messages_by_date[$date] .= "</a>\n";
	}

    } //End of payment data

/* Yay, we have payment info.  Now to display it */

    //Since we have 4 arrays, sorting them individually is not helpful.
    //Good thing we saved our first and last date

    $current_point = strtotime($start_date);
    $end_point = strtotime($end_date);
    $cur_month = substr($start_date, 0, 7);

    // "Less than or equal to" gives me bugs and I don't know why
    while ($current_point < strtotime("+1 day", $end_point)) {
        $cur_date = date("Y-m-d", $current_point);
        $temp_month = substr($cur_date, 0, 7);

        if ($cur_month != $temp_month) {
	    //We have changed months.  Stop and print a subtotal
            echo "<p><b>Month totals for $cur_month: ";
            echo "Badges $".$month_subtotal[$cur_month]['badges'];
            echo " --- ";
            echo "Ribbons $".$month_subtotal[$cur_month]['ribbons'];
            echo " --- ";
	    echo "Other $".$month_subtotal[$cur_month]['other'];
            echo " --- ";
	    echo "Unbalanced $".$month_subtotal[$cur_month]['notfound'];
	    echo "</b></div>";
	    $cur_month = $temp_month;
        }

        $output = "";
        if ($badge_by_date[$cur_date] > 0) {
  	    $output .= "<br> &nbsp; &nbsp; Badges: $".$badge_by_date[$cur_date];
        }
        if ($ribbon_by_date[$cur_date] > 0) {
  	    $output .= "<br> &nbsp; &nbsp; Ribbons: $".$ribbon_by_date[$cur_date];
        }
        if ($other_by_date[$cur_date] > 0) {
  	    $output .= "<br> &nbsp; &nbsp; Other (see Reasons below): $".$other_by_date[$cur_date];
        }
        if ($notfound_by_date[$cur_date] > 0) {
  	    $output .= "<br> &nbsp; &nbsp; Unbalaced (see details below): $".$notfound_by_date[$cur_date];
        }
        $output .= $messages_by_date[$cur_date];
        if ($output) { 
            echo "<p>".$cur_date.": ";
            echo $output; 
        }
        $current_point = strtotime("+1 day", $current_point);
    }
    //We have changed months.  Stop and print a subtotal
     echo "<p><b>Month totals for $cur_month: ";
     echo "Badges $".$month_subtotal[$cur_month]['badges'];
     echo " --- ";
     echo "Ribbons $".$month_subtotal[$cur_month]['ribbons'];
     echo " --- ";
     echo "Other $".$month_subtotal[$cur_month]['other'];
     echo " --- ";
     echo "Unbalanced $".$month_subtotal[$cur_month]['notfound'];
     echo "</b></div>";
    
}

?>

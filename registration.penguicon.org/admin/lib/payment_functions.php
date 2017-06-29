<?php 

function add_payment_to_database() {

    include_once("lib/database_functions.php");
    $db_table = "payments";

    $db_entries = array();
    $db_entries['order_id'] = mysql_real_escape_string($_POST['order_id']);
    $db_entries['payment_type'] = mysql_real_escape_string($_POST['payment_type']);
    $db_entries['transaction_id'] = mysql_real_escape_string($_POST['transaction_id']);
    $db_entries['payment_email'] = mysql_real_escape_string($_POST['payment_email']);
    $db_entries['payment_date'] = mysql_real_escape_string($_POST['payment_date']);
    $db_entries['payment_amt'] = mysql_real_escape_string($_POST['payment_amt']);
    $db_entries['payment_note'] = mysql_real_escape_string($_POST['payment_note']);

    insert_into_database($db_table,$db_entries);

}

function add_refund_to_database() {

    include_once("lib/database_functions.php");
    $db_table = "other_charges";

    $db_entries = array();
    $db_entries['order_number'] = mysql_real_escape_string($_POST['order_id']);
    $db_entries['amount'] = mysql_real_escape_string($_POST['amount']);
    $db_entries['reason'] = mysql_real_escape_string($_POST['reason']);
    $db_entries['transaction_id'] = mysql_real_escape_string($_POST['transaction_id']);

    insert_into_database($db_table,$db_entries);

}

function confirm_new_payment ( $payment_id ) {

    include_once ("order_functions.php");
    include_once ("database_functions.php");

    $order_id = $_POST['order_id'];
    $payment_amt = $_POST['payment_amt'];

    $transaction_id = mysql_real_escape_string($_POST['transaction_id']);
    $duplicate_sql = "SELECT * FROM payments WHERE transaction_id = '".$transaction_id;
    $duplicate_sql .= "' AND payment_type != 'cash' LIMIT 1";
    $result = mysql_query($duplicate_sql);
    $row = mysql_fetch_array($result);
    if ($row['id']) {
        echo "<p>This payment has already been entered!\n";
        echo "<p><a href='addpayment.php'>Move on to the next one.</a>\n";
    } else {

/* Display order info */

        $order_info = get_order_info($order_id);
        $session_id = $order_info['session'];

        echo "<p>Order from ".$order_info['lastname'].", ".$order_info['firstname']."\n";
        echo " on ".$order_info['date']." with a cost of ".$order_info['total_cost']."\n";

        echo "<p>Order contents:\n";
        echo "<blockquote>\n";

        $sql = "SELECT * FROM order_details WHERE session='".$session_id."'";
        $result = mysql_query($sql);
        if (!$result) { die ('Query error: '.mysql_error()); }
        $order_total = 0;
        while ($details = mysql_fetch_array($result)) {
            echo "<p>";
            
            switch ($details['item_type']) {
                case "ribbon":
                    echo "Ribbon: ".$details['ribbon_qty']." on ";
                    echo $details['ribbon_color'];
                    echo "<br>".$details['ribbon_text'];
                    echo "<br>".$details['ribbon_text2'];
                    break;
                default:
                    echo $details['item_type']." badge for ";
                    echo $details['lastname'].", ".$details['firstname'];
            }
        }
        echo "</blockquote>\n";


/* Display "confirm this payment" button */

        echo "<form method='post' action='addpayment.php'>\n";

        $pass_thru_fields = array ();
        $pass_thru_fields[] = 'order_id';
        $pass_thru_fields[] = 'payment_amt';
        $pass_thru_fields[] = 'payment_type';
        $pass_thru_fields[] = 'transaction_id';
        $pass_thru_fields[] = 'payment_email';
        $pass_thru_fields[] = 'payment_date';
        $pass_thru_fields[] = 'payment_note';

        foreach ($pass_thru_fields as $input) {
            echo "<input type='hidden' name='";
            echo $input;
            echo "' value='";
            echo $_POST[$input];
            echo "'>\n";
        }

        echo "<br><input type='submit' name='submit' value='Yes, that one'>\n";
        echo "</form>\n";
    }
}

function display_payment_form ( $payment_id = 0 ) {

    echo "<form method='post' action='confirmpayment.php'>\n";
    echo "<table>\n";
    echo "<tr><td>Order number:</td>\n";
    echo "<td><input type='text' size='10' name='order_id'></td></tr>\n";


    echo "<tr><td>Payment amount:</td>\n";
    echo "<td><input type='text' size='10' name='payment_amt'></td></tr>\n";

    echo "<tr><td>Payment Type:</td>\n";
    echo "<td><select name='payment_type'>\n";
    echo "  <option value='cash'>Cash</option>\n";
    echo "  <option value='paypal'>PayPal</option>\n";
    echo "  <option value='credit'>Credit (Square)</option>\n";
    echo "  <option value='comp'>Comped</option>\n";
    echo "  <option value='volunteer'>Volunteer Hours</option>\n";
    echo "  <option value='budget'>Con Budget (Put the department in the payment note!)</option>\n";
    echo "  <option value='refund-applied'>Refund that the con owed</option>\n";
    echo "  <option value='other'>Other</option>\n";
    echo "</select></td></tr>\n";

    echo "<tr><td>Transaction ID:</td>\n";
    echo "<td><input type='text' size='20' name='transaction_id'></td></tr>\n";


    echo "<tr><td>Payment email:</td>\n";
    echo "<td><input type='text' size='20' name='payment_email'></td></tr>\n";


    echo "<tr><td>Payment date (YYYY-MM-DD):</td>\n";
    echo "<td><input type='text' size='15' name='payment_date'></td></tr>\n";


    echo "<tr><td>Payment note (optional):</td>\n";
    echo "<td><input type='text' size='40' name='payment_note'></td></tr>\n";

    echo "</table>\n";

    echo "<br><input type='submit' name='submit' value='Submit'>\n";
    echo "</form>\n";
}

function display_refund_form ( $refund_id = 0 ) {

    echo "<form method='post' action='addrefund.php'>\n";
    echo "<table>\n";
    echo "<tr><td>Order number:</td>\n";
    echo "<td><input type='text' size='10' name='order_id'></td></tr>\n";


    echo "<tr><td>Refund amount:</td>\n";
    echo "<td><input type='text' size='10' name='amount'></td></tr>\n";

    echo "<tr><td>Transaction ID:</td>\n";
    echo "<td><input type='text' size='20' name='transaction_id'></td></tr>\n";

    echo "<tr><td>Reason:</td>\n";
    echo "<td><input type='text' size='40' name='reason'></td></tr>\n";

    echo "</table>\n";

    echo "<br><input type='submit' name='submit' value='Submit'>\n";
    echo "</form>\n";
}

function get_payment_from_database ( $payment_id ) {

    $sql = mysql_query("SELECT * FROM payments WHERE id='".$payment_id."'");
    $row = mysql_fetch_array($sql);
    return $row;

}

function process_payment ( $payment_id ) {

    $payment_info = get_payment_from_database($payment_id);
    $order_id = $payment_info['order_id'];
    $payment_amt = $payment_info['payment_amt'];
    $payment_amt_used = $payment_info['payment_applied'];

    $errors = array();

    include_once ("order_functions.php");
    include_once ("database_functions.php");
    $order_info = get_order_info($order_id);
    $session_id = $order_info['session'];

    $confirmation_email_to = array();
    if ($order_info['confirmation'] == "yes") {
        $confirmation_email_to[] = $order_info['email'];
    }

    $confirm_text = CONFIRMATION_TEXT;
    /***** TO-DO: If it's been more than a week, add an apology for the delay ****/

    /************TO-DO: Add running totals to everything; Note at the bottom (top?) if balance is not zero ******/
//    $confirm_text .= "Order Total: ".$order_info['total_cost']"\n";
//    $confirm_text .= "Payment Total: ".$payment_amt;

/******* TO-DO: Move confirmation email to a process_order() function instead *********/


    $sql = "SELECT * FROM order_details WHERE session='".$session_id."'";
    $result = mysql_query($sql);
    if (!$result) { die ('Query error: '.mysql_error()); }
    $order_total = 0;
    while ($details = mysql_fetch_array($result)) {
        $db_table = "";
        $db_entries = array();
        $db_entries['con_year'] = CON_YEAR;
        $db_entries['order_number'] = $order_id;
        $db_entries['email_reminder'] = $details['email_reminder'];
        $db_entries['cost'] = $details['item_cost'];

        $order_total .= $details['item_cost'];

        $item_paid = 0;
        if (($payment_amt_used + $details['item_cost']) > $payment_amt) {
            $item_paid = $payment_amt - $payment_amt_used;        
            $errors[] = "Order cost exceeds payment amount.";
        } else {
            $item_paid = $details['item_cost'];
        }

        $payment_amt_used += $item_paid;
        $db_entries['paid'] = $item_paid;

        if ($details['email_processed'] == "yes") {
            $confirmation_email_to[] = $details['email'];
        }

        switch ($details['item_type']) {
            case "ribbon":
                 $db_table = "ribbons";
                 $confirm_text .= "Ribbons ";

                 $qty = $details['ribbon_qty'];
                 $textcolor = $details['ribbon_textcolor'];
                 $color = $details['ribbon_color'];
		 $font = $details['ribbon_font'];

                 $confirm_text .= "(".$qty." with ".$textcolor." text on ".$color." background): \n";

                 $db_entries['ribbon_qty'] = $qty;
                 $db_entries['ribbon_color'] = $color;
                 $db_entries['ribbon_textcolor'] = $textcolor;
		 $db_entries['ribbon_font'] = $font;

                 $image = $details['ribbon_image'];
                 if ($image) {
                     $confirm_text .= "[Image on file: ".$image."]";
                 }
                 $db_entries['ribbon_image'] = $image;

                 $line1 = $details['ribbon_text'];
                 $line2 = $details['ribbon_text2'];

                 if ($line2) {
                     $confirm_text .= "Line 1: ".$line1."\n";
                     $confirm_text .= "Line 2: ".$line2."\n";
                 } else {
                     $confirm_text .= "Text: ".$line1."\n";
                 }

                 $db_entries['ribbon_text'] = $line1;
                 $db_entries['ribbon_text2'] = $line2;


                 $first_name = $order_info['firstname'];
                 $last_name = $order_info['lastname'];

                 $confirm_text .= "Pick-up name: ".$last_name.", ".$first_name."\n\n";

                 $db_entries['first_name'] = $first_name;
                 $db_entries['last_name'] = $last_name;

                 $db_entries['email'] = $order_info['email'];

	         break;
            default:
                 $db_table = "badges";
                 if ($details['email_processed'] == "yes") {
                     $confirmation_email_to[] = $details['email'];
                 }

                 $first_name = $details['firstname'];
                 $last_name = $details['lastname'];

                 $db_entries['type'] = $details['item_type'];
                 $db_entries['first_name'] = $first_name;
                 $db_entries['last_name'] = $last_name;
                 $db_entries['email'] = $details['email'];


                 $db_entries['badge_name'] = $details['badgename'];
                 $confirm_text .= "Badge, ";
                 if (!$details['badgename']) {
                     $confirm_text .= "blank";
                 } else {
                     $confirm_text .= "printed as: ";
                 }

                 $confirm_text .= $details['badgename']."\n";
                 $confirm_text .= "Pick-up name: ".$last_name.", ".$first_name."\n\n";


        }

        insert_into_database($db_table,$db_entries);

        archive_processed_item($details['id']);


    } //End while: $details = mysql_fetch_array();

    $confirmation_email_to = array_unique($confirmation_email_to);

    $email_to = "";
    foreach ($confirmation_email_to as $recipient) {
        if ($email_to != "") {
            $email_to .= ",";
        }
        $email_to .= $recipient;
    }
    send_confirmation_email($email_to, $confirm_text);



    $payment_update_sql = "UPDATE payments SET payment_applied='".$payment_amt_used."'";
    $payment_update_sql .= " WHERE id='".$payment_info['id']."'";
    $sql = mysql_query($payment_update_sql);

    $master_orders_update_sql = "UPDATE master_orders SET order_processed=1 WHERE id='".$order_id."'";
    if ($payment_amt >= $order_info['total_cost']) {
        $sql = mysql_query($master_orders_update_sql);
    }

}


function save_payment_info ( $payment_array ) {
}

?>

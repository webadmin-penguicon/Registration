<?php 

function archive_processed_item ( $item_id ) {

    $sql = mysql_query("SELECT * FROM order_details WHERE id ='".$item_id."'");
    $item_details = mysql_fetch_array ($sql, MYSQL_ASSOC);
    unset($item_details['id']);

    include_once("database_functions.php");
    insert_into_database("order_details_archive",$item_details);

    if (mysql_error()) {
        echo "<p>Error: ".mysql_error();
    } else {
        $sql_delete = mysql_query("DELETE FROM order_details WHERE id='".$item_id."'");
    }

}

function get_order_info ( $order_id ) {

    $sql = mysql_query("SELECT * FROM master_orders WHERE id='".$order_id."'");
    $row = mysql_fetch_array($sql);
    return $row;

}

function process_order_without_payment ( $order_id) {

    $order_info = get_order_info($order_id);
    $session_id = $order_info['session'];

    $sql = "SELECT * FROM order_details WHERE session='".$session_id."'";
    $result = mysql_query($sql);
    if (!$result) { die ('Query error: '.mysql_error()); }

    while ($details = mysql_fetch_array($result)) {
        $db_table = "";
        $db_entries = array();
        $db_entries['con_year'] = CON_YEAR;
        $db_entries['order_number'] = $order_id;
        $db_entries['email_reminder'] = $details['email_reminder'];
        $db_entries['cost'] = $details['item_cost'];
        $db_entries['email'] = $details['email'];

        $first_name = $details['firstname'];
        $last_name = $details['lastname'];

        if (!$first_name) {
            $first_name = $order_info['firstname'];
        }

        if (!$last_name) {
            $last_name = $order_info['lastname'];
        }

        $db_entries['first_name'] = $first_name;
        $db_entries['last_name'] = $last_name;

        switch ($details['item_type']) {
            case "ribbon":
                 $db_table = "ribbons";
                 $confirm_text .= "Ribbons ";

                 $qty = $details['ribbon_qty'];
                 $textcolor = $details['ribbon_textcolor'];
                 $color = $details['ribbon_color'];

                 $db_entries['ribbon_qty'] = $qty;
                 $db_entries['ribbon_color'] = $color;
                 $db_entries['ribbon_textcolor'] = $textcolor;

                 $image = $details['ribbon_image'];
                 $db_entries['ribbon_image'] = $image;

                 $line1 = $details['ribbon_text'];
                 $line2 = $details['ribbon_text2'];

                 $db_entries['ribbon_text'] = $line1;
                 $db_entries['ribbon_text2'] = $line2;

                 $db_entries['email'] = $order_info['email'];

                 break;
            default:
                 $db_table = "badges";

                 $db_entries['type'] = $details['item_type'];
                 $db_entries['badge_name'] = $details['badgename'];

        }

        insert_into_database($db_table,$db_entries);

        archive_processed_item($details['id']);


    } //End while: $details = mysql_fetch_array();

    $master_orders_update_sql = "UPDATE master_orders SET order_processed=1 WHERE id='".$order_id."'";
    $sql = mysql_query($master_orders_update_sql);

}

function send_confirmation_email ($mail_to, $mail_text) {

    $mail_headers = "From: Penguicon Registration <".EMAIL_FROM.">";
    $subject = "Penguicon ".CON_YEAR." Order Processed";
    
    mail($mail_to, $subject, $mail_text, $mail_headers);
}

?>
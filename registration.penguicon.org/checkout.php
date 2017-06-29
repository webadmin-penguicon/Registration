<?php
/************************************************/
/*         CONFIGURATION			*/
/************************************************/

include_once("./config.inc.php");
include_once("./common.inc.php");

//Import functions
include_once("./functions.inc.php");

/* Generate the XML */
$ribbon_xml = "";
$badge_xml = "";
$confirm_text = "";
$paypal_count = 0;
$paypal_input = "";
$has_errors = 0;
$total_cost = 0;

$sql = mysql_query("SELECT * FROM master_orders WHERE session='".$order."'");
$row = mysql_fetch_array($sql);
if (!$row['id']) {
    header("Location: ".BASEURL."/review.php");
}

$paypal_input .= "<form name='_xclick' action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_new'>\n";
$paypal_input .= "<input type='hidden' name='cmd' value='_xclick'>\n";
$paypal_input .= "<input type='hidden' name='business' value='paypal-account@penguicon.org'>\n";
$paypal_input .= "<input type='hidden' name='currency_code' value='USD'>\n";

$item_sql = mysql_query("SELECT * FROM order_details WHERE session='".$order."'");
while ($item_row = mysql_fetch_array($item_sql)) {
    $total_cost += $item_row['item_cost'];
    $paypal_count++;
    $nice_name = "Penguicon Item";

    $both_xml = "";
    $both_xml .= "  <OrderNumber>".$row['id']."</OrderNumber>\n";
    $both_xml .= "  <Date>".TODAY."</Date>\n";
    $both_xml .= "  <ItemNumber>".$item_row['id']."</ItemNumber>\n";
    $both_xml .= "  <ItemCost>".$item_row['item_cost']."</ItemCost>\n";
    $both_xml .= "  <LastName>".$item_row['lastname']."</LastName>\n";
    $both_xml .= "  <FirstName>".$item_row['firstname']."</FirstName>\n";
    $both_xml .= "  <Email>".$item_row['email']."</Email>\n";
    $both_xml .= "  <SendReminder>".$item_row['email_reminder']."</SendReminder>\n";

    if ($item_row['item_type'] == "ribbon") {
        $ribbon_xml .= "<RibbonOrder>\n";
        $ribbon_xml .= $both_xml;
        $ribbon_xml .= "  <RibbonColor>".$item_row['ribbon_color']."</RibbonColor>\n";
        $ribbon_xml .= "  <TextColor>".$item_row['ribbon_textcolor']."</TextColor>\n";
        $ribbon_xml .= "  <Qty>".$item_row['ribbon_qty']."</Qty>\n";
        $ribbon_xml .= "  <TextLine1>".$item_row['ribbon_text']."</Text Line1>\n";
        $ribbon_xml .= "  <TextLine2>".$item_row['ribbon_text2']."</Text Line2>\n";
        $nice_name = "Ribbon: ".$item_row['ribbon_textcolor']." on ".$item_row['ribbon_color'];
        $confirm_text .= "\n".$nice_name;
        $confirm_text .= "\n".htmlspecialchars($item_row['ribbon_text'],ENT_QUOTES);
        if ($item_row['ribbon_text2']) {
            $confirm_text .= "\n".htmlspecialchars($item_row['ribbon_text2'],ENT_QUOTES);
        }

        $ribbon_xml .= "</RibbonOrder>\n\n";
    } else {
        $badge_xml .= "<BadgeOrder>\n";
        $badge_xml .= $both_xml;
        $badge_xml .= "  <SendConfirmation>".$item_row['email_processed']."</SendConfirmation>\n";
        $badge_xml .= "  <BadgeType>".$item_row['item_type']."</BadgeType>\n";
        $badge_xml .= "  <BadgeName>".$item_row['badgename']."</BadgeName>\n";
        $nice_name = ucfirst($item_row['item_type'])." badge for ";
        $nice_name .= htmlspecialchars($item_row['lastname'],ENT_QUOTES);
        $nice_name .= ", ".htmlspecialchars($item_row['firstname'],ENT_QUOTES);
        $confirm_text .= "\n".$nice_name;
        $confirm_text .= "\nPrinted as: ";
        if ($item_row['badgename']) {
            $confirm_text .= htmlspecialchars($item_row['badgename'],ENT_QUOTES);
        } else {
            $confirm_text .= "(blank)";
        }
        $badge_xml .= "</BadgeOrder>\n";
    }
    $confirm_text .= "\nItem cost: $".$item_row['item_cost']."\n";

}

$confirm_text .= "\n\nOrder total: $".$total_cost;

/* If email confirmation requested, send an email */

$mail_headers = "From: Penguicon Registration <".EMAIL_FROM.">";
$subject = "Penguicon ".CON_YEAR." Order Confirmation";

mail(BADGE_EMAIL_TO,$subject,$confirm_text,$mail_headers);

if ($row['confirmation'] == "yes") {
    $mail_to = $row['email'];

    $mail_text = "Your Penguicon order has been received.  If you have not already sent payment, ";
    $mail_text .= "please note that your order is not complete until payment is received.\n\n";
    $mail_text .= "And by \"not complete\" we mean \"We will charge you the full rate when you pick up your badge\"\n\n";
    $mail_text .= "If you have not already done so, you can send PayPal payments to ";
    $mail_text .= "paypal-account@penguicon.org\n\n";
    $mail_text .= "Order contents: \n".$confirm_text;

    mail($mail_to,$subject,$mail_text,$mail_headers);
}

/* if ribbon_xml exists, send it to the Ribbon email address */

if ($ribbon_xml) {
    mail(RIBBON_EMAIL_TO,RIBBON_EMAIL_SUBJECT,$ribbon_xml,$mail_headers);
}

/* If badge_xml exists, send it to the Badge email address */

if ($badge_xml) {
    mail(BADGE_EMAIL_TO,BADGE_EMAIL_SUBJECT,$badge_xml,$mail_headers);
}


$paypal_input .= "<input type='hidden' name='item_name' value='Penguicon Order #".$row['id']."'>\n";
$paypal_input .= "<input type='hidden' name='amount' value='".$total_cost."'>\n";
$paypal_input .= "<input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif' ";
$paypal_input .= "name='submit' border='0' alt='PayPal - The Safer, easier way to pay online!'>\n";
$paypal_input .= "</form>\n";

/************************************************/
/*         BUILD THE FORM			*/
/************************************************/

/* When I'm done, clear the cookie.  */
setcookie("ordernum",$order, time()-3600);

$title = "Order complete - Penguicon ".CON_YEAR." Registration";
display_header_info($title);

echo "<body id='text1'>\n";

echo "<h1>Your order has been submitted!</h1>\n";

echo "<p>Your order number is <b>".$row['id']."</b>";

echo "<p class='error'>Your order is not complete until payment is received.</p>";
echo "<br>And by \"not complete\" we mean \"We will charge you the full rate when you pick up your badge\"</p>";


echo nl2br($confirm_text);

echo $paypal_input;

if (TODAY <= "2014-05-04" AND $total_cost > 0) {
    echo "<p><b>Alternate payment option, if Registration is still open at the 2014 con:</b>";
    echo "<br>Walk to Registration, hand them $".$total_cost." and say \"This is for 2015, order number ".$row['id']."\"\n";
}

/* Update master_orders with date, cost, etc */
$update_sql = "date='".TODAY."',total_cost='".$total_cost."',order_complete=1";
mysql_query("UPDATE master_orders SET ".$update_sql." WHERE session='".$order."'");

display_footer_info();


?>

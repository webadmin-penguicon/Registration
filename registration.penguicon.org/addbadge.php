<?php
/************************************************/
/*         CONFIGURATION			*/
/************************************************/

include_once("./config.inc.php");
include_once("./common.inc.php");

/************************************************/
/*         BUILD THE CART			*/
/************************************************/

//Import functions
include_once("./functions.inc.php");

//If we're submitting, we can skip all the rest.
if ($_POST['submit']) { 
    $cart_error = add_to_cart($db,$order,$badge_cost,$badge_types); 
} else {
    $cart_error = array();
}

/************************************************/
/*         BUILD THE FORM			*/
/************************************************/

$title = "Add a ".CON_YEAR." Penguicon Badge";
display_header_info($title);

echo "<body id='test1'>\n";

//List current shopping cart
list_current_cart($order); 

echo "<div class='page-container'>\n";
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";

if (TODAY < PREREG_CLOSES) {

    //Badge options
    echo "<h1 align='center'>Add a badge to your order</h1>\n";
    if (SPECIAL_BADGES_AVAILABLE) {
        echo WARNING_FOR_SPECIAL_BADGES;
    }

    //Get the errors, if any
    $error_type = array();
    $error_loc = array();
    $error_text = array();
    $error_sql = "SELECT * FROM order_errors WHERE session='".$order."'";
    $error_temp = mysql_query($error_sql);
    while ($error_row = mysql_fetch_array($error_temp)) {
        $error_type[$error_row['id']] = $error_row['error_type'];
        $error_loc[$error_row['error_field']] = $error_row['id'];
        $error_text[$error_row['id']] = $error_row['error_text'];
    }


    echo "<table border=0 width='100%'>\n";
    echo "<tr><td>";
    echo "Type of badge: ";
    echo "</td><td>";
    echo "<select name='badge_type'>\n";
    echo "<option value=''>--Choose a badge</option>\n";
    foreach ($badge_types as $type => $badge_info) {
        echo "<option value='".$type."'";
        if ($_POST['badge_type'] == $type) { echo " selected"; }
        echo ">".$badge_info."  ($".$badge_cost[$type].")</option>\n";
    }
    echo "</select>\n";
    if ($error_loc['badge_type']) {
        echo "<span class='".$error_type[$error_loc['badge_type']]."'>";
        echo $error_text[$error_loc['badge_type']]."</span>\n";
        $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['badge_type']."'");
    }
    echo "</td></tr>\n";

    echo "<tr><td>";
    echo "Name to be printed on the badge (leave blank for none): ";
    echo "</td><td>";
    echo "<input type='text' name='badge_print_name' size='40'";
    if ($_POST['badge_print_name']) {
        echo " value='".$_POST['badge_print_name']."'";
    }
    echo ">\n";
    echo "</td></tr>\n";

    echo "<tr><td colspan='2'>";
    echo "<p>We reserve the right to ask for ID when picking up your badge.  ";
    echo "Please make the First and Last name entries below ";
    echo " match what's on the attendee's identification.</p>\n";
    echo "</td></tr>\n";

    echo "<tr><td>";
    echo "First name of attendee: ";
    echo "</td><td>";
    echo "<input type='text' name='first_name' size='25'";
    if ($_POST['first_name']) {
        echo " value='".$_POST['first_name']."'";
    }
    echo ">\n";
    if ($error_loc['first_name']) {
        echo "<span class='".$error_type[$error_loc['first_name']]."'>";
        echo $error_text[$error_loc['first_name']]."</span>\n";
        $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['first_name']."'");
    }
    echo "</td></tr>\n";

    echo "<tr><td>";
    echo "Last (aka family) name of attendee: ";
    echo "</td><td>";
    echo " <input type='text' name='last_name' size='25'";
    if ($_POST['last_name']) {
        echo " value='".$_POST['last_name']."'";
    }
    echo ">\n";
    if ($error_loc['last_name']) {
        echo "<span class='".$error_type[$error_loc['last_name']]."'>";
        echo $error_text[$error_loc['last_name']]."</span>\n";
        $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['last_name']."'");
    }
    echo "</td></tr>\n";

    echo "<tr><td valign='top'>";
    $confirm_flag = 1;
    echo "Would you like to receive a confirmation email when your badge is processed?  ";
    echo "<br/>(This may not be right away, especially if you are pre-registering very early.)\n";
    echo "</td><td>";
    echo "<input type='radio' name='email_process_confirmation' value='yes'";
    if ($_POST['email_process_confirmation'] == "yes") {
        echo " checked";
        $confirm_flag = 0;
    }
    echo "> Yes \n";
    echo "<br/><input type='radio' name='email_process_confirmation' value='no'";
    if ($confirm_flag) {
        echo " checked";
    }
    echo "> No \n";
    echo "</td></tr>\n";

    echo "<tr><td valign='top'>";
    $reminder_flag = 1;
    echo "Would you like to receive a reminder email about a week before the convention?\n";
    echo "</td><td>";
    echo "<input type='radio' name='email_reminder' value='yes'";
    if ($_POST['email_reminder'] == "yes") {
        echo " checked";
        $reminder_flag = 0;
    }
    echo "> Yes \n";
    echo "<br/><input type='radio' name='email_reminder' value='no'";
    if ($reminder_flag) {
        echo " checked";
    }
    echo "> No \n";
    echo "</td></tr>\n";

    echo "<tr><td>";
    echo "Email address for confirmations and reminders: ";
    echo "<br/>We promise not to spam you.";
    echo "<br/>Buying a badge for a friend?  Please use their email address here, not your own.\n";
    echo "<br/>You'll be able to set the email address for the overall order and your order confirmation ";
    echo "preferences at checkout.\n";
    echo "</td><td valign='top'>";
    echo "<input type='text' name='attendee_email' size='40'";
    if ($_POST['attendee_email']) {
        echo " value='".$_POST['attendee_email']."'";
    }
    echo ">\n";
    if ($error_loc['attendee_email']) {
        echo "<span class='".$error_type[$error_loc['attendee_email']]."'>";
        echo $error_text[$error_loc['attendee_email']]."</span>\n";
        $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['attendee_email']."'");
    }
    echo "</td></tr>\n";
    echo "</table>\n";
    echo "<input type='hidden' name='cart_type' value='badge'>\n";
    echo "<p><input type='submit' value='Add this badge' name='submit'>";
    echo "<input type='submit' formaction='./index.php' value='Cancel'>\n";
    echo "</p>\n";

} else {
    echo "<p>Badge pre-registration is now closed.  Badges may still be purchased at the ";
    echo "convention for the at-the-door price of ".AT_DOOR_BADGE.".</p>\n";
}

echo "</form>\n";
echo "</div>\n";

display_footer_info();
?>

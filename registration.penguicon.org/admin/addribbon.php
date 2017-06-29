<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    if ($_POST['submit']) { 

        include_once("lib/database_functions.php");
        $items=array();

        $items['session'] = mysql_real_escape_string($_POST['session']);
        $items['item_type'] = "ribbon";

        $items['ribbon_qty'] = $_POST['ribbon_qty'];
        $items['item_cost'] = ($items['ribbon_qty'] * RIBBON_PER_ITEM_FEE) + RIBBON_SETUP_FEE;

        $items['firstname'] = mysql_real_escape_string($_POST['first_name']);
        $items['lastname'] = mysql_real_escape_string($_POST['last_name']);
        $items['email'] = mysql_real_escape_string($_POST['attendee_email']);
        $items['ribbon_text'] = mysql_real_escape_string($_POST['ribbon_text']);
        $items['ribbon_text2'] = mysql_real_escape_string($_POST['ribbon_text2']);
        $items['ribbon_color'] = $_POST['ribbon_color'];
        $items['ribbon_textcolor'] = $_POST['ribbon_text_color'];
        $items['email_processed'] = "no";
        $items['email_reminder'] = $_POST['email_reminder'];


        insert_into_database("order_details",$items);

        echo "<p>Added</p>\n";

    } else {

        echo "<div>\n";
        echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";
        echo "<table border=0 width='100%'>\n";
        echo "<tr><td>Order session</td><td>";
        echo "<input type='text' size='20' name='session'>";
        echo "</td></tr>\n";

        echo "<tr><td>First name</td><td>";
        echo "<input type='text' size='40' name='first_name'>";
        echo "</td></tr>\n";

        echo "<tr><td>Last name</td><td>";
        echo "<input type='text' size='40' name='last_name'>";
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Ribbon color: ";
        echo "</td><td valign='top'>";
        echo "<select name='ribbon_color'>\n";
        echo "<option value=''>--Choose a ribbon color</option>\n";
        foreach ($ribbon_color as $location => $color) {
            echo "<option value='".$color."'";
            if ($_POST['ribbon_color'] == $color) { echo " selected"; }
            echo ">".$color;
            if ($location) {
                echo " (".$location.")";
            }
            echo "</option>\n";
        }
        echo "</select>\n";
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Text color: ";
        echo "</td><td valign='top'>";
        echo "<select name='ribbon_text_color'>\n";
        echo "<option value=''>--Choose a color for text</option>\n";
        foreach ($ribbon_text as $text_color) {
            echo "<option value='".$text_color."'";
            if ($_POST['ribbon_text_color'] == $text_color) { echo " selected"; }
            echo ">".$text_color."</option>";
        }
        echo "</select>\n";
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Ribbon text: (".RIBBON_CHAR_LIMIT." characters maximum)";
        echo "</td><td>";
        echo "<input type='text' name='ribbon_text' size='40'";
        if ($_POST['ribbon_text']) {
            echo " value='".$_POST['ribbon_text']."'";
        }
        echo ">\n";
        echo "</td></tr>\n";


        echo "<tr><td>";
        echo "Ribbon text, line 2 (optional, ".RIBBON_CHAR_LIMIT." characters maximum): ";
        echo "</td><td>";
        echo "<input type='text' name='ribbon_text2' size='40'";
        if ($_POST['ribbon_text2']) {
            echo " value='".$_POST['ribbon_text2']."'";
        }
        echo ">\n";
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Quantity: ";
        echo "</td><td>";
        echo "<input type='text' name='ribbon_qty' size='10'";
        if ($_POST['ribbon_qty']) {
            echo " value='".$_POST['ribbon_qty']."'";
        }
        echo ">\n";

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
        echo "Email address for reminder: ";
        echo "<br/>We promise not to spam you.";
        echo "</td><td valign='top'>";
        echo "<input type='text' name='attendee_email' size='40'";
        if ($_POST['attendee_email']) {
            echo " value='".$_POST['attendee_email']."'";
        }
        echo ">\n";
        echo "</td></tr>\n";
        echo "</table>\n";
        echo "<input type='submit' name='submit' value='Submit'>\n";
        echo "</form>\n";    
    }

}

?>

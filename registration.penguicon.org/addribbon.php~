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
    add_to_cart($db,$order,$ribbon_color,$ribbon_text); 
} 

/************************************************/
/*         BUILD THE FORM			*/
/************************************************/

$title = "Order ".CON_YEAR." Penguicon Ribbons";
display_header_info($title);


echo "<body id='text1'>\n";
list_current_cart($order); 

echo "<div class='page-container'>\n";
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";

if (RIBBONS_AVAILABLE) {
    //List current shopping cart
    echo "<h3 align='center'>Add a ribbon design to your order</h3>\n";

    echo "<p>Each different ribbon ordered will have a setup fee: <ul><li> $".$ribbon_setup_fee." for less than 50 ribbons</li>";
    echo "<li>$3 for 50 or more ribbons</li></ul></p>";

    echo "<p>Ribbon prices are $".RIBBON_PER_ITEM_FEE." per ribbon</p>\n";

    echo "<p>Premium ribbon colors are $".$premium_ribbon_per_item_fee." per ribbon</p>\n";


    echo "<p>If you want to add an image to your ribbon, please email ".RIBBON_EMAIL_TO." for details.</p>";

    if (TODAY < RIBBON_CLOSES) {

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
        echo "<tr><td valign='top'>";
        echo "Ribbon color: ";
        echo "<br/>See <a href='".RIBBON_LINK."' target='_blank'>".RIBBON_LINK."</a> for samples.\n";
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

        if ($premium_ribbon_color && !empty($premium_ribbon_color)) {
            echo "<option value=''>--PREMIUM COLORS COST EXTRA--</option>\n";
            foreach ($premium_ribbon_color as $plocation => $pcolor) {
                echo "<option value='".$pcolor."'";
                if ($_POST['ribbon_color'] == $pcolor) { echo " selected"; }
                echo ">".$pcolor." - PREMIUM";
                if ($plocation) {
                    echo " (".$plocation.")";
                }
                echo "</option>\n";
            }
        }

        echo "</select>\n";
        if ($error_loc['ribbon_color']) {
            echo "<span class='".$error_type[$error_loc['ribbon_color']]."'>";
            echo $error_text[$error_loc['ribbon_color']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['ribbon_color']."'");
        }
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Ribbon text: (".RIBBON_CHAR_LIMIT." characters maximum)";
        echo "</td><td>";
        echo "<input type='text' name='ribbon_text' size='40'";
        if ($_POST['ribbon_text']) {
            echo " value='".$_POST['ribbon_text']."'";
        }
        echo ">\n";
        if ($error_loc['ribbon_text']) {
            echo "<span class='".$error_type[$error_loc['ribbon_text']]."'>";
            echo $error_text[$error_loc['ribbon_text']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['ribbon_text']."'");
        }
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Ribbon text, line 2 (optional, ".RIBBON_CHAR_LIMIT." characters maximum): ";
        echo "</td><td>";
        echo "<input type='text' name='ribbon_text2' size='40'";
        if ($_POST['ribbon_text2']) {
            echo " value='".$_POST['ribbon_text2']."'";
        }
        echo ">\n";
        if ($error_loc['ribbon_text2']) {
            echo "<span class='".$error_type[$error_loc['ribbon_text2']]."'>";
            echo $error_text[$error_loc['ribbon_text2']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['ribbon_text2']."'");
        }
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Text color: ";
        echo "<br/>See <a href='".RIBBON_LINK."' target='_blank'>".RIBBON_LINK."</a> for samples.\n";
        echo "</td><td valign='top'>";
        echo "<select name='ribbon_text_color'>\n";
        echo "<option value=''>--Choose a color for text</option>\n";
        foreach ($ribbon_text as $text_color) {
            echo "<option value='".$text_color."'";
            if ($_POST['ribbon_text_color'] == $text_color) { echo " selected"; }
            echo ">".$text_color."</option>";
        }
        echo "</select>\n";
        if ($error_loc['ribbon_text_color']) {
            echo "<span class='".$error_type[$error_loc['ribbon_text_color']]."'>";
            echo $error_text[$error_loc['ribbon_text_color']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['ribbon_text_color']."'");
        }
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Font: ";
        echo "<br/>See <a href='fontchoices.jpg' target='_blank'>here</a> for samples.\n";
        echo "</td><td valign='top'>";
        echo "<select name='ribbon_font'>\n";
        echo "<option value=''>--Choose a font for text</option>\n";
        foreach ($ribbon_font_choices as $font => $font_name) {
            echo "<option value='".$font."'";
            if ($_POST['ribbon_font'] == $font) { echo " selected"; }
            echo ">".$font_name."</option>";
        }
        echo "</select>\n";
        if ($error_loc['ribbon_font']) {
            echo "<span class='".$error_type[$error_loc['ribbon_font']]."'>";
            echo $error_text[$error_loc['ribbon_font']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['ribbon_font']."'");
        }
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Quantity: ";
        echo "</td><td>";
        echo "<input type='text' name='ribbon_qty' size='10'";
        if ($_POST['ribbon_qty']) {
            echo " value='".$_POST['ribbon_qty']."'";
        }
        echo ">\n";
        if ($error_loc['ribbon_qty']) {
            echo "<span class='".$error_type[$error_loc['ribbon_qty']]."'>";
            echo $error_text[$error_loc['ribbon_qty']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['ribbon_qty']."'");
        }
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
        if ($error_loc['attendee_email']) {
            echo "<span class='".$error_type[$error_loc['attendee_email']]."'>";
            echo $error_text[$error_loc['attendee_email']]."</span>\n";
            $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['attendee_email']."'");
        }
        echo "</td></tr>\n";
        echo "</table>\n";
        echo "<input type='hidden' name='cart_type' value='ribbon'>\n";
        echo "<p><input type='submit' value='Add this ribbon design' name='submit'></p>\n";

    } else {
        echo "<p>Ribbon orders are now closed.</p>\n";
    }
}


echo "</form>\n";
echo "</div>\n";

display_footer_info();
?>

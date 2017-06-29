<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    $badge_types['goh'] = "GoH (Guest of Honor)";
    $badge_cost['goh'] = 0;

    $badge_types['goh-guest'] = "Guest of a GoH";
    $badge_cost['goh-guest'] = 0;

    $badge_types['featured'] = "Featured Guest";
    $badge_cost['featured'] = 0;

    $badge_types['goh-emeritus'] = "Former GoH (GoH Emeritus)";
    $badge_cost['goh-emeritus'] = 0;

    $badge_types['2015paid'] = "Weekend (Paid at 2015)";
    $badge_cost['2015paid'] = 35;

    $badge_types['dealer'] = "Dealer";
    $badge_cost['dealer'] = 0;

    $badge_types['artist'] = "Artist Alley";
    $badge_cost['artist'] = 0;

    $badge_types['press'] = "Press";
    $badge_cost['press'] = 0;

    $badge_types['comped'] = "Weekend (Comped)";
    $badge_cost['comped'] = 0;

    $badge_types['volunteer'] = "Weekend (paid with Volunteer Hours)";
    $badge_cost['volunteer'] = 0;


    if ($_POST['submit']) { 

        include_once("lib/database_functions.php");
        $items=array();

        $items['session'] = mysql_real_escape_string($_POST['session']);
        $items['item_type'] = $_POST['badge_type'];
        $items['item_cost'] = $badge_cost[$_POST['badge_type']];

        $items['firstname'] = mysql_real_escape_string($_POST['first_name']);
        $items['lastname'] = mysql_real_escape_string($_POST['last_name']);
        $items['badgename'] = mysql_real_escape_string($_POST['badge_print_name']);
        $items['email'] = mysql_real_escape_string($_POST['attendee_email']);
        $items['email_processed'] = $_POST['confirmation'];
        $items['email_reminder'] = $_POST['reminder'];

        insert_into_database("order_details",$items);
        echo "<p>Added.";

    } else {

        echo "<div>\n";
        echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";
        echo "<table border=0 width='100%'>\n";
        echo "<tr><td>Order session</td><td>";
        echo "<input type='text' size='20' name='session'>";
        echo "</td></tr>\n";

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

        echo "<tr><td>First name</td><td>";
        echo "<input type='text' size='40' name='first_name'>";
        echo "</td></tr>\n";

        echo "<tr><td>Last name</td><td>";
        echo "<input type='text' size='40' name='last_name'>";
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Send a confirmation email?";
        echo "</td><td>";
        echo "<input type='radio' name='confirmation' value='yes'";
        echo "> Yes \n";
        echo "<br/><input type='radio' name='confirmation' value='no'";
        echo "> No \n";
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Send a reminder email?";
        echo "</td><td>";
        echo "<input type='radio' name='reminder' value='yes'";
        echo "> Yes \n";
        echo "<br/><input type='radio' name='reminder' value='no'";
        echo "> No \n";
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Email address: ";
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

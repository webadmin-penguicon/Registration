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

        $items['firstname'] = mysql_real_escape_string($_POST['first_name']);
        $items['lastname'] = mysql_real_escape_string($_POST['last_name']);
        $items['email'] = mysql_real_escape_string($_POST['attendee_email']);
        $items['date'] = mysql_real_escape_string($_POST['date']);
        $items['confirmation'] = $_POST['confirmation'];
        $items['order_processed'] = 0;


        insert_into_database("master_orders",$items);

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

        echo "<tr><td>Order date (YYYY-MM-DD) </td><td>";
        echo "<input type='text' size='40' name='date'>";
        echo "</td></tr>\n";

        echo "<tr><td valign='top'>";
        echo "Send a confirmation email?";
        echo "</td><td>";
        echo "<input type='radio' name='confirmation' value='yes'";
        echo "> Yes \n";
        echo "<br/><input type='radio' name='confirmation' value='no'";
        echo "> No \n";
        echo "</td></tr>\n";

        echo "<tr><td>";
        echo "Email address: ";
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

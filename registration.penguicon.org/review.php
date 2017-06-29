<?php
/************************************************/
/*         CONFIGURATION			*/
/************************************************/

include_once("./config.inc.php");
include_once("./common.inc.php");

//Import functions
include_once("./functions.inc.php");

//If we're submitting, we can skip all the rest.
if ($_POST['submit']) { submit_contact_info($order,$db); } else {


/************************************************/
/*         BUILD THE FORM			*/
/************************************************/

$title = "Review Your Order - Penguicon ".CON_YEAR." Registration";
display_header_info($title);

echo "<body id='text1'>\n";

//Information block

//List current shopping cart
list_current_cart($order); 

echo "<div class='page-container'>\n";
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";

$sql = mysql_query("SELECT * FROM master_orders WHERE session='".$order."'");
$row = mysql_fetch_array($sql);

//Get the errors, if any
$error_sql = "SELECT * FROM order_errors WHERE session='".$order."'";
$error_temp = mysql_query($error_sql);
while ($error_row = mysql_fetch_array($error_temp)) {
    $error_type[$error_row['id']] = $error_row['error_type'];
    $error_loc[$error_row['error_field']] = $error_row['id'];
    $error_text[$error_row['id']] = $error_row['error_text'];
}

echo "<h1>Please enter your contact information</h1>";
echo "<br>Your first name: <input type='text' size='40' name='firstname' ";
echo "value='".htmlspecialchars($row['firstname'],ENT_QUOTES)."'>\n";
if ($error_loc['firstname-contact']) { 
    echo "<span class='".$error_type[$error_loc['firstname-contact']]."'>";
    echo $error_text[$error_loc['firstname-contact']]."</span>\n";
    $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['firstname-contact']."'");
}
echo "<br>Your last name: <input type='text' size='40' name='lastname' ";
echo "value='".htmlspecialchars($row['lastname'],ENT_QUOTES)."'>\n";
if ($error_loc['lastname-contact']) { 
    echo "<span class='".$error_type[$error_loc['lastname-contact']]."'>";
    echo $error_text[$error_loc['lastname-contact']]."</span>\n";
    $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['lastname-contact']."'");
}
echo "</p>\n";

echo "<p>Would you like an email confirming this order?\n";
echo " <input type='radio' name='confirmation' value='yes'";
if ($row['confirmation'] == "yes") { echo " checked"; }
echo "> Yes - No ";
echo " <input type='radio' name='confirmation' value='no'";
if ($row['confirmation'] == "no") { echo " checked"; }
echo ">";
echo "<br/>Email address: ";
echo "<input type='text' size='40' name='email' ";
echo "value='".htmlspecialchars($row['email'],ENT_QUOTES)."'>";
if ($error_loc['email-contact']) { 
    echo "<span class='".$error_type[$error_loc['email-contact']]."'>";
    echo $error_text[$error_loc['email-contact']]."</span>\n";
    $delete_sql = mysql_query("DELETE FROM order_errors WHERE id='".$error_loc['email-contact']."'");
}
echo "<p class='success'>A planned upgrade to this site involves having you log in with OpenID ";
echo "so that you can edit badges once they are ordered, and check to see if you've already registered. ";
echo "But it's not ready yet, and we still wanted you to be able to register for next year. ";
echo "So we need a way to match up early orders with later logins, and the easiest way to do that is with an ";
echo "email address.  We promise, we won't spam you. ";
echo "If you use an email address that isn't your OpenID email address, we might email you once to try and ";
echo "get you matched up with a username, but that's it.</p>";
echo "<p class='success'>We're not going to make the field mandatory, because those of you who absolutely ";
echo "refuse to give your email address will just lie to us, and that's more annoying than not having an ";
echo "email address at all.  But if you give us a working email address, we'll use it to make your ";
echo "registration experience smoother.</p>";
echo "<p align='center'><input type='submit' name='submit' value='Submit'>\n";

echo "</form>\n";
echo "</div>\n";

display_footer_info();

} // end of else: if ($_POST['submit'])

function submit_contact_info($session, $db) {

    $sql = mysql_query("SELECT * FROM master_orders WHERE session='".$session."'");
    $row = mysql_fetch_array($sql);

    $insert_fields = "";
    $insert_values = "";
    $update_sql = "";
    $has_error = 0;

    if ($_POST['firstname'] == "") {
	$has_error = 1;
        $error_loc = "firstname-contact";
        $error_text = "First name cannot be blank.";
        $error_sql = "INSERT INTO order_errors (session,error_type,error_text,error_field) ";
        $error_sql .= "VALUES ('".$session."','error','".$error_text."','".$error_loc."')";
        $temp = mysql_query($error_sql);
    } else {
        $firstname = mysql_real_escape_string($_POST['firstname']);
        if ($insert_fields != "") { $insert_fields .= ", "; }
        if ($insert_values != "") { $insert_values .= ", "; }
        $insert_fields .= "firstname";
	$insert_values .= "'".$firstname."'";
        if ($update_sql != "") { $update_sql .= ", "; }
        $update_sql .= "firstname = '".$firstname."'";
    }

    if ($_POST['lastname'] == "") {
	$has_error = 1;
        $error_loc = "lastname-contact";
        $error_text = "Last name cannot be blank.";
        $error_sql = "INSERT INTO order_errors (session,error_type,error_text,error_field) ";
        $error_sql .= "VALUES ('".$session."','error','".$error_text."','".$error_loc."')";
        $temp = mysql_query($error_sql);
    } else {
        $lastname = mysql_real_escape_string($_POST['lastname']);
        if ($insert_fields != "") { $insert_fields .= ", "; }
        if ($insert_values != "") { $insert_values .= ", "; }
        $insert_fields .= "lastname";
	$insert_values .= "'".$lastname."'";
        if ($update_sql != "") { $update_sql .= ", "; }
        $update_sql .= "lastname = '".$lastname."'";
    }

    if ($insert_fields != "") { $insert_fields .= ", "; }
    if ($insert_values != "") { $insert_values .= ", "; }
    $insert_fields .= "confirmation";
    $insert_values .= "'".$_POST['confirmation']."'";
    if ($update_sql != "") { $update_sql .= ", "; }
    $update_sql .= "confirmation = '".$_POST['confirmation']."'";

    $email_error = 0;
    if ($_POST['confirmation'] == "yes") {
        if ($_POST['email'] == "") {
  	    $email_error = 1;
            $error_loc = "email-contact";
            $error_text = "Email cannot be blank if a confirmation is requested.";
            $error_sql = "INSERT INTO order_errors (session,error_type,error_text,error_field) ";
            $error_sql .= "VALUES ('".$session."','error','".$error_text."','".$error_loc."')";
            $temp = mysql_query($error_sql);
        } else {
            if (!validate_email($_POST['email'])) {
                $email_error = 1;
                $error_loc = "email-contact";
                $error_text = "Email address is not valid.";
                $error_sql = "INSERT INTO order_errors (session,error_type,error_text,error_field) ";
                $error_sql .= "VALUES ('".$session."','error','".$error_text."','".$error_loc."')";
                $temp = mysql_query($error_sql);
            }
        }
    }

    if ($email_error) {
        $has_error = 1;
    } else {
        $email = mysql_real_escape_string($_POST['email']);
        if ($insert_fields != "") { $insert_fields .= ", "; }
        if ($insert_values != "") { $insert_values .= ", "; }
        $insert_fields .= "email";
	$insert_values .= "'".$email."'";
        if ($update_sql != "") { $update_sql .= ", "; }
        $update_sql .= "email = '".$email."'";
    }

    if ($row['id']) {
        /* Record already exists; we're UPDATEing */
        if ($update_sql != "") {
            mysql_query("UPDATE master_orders SET ".$update_sql." WHERE session='".$session."'");
        }
    } else {
        /* Record does not exist; we're INSERTing */
        if ($insert_fields .= "" AND $insert_values .= "") {
            $insert_fields .= ",session";
            $insert_values .= ",'".$session."'";
            mysql_query("INSERT INTO master_orders (".$insert_fields.") VALUES (".$insert_values.")");
        }
    }

    if ($has_error) {
        header("Location: ".BASEURL."/review.php");
    } else {
        header("Location: ".BASEURL."/checkout.php");
    }
}

?>

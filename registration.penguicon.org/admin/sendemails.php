<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

//Find all entries where email_reminder = yes
//Send an email
//Update the entry to set email_reminder to today's date
    $today = date("Y-m-d");

    $mail_headers = "From: Penguicon Registration <registration@penguicon.org>";
    $subject = "Penguicon Pre-Registration Reminder";

    $text = "\nPenguicon is coming up in one week.";
    $text .= "\n\nYou've asked for a reminder that you've already registered for your badge, ";
    $text .= "and this is that reminder.\n";

    $prior = "";
    $extra_text = "";
    $sql = mysql_query("SELECT * FROM badges WHERE con_year='".CON_YEAR."' AND email_reminder='yes' ORDER BY email");
    while ($row = mysql_fetch_array($sql)) {
        $current = $row['email'];
        if ($current != $prior) {
            //Send the prior one

            echo "<p>Sending email to ".$prior;

            $body = $text.$extra_text;
            mail($prior,$subject,$body,$mail_headers);

            //Reset the details
            $extra_text = "";
        }

        $extra_text .= "\nBadge for ".$row['last_name'].", ".$row['first_name'];
        if ($row['badge_name']) {
            $extra_text .= " (printed as ".$row['badge_name'].")";
        } else {
            $extra_text .= " (blank)";
        }

        $prior = $row['email'];
        $sqlu = mysql_query("UPDATE badges SET email_reminder='".$today."' WHERE id=".$row['id']);
    }

    //The last one didn't get sent.  Send it.

    echo "<p>Sending email to ".$prior;

    $body = $text.$extra_text;
    mail($prior,$subject,$body,$mail_headers);

}

?>

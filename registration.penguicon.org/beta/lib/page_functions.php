<?php 

function display_header() {
/*
 Check for logged in
  If yes, display who they are logged in as
  If no, display login options
*/

    if (is_logged_in()) {
    } else {
    }

    display_short_header();
    display_navigation();
}

function display_navigation() {

    echo "<br>\n<br>Administrative:\n";
    echo "<br><a href='adduser.php'>Add a user</a>\n";

}

function display_short_header() {
    echo "Logged in as ".$_SESSION['userid']."  &nbsp; &nbsp; <a href='./logout.php'>Logout</a>\n";
    echo "<p><a href='index.php'>Home</a>\n";
}

?>
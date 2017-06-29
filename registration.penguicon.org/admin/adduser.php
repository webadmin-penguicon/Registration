<?php 
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {

    display_short_header();

    if ($_SESSION['userid'] != "alrobins@gmail.com") {
        echo "<p>You're not Amanda!  Go away, only she can add users right now.";
    } else {
        if ($_POST['submit']) {
            include_once("lib/database_functions.php");
            /* Add the user */
            add_user($_POST['username'],$_POST['password'],"users_admin");
        } else {
            /* display a form */
            echo "<form name='login' action='adduser.php' method='post'>\n";
            echo "   <br>Username: <input type='text' name='username' />\n";
            echo "   <br>Password: <input type='password' name='password' />\n";
            echo "   <br><input type='submit' name='submit' value='Add this user' />\n";
            echo "</form>\n";
        }

    }

}

?>
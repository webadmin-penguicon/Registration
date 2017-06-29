<?php 
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    if ($_POST['submit']) {

        $current = $_POST['current'];
        $new = $_POST['new1'];
        $verify = $_POST['new2'];
        $error = validate_password_change($current, $new, $verify);
        if (array_key_exists("success",$error)) {
            /* Do the password change */
            $username=$_SESSION['userid'];
            set_password($username,$new,"users_admin"); 
       } else {
            echo "<p>Danger, Will Robinson!  I have some errors: ";
            foreach ($error as $message) {
                echo "<br><span style='color:red'>".$message;
            }
            display_password_change_form();
        }

    } else {  //No submission yet
         display_password_change_form();
    }
}

?>
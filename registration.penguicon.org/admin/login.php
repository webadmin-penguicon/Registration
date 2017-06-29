<?php 
include_once("common.inc.php");

if ($_POST['submit']) {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $username = mysql_real_escape_string($username);
    $query = "SELECT password, salt FROM users_admin WHERE username = '$username';";
    $result = mysql_query($query);
    if (mysql_num_rows($result) < 1)  {  // no such user exists
        header('Location: login.php');
        die();
    } else {
        $userData = mysql_fetch_array($result, MYSQL_ASSOC);
        $hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
        if ($hash != $userData['password'])  {  //incorrect password
            header('Location: login.php');
            die();
        } else {
            validate_user($username);
            header('Location: index.php');
        }        
    }
} else {  //No submission yet
     display_login_form();
}


?>
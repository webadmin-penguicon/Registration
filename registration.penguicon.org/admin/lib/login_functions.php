<?php 
function add_user($username,$password,$table) {

    $salt = create_salt();
    $hash = get_hash($salt,$password);
    $safe_username = mysql_real_escape_string($username);

    $fields = "username,password,salt";
    $values = "'".$safe_username."','".$hash."','".$salt."'";
    $sql = "INSERT INTO ".$table." (".$fields.") VALUES (".$values.")";
    $result = mysql_query($sql);
    if (mysql_error()) {
        echo "<p>Error: ".mysql_error();
    } else {
        echo "<p>User added!";
    }

}

function create_salt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}

function display_login_form() {

    echo "<form name='login' action='login.php' method='post'>\n";
    echo "   <br>Username: <input type='text' name='username' />\n";
    echo "   <br>Password: <input type='password' name='password' />\n";
    echo "   <br><input type='submit' name='submit' value='Login' />\n";
    echo "</form>\n";
}

function display_password_change_form() {

    echo "<form name='login' action='changepassword.php' method='post'>\n";
    echo "   <br>Current password: <input type='password' name='current' />\n";
    echo "   <br>New Password: <input type='password' name='new1' />\n";
    echo "   <br>New Password (again): <input type='password' name='new2' />\n";
    echo "   <br><input type='submit' name='submit' value='Change my password' />\n";
    echo "</form>\n";

}

function get_hash($salt,$text) {
    $hash = hash('sha256', $salt . hash('sha256', $text) );
    return $hash;
}

function is_logged_in()
{
    if(isset($_SESSION['registration_admin']) && $_SESSION['registration_admin'])
        return true;
    return false;
}

function logout()
{
    $_SESSION = array(); //destroy all of the session variables
    session_destroy();
}

function set_password($username,$password,$table) {

/* get a new salt */
    $salt = create_salt();

/* hash the password */
    $hash = get_hash($salt,$password);

/* Store the new password and salt */
    $safe_username = mysql_real_escape_string($username);

    $sql = "UPDATE ".$table." SET password='".$hash."', salt='".$salt."' WHERE username='";
    $sql .= $safe_username."' LIMIT 1";
    $result = mysql_query($sql);
    if (mysql_error()) {
        echo "<p>Error: ".mysql_error();
    } else {
        echo "<p>Password changed!";
    }

}

function validate_password_change ($current, $new, $verify) {

    $error_found = 0;
    $error = array();

/* Is the current password correct? */

    $username = $_SESSION['userid'];
    $password = $current;


    $username = mysql_real_escape_string($username);
    $query = "SELECT password, salt FROM users_admin WHERE username = '$username';";
    $result = mysql_query($query);
    if (mysql_num_rows($result) < 1)  {  // no such user exists
        $error_found = 1;
        $error[] = "You don't exist!  This should never, ever be.";
    } else {
        $userData = mysql_fetch_array($result, MYSQL_ASSOC);
        $hash = get_hash($userData['salt'], $password);
        if ($hash != $userData['password'])  {  //incorrect password
            $error_found = 1;
            $error[] = "Incorrect current password.";
        }        
    }


/* Are the two new passwords identical? */

    if ($verify != $new) {
        $error_found = 1;
        $error[] = "The two new passwords don't match!";
    }

/* Is the new password the same as the username? */

    if ($new == $username) {
        $error_found = 1;
        $error[] = "Seriously, dude?  Using your username as your password?  No.  Just no.";
    }

/* Is the new password at least 6 characters long? */

    if (strlen($new) < 6) {
        $error_found = 1;
        $error[] = "You're gonna need at least 6 characters before I'll consider letting you use a password.  Try again.";
    }

    if ($error_found == 0) {
        $error['success'] = "Password okay.";
    }

    return $error;
}

function validate_user($username)
{
    session_regenerate_id (); 
    $_SESSION['registration_admin'] = 1;
    $_SESSION['userid'] = $username;
}
?>

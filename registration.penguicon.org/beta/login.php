<?php

require_once('./common.inc.php');

include_once('./lib/login_functions.php');

if (is_logged_in()) {

    if ($_SESSION['just_logged_in']) {
        $_SESSION['just_logged_in'] = 0;
        header('Location: index.php');
    } else {
        echo "<p>You are already logged in!  Please <a href='./logout.php'>Log out</a> first.</a>\n";
    }
} else {

    switch($_GET['provider']) {
        case "twitter":
        case "google":
        case "facebook":
            hybrid_login($_GET['provider']);
            break;
        default:
            echo "<p>I'm sorry, I don't recognize that provider.</p>";
            break;
    }
        header('Location: index.php');
}

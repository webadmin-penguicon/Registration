<?php

include_once('./common.inc.php');

if (!is_logged_in())
{
    /* TO-DO: Display the "login with" icons and links */
    /* TO-DO: Display manual form */

    /***********DEBUG************/
    echo "<p>You are not logged in.";
    
} else {
    display_header();

}


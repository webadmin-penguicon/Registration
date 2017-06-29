<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    $timestamp = time();
    $_SESSION['order'] = $timestamp;
    $_COOKIE['ordernum'] = $timestamp;
    header('Location: index.php');
}

?>

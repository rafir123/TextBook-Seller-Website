<?php
/**
 * Destroy all SESSION data that contains user information
 * Redirect to login page
 */

// Initialize the session
session_start();

$_SESSION = array();
session_destroy();

header("location: login.php");
exit;
?>

<?php require "templates/header.php";?>

Logout Page

<?php require "templates/footer.php";?>
